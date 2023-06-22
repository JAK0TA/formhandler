#
# Table structure for table 'tx_formhandler_domain_model_log'
#
CREATE TABLE tx_formhandler_domain_model_log (
	form_page_id int(11) unsigned DEFAULT '0' NOT NULL,
	ip tinytext,
	params mediumtext,
	is_spam int(11) unsigned DEFAULT '0',
	key_hash tinytext,
	unique_hash tinytext,
);
