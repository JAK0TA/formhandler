<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Validator\ErrorCheck;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryHelper;
use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\AbstractErrorCheckModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\ErrorCheck\TableLookupModel;

class TableLookup extends AbstractErrorCheck {
  public function isValid(FormModel &$formConfig, AbstractErrorCheckModel &$errorCheckConfig, string $fieldNamePathBrackets, string $fieldNamePathDots, mixed $value): bool {
    if (!$errorCheckConfig instanceof TableLookupModel) {
      return false;
    }

    $value = strval($value);

    if (strlen($value) > 0) {
      $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($errorCheckConfig->table);

      $queryBuilder->setRestrictions(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));
      $queryBuilder
        ->count($errorCheckConfig->field)
        ->from($errorCheckConfig->table)
        ->where(
          $queryBuilder->expr()->eq($errorCheckConfig->field, $queryBuilder->createNamedParameter($value))
        )
      ;

      if (!empty($errorCheckConfig->additionalWhere)) {
        $queryBuilder->andWhere(QueryHelper::stripLogicalOperatorPrefix($errorCheckConfig->additionalWhere));
      }

      if ($errorCheckConfig->excludeHidden) {
        $queryBuilder->getRestrictions()->removeByType(HiddenRestriction::class);
      }

      try {
        /** @var int $count */
        $count = $queryBuilder->executeQuery()->fetchOne();
        if ($errorCheckConfig->exists && 0 < $count) {
          return true;
        }
        if (!$errorCheckConfig->exists && 0 == $count) {
          return true;
        }
      } catch (\Exception $th) {
        $formConfig->debugMessage('error', [$th->getMessage()], 3);
      }
    }

    return false;
  }
}
