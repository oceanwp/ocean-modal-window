(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _classPrivateFieldInitSpec(obj, privateMap, value) { _checkPrivateRedeclaration(obj, privateMap); privateMap.set(obj, value); }
function _checkPrivateRedeclaration(obj, privateCollection) { if (privateCollection.has(obj)) { throw new TypeError("Cannot initialize the same private elements twice on an object"); } }
function _classPrivateFieldGet(receiver, privateMap) { var descriptor = _classExtractFieldDescriptor(receiver, privateMap, "get"); return _classApplyDescriptorGet(receiver, descriptor); }
function _classApplyDescriptorGet(receiver, descriptor) { if (descriptor.get) { return descriptor.get.call(receiver); } return descriptor.value; }
function _classPrivateFieldSet(receiver, privateMap, value) { var descriptor = _classExtractFieldDescriptor(receiver, privateMap, "set"); _classApplyDescriptorSet(receiver, descriptor, value); return value; }
function _classExtractFieldDescriptor(receiver, privateMap, action) { if (!privateMap.has(receiver)) { throw new TypeError("attempted to " + action + " private field on non-instance"); } return privateMap.get(receiver); }
function _classApplyDescriptorSet(receiver, descriptor, value) { if (descriptor.set) { descriptor.set.call(receiver, value); } else { if (!descriptor.writable) { throw new TypeError("attempted to set read only private field"); } descriptor.value = value; } }
var _settings = /*#__PURE__*/new WeakMap();
var OW_Base = /*#__PURE__*/function () {
  function OW_Base() {
    _classCallCheck(this, OW_Base);
    _classPrivateFieldInitSpec(this, _settings, {
      writable: true,
      value: void 0
    });
    _defineProperty(this, "elements", void 0);
    this.onInit();
    this.bindEvents();
  }
  _createClass(OW_Base, [{
    key: "getDefaultSettings",
    value: function getDefaultSettings() {
      return {};
    }
  }, {
    key: "getDefaultElements",
    value: function getDefaultElements() {
      return {};
    }
  }, {
    key: "onInit",
    value: function onInit() {
      _classPrivateFieldSet(this, _settings, this.getDefaultSettings());
      this.elements = this.getDefaultElements();
    }
  }, {
    key: "bindEvents",
    value: function bindEvents() {}
  }, {
    key: "getSettings",
    value: function getSettings() {
      var key = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
      if (!!key) {
        return _classPrivateFieldGet(this, _settings)[key];
      }
      return _classPrivateFieldGet(this, _settings);
    }
  }, {
    key: "setSettings",
    value: function setSettings() {
      var settings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      if (!settings) {
        return;
      }
      _classPrivateFieldSet(this, _settings, Object.assign(_classPrivateFieldGet(this, _settings), settings));
    }
  }]);
  return OW_Base;
}();
var _default = OW_Base;
exports["default"] = _default;

},{}],2:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.slideUp = exports.slideToggle = exports.slideDown = exports.fadeToggle = exports.fadeOut = exports.fadeIn = void 0;
var slideDown = function slideDown(element) {
  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 300;
  var display = window.getComputedStyle(element).display;
  if (display === "none") {
    display = "block";
  }
  element.style.transitionProperty = "height";
  element.style.transitionDuration = "".concat(duration, "ms");
  element.style.opacity = 0;
  element.style.display = display;
  var height = element.offsetHeight;
  element.style.height = 0;
  element.style.opacity = 1;
  element.style.overflow = "hidden";
  setTimeout(function () {
    element.style.height = "".concat(height, "px");
  }, 5);
  window.setTimeout(function () {
    element.style.removeProperty("height");
    element.style.removeProperty("overflow");
    element.style.removeProperty("transition-duration");
    element.style.removeProperty("transition-property");
    element.style.removeProperty("opacity");
  }, duration + 50);
};
exports.slideDown = slideDown;
var slideUp = function slideUp(element) {
  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 300;
  element.style.boxSizing = "border-box";
  element.style.transitionProperty = "height, margin";
  element.style.transitionDuration = "".concat(duration, "ms");
  element.style.height = "".concat(element.offsetHeight, "px");
  element.style.marginTop = 0;
  element.style.marginBottom = 0;
  element.style.overflow = "hidden";
  setTimeout(function () {
    element.style.height = 0;
  }, 5);
  window.setTimeout(function () {
    element.style.display = "none";
    element.style.removeProperty("height");
    element.style.removeProperty("margin-top");
    element.style.removeProperty("margin-bottom");
    element.style.removeProperty("overflow");
    element.style.removeProperty("transition-duration");
    element.style.removeProperty("transition-property");
  }, duration + 50);
};
exports.slideUp = slideUp;
var slideToggle = function slideToggle(element, duration) {
  window.getComputedStyle(element).display === "none" ? slideDown(element, duration) : slideUp(element, duration);
};
exports.slideToggle = slideToggle;
var fadeIn = function fadeIn(element) {
  var _options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  var options = {
    duration: 300,
    display: null,
    opacity: 1,
    callback: null
  };
  Object.assign(options, _options);
  element.style.opacity = 0;
  element.style.display = options.display || "block";
  setTimeout(function () {
    element.style.transition = "".concat(options.duration, "ms opacity ease");
    element.style.opacity = options.opacity;
  }, 5);
  setTimeout(function () {
    element.style.removeProperty("transition");
    !!options.callback && options.callback();
  }, options.duration + 50);
};
exports.fadeIn = fadeIn;
var fadeOut = function fadeOut(element) {
  var _options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  var options = {
    duration: 300,
    display: null,
    opacity: 0,
    callback: null
  };
  Object.assign(options, _options);
  element.style.opacity = 1;
  element.style.display = options.display || "block";
  setTimeout(function () {
    element.style.transition = "".concat(options.duration, "ms opacity ease");
    element.style.opacity = options.opacity;
  }, 5);
  setTimeout(function () {
    element.style.display = "none";
    element.style.removeProperty("transition");
    !!options.callback && options.callback();
  }, options.duration + 50);
};
exports.fadeOut = fadeOut;
var fadeToggle = function fadeToggle(element, options) {
  window.getComputedStyle(element).display === "none" ? fadeIn(element, options) : fadeOut(element, options);
};
exports.fadeToggle = fadeToggle;

},{}],3:[function(require,module,exports){
"use strict";

var _base = _interopRequireDefault(require("./base/base"));
var _utils = require("./lib/utils");
var _delegate = _interopRequireDefault(require("delegate"));
function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _get() { if (typeof Reflect !== "undefined" && Reflect.get) { _get = Reflect.get.bind(); } else { _get = function _get(target, property, receiver) { var base = _superPropBase(target, property); if (!base) return; var desc = Object.getOwnPropertyDescriptor(base, property); if (desc.get) { return desc.get.call(arguments.length < 3 ? target : receiver); } return desc.value; }; } return _get.apply(this, arguments); }
function _superPropBase(object, property) { while (!Object.prototype.hasOwnProperty.call(object, property)) { object = _getPrototypeOf(object); if (object === null) break; } return object; }
function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); Object.defineProperty(subClass, "prototype", { writable: false }); if (superClass) _setPrototypeOf(subClass, superClass); }
function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }
function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }
function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } else if (call !== void 0) { throw new TypeError("Derived constructors may only return object or undefined"); } return _assertThisInitialized(self); }
function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }
function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }
function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
var OW_ModalWindow = /*#__PURE__*/function (_OW_Base) {
  _inherits(OW_ModalWindow, _OW_Base);
  var _super = _createSuper(OW_ModalWindow);
  function OW_ModalWindow() {
    var _this;
    _classCallCheck(this, OW_ModalWindow);
    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }
    _this = _super.call.apply(_super, [this].concat(args));
    _defineProperty(_assertThisInitialized(_this), "modal", void 0);
    return _this;
  }
  _createClass(OW_ModalWindow, [{
    key: "getDefaultSettings",
    value: function getDefaultSettings() {
      return {
        selectors: {
          modalWindow: ".omw-modal",
          modalWindowOpenButtons: ".omw-open-modal, .omw-open-modal a, .omw-open-modal a.elementor-button, li.sidr-class-omw-open-modal > a, li.sidr-class-opl-login-li > a",
          modalWindowCloseBtn: ".omw-close-modal",
          overlay: ".omw-modal-overlay"
        }
      };
    }
  }, {
    key: "getDefaultElements",
    value: function getDefaultElements() {
      var selectors = this.getSettings("selectors");
      return {
        modalWindow: document.querySelector(selectors.modalWindow),
        modalWindowOpenButtons: document.querySelectorAll(selectors.modalWindowOpenButtons),
        modalWindowCloseBtn: document.querySelector(selectors.modalWindowCloseBtn),
        overlay: document.querySelector(selectors.overlay),
        body: document.body
      };
    }
  }, {
    key: "onInit",
    value: function onInit() {
      _get(_getPrototypeOf(OW_ModalWindow.prototype), "onInit", this).call(this);
      if (!!this.elements.modalWindow) {
        this.initPerfectScrollbar();
      }
    }
  }, {
    key: "bindEvents",
    value: function bindEvents() {
      var _this2 = this;
      if (!this.elements.modalWindow) {
        return;
      }
      this.elements.modalWindowOpenButtons.forEach(function (modalOpenBtn) {
        modalOpenBtn.addEventListener("click", _this2.openModal.bind(_this2));
      });
      (0, _delegate["default"])(document.body, ".omw-close-modal", "click", this.closeModal.bind(this));
      this.elements.overlay.addEventListener("click", this.closeModal.bind(this));
      window.addEventListener("keyup", this.onWindowKeyup.bind(this));
    }
  }, {
    key: "openModal",
    value: function openModal(event) {
      event.preventDefault();
      event.stopPropagation();
      var modalOpenBtn = event.currentTarget;
      var modalID = modalOpenBtn.getAttribute("href");
      this.modal = document.querySelector(modalID);
      if (!!this.modal) {
        this.elements.body.classList.add(this.modal.id);
        (0, _utils.fadeIn)(this.elements.overlay);
        (0, _utils.fadeIn)(this.modal);
        this.modal.classList.add("omw-open");
      }
    }
  }, {
    key: "closeModal",
    value: function closeModal(event) {
      var _this3 = this;
      event.preventDefault();
      if (!this.modal) {
        return;
      }
      if (!this.modal.classList.contains("omw-open")) {
        return;
      }
      (0, _utils.fadeOut)(this.elements.overlay);
      (0, _utils.fadeOut)(this.modal);
      this.modal.classList.remove("omw-open");

      // Stop video
      var iframes = this.modal.querySelectorAll("iframe");
      if (!!iframes) {
        iframes.forEach(function (iframe) {
          iframe.src = iframe.src;
        });
      }
      setTimeout(function () {
        _this3.elements.body.classList.remove(_this3.modal.id);
      }, 300);
    }
  }, {
    key: "onWindowKeyup",
    value: function onWindowKeyup(event) {
      var isESCKey = event.keyCode === 27 ? true : false;
      if (isESCKey) {
        this.closeModal(event);
      }
    }
  }, {
    key: "initPerfectScrollbar",
    value: function initPerfectScrollbar() {
      new PerfectScrollbar(this.elements.modalWindow, {
        wheelSpeed: 0.5,
        suppressScrollX: false,
        suppressScrollY: false
      });
    }
  }]);
  return OW_ModalWindow;
}(_base["default"]);
"use script";
new OW_ModalWindow();

},{"./base/base":1,"./lib/utils":2,"delegate":5}],4:[function(require,module,exports){
var DOCUMENT_NODE_TYPE = 9;

/**
 * A polyfill for Element.matches()
 */
if (typeof Element !== 'undefined' && !Element.prototype.matches) {
    var proto = Element.prototype;

    proto.matches = proto.matchesSelector ||
                    proto.mozMatchesSelector ||
                    proto.msMatchesSelector ||
                    proto.oMatchesSelector ||
                    proto.webkitMatchesSelector;
}

/**
 * Finds the closest parent that matches a selector.
 *
 * @param {Element} element
 * @param {String} selector
 * @return {Function}
 */
function closest (element, selector) {
    while (element && element.nodeType !== DOCUMENT_NODE_TYPE) {
        if (typeof element.matches === 'function' &&
            element.matches(selector)) {
          return element;
        }
        element = element.parentNode;
    }
}

module.exports = closest;

},{}],5:[function(require,module,exports){
var closest = require('./closest');

/**
 * Delegates event to a selector.
 *
 * @param {Element} element
 * @param {String} selector
 * @param {String} type
 * @param {Function} callback
 * @param {Boolean} useCapture
 * @return {Object}
 */
function _delegate(element, selector, type, callback, useCapture) {
    var listenerFn = listener.apply(this, arguments);

    element.addEventListener(type, listenerFn, useCapture);

    return {
        destroy: function() {
            element.removeEventListener(type, listenerFn, useCapture);
        }
    }
}

/**
 * Delegates event to a selector.
 *
 * @param {Element|String|Array} [elements]
 * @param {String} selector
 * @param {String} type
 * @param {Function} callback
 * @param {Boolean} useCapture
 * @return {Object}
 */
function delegate(elements, selector, type, callback, useCapture) {
    // Handle the regular Element usage
    if (typeof elements.addEventListener === 'function') {
        return _delegate.apply(null, arguments);
    }

    // Handle Element-less usage, it defaults to global delegation
    if (typeof type === 'function') {
        // Use `document` as the first parameter, then apply arguments
        // This is a short way to .unshift `arguments` without running into deoptimizations
        return _delegate.bind(null, document).apply(null, arguments);
    }

    // Handle Selector-based usage
    if (typeof elements === 'string') {
        elements = document.querySelectorAll(elements);
    }

    // Handle Array-like based usage
    return Array.prototype.map.call(elements, function (element) {
        return _delegate(element, selector, type, callback, useCapture);
    });
}

/**
 * Finds closest match and invokes callback.
 *
 * @param {Element} element
 * @param {String} selector
 * @param {String} type
 * @param {Function} callback
 * @return {Function}
 */
function listener(element, selector, type, callback) {
    return function(e) {
        e.delegateTarget = closest(e.target, selector);

        if (e.delegateTarget) {
            callback.call(element, e);
        }
    }
}

module.exports = delegate;

},{"./closest":4}]},{},[3])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJhc3NldHMvc3JjL2pzL2Jhc2UvYmFzZS5qcyIsImFzc2V0cy9zcmMvanMvbGliL3V0aWxzLmpzIiwiYXNzZXRzL3NyYy9qcy9tb2RhbC13aW5kb3cuanMiLCJub2RlX21vZHVsZXMvZGVsZWdhdGUvc3JjL2Nsb3Nlc3QuanMiLCJub2RlX21vZHVsZXMvZGVsZWdhdGUvc3JjL2RlbGVnYXRlLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0lDQU0sT0FBTztFQUlULFNBQUEsUUFBQSxFQUFjO0lBQUEsZUFBQSxPQUFBLE9BQUE7SUFBQSwwQkFBQSxPQUFBLFNBQUE7TUFBQSxRQUFBO01BQUEsS0FBQTtJQUFBO0lBQUEsZUFBQTtJQUNWLElBQUksQ0FBQyxNQUFNLENBQUMsQ0FBQztJQUNiLElBQUksQ0FBQyxVQUFVLENBQUMsQ0FBQztFQUNyQjtFQUFDLFlBQUEsQ0FBQSxPQUFBO0lBQUEsR0FBQTtJQUFBLEtBQUEsRUFFRCxTQUFBLG1CQUFBLEVBQXFCO01BQ2pCLE9BQU8sQ0FBQyxDQUFDO0lBQ2I7RUFBQztJQUFBLEdBQUE7SUFBQSxLQUFBLEVBRUQsU0FBQSxtQkFBQSxFQUFxQjtNQUNqQixPQUFPLENBQUMsQ0FBQztJQUNiO0VBQUM7SUFBQSxHQUFBO0lBQUEsS0FBQSxFQUVELFNBQUEsT0FBQSxFQUFTO01BQ0wscUJBQUEsS0FBSSxFQUFBLFNBQUEsRUFBYSxJQUFJLENBQUMsa0JBQWtCLENBQUMsQ0FBQztNQUMxQyxJQUFJLENBQUMsUUFBUSxHQUFHLElBQUksQ0FBQyxrQkFBa0IsQ0FBQyxDQUFDO0lBQzdDO0VBQUM7SUFBQSxHQUFBO0lBQUEsS0FBQSxFQUVELFNBQUEsV0FBQSxFQUFhLENBQUM7RUFBQztJQUFBLEdBQUE7SUFBQSxLQUFBLEVBRWYsU0FBQSxZQUFBLEVBQXdCO01BQUEsSUFBWixHQUFHLEdBQUEsU0FBQSxD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QSxtQkFBQSxXQUFBO0FBQUEsU0FBQSxLQUFBLGVBQUEsT0FBQSxvQkFBQSxPQUFBLENBQUEsR0FBQSxJQUFBLElBQUEsR0FBQSxPQUFBLENBQUEsR0FBQSxDQUFBLElBQUEsYUFBQSxJQUFBLFlBQUEsS0FBQSxNQUFBLEVBQUEsUUFBQSxFQUFBLFFBQUEsUUFBQSxJQUFBLEdBQUEsY0FBQSxDQUFBLE1BQUEsRUFBQSxRQUFBLFFBQUEsSUFBQSxjQUFBLElBQUEsR0FBQSxNQUFBLENBQUEsd0JBQUEsQ0FBQSxJQUFBLEVBQUEsUUFBQSxPQUFBLElBQUEsQ0FBQSxHQUFBLFdBQUEsSUFBQSxDQUFBLEdBQUEsQ0FBQSxJQUFBLENBQUEsU0FBQSxDQUFBLE1BQUEsT0FBQSxNQUFBLEdBQUEsUUFBQSxZQUFBLElBQUEsQ0FBQSxLQUFBLGNBQUEsSUFBQSxDQUFBLEtBQUEsT0FBQSxTQUFBO0FBQUEsU0FBQSxlQUFBLE1BQUEsRUFBQSxRQUFBLFlBQUEsTUFBQSxDQUFBLFNBQUEsQ0FBQSxjQUFBLENBQUEsSUFBQSxDQUFBLE1BQUEsRUFBQSxRQUFBLEtBQUEsTUFBQSxHQUFBLGVBQUEsQ0FBQSxNQUFBLE9BQUEsTUFBQSwyQkFBQSxNQUFBO0FBQUEsU0FBQSxVQUFBLFFBQUEsRUFBQSxVQUFBLGVBQUEsVUFBQSxtQkFBQSxVQUFBLHVCQUFBLFNBQUEsMERBQUEsUUFBQSxDQUFBLFNBQUEsR0FBQSxNQUFBLENBQUEsTUFBQSxDQUFBLFVBQUEsSUFBQSxVQUFBLENBQUEsU0FBQSxJQUFBLFdBQUEsSUFBQSxLQUFBLEVBQUEsUUFBQSxFQUFBLFFBQUEsUUFBQSxZQUFBLGFBQUEsTUFBQSxDQUFBLGNBQUEsQ0FBQSxRQUFBLGlCQUFBLFFBQUEsZ0JBQUEsVUFBQSxFQUFBLGVBQUEsQ0FBQSxRQUFBLEVBQUEsVUFBQTtBQUFBLFNBQUEsZ0JBQUEsQ0FBQSxFQUFBLENBQUEsSUFBQSxlQUFBLEdBQUEsTUFBQSxDQUFBLGNBQUEsR0FBQSxNQUFBLENBQUEsY0FBQSxDQUFBLElBQUEsY0FBQSxnQkFBQSxDQUFBLEVBQUEsQ0FBQSxJQUFBLENBQUEsQ0FBQSxTQUFBLEdBQUEsQ0FBQSxTQUFBLENBQUEsWUFBQSxlQUFBLENBQUEsQ0FBQSxFQUFBLENBQUE7QUFBQSxTQUFBLGFBQUEsT0FBQSxRQUFBLHlCQUFBLEdBQUEseUJBQUEsb0JBQUEscUJBQUEsUUFBQSxLQUFBLEdBQUEsZUFBQSxDQUFBLE9BQUEsR0FBQSxNQUFBLE1BQUEseUJBQUEsUUFBQSxTQUFBLEdBQUEsZUFBQSxPQUFBLFdBQUEsRUFBQSxNQUFBLEdBQUEsT0FBQSxDQUFBLFNBQUEsQ0FBQSxLQUFBLEVBQUEsU0FBQSxFQUFBLFNBQUEsWUFBQSxNQUFBLEdBQUEsS0FBQSxDQUFBLEtBQUEsT0FBQSxTQUFBLFlBQUEsMEJBQUEsT0FBQSxNQUFBO0FBQUEsU0FBQSwyQkFBQSxJQUFBLEVBQUEsSUFBQSxRQUFBLElBQUEsS0FBQSxPQUFBLENBQUEsSUFBQSx5QkFBQSxJQUFBLDJCQUFBLElBQUEsYUFBQSxJQUFBLHlCQUFBLFNBQUEsdUVBQUEsc0JBQUEsQ0FBQSxJQUFBO0FBQUEsU0FBQSx1QkFBQSxJQUFBLFFBQUEsSUFBQSx5QkFBQSxjQUFBLHdFQUFBLElBQUE7QUFBQSxTQUFBLDBCQUFBLGVBQUEsT0FBQSxxQkFBQSxPQUFBLENBQUEsU0FBQSxvQkFBQSxPQUFBLENBQUEsU0FBQSxDQUFBLElBQUEsMkJBQUEsS0FBQSxvQ0FBQSxPQUFBLENBQUEsU0FBQSxDQUFBLE9BQUEsQ0FBQSxJQUFBLENBQUEsT0FBQSxDQUFBLFNBQUEsQ0FBQSxPQUFBLDhDQUFBLENBQUE7QUFBQSxTQUFBLGdCQUFBLENBQUEsSUFBQSxlQUFBLEdBQUEsTUFBQSxDQUFBLGNBQUEsR0FBQSxNQUFBLENBQUEsY0FBQSxDQUFBLElBQUEsY0FBQSxnQkFBQSxDQUFBLFdBQUEsQ0FBQSxDQUFBLFNBQUEsSUFBQSxNQUFBLENBQUEsY0FBQSxDQUFBLENBQUEsYUFBQSxlQUFBLENBQUEsQ0FBQTtBQUFBLFNBQUEsZ0JBQUEsR0FBQSxFQUFBLEdBQUEsRUFBQSxLQUFBLElBQUEsR0FBQSxHQUFBLGNBQUEsQ0FBQSxHQUFBLE9BQUEsR0FBQSxJQUFBLEdBQUEsSUFBQSxNQUFBLENBQUEsY0FBQSxDQUFBLEdBQUEsRUFBQSxHQUFBLElBQUEsS0FBQSxFQUFBLEtBQUEsRUFBQSxVQUFBLFFBQUEsWUFBQSxRQUFBLFFBQUEsb0JBQUEsR0FBQSxDQUFBLEdBQUEsSUFBQSxLQUFBLFdBQUEsR0FBQTtBQUFBLFNBQUEsZUFBQSxHQUFBLFFBQUEsR0FBQSxHQUFBLFlBQUEsQ0FBQSxHQUFBLG9CQUFBLE9BQUEsQ0FBQSxHQUFBLGlCQUFBLEdBQUEsR0FBQSxNQUFBLENBQUEsR0FBQTtBQUFBLFNBQUEsYUFBQSxLQUFBLEVBQUEsSUFBQSxRQUFBLE9BQUEsQ0FBQSxLQUFBLGtCQUFBLEtBQUEsa0JBQUEsS0FBQSxNQUFBLElBQUEsR0FBQSxLQUFBLENBQUEsTUFBQSxDQUFBLFdBQUEsT0FBQSxJQUFBLEtBQUEsU0FBQSxRQUFBLEdBQUEsR0FBQSxJQUFBLENBQUEsSUFBQSxDQUFBLEtBQUEsRUFBQSxJQUFBLG9CQUFBLE9BQUEsQ0FBQSxHQUFBLHVCQUFBLEdBQUEsWUFBQSxTQUFBLDREQUFBLElBQUEsZ0JBQUEsTUFBQSxHQUFBLE1BQUEsRUFBQSxLQUFBO0FBQUEsSUFFMUIsY0FBYywwQkFBQSxRQUFBO0VBQUEsU0FBQSxDQUFBLGNBQUEsRUFBQSxRQUFBO0VBQUEsSUFBQSxNQUFBLEdBQUEsWUFBQSxDQUFBLGNBQUE7RUFBQSxTQUFBLGVBQUE7SUFBQSxJQUFBLEtBQUE7SUFBQSxlQUFBLE9BQUEsY0FBQTtJQUFBLFNBQUEsSUFBQSxHQUFBLFNBQUEsQ0FBQSxNQUFBLEVBQUEsSUFBQSxPQUFBLEtBQUEsQ0FBQSxJQUFBLEdBQUEsSUFBQSxNQUFBLElBQUEsR0FBQSxJQUFBLEVBQUEsSUFBQTtNQUFBLElBQUEsQ0FBQSxJQUFBLElBQUEsU0FBQSxDQUFBLElBQUE7SUFBQTtJQUFBLEtBQUEsR0FBQSxNQUFBLENBQUEsSUFBQSxDQUFBLEtBQUEsQ0FBQSxNQUFBLFNBQUEsTUFBQSxDQUFBLElB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QUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbigpe2Z1bmN0aW9uIHIoZSxuLHQpe2Z1bmN0aW9uIG8oaSxmKXtpZighbltpXSl7aWYoIWVbaV0pe3ZhciBjPVwiZnVuY3Rpb25cIj09dHlwZW9mIHJlcXVpcmUmJnJlcXVpcmU7aWYoIWYmJmMpcmV0dXJuIGMoaSwhMCk7aWYodSlyZXR1cm4gdShpLCEwKTt2YXIgYT1uZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiK2krXCInXCIpO3Rocm93IGEuY29kZT1cIk1PRFVMRV9OT1RfRk9VTkRcIixhfXZhciBwPW5baV09e2V4cG9ydHM6e319O2VbaV1bMF0uY2FsbChwLmV4cG9ydHMsZnVuY3Rpb24ocil7dmFyIG49ZVtpXVsxXVtyXTtyZXR1cm4gbyhufHxyKX0scCxwLmV4cG9ydHMscixlLG4sdCl9cmV0dXJuIG5baV0uZXhwb3J0c31mb3IodmFyIHU9XCJmdW5jdGlvblwiPT10eXBlb2YgcmVxdWlyZSYmcmVxdWlyZSxpPTA7aTx0Lmxlbmd0aDtpKyspbyh0W2ldKTtyZXR1cm4gb31yZXR1cm4gcn0pKCkiLCJjbGFzcyBPV19CYXNlIHtcbiAgICAjc2V0dGluZ3M7XG4gICAgZWxlbWVudHM7XG5cbiAgICBjb25zdHJ1Y3RvcigpIHtcbiAgICAgICAgdGhpcy5vbkluaXQoKTtcbiAgICAgICAgdGhpcy5iaW5kRXZlbnRzKCk7XG4gICAgfVxuXG4gICAgZ2V0RGVmYXVsdFNldHRpbmdzKCkge1xuICAgICAgICByZXR1cm4ge307XG4gICAgfVxuXG4gICAgZ2V0RGVmYXVsdEVsZW1lbnRzKCkge1xuICAgICAgICByZXR1cm4ge307XG4gICAgfVxuXG4gICAgb25Jbml0KCkge1xuICAgICAgICB0aGlzLiNzZXR0aW5ncyA9IHRoaXMuZ2V0RGVmYXVsdFNldHRpbmdzKCk7XG4gICAgICAgIHRoaXMuZWxlbWVudHMgPSB0aGlzLmdldERlZmF1bHRFbGVtZW50cygpO1xuICAgIH1cblxuICAgIGJpbmRFdmVudHMoKSB7fVxuXG4gICAgZ2V0U2V0dGluZ3Moa2V5ID0gbnVsbCkge1xuICAgICAgICBpZiAoISFrZXkpIHtcbiAgICAgICAgICAgIHJldHVybiB0aGlzLiNzZXR0aW5nc1trZXldO1xuICAgICAgICB9XG5cbiAgICAgICAgcmV0dXJuIHRoaXMuI3NldHRpbmdzO1xuICAgIH1cblxuICAgIHNldFNldHRpbmdzKHNldHRpbmdzID0ge30pIHtcbiAgICAgICAgaWYgKCFzZXR0aW5ncykge1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy4jc2V0dGluZ3MgPSBPYmplY3QuYXNzaWduKHRoaXMuI3NldHRpbmdzLCBzZXR0aW5ncyk7XG4gICAgfVxufVxuXG5leHBvcnQgZGVmYXVsdCBPV19CYXNlO1xuIiwiZXhwb3J0IGNvbnN0IHNsaWRlRG93biA9IChlbGVtZW50LCBkdXJhdGlvbiA9IDMwMCkgPT4ge1xuICAgIGxldCBkaXNwbGF5ID0gd2luZG93LmdldENvbXB1dGVkU3R5bGUoZWxlbWVudCkuZGlzcGxheTtcblxuICAgIGlmIChkaXNwbGF5ID09PSBcIm5vbmVcIikge1xuICAgICAgICBkaXNwbGF5ID0gXCJibG9ja1wiO1xuICAgIH1cblxuICAgIGVsZW1lbnQuc3R5bGUudHJhbnNpdGlvblByb3BlcnR5ID0gXCJoZWlnaHRcIjtcbiAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb25EdXJhdGlvbiA9IGAke2R1cmF0aW9ufW1zYDtcblxuICAgIGVsZW1lbnQuc3R5bGUub3BhY2l0eSA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5kaXNwbGF5ID0gZGlzcGxheTtcbiAgICBsZXQgaGVpZ2h0ID0gZWxlbWVudC5vZmZzZXRIZWlnaHQ7XG5cbiAgICBlbGVtZW50LnN0eWxlLmhlaWdodCA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5vcGFjaXR5ID0gMTtcbiAgICBlbGVtZW50LnN0eWxlLm92ZXJmbG93ID0gXCJoaWRkZW5cIjtcblxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICBlbGVtZW50LnN0eWxlLmhlaWdodCA9IGAke2hlaWdodH1weGA7XG4gICAgfSwgNSk7XG5cbiAgICB3aW5kb3cuc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJoZWlnaHRcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJvdmVyZmxvd1wiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcInRyYW5zaXRpb24tZHVyYXRpb25cIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJ0cmFuc2l0aW9uLXByb3BlcnR5XCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwib3BhY2l0eVwiKTtcbiAgICB9LCBkdXJhdGlvbiArIDUwKTtcbn07XG5cbmV4cG9ydCBjb25zdCBzbGlkZVVwID0gKGVsZW1lbnQsIGR1cmF0aW9uID0gMzAwKSA9PiB7XG4gICAgZWxlbWVudC5zdHlsZS5ib3hTaXppbmcgPSBcImJvcmRlci1ib3hcIjtcbiAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb25Qcm9wZXJ0eSA9IFwiaGVpZ2h0LCBtYXJnaW5cIjtcbiAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb25EdXJhdGlvbiA9IGAke2R1cmF0aW9ufW1zYDtcbiAgICBlbGVtZW50LnN0eWxlLmhlaWdodCA9IGAke2VsZW1lbnQub2Zmc2V0SGVpZ2h0fXB4YDtcbiAgICBlbGVtZW50LnN0eWxlLm1hcmdpblRvcCA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5tYXJnaW5Cb3R0b20gPSAwO1xuICAgIGVsZW1lbnQuc3R5bGUub3ZlcmZsb3cgPSBcImhpZGRlblwiO1xuXG4gICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUuaGVpZ2h0ID0gMDtcbiAgICB9LCA1KTtcblxuICAgIHdpbmRvdy5zZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5kaXNwbGF5ID0gXCJub25lXCI7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJoZWlnaHRcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJtYXJnaW4tdG9wXCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwibWFyZ2luLWJvdHRvbVwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcIm92ZXJmbG93XCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwidHJhbnNpdGlvbi1kdXJhdGlvblwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcInRyYW5zaXRpb24tcHJvcGVydHlcIik7XG4gICAgfSwgZHVyYXRpb24gKyA1MCk7XG59O1xuXG5leHBvcnQgY29uc3Qgc2xpZGVUb2dnbGUgPSAoZWxlbWVudCwgZHVyYXRpb24pID0+IHtcbiAgICB3aW5kb3cuZ2V0Q29tcHV0ZWRTdHlsZShlbGVtZW50KS5kaXNwbGF5ID09PSBcIm5vbmVcIiA/IHNsaWRlRG93bihlbGVtZW50LCBkdXJhdGlvbikgOiBzbGlkZVVwKGVsZW1lbnQsIGR1cmF0aW9uKTtcbn07XG5cbmV4cG9ydCBjb25zdCBmYWRlSW4gPSAoZWxlbWVudCwgX29wdGlvbnMgPSB7fSkgPT4ge1xuICAgIGNvbnN0IG9wdGlvbnMgPSB7XG4gICAgICAgIGR1cmF0aW9uOiAzMDAsXG4gICAgICAgIGRpc3BsYXk6IG51bGwsXG4gICAgICAgIG9wYWNpdHk6IDEsXG4gICAgICAgIGNhbGxiYWNrOiBudWxsLFxuICAgIH07XG5cbiAgICBPYmplY3QuYXNzaWduKG9wdGlvbnMsIF9vcHRpb25zKTtcblxuICAgIGVsZW1lbnQuc3R5bGUub3BhY2l0eSA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5kaXNwbGF5ID0gb3B0aW9ucy5kaXNwbGF5IHx8IFwiYmxvY2tcIjtcblxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb24gPSBgJHtvcHRpb25zLmR1cmF0aW9ufW1zIG9wYWNpdHkgZWFzZWA7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUub3BhY2l0eSA9IG9wdGlvbnMub3BhY2l0eTtcbiAgICB9LCA1KTtcblxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwidHJhbnNpdGlvblwiKTtcbiAgICAgICAgISFvcHRpb25zLmNhbGxiYWNrICYmIG9wdGlvbnMuY2FsbGJhY2soKTtcbiAgICB9LCBvcHRpb25zLmR1cmF0aW9uICsgNTApO1xufTtcblxuZXhwb3J0IGNvbnN0IGZhZGVPdXQgPSAoZWxlbWVudCwgX29wdGlvbnMgPSB7fSkgPT4ge1xuICAgIGNvbnN0IG9wdGlvbnMgPSB7XG4gICAgICAgIGR1cmF0aW9uOiAzMDAsXG4gICAgICAgIGRpc3BsYXk6IG51bGwsXG4gICAgICAgIG9wYWNpdHk6IDAsXG4gICAgICAgIGNhbGxiYWNrOiBudWxsLFxuICAgIH07XG5cbiAgICBPYmplY3QuYXNzaWduKG9wdGlvbnMsIF9vcHRpb25zKTtcblxuICAgIGVsZW1lbnQuc3R5bGUub3BhY2l0eSA9IDE7XG4gICAgZWxlbWVudC5zdHlsZS5kaXNwbGF5ID0gb3B0aW9ucy5kaXNwbGF5IHx8IFwiYmxvY2tcIjtcblxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb24gPSBgJHtvcHRpb25zLmR1cmF0aW9ufW1zIG9wYWNpdHkgZWFzZWA7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUub3BhY2l0eSA9IG9wdGlvbnMub3BhY2l0eTtcbiAgICB9LCA1KTtcblxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICBlbGVtZW50LnN0eWxlLmRpc3BsYXkgPSBcIm5vbmVcIjtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcInRyYW5zaXRpb25cIik7XG4gICAgICAgICEhb3B0aW9ucy5jYWxsYmFjayAmJiBvcHRpb25zLmNhbGxiYWNrKCk7XG4gICAgfSwgb3B0aW9ucy5kdXJhdGlvbiArIDUwKTtcbn07XG5cbmV4cG9ydCBjb25zdCBmYWRlVG9nZ2xlID0gKGVsZW1lbnQsIG9wdGlvbnMpID0+IHtcbiAgICB3aW5kb3cuZ2V0Q29tcHV0ZWRTdHlsZShlbGVtZW50KS5kaXNwbGF5ID09PSBcIm5vbmVcIiA/IGZhZGVJbihlbGVtZW50LCBvcHRpb25zKSA6IGZhZGVPdXQoZWxlbWVudCwgb3B0aW9ucyk7XG59O1xuIiwiaW1wb3J0IE9XX0Jhc2UgZnJvbSBcIi4vYmFzZS9iYXNlXCI7XG5pbXBvcnQgeyBmYWRlSW4sIGZhZGVPdXQgfSBmcm9tIFwiLi9saWIvdXRpbHNcIjtcbmltcG9ydCBkZWxlZ2F0ZSBmcm9tIFwiZGVsZWdhdGVcIjtcblxuY2xhc3MgT1dfTW9kYWxXaW5kb3cgZXh0ZW5kcyBPV19CYXNlIHtcbiAgICBtb2RhbDtcblxuICAgIGdldERlZmF1bHRTZXR0aW5ncygpIHtcbiAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgIHNlbGVjdG9yczoge1xuICAgICAgICAgICAgICAgIG1vZGFsV2luZG93OiBcIi5vbXctbW9kYWxcIixcbiAgICAgICAgICAgICAgICBtb2RhbFdpbmRvd09wZW5CdXR0b25zOlxuICAgICAgICAgICAgICAgICAgICBcIi5vbXctb3Blbi1tb2RhbCwgLm9tdy1vcGVuLW1vZGFsIGEsIC5vbXctb3Blbi1tb2RhbCBhLmVsZW1lbnRvci1idXR0b24sIGxpLnNpZHItY2xhc3Mtb213LW9wZW4tbW9kYWwgPiBhLCBsaS5zaWRyLWNsYXNzLW9wbC1sb2dpbi1saSA+IGFcIixcbiAgICAgICAgICAgICAgICBtb2RhbFdpbmRvd0Nsb3NlQnRuOiBcIi5vbXctY2xvc2UtbW9kYWxcIixcbiAgICAgICAgICAgICAgICBvdmVybGF5OiBcIi5vbXctbW9kYWwtb3ZlcmxheVwiLFxuICAgICAgICAgICAgfSxcbiAgICAgICAgfTtcbiAgICB9XG5cbiAgICBnZXREZWZhdWx0RWxlbWVudHMoKSB7XG4gICAgICAgIGNvbnN0IHNlbGVjdG9ycyA9IHRoaXMuZ2V0U2V0dGluZ3MoXCJzZWxlY3RvcnNcIik7XG5cbiAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgIG1vZGFsV2luZG93OiBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKHNlbGVjdG9ycy5tb2RhbFdpbmRvdyksXG4gICAgICAgICAgICBtb2RhbFdpbmRvd09wZW5CdXR0b25zOiBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKHNlbGVjdG9ycy5tb2RhbFdpbmRvd09wZW5CdXR0b25zKSxcbiAgICAgICAgICAgIG1vZGFsV2luZG93Q2xvc2VCdG46IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3Ioc2VsZWN0b3JzLm1vZGFsV2luZG93Q2xvc2VCdG4pLFxuICAgICAgICAgICAgb3ZlcmxheTogZG9jdW1lbnQucXVlcnlTZWxlY3RvcihzZWxlY3RvcnMub3ZlcmxheSksXG4gICAgICAgICAgICBib2R5OiBkb2N1bWVudC5ib2R5LFxuICAgICAgICB9O1xuICAgIH1cblxuICAgIG9uSW5pdCgpIHtcbiAgICAgICAgc3VwZXIub25Jbml0KCk7XG5cbiAgICAgICAgaWYgKCEhdGhpcy5lbGVtZW50cy5tb2RhbFdpbmRvdykge1xuICAgICAgICAgICAgdGhpcy5pbml0UGVyZmVjdFNjcm9sbGJhcigpO1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgYmluZEV2ZW50cygpIHtcbiAgICAgICAgaWYgKCF0aGlzLmVsZW1lbnRzLm1vZGFsV2luZG93KSB7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLmVsZW1lbnRzLm1vZGFsV2luZG93T3BlbkJ1dHRvbnMuZm9yRWFjaCgobW9kYWxPcGVuQnRuKSA9PiB7XG4gICAgICAgICAgICBtb2RhbE9wZW5CdG4uYWRkRXZlbnRMaXN0ZW5lcihcImNsaWNrXCIsIHRoaXMub3Blbk1vZGFsLmJpbmQodGhpcykpO1xuICAgICAgICB9KTtcblxuICAgICAgICBkZWxlZ2F0ZShkb2N1bWVudC5ib2R5LCBcIi5vbXctY2xvc2UtbW9kYWxcIiwgXCJjbGlja1wiLCB0aGlzLmNsb3NlTW9kYWwuYmluZCh0aGlzKSk7XG4gICAgICAgIHRoaXMuZWxlbWVudHMub3ZlcmxheS5hZGRFdmVudExpc3RlbmVyKFwiY2xpY2tcIiwgdGhpcy5jbG9zZU1vZGFsLmJpbmQodGhpcykpO1xuXG4gICAgICAgIHdpbmRvdy5hZGRFdmVudExpc3RlbmVyKFwia2V5dXBcIiwgdGhpcy5vbldpbmRvd0tleXVwLmJpbmQodGhpcykpO1xuICAgIH1cblxuICAgIG9wZW5Nb2RhbChldmVudCkge1xuICAgICAgICBldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICBldmVudC5zdG9wUHJvcGFnYXRpb24oKTtcblxuICAgICAgICBjb25zdCBtb2RhbE9wZW5CdG4gPSBldmVudC5jdXJyZW50VGFyZ2V0O1xuICAgICAgICBjb25zdCBtb2RhbElEID0gbW9kYWxPcGVuQnRuLmdldEF0dHJpYnV0ZShcImhyZWZcIik7XG4gICAgICAgIHRoaXMubW9kYWwgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKG1vZGFsSUQpO1xuXG4gICAgICAgIGlmICghIXRoaXMubW9kYWwpIHtcbiAgICAgICAgICAgIHRoaXMuZWxlbWVudHMuYm9keS5jbGFzc0xpc3QuYWRkKHRoaXMubW9kYWwuaWQpO1xuICAgICAgICAgICAgZmFkZUluKHRoaXMuZWxlbWVudHMub3ZlcmxheSk7XG4gICAgICAgICAgICBmYWRlSW4odGhpcy5tb2RhbCk7XG4gICAgICAgICAgICB0aGlzLm1vZGFsLmNsYXNzTGlzdC5hZGQoXCJvbXctb3BlblwiKTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIGNsb3NlTW9kYWwoZXZlbnQpIHtcbiAgICAgICAgZXZlbnQucHJldmVudERlZmF1bHQoKTtcblxuICAgICAgICBpZiAoIXRoaXMubW9kYWwpIHtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmICghdGhpcy5tb2RhbC5jbGFzc0xpc3QuY29udGFpbnMoXCJvbXctb3BlblwiKSkge1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG5cbiAgICAgICAgZmFkZU91dCh0aGlzLmVsZW1lbnRzLm92ZXJsYXkpO1xuICAgICAgICBmYWRlT3V0KHRoaXMubW9kYWwpO1xuICAgICAgICB0aGlzLm1vZGFsLmNsYXNzTGlzdC5yZW1vdmUoXCJvbXctb3BlblwiKTtcblxuICAgICAgICAvLyBTdG9wIHZpZGVvXG4gICAgICAgIGNvbnN0IGlmcmFtZXMgPSB0aGlzLm1vZGFsLnF1ZXJ5U2VsZWN0b3JBbGwoXCJpZnJhbWVcIik7XG5cbiAgICAgICAgaWYgKCEhaWZyYW1lcykge1xuICAgICAgICAgICAgaWZyYW1lcy5mb3JFYWNoKChpZnJhbWUpID0+IHtcbiAgICAgICAgICAgICAgICBpZnJhbWUuc3JjID0gaWZyYW1lLnNyYztcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG5cbiAgICAgICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgICAgICB0aGlzLmVsZW1lbnRzLmJvZHkuY2xhc3NMaXN0LnJlbW92ZSh0aGlzLm1vZGFsLmlkKTtcbiAgICAgICAgfSwgMzAwKTtcbiAgICB9XG5cbiAgICBvbldpbmRvd0tleXVwKGV2ZW50KSB7XG4gICAgICAgIGNvbnN0IGlzRVNDS2V5ID0gZXZlbnQua2V5Q29kZSA9PT0gMjcgPyB0cnVlIDogZmFsc2U7XG5cbiAgICAgICAgaWYgKGlzRVNDS2V5KSB7XG4gICAgICAgICAgICB0aGlzLmNsb3NlTW9kYWwoZXZlbnQpO1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgaW5pdFBlcmZlY3RTY3JvbGxiYXIoKSB7XG4gICAgICAgIG5ldyBQZXJmZWN0U2Nyb2xsYmFyKHRoaXMuZWxlbWVudHMubW9kYWxXaW5kb3csIHtcbiAgICAgICAgICAgIHdoZWVsU3BlZWQ6IDAuNSxcbiAgICAgICAgICAgIHN1cHByZXNzU2Nyb2xsWDogZmFsc2UsXG4gICAgICAgICAgICBzdXBwcmVzc1Njcm9sbFk6IGZhbHNlLFxuICAgICAgICB9KTtcbiAgICB9XG59XG5cbihcInVzZSBzY3JpcHRcIik7XG5uZXcgT1dfTW9kYWxXaW5kb3coKTtcbiIsInZhciBET0NVTUVOVF9OT0RFX1RZUEUgPSA5O1xuXG4vKipcbiAqIEEgcG9seWZpbGwgZm9yIEVsZW1lbnQubWF0Y2hlcygpXG4gKi9cbmlmICh0eXBlb2YgRWxlbWVudCAhPT0gJ3VuZGVmaW5lZCcgJiYgIUVsZW1lbnQucHJvdG90eXBlLm1hdGNoZXMpIHtcbiAgICB2YXIgcHJvdG8gPSBFbGVtZW50LnByb3RvdHlwZTtcblxuICAgIHByb3RvLm1hdGNoZXMgPSBwcm90by5tYXRjaGVzU2VsZWN0b3IgfHxcbiAgICAgICAgICAgICAgICAgICAgcHJvdG8ubW96TWF0Y2hlc1NlbGVjdG9yIHx8XG4gICAgICAgICAgICAgICAgICAgIHByb3RvLm1zTWF0Y2hlc1NlbGVjdG9yIHx8XG4gICAgICAgICAgICAgICAgICAgIHByb3RvLm9NYXRjaGVzU2VsZWN0b3IgfHxcbiAgICAgICAgICAgICAgICAgICAgcHJvdG8ud2Via2l0TWF0Y2hlc1NlbGVjdG9yO1xufVxuXG4vKipcbiAqIEZpbmRzIHRoZSBjbG9zZXN0IHBhcmVudCB0aGF0IG1hdGNoZXMgYSBzZWxlY3Rvci5cbiAqXG4gKiBAcGFyYW0ge0VsZW1lbnR9IGVsZW1lbnRcbiAqIEBwYXJhbSB7U3RyaW5nfSBzZWxlY3RvclxuICogQHJldHVybiB7RnVuY3Rpb259XG4gKi9cbmZ1bmN0aW9uIGNsb3Nlc3QgKGVsZW1lbnQsIHNlbGVjdG9yKSB7XG4gICAgd2hpbGUgKGVsZW1lbnQgJiYgZWxlbWVudC5ub2RlVHlwZSAhPT0gRE9DVU1FTlRfTk9ERV9UWVBFKSB7XG4gICAgICAgIGlmICh0eXBlb2YgZWxlbWVudC5tYXRjaGVzID09PSAnZnVuY3Rpb24nICYmXG4gICAgICAgICAgICBlbGVtZW50Lm1hdGNoZXMoc2VsZWN0b3IpKSB7XG4gICAgICAgICAgcmV0dXJuIGVsZW1lbnQ7XG4gICAgICAgIH1cbiAgICAgICAgZWxlbWVudCA9IGVsZW1lbnQucGFyZW50Tm9kZTtcbiAgICB9XG59XG5cbm1vZHVsZS5leHBvcnRzID0gY2xvc2VzdDtcbiIsInZhciBjbG9zZXN0ID0gcmVxdWlyZSgnLi9jbG9zZXN0Jyk7XG5cbi8qKlxuICogRGVsZWdhdGVzIGV2ZW50IHRvIGEgc2VsZWN0b3IuXG4gKlxuICogQHBhcmFtIHtFbGVtZW50fSBlbGVtZW50XG4gKiBAcGFyYW0ge1N0cmluZ30gc2VsZWN0b3JcbiAqIEBwYXJhbSB7U3RyaW5nfSB0eXBlXG4gKiBAcGFyYW0ge0Z1bmN0aW9ufSBjYWxsYmFja1xuICogQHBhcmFtIHtCb29sZWFufSB1c2VDYXB0dXJlXG4gKiBAcmV0dXJuIHtPYmplY3R9XG4gKi9cbmZ1bmN0aW9uIF9kZWxlZ2F0ZShlbGVtZW50LCBzZWxlY3RvciwgdHlwZSwgY2FsbGJhY2ssIHVzZUNhcHR1cmUpIHtcbiAgICB2YXIgbGlzdGVuZXJGbiA9IGxpc3RlbmVyLmFwcGx5KHRoaXMsIGFyZ3VtZW50cyk7XG5cbiAgICBlbGVtZW50LmFkZEV2ZW50TGlzdGVuZXIodHlwZSwgbGlzdGVuZXJGbiwgdXNlQ2FwdHVyZSk7XG5cbiAgICByZXR1cm4ge1xuICAgICAgICBkZXN0cm95OiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIGVsZW1lbnQucmVtb3ZlRXZlbnRMaXN0ZW5lcih0eXBlLCBsaXN0ZW5lckZuLCB1c2VDYXB0dXJlKTtcbiAgICAgICAgfVxuICAgIH1cbn1cblxuLyoqXG4gKiBEZWxlZ2F0ZXMgZXZlbnQgdG8gYSBzZWxlY3Rvci5cbiAqXG4gKiBAcGFyYW0ge0VsZW1lbnR8U3RyaW5nfEFycmF5fSBbZWxlbWVudHNdXG4gKiBAcGFyYW0ge1N0cmluZ30gc2VsZWN0b3JcbiAqIEBwYXJhbSB7U3RyaW5nfSB0eXBlXG4gKiBAcGFyYW0ge0Z1bmN0aW9ufSBjYWxsYmFja1xuICogQHBhcmFtIHtCb29sZWFufSB1c2VDYXB0dXJlXG4gKiBAcmV0dXJuIHtPYmplY3R9XG4gKi9cbmZ1bmN0aW9uIGRlbGVnYXRlKGVsZW1lbnRzLCBzZWxlY3RvciwgdHlwZSwgY2FsbGJhY2ssIHVzZUNhcHR1cmUpIHtcbiAgICAvLyBIYW5kbGUgdGhlIHJlZ3VsYXIgRWxlbWVudCB1c2FnZVxuICAgIGlmICh0eXBlb2YgZWxlbWVudHMuYWRkRXZlbnRMaXN0ZW5lciA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgICByZXR1cm4gX2RlbGVnYXRlLmFwcGx5KG51bGwsIGFyZ3VtZW50cyk7XG4gICAgfVxuXG4gICAgLy8gSGFuZGxlIEVsZW1lbnQtbGVzcyB1c2FnZSwgaXQgZGVmYXVsdHMgdG8gZ2xvYmFsIGRlbGVnYXRpb25cbiAgICBpZiAodHlwZW9mIHR5cGUgPT09ICdmdW5jdGlvbicpIHtcbiAgICAgICAgLy8gVXNlIGBkb2N1bWVudGAgYXMgdGhlIGZpcnN0IHBhcmFtZXRlciwgdGhlbiBhcHBseSBhcmd1bWVudHNcbiAgICAgICAgLy8gVGhpcyBpcyBhIHNob3J0IHdheSB0byAudW5zaGlmdCBgYXJndW1lbnRzYCB3aXRob3V0IHJ1bm5pbmcgaW50byBkZW9wdGltaXphdGlvbnNcbiAgICAgICAgcmV0dXJuIF9kZWxlZ2F0ZS5iaW5kKG51bGwsIGRvY3VtZW50KS5hcHBseShudWxsLCBhcmd1bWVudHMpO1xuICAgIH1cblxuICAgIC8vIEhhbmRsZSBTZWxlY3Rvci1iYXNlZCB1c2FnZVxuICAgIGlmICh0eXBlb2YgZWxlbWVudHMgPT09ICdzdHJpbmcnKSB7XG4gICAgICAgIGVsZW1lbnRzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChlbGVtZW50cyk7XG4gICAgfVxuXG4gICAgLy8gSGFuZGxlIEFycmF5LWxpa2UgYmFzZWQgdXNhZ2VcbiAgICByZXR1cm4gQXJyYXkucHJvdG90eXBlLm1hcC5jYWxsKGVsZW1lbnRzLCBmdW5jdGlvbiAoZWxlbWVudCkge1xuICAgICAgICByZXR1cm4gX2RlbGVnYXRlKGVsZW1lbnQsIHNlbGVjdG9yLCB0eXBlLCBjYWxsYmFjaywgdXNlQ2FwdHVyZSk7XG4gICAgfSk7XG59XG5cbi8qKlxuICogRmluZHMgY2xvc2VzdCBtYXRjaCBhbmQgaW52b2tlcyBjYWxsYmFjay5cbiAqXG4gKiBAcGFyYW0ge0VsZW1lbnR9IGVsZW1lbnRcbiAqIEBwYXJhbSB7U3RyaW5nfSBzZWxlY3RvclxuICogQHBhcmFtIHtTdHJpbmd9IHR5cGVcbiAqIEBwYXJhbSB7RnVuY3Rpb259IGNhbGxiYWNrXG4gKiBAcmV0dXJuIHtGdW5jdGlvbn1cbiAqL1xuZnVuY3Rpb24gbGlzdGVuZXIoZWxlbWVudCwgc2VsZWN0b3IsIHR5cGUsIGNhbGxiYWNrKSB7XG4gICAgcmV0dXJuIGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgZS5kZWxlZ2F0ZVRhcmdldCA9IGNsb3Nlc3QoZS50YXJnZXQsIHNlbGVjdG9yKTtcblxuICAgICAgICBpZiAoZS5kZWxlZ2F0ZVRhcmdldCkge1xuICAgICAgICAgICAgY2FsbGJhY2suY2FsbChlbGVtZW50LCBlKTtcbiAgICAgICAgfVxuICAgIH1cbn1cblxubW9kdWxlLmV4cG9ydHMgPSBkZWxlZ2F0ZTtcbiJdfQ==
