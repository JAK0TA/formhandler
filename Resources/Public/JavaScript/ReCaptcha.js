/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/recaptcha-v3/dist/ReCaptcha.js":
/*!*****************************************************!*\
  !*** ./node_modules/recaptcha-v3/dist/ReCaptcha.js ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

eval("\nObject.defineProperty(exports, \"__esModule\", ({ value: true }));\nexports.ReCaptchaInstance = exports.getInstance = exports.load = void 0;\nvar ReCaptchaLoader_1 = __webpack_require__(/*! ./ReCaptchaLoader */ \"./node_modules/recaptcha-v3/dist/ReCaptchaLoader.js\");\nObject.defineProperty(exports, \"load\", ({ enumerable: true, get: function () { return ReCaptchaLoader_1.load; } }));\nObject.defineProperty(exports, \"getInstance\", ({ enumerable: true, get: function () { return ReCaptchaLoader_1.getInstance; } }));\nvar ReCaptchaInstance_1 = __webpack_require__(/*! ./ReCaptchaInstance */ \"./node_modules/recaptcha-v3/dist/ReCaptchaInstance.js\");\nObject.defineProperty(exports, \"ReCaptchaInstance\", ({ enumerable: true, get: function () { return ReCaptchaInstance_1.ReCaptchaInstance; } }));\n\n\n//# sourceURL=webpack://formhandler/./node_modules/recaptcha-v3/dist/ReCaptcha.js?");

/***/ }),

/***/ "./node_modules/recaptcha-v3/dist/ReCaptchaInstance.js":
/*!*************************************************************!*\
  !*** ./node_modules/recaptcha-v3/dist/ReCaptchaInstance.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, exports) {

eval("\nvar __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {\n    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }\n    return new (P || (P = Promise))(function (resolve, reject) {\n        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }\n        function rejected(value) { try { step(generator[\"throw\"](value)); } catch (e) { reject(e); } }\n        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }\n        step((generator = generator.apply(thisArg, _arguments || [])).next());\n    });\n};\nvar __generator = (this && this.__generator) || function (thisArg, body) {\n    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;\n    return g = { next: verb(0), \"throw\": verb(1), \"return\": verb(2) }, typeof Symbol === \"function\" && (g[Symbol.iterator] = function() { return this; }), g;\n    function verb(n) { return function (v) { return step([n, v]); }; }\n    function step(op) {\n        if (f) throw new TypeError(\"Generator is already executing.\");\n        while (_) try {\n            if (f = 1, y && (t = op[0] & 2 ? y[\"return\"] : op[0] ? y[\"throw\"] || ((t = y[\"return\"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;\n            if (y = 0, t) op = [op[0] & 2, t.value];\n            switch (op[0]) {\n                case 0: case 1: t = op; break;\n                case 4: _.label++; return { value: op[1], done: false };\n                case 5: _.label++; y = op[1]; op = [0]; continue;\n                case 7: op = _.ops.pop(); _.trys.pop(); continue;\n                default:\n                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }\n                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }\n                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }\n                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }\n                    if (t[2]) _.ops.pop();\n                    _.trys.pop(); continue;\n            }\n            op = body.call(thisArg, _);\n        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }\n        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };\n    }\n};\nObject.defineProperty(exports, \"__esModule\", ({ value: true }));\nexports.ReCaptchaInstance = void 0;\nvar ReCaptchaInstance = (function () {\n    function ReCaptchaInstance(siteKey, recaptchaID, recaptcha) {\n        this.siteKey = siteKey;\n        this.recaptchaID = recaptchaID;\n        this.recaptcha = recaptcha;\n        this.styleContainer = null;\n    }\n    ReCaptchaInstance.prototype.execute = function (action) {\n        return __awaiter(this, void 0, void 0, function () {\n            return __generator(this, function (_a) {\n                return [2, this.recaptcha.enterprise ? this.recaptcha.enterprise.execute(this.recaptchaID, { action: action }) : this.recaptcha.execute(this.recaptchaID, { action: action })];\n            });\n        });\n    };\n    ReCaptchaInstance.prototype.getSiteKey = function () {\n        return this.siteKey;\n    };\n    ReCaptchaInstance.prototype.hideBadge = function () {\n        if (this.styleContainer !== null) {\n            return;\n        }\n        this.styleContainer = document.createElement('style');\n        this.styleContainer.innerHTML = '.grecaptcha-badge{visibility:hidden !important;}';\n        document.head.appendChild(this.styleContainer);\n    };\n    ReCaptchaInstance.prototype.showBadge = function () {\n        if (this.styleContainer === null) {\n            return;\n        }\n        document.head.removeChild(this.styleContainer);\n        this.styleContainer = null;\n    };\n    return ReCaptchaInstance;\n}());\nexports.ReCaptchaInstance = ReCaptchaInstance;\n\n\n//# sourceURL=webpack://formhandler/./node_modules/recaptcha-v3/dist/ReCaptchaInstance.js?");

/***/ }),

