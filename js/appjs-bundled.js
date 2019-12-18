/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./js/app.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./js/app.js":
/*!*******************!*\
  !*** ./js/app.js ***!
  \*******************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _modules_Search__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/Search */ \"./js/modules/Search.js\");\n\r\n\r\nvar search = new _modules_Search__WEBPACK_IMPORTED_MODULE_0__[\"default\"]();\r\n\n\n//# sourceURL=webpack:///./js/app.js?");

/***/ }),

/***/ "./js/modules/Search.js":
/*!******************************!*\
  !*** ./js/modules/Search.js ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n!(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }());\n//53. Open and Close Search Overlay\r\n\r\n\r\nclass Search {\r\n  //Class Section 1: init\r\n  constructor() {\r\n    this.addSearchHTML();\r\n    this.resultsDiv = !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(\".search-overlay__results\");\r\n    this.openButton = !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(\".js-search-trigger\");\r\n    this.closeButton = !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(\".search-overlay__close\");\r\n    this.searchOverlay = !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(\".search-overlay\");\r\n    this.searchField = !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(\".search-term\");\r\n    this.events();\r\n    this.isOverlayOpen = false;\r\n    this.isSpinnerVisible = false;\r\n    this.previousValue = \" \";\r\n    this.typingTimer;\r\n  }\r\n\r\n  //2. events\r\n  events() {\r\n    this.openButton.on(\"click\", this.openOverlay.bind(this));\r\n    this.closeButton.on(\"click\", this.closeOverlay.bind(this));\r\n    !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(document).on(\"keydown\", this.keyPressDispatcher.bind(this));\r\n    this.searchField.on(\"keyup\", this.typingLogic.bind(this));\r\n  }\r\n\r\n  //3. methods\r\n  //55. Managing Time in Javascript | 55.. Add Key Press Timer\r\n  typingLogic() {\r\n    if (this.searchField.val().trim() != this.previousValue.trim()) {\r\n      clearTimeout(this.typingTimer);\r\n\r\n      if (this.searchField.val()) {\r\n        if (!this.isSpinnerVisible) {\r\n          this.resultsDiv.html('<div class=\"spinner-loader\"></div>');\r\n          this.isSpinnerVisible = true;\r\n        }\r\n        this.typingTimer = setTimeout(this.getResults.bind(this), 750);\r\n      } else {\r\n        this.resultsDiv.html(\"\");\r\n        this.isSpinnerVisible = false;\r\n      }\r\n\r\n      this.previousValue = this.searchField.val();\r\n    }\r\n  }\r\n\r\n  getResults() {\r\n    //68. 3 Column Layout for Search Overlay\r\n    !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }()).getJSON(\r\n      //universityDate is returned by PHP module functions.php\r\n      universityData.root_url +\r\n        \"/wp-json/pidrealty/v1/search?xSearch=\" +\r\n        this.searchField.val(),\r\n\r\n      xPosts => {\r\n        //console.log(results);\r\n        this.resultsDiv.html(`\r\n            <div class=\"row\">\r\n                <div class=\"one-third\">\r\n                    <h2 class=\"search-overlay__section-title\">General Information</h2>\r\n                    ${\r\n                      xPosts.generalInfo.length > 0\r\n                        ? '<ul class=\"link-list min-list\">'\r\n                        : \"<p>No Search Results</p>\"\r\n                    }\r\n                    ${xPosts.generalInfo\r\n                      .map(\r\n                        xPost =>\r\n                          `<li><a href=\"${xPost.url}\">${xPost.title}</a> ${\r\n                            xPost.postType == \"post\"\r\n                              ? \"by \" + xPost.authorName\r\n                              : \"\"\r\n                          } </li>`\r\n                      )\r\n                      .join(\"\")}\r\n                      ${xPosts.generalInfo.length > 0 ? \"</ul>\" : \"\"}\r\n                </div>\r\n                <div class=\"one-third\">\r\n                    <h2 class=\"search-overlay__section-title\">Programs</h2>\r\n                    ${\r\n                      xPosts.programs.length > 0\r\n                        ? '<ul class=\"link-list min-list\">'\r\n                        : \"<p>No Search Results</p>\"\r\n                    }\r\n                    ${xPosts.programs\r\n                      .map(\r\n                        xPost =>\r\n                          `<li><a href=\"${xPost.url}\">${xPost.title}</a>  </li>`\r\n                      )\r\n                      .join(\"\")}\r\n                    ${xPosts.programs.length > 0 ? \"</ul>\" : \"\"}\r\n\r\n                    ${\r\n                      /* 69. Custom Layout & JSON based on Post Type */ console.log()\r\n                    }\r\n                    <h2 class=\"search-overlay__section-title\">Professors</h2>\r\n                    ${\r\n                      xPosts.professors.length > 0\r\n                        ? '<ul class=\"link-list min-list\">'\r\n                        : \"<p>No Search Results</p>\"\r\n                    }\r\n                    ${xPosts.professors\r\n                      .map(\r\n                        xPost => `\r\n                            <li class=\"professor-card__list-item\">\r\n                            <a class=\"professor-card\" href=\"${xPost.url}\">\r\n                                <img class=\"professor-card__image\" src=\"${xPost.thumbnailURL}\">\r\n                                <span class=\"professor-card__name\">${xPost.title}</span>\r\n                            </a>\r\n                            </li>\r\n                        `\r\n                      )\r\n                      .join(\"\")}\r\n                    ${xPosts.professors.length > 0 ? \"</ul>\" : \"\"}\r\n\r\n                </div>\r\n                <div class=\"one-third\">\r\n                    <h2 class=\"search-overlay__section-title\">Communities</h2>\r\n                    ${\r\n                      xPosts.communities.length > 0\r\n                        ? '<ul class=\"link-list min-list\">'\r\n                        : \"<p>No Search Results</p>\"\r\n                    }\r\n                    ${xPosts.communities\r\n                      .map(\r\n                        xPost =>\r\n                          `<li><a href=\"${xPost.url}\">${xPost.title}</a>  </li>`\r\n                      )\r\n                      .join(\"\")}\r\n                    ${xPosts.communities.length > 0 ? \"</ul>\" : \"\"}\r\n                    \r\n                    <h2 class=\"search-overlay__section-title\">Events</h2>\r\n                    ${\r\n                      xPosts.events.length > 0 ? \"\" : \"<p>No Search Results</p>\"\r\n                    }\r\n                    ${xPosts.events\r\n                      .map(\r\n                        xPost => `\r\n                        <div class=\"event-summary\">\r\n                        <a class=\"event-summary__date t-center\" href=\"${xPost.url}\">\r\n                            <span class=\"event-summary__month\">${xPost.month}</span>\r\n                            <span class=\"event-summary__day\">${xPost.day}</span>  \r\n                        </a>\r\n                        <div class=\"event-summary__content\">\r\n                            <h5 class=\"event-summary__title headline headline--tiny\"><a href=\"${xPost.url}\">${xPost.title}</a></h5>\r\n                            <p>${xPost.description}<a href=\"${xPost.url}\" class=\"nu gray\">Learn more</a></p>\r\n                        </div>\r\n                        </div> `\r\n                      )\r\n                      .join(\"\")}\r\n                    ${xPosts.events.length > 0 ? \"\" : \"\"}\r\n                </div>\r\n            </div>\r\n        `);\r\n        this.isSpinnerVisible = false;\r\n      }\r\n    );\r\n  }\r\n\r\n  getResults_old() {\r\n    //61-62. Synchronous vs Asynchronous\r\n    !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }()).when(\r\n      //arg: call1(), call2(), ...\r\n      !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }()).getJSON(\r\n        universityData.root_url +\r\n          \"/wp-json/wp/v2/posts?search=\" +\r\n          this.searchField.val()\r\n      ),\r\n      !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }()).getJSON(\r\n        universityData.root_url +\r\n          \"/wp-json/wp/v2/pages?search=\" +\r\n          this.searchField.val()\r\n      )\r\n    ).then(\r\n      //response(fromCall1, fromCall2, ...), callback()\r\n      (posts, pages) => {\r\n        var combineResults = posts[0].concat(pages[0]);\r\n        this.resultsDiv.html(`\r\n        <h2 class=\"search-overlay__section-title\">General Information for Search New Version</h2>\r\n        ${\r\n          combineResults.length > 0\r\n            ? '<ul class=\"link-list min-list\">'\r\n            : \"<p>No Search Results</p>\"\r\n        }\r\n            ${combineResults\r\n              .map(\r\n                post =>\r\n                  `<li><a href=\"${post.link}\">${post.title.rendered}</a> ${\r\n                    post.type == \"post\" ? \"by \" + post.authorName : \"\"\r\n                  } </li>`\r\n              )\r\n              .join(\"\")}\r\n        ${combineResults.length > 0 ? \"</ul>\" : \"\"}\r\n        `);\r\n        this.isSpinnerVisible = false;\r\n      },\r\n      () => {\r\n        this.resultsDiv.html(\"<p>unexpected Error, please try again later</p>\");\r\n      }\r\n    );\r\n  }\r\n\r\n  openOverlay() {\r\n    this.searchOverlay.addClass(\"search-overlay--active\");\r\n    !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(\"body\").addClass(\"body-no-scroll\");\r\n    this.searchField.val(\"\");\r\n    setTimeout(() => this.searchField.focus(), 300);\r\n    this.isOverlayOpen = true;\r\n    return false;\r\n  }\r\n\r\n  closeOverlay() {\r\n    this.searchOverlay.removeClass(\"search-overlay--active\");\r\n    !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(\"body\").removeClass(\"body-no-scroll\");\r\n    this.isOverlayOpen = false;\r\n  }\r\n\r\n  //54. Keyboard Events in Javascript\r\n  keyPressDispatcher(e) {\r\n    if (\r\n      e.altKey &&\r\n      e.keyCode == 83 &&\r\n      !this.isOverlayOpen &&\r\n      !!(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(\"input, textarea\").is(\".focus\")\r\n    ) {\r\n      this.openOverlay();\r\n    }\r\n\r\n    if (e.keyCode == 27 && this.isOverlayOpen) {\r\n      this.closeOverlay();\r\n    }\r\n  }\r\n\r\n  //60. Add Search HTML\r\n  addSearchHTML() {\r\n    !(function webpackMissingModule() { var e = new Error(\"Cannot find module 'jquery'\"); e.code = 'MODULE_NOT_FOUND'; throw e; }())(\"body\").append(`\r\n        <div class=\"search-overlay\">\r\n            <div class=\"search-overlay__top\">\r\n            <div class=\"container\">\r\n                <i class=\"fa fa-search search-overlay__icon\" aria-hidden=\"true\"></i>\r\n                <input type=\"text\" class=\"search-term\" placeholder=\"What are you looking for?\">\r\n                <i class=\"fa fa-window-close search-overlay__close\" aria-hidden=\"true\"></i>\r\n            </div>\r\n            </div>\r\n            <div class=\"container\">\r\n            <div class=\"search-overlay__results\">\r\n                Search Results:\r\n            </div>\r\n            </div>\r\n        </div>\r\n      `);\r\n  }\r\n}\r\n\r\n/* harmony default export */ __webpack_exports__[\"default\"] = (Search);\r\n\n\n//# sourceURL=webpack:///./js/modules/Search.js?");

/***/ })

/******/ });