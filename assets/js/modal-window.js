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
      document.addEventListener("init-omw-for-element", this.bindEvent.bind(this));
    }
  }, {
    key: "bindEvent",
    value: function bindEvent(event) {
      event.target.addEventListener("click", this.openModal.bind(this));
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJhc3NldHMvc3JjL2pzL2Jhc2UvYmFzZS5qcyIsImFzc2V0cy9zcmMvanMvbGliL3V0aWxzLmpzIiwiYXNzZXRzL3NyYy9qcy9tb2RhbC13aW5kb3cuanMiLCJub2RlX21vZHVsZXMvZGVsZWdhdGUvc3JjL2Nsb3Nlc3QuanMiLCJub2RlX21vZHVsZXMvZGVsZWdhdGUvc3JjL2RlbGVnYXRlLmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0lDQU0sT0FBTztFQUlULFNBQUEsUUFBQSxFQUFjO0lBQUEsZUFBQSxPQUFBLE9BQUE7SUFBQSwwQkFBQSxPQUFBLFNBQUE7TUFBQSxRQUFBO01BQUEsS0FBQTtJQUFBO0lBQUEsZUFBQTtJQUNWLElBQUksQ0FBQyxNQUFNLENBQUMsQ0FBQztJQUNiLElBQUksQ0FBQyxVQUFVLENBQUMsQ0FBQztFQUNyQjtFQUFDLFlBQUEsQ0FBQSxPQUFBO0lBQUEsR0FBQTtJQUFBLEtBQUEsRUFFRCxTQUFBLG1CQUFBLEVBQXFCO01BQ2pCLE9BQU8sQ0FBQyxDQUFDO0lBQ2I7RUFBQztJQUFBLEdBQUE7SUFBQSxLQUFBLEVBRUQsU0FBQSxtQkFBQSxFQUFxQjtNQUNqQixPQUFPLENBQUMsQ0FBQztJQUNiO0VBQUM7SUFBQSxHQUFBO0lBQUEsS0FBQSxFQUVELFNBQUEsT0FBQSxFQUFTO01BQ0wscUJBQUEsS0FBSSxFQUFBLFNBQUEsRUFBYSxJQUFJLENBQUMsa0JBQWtCLENBQUMsQ0FBQztNQUMxQyxJQUFJLENBQUMsUUFBUSxHQUFHLElBQUksQ0FBQyxrQkFBa0IsQ0FBQyxDQUFDO0lBQzdDO0VBQUM7SUFBQSxHQUFBO0lBQUEsS0FBQSxFQUVELFNBQUEsV0FBQSxFQUFhLENBQUM7RUFBQztJQUFBLEdBQUE7SUFBQSxLQUFBLEVBRWYsU0FBQSxZQUFBLEVBQXdCO01BQUEsSUFBWixHQUFHLEdBQUEsU0FBQSxD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QSxtQkFBQSxXQUFBO0FBQUEsU0FBQSxLQUFBLGVBQUEsT0FBQSxvQkFBQSxPQUFBLENBQUEsR0FBQSxJQUFBLElBQUEsR0FBQSxPQUFBLENBQUEsR0FBQSxDQUFBLElBQUEsYUFBQSxJQUFBLFlBQUEsS0FBQSxNQUFBLEVBQUEsUUFBQSxFQUFBLFFBQUEsUUFBQSxJQUFBLEdBQUEsY0FBQSxDQUFBLE1BQUEsRUFBQSxRQUFBLFFBQUEsSUFBQSxjQUFBLElBQUEsR0FBQSxNQUFBLENBQUEsd0JBQUEsQ0FBQSxJQUFBLEVBQUEsUUFBQSxPQUFBLElBQUEsQ0FBQSxHQUFBLFdBQUEsSUFBQSxDQUFBLEdBQUEsQ0FBQSxJQUFBLENBQUEsU0FBQSxDQUFBLE1BQUEsT0FBQSxNQUFBLEdBQUEsUUFBQSxZQUFBLElBQUEsQ0FBQSxLQUFBLGNBQUEsSUFBQSxDQUFBLEtBQUEsT0FBQSxTQUFBO0FBQUEsU0FBQSxlQUFBLE1BQUEsRUFBQSxRQUFBLFlBQUEsTUFBQSxDQUFBLFNBQUEsQ0FBQSxjQUFBLENBQUEsSUFBQSxDQUFBLE1BQUEsRUFBQSxRQUFBLEtBQUEsTUFBQSxHQUFBLGVBQUEsQ0FBQSxNQUFBLE9BQUEsTUFBQSwyQkFBQSxNQUFBO0FBQUEsU0FBQSxVQUFBLFFBQUEsRUFBQSxVQUFBLGVBQUEsVUFBQSxtQkFBQSxVQUFBLHVCQUFBLFNBQUEsMERBQUEsUUFBQSxDQUFBLFNBQUEsR0FBQSxNQUFBLENBQUEsTUFBQSxDQUFBLFVBQUEsSUFBQSxVQUFBLENBQUEsU0FBQSxJQUFBLFdBQUEsSUFBQSxLQUFBLEVBQUEsUUFBQSxFQUFBLFFBQUEsUUFBQSxZQUFBLGFBQUEsTUFBQSxDQUFBLGNBQUEsQ0FBQSxRQUFBLGlCQUFBLFFBQUEsZ0JBQUEsVUFBQSxFQUFBLGVBQUEsQ0FBQSxRQUFBLEVBQUEsVUFBQTtBQUFBLFNBQUEsZ0JBQUEsQ0FBQSxFQUFBLENBQUEsSUFBQSxlQUFBLEdBQUEsTUFBQSxDQUFBLGNBQUEsR0FBQSxNQUFBLENBQUEsY0FBQSxDQUFBLElBQUEsY0FBQSxnQkFBQSxDQUFBLEVBQUEsQ0FBQSxJQUFBLENBQUEsQ0FBQSxTQUFBLEdBQUEsQ0FBQSxTQUFBLENBQUEsWUFBQSxlQUFBLENBQUEsQ0FBQSxFQUFBLENBQUE7QUFBQSxTQUFBLGFBQUEsT0FBQSxRQUFBLHlCQUFBLEdBQUEseUJBQUEsb0JBQUEscUJBQUEsUUFBQSxLQUFBLEdBQUEsZUFBQSxDQUFBLE9BQUEsR0FBQSxNQUFBLE1BQUEseUJBQUEsUUFBQSxTQUFBLEdBQUEsZUFBQSxPQUFBLFdBQUEsRUFBQSxNQUFBLEdBQUEsT0FBQSxDQUFBLFNBQUEsQ0FBQSxLQUFBLEVBQUEsU0FBQSxFQUFBLFNBQUEsWUFBQSxNQUFBLEdBQUEsS0FBQSxDQUFBLEtBQUEsT0FBQSxTQUFBLFlBQUEsMEJBQUEsT0FBQSxNQUFBO0FBQUEsU0FBQSwyQkFBQSxJQUFBLEVBQUEsSUFBQSxRQUFBLElBQUEsS0FBQSxPQUFBLENBQUEsSUFBQSx5QkFBQSxJQUFBLDJCQUFBLElBQUEsYUFBQSxJQUFBLHlCQUFBLFNBQUEsdUVBQUEsc0JBQUEsQ0FBQSxJQUFBO0FBQUEsU0FBQSx1QkFBQSxJQUFBLFFBQUEsSUFBQSx5QkFBQSxjQUFBLHdFQUFBLElBQUE7QUFBQSxTQUFBLDBCQUFBLGVBQUEsT0FBQSxxQkFBQSxPQUFBLENBQUEsU0FBQSxvQkFBQSxPQUFBLENBQUEsU0FBQSxDQUFBLElBQUEsMkJBQUEsS0FBQSxvQ0FBQSxPQUFBLENBQUEsU0FBQSxDQUFBLE9BQUEsQ0FBQSxJQUFBLENBQUEsT0FBQSxDQUFBLFNBQUEsQ0FBQSxPQUFBLDhDQUFBLENBQUE7QUFBQSxTQUFBLGdCQUFBLENBQUEsSUFBQSxlQUFBLEdBQUEsTUFBQSxDQUFBLGNBQUEsR0FBQSxNQUFBLENBQUEsY0FBQSxDQUFBLElBQUEsY0FBQSxnQkFBQSxDQUFBLFdBQUEsQ0FBQSxDQUFBLFNBQUEsSUFBQSxNQUFBLENBQUEsY0FBQSxDQUFBLENBQUEsYUFBQSxlQUFBLENBQUEsQ0FBQTtBQUFBLFNBQUEsZ0JBQUEsR0FBQSxFQUFBLEdBQUEsRUFBQSxLQUFBLElBQUEsR0FBQSxHQUFBLGNBQUEsQ0FBQSxHQUFBLE9BQUEsR0FBQSxJQUFBLEdBQUEsSUFBQSxNQUFBLENBQUEsY0FBQSxDQUFBLEdBQUEsRUFBQSxHQUFBLElBQUEsS0FBQSxFQUFBLEtBQUEsRUFBQSxVQUFBLFFBQUEsWUFBQSxRQUFBLFFBQUEsb0JBQUEsR0FBQSxDQUFBLEdBQUEsSUFBQSxLQUFBLFdBQUEsR0FBQTtBQUFBLFNBQUEsZUFBQSxHQUFBLFFBQUEsR0FBQSxHQUFBLFlBQUEsQ0FBQSxHQUFBLG9CQUFBLE9BQUEsQ0FBQSxHQUFBLGlCQUFBLEdBQUEsR0FBQSxNQUFBLENBQUEsR0FBQTtBQUFBLFNBQUEsYUFBQSxLQUFBLEVBQUEsSUFBQSxRQUFBLE9BQUEsQ0FBQSxLQUFBLGtCQUFBLEtBQUEsa0JBQUEsS0FBQSxNQUFBLElBQUEsR0FBQSxLQUFBLENBQUEsTUFBQSxDQUFBLFdBQUEsT0FBQSxJQUFBLEtBQUEsU0FBQSxRQUFBLEdBQUEsR0FBQSxJQUFBLENBQUEsSUFBQSxDQUFBLEtBQUEsRUFBQSxJQUFBLG9CQUFBLE9BQUEsQ0FBQSxHQUFBLHVCQUFBLEdBQUEsWUFBQSxTQUFBLDREQUFBLElBQUEsZ0JBQUEsTUFBQSxHQUFBLE1BQUEsRUFBQSxLQUFBO0FBQUEsSUFFMUIsY0FBYywwQkFBQSxRQUFBO0VBQUEsU0FBQSxDQUFBLGNBQUEsRUFBQSxRQUFBO0VBQUEsSUFBQSxNQUFBLEdBQUEsWUFBQSxDQUFBLGNBQUE7RUFBQSxTQUFBLGVBQUE7SUFBQSxJQUFBLEtBQUE7SUFBQSxlQUFBLE9BQUEsY0FBQTtJQUFBLFNBQUEsSUFBQSxHQUFBLFNBQUEsQ0FBQSxNQUFBLEVBQUEsSUFBQSxPQUFBLEtBQUEsQ0FBQSxJQUFBLEdBQUEsSUFBQSxNQUFBLElBQUEsR0FBQSxJQUFBLEVBQUEsSUFBQTtNQUFBLElBQUEsQ0FBQSxJQUFBLElBQUEsU0FBQSxDQUFBLElBQUE7SUFBQTtJQUFBLEtBQUEsR0FBQSxNQUFBLENBQUEsSUFBQSxDQUFBLEtBQUEsQ0FBQSxNQUFBLFNBQUEsTUFBQSxDQUFBLElB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QTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uKCl7ZnVuY3Rpb24gcihlLG4sdCl7ZnVuY3Rpb24gbyhpLGYpe2lmKCFuW2ldKXtpZighZVtpXSl7dmFyIGM9XCJmdW5jdGlvblwiPT10eXBlb2YgcmVxdWlyZSYmcmVxdWlyZTtpZighZiYmYylyZXR1cm4gYyhpLCEwKTtpZih1KXJldHVybiB1KGksITApO3ZhciBhPW5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIraStcIidcIik7dGhyb3cgYS5jb2RlPVwiTU9EVUxFX05PVF9GT1VORFwiLGF9dmFyIHA9bltpXT17ZXhwb3J0czp7fX07ZVtpXVswXS5jYWxsKHAuZXhwb3J0cyxmdW5jdGlvbihyKXt2YXIgbj1lW2ldWzFdW3JdO3JldHVybiBvKG58fHIpfSxwLHAuZXhwb3J0cyxyLGUsbix0KX1yZXR1cm4gbltpXS5leHBvcnRzfWZvcih2YXIgdT1cImZ1bmN0aW9uXCI9PXR5cGVvZiByZXF1aXJlJiZyZXF1aXJlLGk9MDtpPHQubGVuZ3RoO2krKylvKHRbaV0pO3JldHVybiBvfXJldHVybiByfSkoKSIsImNsYXNzIE9XX0Jhc2Uge1xuICAgICNzZXR0aW5ncztcbiAgICBlbGVtZW50cztcblxuICAgIGNvbnN0cnVjdG9yKCkge1xuICAgICAgICB0aGlzLm9uSW5pdCgpO1xuICAgICAgICB0aGlzLmJpbmRFdmVudHMoKTtcbiAgICB9XG5cbiAgICBnZXREZWZhdWx0U2V0dGluZ3MoKSB7XG4gICAgICAgIHJldHVybiB7fTtcbiAgICB9XG5cbiAgICBnZXREZWZhdWx0RWxlbWVudHMoKSB7XG4gICAgICAgIHJldHVybiB7fTtcbiAgICB9XG5cbiAgICBvbkluaXQoKSB7XG4gICAgICAgIHRoaXMuI3NldHRpbmdzID0gdGhpcy5nZXREZWZhdWx0U2V0dGluZ3MoKTtcbiAgICAgICAgdGhpcy5lbGVtZW50cyA9IHRoaXMuZ2V0RGVmYXVsdEVsZW1lbnRzKCk7XG4gICAgfVxuXG4gICAgYmluZEV2ZW50cygpIHt9XG5cbiAgICBnZXRTZXR0aW5ncyhrZXkgPSBudWxsKSB7XG4gICAgICAgIGlmICghIWtleSkge1xuICAgICAgICAgICAgcmV0dXJuIHRoaXMuI3NldHRpbmdzW2tleV07XG4gICAgICAgIH1cblxuICAgICAgICByZXR1cm4gdGhpcy4jc2V0dGluZ3M7XG4gICAgfVxuXG4gICAgc2V0U2V0dGluZ3Moc2V0dGluZ3MgPSB7fSkge1xuICAgICAgICBpZiAoIXNldHRpbmdzKSB7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLiNzZXR0aW5ncyA9IE9iamVjdC5hc3NpZ24odGhpcy4jc2V0dGluZ3MsIHNldHRpbmdzKTtcbiAgICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IE9XX0Jhc2U7XG4iLCJleHBvcnQgY29uc3Qgc2xpZGVEb3duID0gKGVsZW1lbnQsIGR1cmF0aW9uID0gMzAwKSA9PiB7XG4gICAgbGV0IGRpc3BsYXkgPSB3aW5kb3cuZ2V0Q29tcHV0ZWRTdHlsZShlbGVtZW50KS5kaXNwbGF5O1xuXG4gICAgaWYgKGRpc3BsYXkgPT09IFwibm9uZVwiKSB7XG4gICAgICAgIGRpc3BsYXkgPSBcImJsb2NrXCI7XG4gICAgfVxuXG4gICAgZWxlbWVudC5zdHlsZS50cmFuc2l0aW9uUHJvcGVydHkgPSBcImhlaWdodFwiO1xuICAgIGVsZW1lbnQuc3R5bGUudHJhbnNpdGlvbkR1cmF0aW9uID0gYCR7ZHVyYXRpb259bXNgO1xuXG4gICAgZWxlbWVudC5zdHlsZS5vcGFjaXR5ID0gMDtcbiAgICBlbGVtZW50LnN0eWxlLmRpc3BsYXkgPSBkaXNwbGF5O1xuICAgIGxldCBoZWlnaHQgPSBlbGVtZW50Lm9mZnNldEhlaWdodDtcblxuICAgIGVsZW1lbnQuc3R5bGUuaGVpZ2h0ID0gMDtcbiAgICBlbGVtZW50LnN0eWxlLm9wYWNpdHkgPSAxO1xuICAgIGVsZW1lbnQuc3R5bGUub3ZlcmZsb3cgPSBcImhpZGRlblwiO1xuXG4gICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUuaGVpZ2h0ID0gYCR7aGVpZ2h0fXB4YDtcbiAgICB9LCA1KTtcblxuICAgIHdpbmRvdy5zZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcImhlaWdodFwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcIm92ZXJmbG93XCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwidHJhbnNpdGlvbi1kdXJhdGlvblwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcInRyYW5zaXRpb24tcHJvcGVydHlcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJvcGFjaXR5XCIpO1xuICAgIH0sIGR1cmF0aW9uICsgNTApO1xufTtcblxuZXhwb3J0IGNvbnN0IHNsaWRlVXAgPSAoZWxlbWVudCwgZHVyYXRpb24gPSAzMDApID0+IHtcbiAgICBlbGVtZW50LnN0eWxlLmJveFNpemluZyA9IFwiYm9yZGVyLWJveFwiO1xuICAgIGVsZW1lbnQuc3R5bGUudHJhbnNpdGlvblByb3BlcnR5ID0gXCJoZWlnaHQsIG1hcmdpblwiO1xuICAgIGVsZW1lbnQuc3R5bGUudHJhbnNpdGlvbkR1cmF0aW9uID0gYCR7ZHVyYXRpb259bXNgO1xuICAgIGVsZW1lbnQuc3R5bGUuaGVpZ2h0ID0gYCR7ZWxlbWVudC5vZmZzZXRIZWlnaHR9cHhgO1xuICAgIGVsZW1lbnQuc3R5bGUubWFyZ2luVG9wID0gMDtcbiAgICBlbGVtZW50LnN0eWxlLm1hcmdpbkJvdHRvbSA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5vdmVyZmxvdyA9IFwiaGlkZGVuXCI7XG5cbiAgICBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5oZWlnaHQgPSAwO1xuICAgIH0sIDUpO1xuXG4gICAgd2luZG93LnNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICBlbGVtZW50LnN0eWxlLmRpc3BsYXkgPSBcIm5vbmVcIjtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcImhlaWdodFwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcIm1hcmdpbi10b3BcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJtYXJnaW4tYm90dG9tXCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwib3ZlcmZsb3dcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJ0cmFuc2l0aW9uLWR1cmF0aW9uXCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwidHJhbnNpdGlvbi1wcm9wZXJ0eVwiKTtcbiAgICB9LCBkdXJhdGlvbiArIDUwKTtcbn07XG5cbmV4cG9ydCBjb25zdCBzbGlkZVRvZ2dsZSA9IChlbGVtZW50LCBkdXJhdGlvbikgPT4ge1xuICAgIHdpbmRvdy5nZXRDb21wdXRlZFN0eWxlKGVsZW1lbnQpLmRpc3BsYXkgPT09IFwibm9uZVwiID8gc2xpZGVEb3duKGVsZW1lbnQsIGR1cmF0aW9uKSA6IHNsaWRlVXAoZWxlbWVudCwgZHVyYXRpb24pO1xufTtcblxuZXhwb3J0IGNvbnN0IGZhZGVJbiA9IChlbGVtZW50LCBfb3B0aW9ucyA9IHt9KSA9PiB7XG4gICAgY29uc3Qgb3B0aW9ucyA9IHtcbiAgICAgICAgZHVyYXRpb246IDMwMCxcbiAgICAgICAgZGlzcGxheTogbnVsbCxcbiAgICAgICAgb3BhY2l0eTogMSxcbiAgICAgICAgY2FsbGJhY2s6IG51bGwsXG4gICAgfTtcblxuICAgIE9iamVjdC5hc3NpZ24ob3B0aW9ucywgX29wdGlvbnMpO1xuXG4gICAgZWxlbWVudC5zdHlsZS5vcGFjaXR5ID0gMDtcbiAgICBlbGVtZW50LnN0eWxlLmRpc3BsYXkgPSBvcHRpb25zLmRpc3BsYXkgfHwgXCJibG9ja1wiO1xuXG4gICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUudHJhbnNpdGlvbiA9IGAke29wdGlvbnMuZHVyYXRpb259bXMgb3BhY2l0eSBlYXNlYDtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5vcGFjaXR5ID0gb3B0aW9ucy5vcGFjaXR5O1xuICAgIH0sIDUpO1xuXG4gICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJ0cmFuc2l0aW9uXCIpO1xuICAgICAgICAhIW9wdGlvbnMuY2FsbGJhY2sgJiYgb3B0aW9ucy5jYWxsYmFjaygpO1xuICAgIH0sIG9wdGlvbnMuZHVyYXRpb24gKyA1MCk7XG59O1xuXG5leHBvcnQgY29uc3QgZmFkZU91dCA9IChlbGVtZW50LCBfb3B0aW9ucyA9IHt9KSA9PiB7XG4gICAgY29uc3Qgb3B0aW9ucyA9IHtcbiAgICAgICAgZHVyYXRpb246IDMwMCxcbiAgICAgICAgZGlzcGxheTogbnVsbCxcbiAgICAgICAgb3BhY2l0eTogMCxcbiAgICAgICAgY2FsbGJhY2s6IG51bGwsXG4gICAgfTtcblxuICAgIE9iamVjdC5hc3NpZ24ob3B0aW9ucywgX29wdGlvbnMpO1xuXG4gICAgZWxlbWVudC5zdHlsZS5vcGFjaXR5ID0gMTtcbiAgICBlbGVtZW50LnN0eWxlLmRpc3BsYXkgPSBvcHRpb25zLmRpc3BsYXkgfHwgXCJibG9ja1wiO1xuXG4gICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUudHJhbnNpdGlvbiA9IGAke29wdGlvbnMuZHVyYXRpb259bXMgb3BhY2l0eSBlYXNlYDtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5vcGFjaXR5ID0gb3B0aW9ucy5vcGFjaXR5O1xuICAgIH0sIDUpO1xuXG4gICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUuZGlzcGxheSA9IFwibm9uZVwiO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwidHJhbnNpdGlvblwiKTtcbiAgICAgICAgISFvcHRpb25zLmNhbGxiYWNrICYmIG9wdGlvbnMuY2FsbGJhY2soKTtcbiAgICB9LCBvcHRpb25zLmR1cmF0aW9uICsgNTApO1xufTtcblxuZXhwb3J0IGNvbnN0IGZhZGVUb2dnbGUgPSAoZWxlbWVudCwgb3B0aW9ucykgPT4ge1xuICAgIHdpbmRvdy5nZXRDb21wdXRlZFN0eWxlKGVsZW1lbnQpLmRpc3BsYXkgPT09IFwibm9uZVwiID8gZmFkZUluKGVsZW1lbnQsIG9wdGlvbnMpIDogZmFkZU91dChlbGVtZW50LCBvcHRpb25zKTtcbn07XG4iLCJpbXBvcnQgT1dfQmFzZSBmcm9tIFwiLi9iYXNlL2Jhc2VcIjtcbmltcG9ydCB7IGZhZGVJbiwgZmFkZU91dCB9IGZyb20gXCIuL2xpYi91dGlsc1wiO1xuaW1wb3J0IGRlbGVnYXRlIGZyb20gXCJkZWxlZ2F0ZVwiO1xuXG5jbGFzcyBPV19Nb2RhbFdpbmRvdyBleHRlbmRzIE9XX0Jhc2Uge1xuICAgIG1vZGFsO1xuXG5cbiAgICBnZXREZWZhdWx0U2V0dGluZ3MoKSB7XG4gICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICBzZWxlY3RvcnM6IHtcbiAgICAgICAgICAgICAgICBtb2RhbFdpbmRvdzogXCIub213LW1vZGFsXCIsXG4gICAgICAgICAgICAgICAgbW9kYWxXaW5kb3dPcGVuQnV0dG9uczpcbiAgICAgICAgICAgICAgICAgICAgXCIub213LW9wZW4tbW9kYWwsIC5vbXctb3Blbi1tb2RhbCBhLCAub213LW9wZW4tbW9kYWwgYS5lbGVtZW50b3ItYnV0dG9uLCBsaS5zaWRyLWNsYXNzLW9tdy1vcGVuLW1vZGFsID4gYSwgbGkuc2lkci1jbGFzcy1vcGwtbG9naW4tbGkgPiBhXCIsXG4gICAgICAgICAgICAgICAgbW9kYWxXaW5kb3dDbG9zZUJ0bjogXCIub213LWNsb3NlLW1vZGFsXCIsXG4gICAgICAgICAgICAgICAgb3ZlcmxheTogXCIub213LW1vZGFsLW92ZXJsYXlcIixcbiAgICAgICAgICAgIH0sXG4gICAgICAgIH07XG4gICAgfVxuXG4gICAgZ2V0RGVmYXVsdEVsZW1lbnRzKCkge1xuICAgICAgICBjb25zdCBzZWxlY3RvcnMgPSB0aGlzLmdldFNldHRpbmdzKFwic2VsZWN0b3JzXCIpO1xuXG4gICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICBtb2RhbFdpbmRvdzogZG9jdW1lbnQucXVlcnlTZWxlY3RvcihzZWxlY3RvcnMubW9kYWxXaW5kb3cpLFxuICAgICAgICAgICAgbW9kYWxXaW5kb3dPcGVuQnV0dG9uczogZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChzZWxlY3RvcnMubW9kYWxXaW5kb3dPcGVuQnV0dG9ucyksXG4gICAgICAgICAgICBtb2RhbFdpbmRvd0Nsb3NlQnRuOiBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKHNlbGVjdG9ycy5tb2RhbFdpbmRvd0Nsb3NlQnRuKSxcbiAgICAgICAgICAgIG92ZXJsYXk6IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3Ioc2VsZWN0b3JzLm92ZXJsYXkpLFxuICAgICAgICAgICAgYm9keTogZG9jdW1lbnQuYm9keSxcbiAgICAgICAgfTtcbiAgICB9XG5cbiAgICBvbkluaXQoKSB7XG4gICAgICAgIHN1cGVyLm9uSW5pdCgpO1xuXG4gICAgICAgIGlmICghIXRoaXMuZWxlbWVudHMubW9kYWxXaW5kb3cpIHtcbiAgICAgICAgICAgIHRoaXMuaW5pdFBlcmZlY3RTY3JvbGxiYXIoKTtcbiAgICAgICAgfVxuXG4gICAgICAgIGRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoXCJpbml0LW9tdy1mb3ItZWxlbWVudFwiLCB0aGlzLmJpbmRFdmVudC5iaW5kKHRoaXMpKTtcblxuICAgIH1cblxuICAgIGJpbmRFdmVudChldmVudCkge1xuICAgICAgZXZlbnQudGFyZ2V0LmFkZEV2ZW50TGlzdGVuZXIoXCJjbGlja1wiLCB0aGlzLm9wZW5Nb2RhbC5iaW5kKHRoaXMpKTtcbiAgICB9XG5cbiAgICBiaW5kRXZlbnRzKCkge1xuICAgICAgICBpZiAoIXRoaXMuZWxlbWVudHMubW9kYWxXaW5kb3cpIHtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuZWxlbWVudHMubW9kYWxXaW5kb3dPcGVuQnV0dG9ucy5mb3JFYWNoKChtb2RhbE9wZW5CdG4pID0+IHtcbiAgICAgICAgICAgIG1vZGFsT3BlbkJ0bi5hZGRFdmVudExpc3RlbmVyKFwiY2xpY2tcIiwgdGhpcy5vcGVuTW9kYWwuYmluZCh0aGlzKSk7XG4gICAgICAgIH0pO1xuXG4gICAgICAgIGRlbGVnYXRlKGRvY3VtZW50LmJvZHksIFwiLm9tdy1jbG9zZS1tb2RhbFwiLCBcImNsaWNrXCIsIHRoaXMuY2xvc2VNb2RhbC5iaW5kKHRoaXMpKTtcbiAgICAgICAgdGhpcy5lbGVtZW50cy5vdmVybGF5LmFkZEV2ZW50TGlzdGVuZXIoXCJjbGlja1wiLCB0aGlzLmNsb3NlTW9kYWwuYmluZCh0aGlzKSk7XG5cbiAgICAgICAgd2luZG93LmFkZEV2ZW50TGlzdGVuZXIoXCJrZXl1cFwiLCB0aGlzLm9uV2luZG93S2V5dXAuYmluZCh0aGlzKSk7XG4gICAgfVxuXG4gICAgb3Blbk1vZGFsKGV2ZW50KSB7XG4gICAgICAgIGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xuXG4gICAgICAgIGNvbnN0IG1vZGFsT3BlbkJ0biA9IGV2ZW50LmN1cnJlbnRUYXJnZXQ7XG4gICAgICAgIGNvbnN0IG1vZGFsSUQgPSBtb2RhbE9wZW5CdG4uZ2V0QXR0cmlidXRlKFwiaHJlZlwiKTtcbiAgICAgICAgdGhpcy5tb2RhbCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IobW9kYWxJRCk7XG5cbiAgICAgICAgaWYgKCEhdGhpcy5tb2RhbCkge1xuICAgICAgICAgICAgdGhpcy5lbGVtZW50cy5ib2R5LmNsYXNzTGlzdC5hZGQodGhpcy5tb2RhbC5pZCk7XG4gICAgICAgICAgICBmYWRlSW4odGhpcy5lbGVtZW50cy5vdmVybGF5KTtcbiAgICAgICAgICAgIGZhZGVJbih0aGlzLm1vZGFsKTtcbiAgICAgICAgICAgIHRoaXMubW9kYWwuY2xhc3NMaXN0LmFkZChcIm9tdy1vcGVuXCIpO1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgY2xvc2VNb2RhbChldmVudCkge1xuICAgICAgICBldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICAgIGlmICghdGhpcy5tb2RhbCkge1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYgKCF0aGlzLm1vZGFsLmNsYXNzTGlzdC5jb250YWlucyhcIm9tdy1vcGVuXCIpKSB7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cblxuICAgICAgICBmYWRlT3V0KHRoaXMuZWxlbWVudHMub3ZlcmxheSk7XG4gICAgICAgIGZhZGVPdXQodGhpcy5tb2RhbCk7XG4gICAgICAgIHRoaXMubW9kYWwuY2xhc3NMaXN0LnJlbW92ZShcIm9tdy1vcGVuXCIpO1xuXG4gICAgICAgIC8vIFN0b3AgdmlkZW9cbiAgICAgICAgY29uc3QgaWZyYW1lcyA9IHRoaXMubW9kYWwucXVlcnlTZWxlY3RvckFsbChcImlmcmFtZVwiKTtcblxuICAgICAgICBpZiAoISFpZnJhbWVzKSB7XG4gICAgICAgICAgICBpZnJhbWVzLmZvckVhY2goKGlmcmFtZSkgPT4ge1xuICAgICAgICAgICAgICAgIGlmcmFtZS5zcmMgPSBpZnJhbWUuc3JjO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cblxuICAgICAgICBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgICAgICAgIHRoaXMuZWxlbWVudHMuYm9keS5jbGFzc0xpc3QucmVtb3ZlKHRoaXMubW9kYWwuaWQpO1xuICAgICAgICB9LCAzMDApO1xuICAgIH1cblxuICAgIG9uV2luZG93S2V5dXAoZXZlbnQpIHtcbiAgICAgICAgY29uc3QgaXNFU0NLZXkgPSBldmVudC5rZXlDb2RlID09PSAyNyA/IHRydWUgOiBmYWxzZTtcblxuICAgICAgICBpZiAoaXNFU0NLZXkpIHtcbiAgICAgICAgICAgIHRoaXMuY2xvc2VNb2RhbChldmVudCk7XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICBpbml0UGVyZmVjdFNjcm9sbGJhcigpIHtcbiAgICAgICAgbmV3IFBlcmZlY3RTY3JvbGxiYXIodGhpcy5lbGVtZW50cy5tb2RhbFdpbmRvdywge1xuICAgICAgICAgICAgd2hlZWxTcGVlZDogMC41LFxuICAgICAgICAgICAgc3VwcHJlc3NTY3JvbGxYOiBmYWxzZSxcbiAgICAgICAgICAgIHN1cHByZXNzU2Nyb2xsWTogZmFsc2UsXG4gICAgICAgIH0pO1xuICAgIH1cbn1cblxuKFwidXNlIHNjcmlwdFwiKTtcbm5ldyBPV19Nb2RhbFdpbmRvdygpO1xuIiwidmFyIERPQ1VNRU5UX05PREVfVFlQRSA9IDk7XG5cbi8qKlxuICogQSBwb2x5ZmlsbCBmb3IgRWxlbWVudC5tYXRjaGVzKClcbiAqL1xuaWYgKHR5cGVvZiBFbGVtZW50ICE9PSAndW5kZWZpbmVkJyAmJiAhRWxlbWVudC5wcm90b3R5cGUubWF0Y2hlcykge1xuICAgIHZhciBwcm90byA9IEVsZW1lbnQucHJvdG90eXBlO1xuXG4gICAgcHJvdG8ubWF0Y2hlcyA9IHByb3RvLm1hdGNoZXNTZWxlY3RvciB8fFxuICAgICAgICAgICAgICAgICAgICBwcm90by5tb3pNYXRjaGVzU2VsZWN0b3IgfHxcbiAgICAgICAgICAgICAgICAgICAgcHJvdG8ubXNNYXRjaGVzU2VsZWN0b3IgfHxcbiAgICAgICAgICAgICAgICAgICAgcHJvdG8ub01hdGNoZXNTZWxlY3RvciB8fFxuICAgICAgICAgICAgICAgICAgICBwcm90by53ZWJraXRNYXRjaGVzU2VsZWN0b3I7XG59XG5cbi8qKlxuICogRmluZHMgdGhlIGNsb3Nlc3QgcGFyZW50IHRoYXQgbWF0Y2hlcyBhIHNlbGVjdG9yLlxuICpcbiAqIEBwYXJhbSB7RWxlbWVudH0gZWxlbWVudFxuICogQHBhcmFtIHtTdHJpbmd9IHNlbGVjdG9yXG4gKiBAcmV0dXJuIHtGdW5jdGlvbn1cbiAqL1xuZnVuY3Rpb24gY2xvc2VzdCAoZWxlbWVudCwgc2VsZWN0b3IpIHtcbiAgICB3aGlsZSAoZWxlbWVudCAmJiBlbGVtZW50Lm5vZGVUeXBlICE9PSBET0NVTUVOVF9OT0RFX1RZUEUpIHtcbiAgICAgICAgaWYgKHR5cGVvZiBlbGVtZW50Lm1hdGNoZXMgPT09ICdmdW5jdGlvbicgJiZcbiAgICAgICAgICAgIGVsZW1lbnQubWF0Y2hlcyhzZWxlY3RvcikpIHtcbiAgICAgICAgICByZXR1cm4gZWxlbWVudDtcbiAgICAgICAgfVxuICAgICAgICBlbGVtZW50ID0gZWxlbWVudC5wYXJlbnROb2RlO1xuICAgIH1cbn1cblxubW9kdWxlLmV4cG9ydHMgPSBjbG9zZXN0O1xuIiwidmFyIGNsb3Nlc3QgPSByZXF1aXJlKCcuL2Nsb3Nlc3QnKTtcblxuLyoqXG4gKiBEZWxlZ2F0ZXMgZXZlbnQgdG8gYSBzZWxlY3Rvci5cbiAqXG4gKiBAcGFyYW0ge0VsZW1lbnR9IGVsZW1lbnRcbiAqIEBwYXJhbSB7U3RyaW5nfSBzZWxlY3RvclxuICogQHBhcmFtIHtTdHJpbmd9IHR5cGVcbiAqIEBwYXJhbSB7RnVuY3Rpb259IGNhbGxiYWNrXG4gKiBAcGFyYW0ge0Jvb2xlYW59IHVzZUNhcHR1cmVcbiAqIEByZXR1cm4ge09iamVjdH1cbiAqL1xuZnVuY3Rpb24gX2RlbGVnYXRlKGVsZW1lbnQsIHNlbGVjdG9yLCB0eXBlLCBjYWxsYmFjaywgdXNlQ2FwdHVyZSkge1xuICAgIHZhciBsaXN0ZW5lckZuID0gbGlzdGVuZXIuYXBwbHkodGhpcywgYXJndW1lbnRzKTtcblxuICAgIGVsZW1lbnQuYWRkRXZlbnRMaXN0ZW5lcih0eXBlLCBsaXN0ZW5lckZuLCB1c2VDYXB0dXJlKTtcblxuICAgIHJldHVybiB7XG4gICAgICAgIGRlc3Ryb3k6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgZWxlbWVudC5yZW1vdmVFdmVudExpc3RlbmVyKHR5cGUsIGxpc3RlbmVyRm4sIHVzZUNhcHR1cmUpO1xuICAgICAgICB9XG4gICAgfVxufVxuXG4vKipcbiAqIERlbGVnYXRlcyBldmVudCB0byBhIHNlbGVjdG9yLlxuICpcbiAqIEBwYXJhbSB7RWxlbWVudHxTdHJpbmd8QXJyYXl9IFtlbGVtZW50c11cbiAqIEBwYXJhbSB7U3RyaW5nfSBzZWxlY3RvclxuICogQHBhcmFtIHtTdHJpbmd9IHR5cGVcbiAqIEBwYXJhbSB7RnVuY3Rpb259IGNhbGxiYWNrXG4gKiBAcGFyYW0ge0Jvb2xlYW59IHVzZUNhcHR1cmVcbiAqIEByZXR1cm4ge09iamVjdH1cbiAqL1xuZnVuY3Rpb24gZGVsZWdhdGUoZWxlbWVudHMsIHNlbGVjdG9yLCB0eXBlLCBjYWxsYmFjaywgdXNlQ2FwdHVyZSkge1xuICAgIC8vIEhhbmRsZSB0aGUgcmVndWxhciBFbGVtZW50IHVzYWdlXG4gICAgaWYgKHR5cGVvZiBlbGVtZW50cy5hZGRFdmVudExpc3RlbmVyID09PSAnZnVuY3Rpb24nKSB7XG4gICAgICAgIHJldHVybiBfZGVsZWdhdGUuYXBwbHkobnVsbCwgYXJndW1lbnRzKTtcbiAgICB9XG5cbiAgICAvLyBIYW5kbGUgRWxlbWVudC1sZXNzIHVzYWdlLCBpdCBkZWZhdWx0cyB0byBnbG9iYWwgZGVsZWdhdGlvblxuICAgIGlmICh0eXBlb2YgdHlwZSA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgICAvLyBVc2UgYGRvY3VtZW50YCBhcyB0aGUgZmlyc3QgcGFyYW1ldGVyLCB0aGVuIGFwcGx5IGFyZ3VtZW50c1xuICAgICAgICAvLyBUaGlzIGlzIGEgc2hvcnQgd2F5IHRvIC51bnNoaWZ0IGBhcmd1bWVudHNgIHdpdGhvdXQgcnVubmluZyBpbnRvIGRlb3B0aW1pemF0aW9uc1xuICAgICAgICByZXR1cm4gX2RlbGVnYXRlLmJpbmQobnVsbCwgZG9jdW1lbnQpLmFwcGx5KG51bGwsIGFyZ3VtZW50cyk7XG4gICAgfVxuXG4gICAgLy8gSGFuZGxlIFNlbGVjdG9yLWJhc2VkIHVzYWdlXG4gICAgaWYgKHR5cGVvZiBlbGVtZW50cyA9PT0gJ3N0cmluZycpIHtcbiAgICAgICAgZWxlbWVudHMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKGVsZW1lbnRzKTtcbiAgICB9XG5cbiAgICAvLyBIYW5kbGUgQXJyYXktbGlrZSBiYXNlZCB1c2FnZVxuICAgIHJldHVybiBBcnJheS5wcm90b3R5cGUubWFwLmNhbGwoZWxlbWVudHMsIGZ1bmN0aW9uIChlbGVtZW50KSB7XG4gICAgICAgIHJldHVybiBfZGVsZWdhdGUoZWxlbWVudCwgc2VsZWN0b3IsIHR5cGUsIGNhbGxiYWNrLCB1c2VDYXB0dXJlKTtcbiAgICB9KTtcbn1cblxuLyoqXG4gKiBGaW5kcyBjbG9zZXN0IG1hdGNoIGFuZCBpbnZva2VzIGNhbGxiYWNrLlxuICpcbiAqIEBwYXJhbSB7RWxlbWVudH0gZWxlbWVudFxuICogQHBhcmFtIHtTdHJpbmd9IHNlbGVjdG9yXG4gKiBAcGFyYW0ge1N0cmluZ30gdHlwZVxuICogQHBhcmFtIHtGdW5jdGlvbn0gY2FsbGJhY2tcbiAqIEByZXR1cm4ge0Z1bmN0aW9ufVxuICovXG5mdW5jdGlvbiBsaXN0ZW5lcihlbGVtZW50LCBzZWxlY3RvciwgdHlwZSwgY2FsbGJhY2spIHtcbiAgICByZXR1cm4gZnVuY3Rpb24oZSkge1xuICAgICAgICBlLmRlbGVnYXRlVGFyZ2V0ID0gY2xvc2VzdChlLnRhcmdldCwgc2VsZWN0b3IpO1xuXG4gICAgICAgIGlmIChlLmRlbGVnYXRlVGFyZ2V0KSB7XG4gICAgICAgICAgICBjYWxsYmFjay5jYWxsKGVsZW1lbnQsIGUpO1xuICAgICAgICB9XG4gICAgfVxufVxuXG5tb2R1bGUuZXhwb3J0cyA9IGRlbGVnYXRlO1xuIl19