/***/ "./node_modules/recaptcha-v3/dist/ReCaptchaLoader.js":
/*!***********************************************************!*\
  !*** ./node_modules/recaptcha-v3/dist/ReCaptchaLoader.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

eval("\nObject.defineProperty(exports, \"__esModule\", ({ value: true }));\nexports.getInstance = exports.load = void 0;\nvar ReCaptchaInstance_1 = __webpack_require__(/*! ./ReCaptchaInstance */ \"./node_modules/recaptcha-v3/dist/ReCaptchaInstance.js\");\nvar ELoadingState;\n(function (ELoadingState) {\n    ELoadingState[ELoadingState[\"NOT_LOADED\"] = 0] = \"NOT_LOADED\";\n    ELoadingState[ELoadingState[\"LOADING\"] = 1] = \"LOADING\";\n    ELoadingState[ELoadingState[\"LOADED\"] = 2] = \"LOADED\";\n})(ELoadingState || (ELoadingState = {}));\nvar ReCaptchaLoader = (function () {\n    function ReCaptchaLoader() {\n    }\n    ReCaptchaLoader.load = function (siteKey, options) {\n        if (options === void 0) { options = {}; }\n        if (typeof document === 'undefined') {\n            return Promise.reject(new Error('This is a library for the browser!'));\n        }\n        if (ReCaptchaLoader.getLoadingState() === ELoadingState.LOADED) {\n            if (ReCaptchaLoader.instance.getSiteKey() === siteKey) {\n                return Promise.resolve(ReCaptchaLoader.instance);\n            }\n            else {\n                return Promise.reject(new Error('reCAPTCHA already loaded with different site key!'));\n            }\n        }\n        if (ReCaptchaLoader.getLoadingState() === ELoadingState.LOADING) {\n            if (siteKey !== ReCaptchaLoader.instanceSiteKey) {\n                return Promise.reject(new Error('reCAPTCHA already loaded with different site key!'));\n            }\n            return new Promise(function (resolve, reject) {\n                ReCaptchaLoader.successfulLoadingConsumers.push(function (instance) { return resolve(instance); });\n                ReCaptchaLoader.errorLoadingRunnable.push(function (reason) { return reject(reason); });\n            });\n        }\n        ReCaptchaLoader.instanceSiteKey = siteKey;\n        ReCaptchaLoader.setLoadingState(ELoadingState.LOADING);\n        var loader = new ReCaptchaLoader();\n        return new Promise(function (resolve, reject) {\n            loader.loadScript(siteKey, options.useRecaptchaNet || false, options.useEnterprise || false, options.renderParameters ? options.renderParameters : {}, options.customUrl).then(function () {\n                ReCaptchaLoader.setLoadingState(ELoadingState.LOADED);\n                var widgetID = loader.doExplicitRender(grecaptcha, siteKey, options.explicitRenderParameters ? options.explicitRenderParameters : {}, options.useEnterprise || false);\n                var instance = new ReCaptchaInstance_1.ReCaptchaInstance(siteKey, widgetID, grecaptcha);\n                ReCaptchaLoader.successfulLoadingConsumers.forEach(function (v) { return v(instance); });\n                ReCaptchaLoader.successfulLoadingConsumers = [];\n                if (options.autoHideBadge) {\n                    instance.hideBadge();\n                }\n                ReCaptchaLoader.instance = instance;\n                resolve(instance);\n            }).catch(function (error) {\n                ReCaptchaLoader.errorLoadingRunnable.forEach(function (v) { return v(error); });\n                ReCaptchaLoader.errorLoadingRunnable = [];\n                reject(error);\n            });\n        });\n    };\n    ReCaptchaLoader.getInstance = function () {\n        return ReCaptchaLoader.instance;\n    };\n    ReCaptchaLoader.setLoadingState = function (state) {\n        ReCaptchaLoader.loadingState = state;\n    };\n    ReCaptchaLoader.getLoadingState = function () {\n        if (ReCaptchaLoader.loadingState === null) {\n            return ELoadingState.NOT_LOADED;\n        }\n        else {\n            return ReCaptchaLoader.loadingState;\n        }\n    };\n    ReCaptchaLoader.prototype.loadScript = function (siteKey, useRecaptchaNet, useEnterprise, renderParameters, customUrl) {\n        var _this = this;\n        if (useRecaptchaNet === void 0) { useRecaptchaNet = false; }\n        if (useEnterprise === void 0) { useEnterprise = false; }\n        if (renderParameters === void 0) { renderParameters = {}; }\n        if (customUrl === void 0) { customUrl = ''; }\n        var scriptElement = document.createElement('script');\n        scriptElement.setAttribute('recaptcha-v3-script', '');\n        var scriptBase = 'https://www.google.com/recaptcha/api.js';\n        if (useRecaptchaNet) {\n            if (useEnterprise) {\n                scriptBase = 'https://recaptcha.net/recaptcha/enterprise.js';\n            }\n            else {\n                scriptBase = 'https://recaptcha.net/recaptcha/api.js';\n            }\n        }\n        if (useEnterprise) {\n            scriptBase = 'https://www.google.com/recaptcha/enterprise.js';\n        }\n        if (customUrl) {\n            scriptBase = customUrl;\n        }\n        if (renderParameters.render) {\n            renderParameters.render = undefined;\n        }\n        var parametersQuery = this.buildQueryString(renderParameters);\n        scriptElement.src = scriptBase + '?render=explicit' + parametersQuery;\n        return new Promise(function (resolve, reject) {\n            scriptElement.addEventListener('load', _this.waitForScriptToLoad(function () {\n                resolve(scriptElement);\n            }, useEnterprise), false);\n            scriptElement.onerror = function (error) {\n                ReCaptchaLoader.setLoadingState(ELoadingState.NOT_LOADED);\n                reject(error);\n            };\n            document.head.appendChild(scriptElement);\n        });\n    };\n    ReCaptchaLoader.prototype.buildQueryString = function (parameters) {\n        var parameterKeys = Object.keys(parameters);\n        if (parameterKeys.length < 1) {\n            return '';\n        }\n        return '&' + Object.keys(parameters)\n            .filter(function (parameterKey) {\n            return !!parameters[parameterKey];\n        })\n            .map(function (parameterKey) {\n            return parameterKey + '=' + parameters[parameterKey];\n        }).join('&');\n    };\n    ReCaptchaLoader.prototype.waitForScriptToLoad = function (callback, useEnterprise) {\n        var _this = this;\n        return function () {\n            if (window.grecaptcha === undefined) {\n                setTimeout(function () {\n                    _this.waitForScriptToLoad(callback, useEnterprise);\n                }, ReCaptchaLoader.SCRIPT_LOAD_DELAY);\n            }\n            else {\n                if (useEnterprise) {\n                    window.grecaptcha.enterprise.ready(function () {\n                        callback();\n                    });\n                }\n                else {\n                    window.grecaptcha.ready(function () {\n                        callback();\n                    });\n                }\n            }\n        };\n    };\n    ReCaptchaLoader.prototype.doExplicitRender = function (grecaptcha, siteKey, parameters, isEnterprise) {\n        var augmentedParameters = {\n            sitekey: siteKey,\n            badge: parameters.badge,\n            size: parameters.size,\n            tabindex: parameters.tabindex\n        };\n        if (parameters.container) {\n            if (isEnterprise) {\n                return grecaptcha.enterprise.render(parameters.container, augmentedParameters);\n            }\n            else {\n                return grecaptcha.render(parameters.container, augmentedParameters);\n            }\n        }\n        else {\n            if (isEnterprise) {\n                return grecaptcha.enterprise.render(augmentedParameters);\n            }\n            else {\n                return grecaptcha.render(augmentedParameters);\n            }\n        }\n    };\n    ReCaptchaLoader.loadingState = null;\n    ReCaptchaLoader.instance = null;\n    ReCaptchaLoader.instanceSiteKey = null;\n    ReCaptchaLoader.successfulLoadingConsumers = [];\n    ReCaptchaLoader.errorLoadingRunnable = [];\n    ReCaptchaLoader.SCRIPT_LOAD_DELAY = 25;\n    return ReCaptchaLoader;\n}());\nexports.load = ReCaptchaLoader.load;\nexports.getInstance = ReCaptchaLoader.getInstance;\n\n\n//# sourceURL=webpack://formhandler/./node_modules/recaptcha-v3/dist/ReCaptchaLoader.js?");

