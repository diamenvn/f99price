(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define("shopdat09", [], factory);
	else if(typeof exports === 'object')
		exports["shopdat09"] = factory();
	else
		root["shopdat09"] = factory();
})(this, () => {
return /******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/custom.js":
/*!********************************!*\
  !*** ./resources/js/custom.js ***!
  \********************************/
/***/ (() => {

var app = {
  config: {
    routesUsingTheme: ['site.list.index', 'site.list.detail'],
    modalID: '#modal',
    modal: null
  },
  init: function init() {
    $(function () {
      app.action.clickDom();
      app.running.setCSRF();
      app.running.loadDefault();
    });
  },
  action: {
    clickDom: function clickDom() {
      $(document).on('click', '.call_ajax_modal-js', function (e) {
        self = $(this);
        href = self.attr('data-href') || self.attr('href');
        maxWidth = self.attr('max-width') || '600px';
        e.preventDefault();
        $.ajax({
          url: href + "?popup=true",
          type: 'GET',
          dataType: 'html'
        }).done(function (res, status, xhr) {
          if (xhr.status == 200) {
            openModal(res, maxWidth);
            app.action.activeUpload();
          }
        }).fail(function (res) {
          if (res.status == 401) {
            window.location.href = window.loginURI + "?callback=" + window.location.href;
          }
        });
      }).on('click', '.call_ajax_remove-js', function (e) {
        self = $(this);
        href = self.attr('data-href') || self.attr('href');
        e.preventDefault();
        $.confirm({
          title: 'Xoá trang này',
          content: 'Bạn có chắc chắn muốn xoá?',
          buttons: {
            confirm: {
              text: 'Xoá',
              btnClass: 'btn-red',
              keys: ['enter'],
              action: function action() {
                $.ajax({
                  url: href,
                  type: 'DELETE',
                  dataType: 'json'
                }).done(function (res) {
                  alert(res.msg);
                  if (res.success) {
                    window.location.reload();
                  }
                });
              }
            },
            cancel: function cancel() {}
          }
        });
      }).on('submit', '.form_submit_ajax-js', function (e) {
        e.preventDefault();
        method = $(this).attr('method') || "POST";
        d = $(this).serializeArray();
        href = $(this).attr('action') || "";
        $.ajax({
          url: href,
          type: method,
          data: d,
          dataType: 'json'
        }).done(function (res) {
          alert(res.msg);
          if (res.success) {
            window.location.reload();
          }
        });
      }).on('click', '.btn-category-add-display-view-js', function () {
        domClone = $(this).attr('data-dom-clone');
        domParent = $(this).attr('data-dom-parent');
        if (domClone && domParent) {
          $(domParent).append($(domClone).clone().show());
        }
      }).on('click', '[event-click-remove-dom]', function () {
        findType = $(this).attr('data-find-type') || "this";
        domRemove = $(this).attr('event-click-remove-dom');
        alert = $(this).attr('data-alert') || false;
        if (alert == "true" && !confirm("Bạn có chắc chắn muốn xoá")) {
          return;
        }
        if (findType == "this") {
          $(domRemove).remove();
        } else {
          $(this).closest(domRemove).remove();
        }
      }).on('click', '.submit_form-js', function () {
        form = $(this).attr('data-form') || null;
        if (form) {
          $(form).submit();
        }
      }).on('click', '.app_navigation-js', function () {
        get = localStorage.getItem('sidebar-right-display');
        if (get == "hide") {
          $('.sidebar--right-js').css('display', 'block');
          localStorage.setItem("sidebar-right-display", "show");
        } else {
          animateCSS('.sidebar--right-js', 'zoomOutLeft').then(function (message) {
            $('.sidebar--right-js').hide();
            localStorage.setItem("sidebar-right-display", "hide");
          });
        }
      }).on('click', '.sidebar__lists-items-js', function () {
        // animateCSS('.main-content', 'fadeOutDown').then((message) => {
        //     // localStorage.setItem("sidebar-right-display", "hide");
        //     $('.main-content').hide();
        // });
      }).on('click', '.btn-add-product-js', function () {
        form = $(this).attr('data-form-target');
        stt = $(form).find('tr').length;
        html = "<tr><th scope=\"row\">" + stt + "</th>\n                    <td><input class=\"form-control\" name=\"product[]\" type=\"text\" value=\"\" placeholder=\"Nh\u1EADp t\xEAn s\u1EA3n ph\u1EA9m...\"></td>\n                    <td>\n                        <div class=\"btn btn-danger btn-click-remove-product-js\">\n                            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-trash\" viewBox=\"0 0 16 16\">\n                                <path d=\"M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\"></path>\n                                <path fill-rule=\"evenodd\" d=\"M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\"></path>\n                            </svg>\n                        </div>\n                        <div class=\"btn btn-secondary drag-handler\">\n                            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-arrows-expand\" viewBox=\"0 0 16 16\">\n                                <path fill-rule=\"evenodd\" d=\"M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8zM7.646.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 1.707V5.5a.5.5 0 0 1-1 0V1.707L6.354 2.854a.5.5 0 1 1-.708-.708l2-2zM8 10a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 14.293V10.5A.5.5 0 0 1 8 10z\"/>\n                            </svg>\n                        </div>\n                    </td></tr>";
        $(form).find('tbody').append(html);
      }).on('click', '.btn-click-remove-product-js', function () {
        $(this).closest('tr').remove();
      }).on('click', '.btn-click-add-page-js', function () {
        alert();
      });
    },
    openModal: function openModal() {
      var message = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
      var confirm = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      var cancel = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
      app.config.modal = app.running.initModal();
      app.config.modal.setContent(message);
      app.config.modal.addFooterBtn('Huỷ bỏ', 'tingle-btn tingle-btn--default', function () {
        if (!!cancel) {
          cancel();
        } else {
          app.config.modal.destroy();
        }
      });
      if (!!confirm) {
        app.config.modal.addFooterBtn('Xác nhận', 'tingle-btn tingle-btn--primary', function () {
          confirm();
        });
      }
      app.config.modal.open();
    },
    activeUpload: function activeUpload() {
      $('[type="file"]').filepond({
        labelIdle: 'Kéo thả file hoặc nhấn vào <span class="filepond--label-action"> đây </span>'
      });
      $("[data-type='currency']").simpleMoneyFormat();
    }
  },
  running: {
    setCSRF: function setCSRF() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    },
    initModal: function initModal() {
      modal = new tingle.modal({
        footer: true,
        stickyFooter: false,
        closeMethods: ['overlay', 'button', 'escape'],
        closeLabel: "Close",
        cssClass: ['custom-modal'],
        onClose: function onClose() {
          modal.destroy();
        },
        beforeClose: function beforeClose() {
          return true;
        }
      });
      return modal;
    },
    loadDefault: function loadDefault() {
      $.fn.filepond.setOptions({
        server: {
          process: function process(fieldName, file, metadata, load, error, progress, _abort, transfer, options) {
            var formData = new FormData();
            formData.append('file', file, file.name);
            var request = new XMLHttpRequest();
            request.open('POST', window.uploadURI);
            request.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute("content"));
            request.onload = function () {
              if (request.status >= 200 && request.status < 300) {
                load(JSON.parse(request.responseText).data);
              } else {
                error('Error');
              }
            };
            request.send(formData);

            // Should expose an abort method so the request can be cancelled
            return {
              abort: function abort() {
                // This function is entered if the user has tapped the cancel button
                request.abort();

                // Let FilePond know the request has been cancelled
                _abort();
              }
            };
          }
        }
      });
      $("[data-type='currency']").simpleMoneyFormat();
      get = localStorage.getItem('sidebar-right-display');
      if (get == "hide") {
        $('.sidebar--right-js').hide();
      }
    }
  }
};
openModal = function openModal() {
  var html = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
  var size = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "600px";
  modal = $(app.config.modalID);
  modal.find('.modal-dialog').css('max-width', size);
  modal.find('.modal-body').html(html);
  modal.modal();
};
app.init();

/***/ }),

/***/ "./resources/sass/app.sass":
/*!*********************************!*\
  !*** ./resources/sass/app.sass ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/css/filepond/filepond.css":
/*!*********************************************!*\
  !*** ./resources/css/filepond/filepond.css ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/css/vendor.css":
/*!**********************************!*\
  !*** ./resources/css/vendor.css ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


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
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
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
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/assets/js/custom": 0,
/******/ 			"assets/css/app": 0,
/******/ 			"assets/css/vendor": 0,
/******/ 			"assets/css/filepond": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = this["webpackChunkshopdat09"] = this["webpackChunkshopdat09"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["assets/css/app","assets/css/vendor","assets/css/filepond"], () => (__webpack_require__("./resources/js/custom.js")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/app","assets/css/vendor","assets/css/filepond"], () => (__webpack_require__("./resources/sass/app.sass")))
/******/ 	__webpack_require__.O(undefined, ["assets/css/app","assets/css/vendor","assets/css/filepond"], () => (__webpack_require__("./resources/css/filepond/filepond.css")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/css/app","assets/css/vendor","assets/css/filepond"], () => (__webpack_require__("./resources/css/vendor.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ 	return __webpack_exports__;
/******/ })()
;
});