/***/ }),

/***/ "./Resources/Private/TypeScript/ReCaptcha.ts":
/*!***************************************************!*\
  !*** ./Resources/Private/TypeScript/ReCaptcha.ts ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _modules_ReCaptchaSubmit__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/ReCaptchaSubmit */ \"./Resources/Private/TypeScript/modules/ReCaptchaSubmit.ts\");\n\ndocument.addEventListener('DOMContentLoaded', function () {\n    var recaptchaForm = document.querySelector('form.formhandler');\n    if (null !== recaptchaForm) {\n        new _modules_ReCaptchaSubmit__WEBPACK_IMPORTED_MODULE_0__.ReCaptchaSubmit(recaptchaForm);\n    }\n});\n\n\n//# sourceURL=webpack://formhandler/./Resources/Private/TypeScript/ReCaptcha.ts?");

/***/ }),

/***/ "./Resources/Private/TypeScript/modules/ReCaptchaSubmit.ts":
/*!*****************************************************************!*\
  !*** ./Resources/Private/TypeScript/modules/ReCaptchaSubmit.ts ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"ReCaptchaSubmit\": () => (/* binding */ ReCaptchaSubmit)\n/* harmony export */ });\n/* harmony import */ var recaptcha_v3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! recaptcha-v3 */ \"./node_modules/recaptcha-v3/dist/ReCaptcha.js\");\n\nvar ReCaptchaSubmit = /** @class */ (function () {\n    function ReCaptchaSubmit(container) {\n        var _this = this;\n        var _a;\n        this.container = container;\n        this.captchaInput = this.container.querySelector('#ReCaptchaField');\n        this.siteKey = String(this.captchaInput.dataset.sitekey);\n        (_a = this.container\n            .querySelector('[type=\"submit\"]')) === null || _a === void 0 ? void 0 : _a.addEventListener('click', function (e) { return _this.handleClick(e); });\n    }\n    ReCaptchaSubmit.prototype.handleClick = function (e) {\n        var _this = this;\n        console.log('triggered!');\n        e.preventDefault();\n        (0,recaptcha_v3__WEBPACK_IMPORTED_MODULE_0__.load)(this.siteKey).then(function (recaptcha) {\n            recaptcha.execute('submit').then(function (token) {\n                console.log(token);\n                _this.captchaInput.value = token;\n                _this.container.submit();\n            });\n        });\n    };\n    return ReCaptchaSubmit;\n}());\n\n\n\n//# sourceURL=webpack://formhandler/./Resources/Private/TypeScript/modules/ReCaptchaSubmit.ts?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./Resources/Private/TypeScript/ReCaptcha.ts");
/******/ 	
/******/ })()
;