(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classPrivateFieldGet(receiver, privateMap) { var descriptor = _classExtractFieldDescriptor(receiver, privateMap, "get"); return _classApplyDescriptorGet(receiver, descriptor); }

function _classApplyDescriptorGet(receiver, descriptor) { if (descriptor.get) { return descriptor.get.call(receiver); } return descriptor.value; }

function _classPrivateFieldSet(receiver, privateMap, value) { var descriptor = _classExtractFieldDescriptor(receiver, privateMap, "set"); _classApplyDescriptorSet(receiver, descriptor, value); return value; }

function _classExtractFieldDescriptor(receiver, privateMap, action) { if (!privateMap.has(receiver)) { throw new TypeError("attempted to " + action + " private field on non-instance"); } return privateMap.get(receiver); }

function _classApplyDescriptorSet(receiver, descriptor, value) { if (descriptor.set) { descriptor.set.call(receiver, value); } else { if (!descriptor.writable) { throw new TypeError("attempted to set read only private field"); } descriptor.value = value; } }

var _settings = /*#__PURE__*/new WeakMap();

var OW_Base = /*#__PURE__*/function () {
  function OW_Base() {
    _classCallCheck(this, OW_Base);

    _settings.set(this, {
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
exports.fadeOut = exports.fadeIn = exports.slideDown = exports.slideUp = void 0;

var slideUp = function slideUp(element) {
  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 300;
  element.style.boxSizing = "border-box";
  element.style.transitionProperty = "height, margin, padding";
  element.style.transitionDuration = "".concat(duration, "ms");
  element.style.height = "".concat(element.offsetHeight, "px");
  element.style.paddingTop = 0;
  element.style.paddingBottom = 0;
  element.style.marginTop = 0;
  element.style.marginBottom = 0;
  element.style.overflow = "hidden";
  setTimeout(function () {
    element.style.height = 0;
  }, 10);
  window.setTimeout(function () {
    element.style.display = "none";
    element.style.removeProperty("height");
    element.style.removeProperty("padding-top");
    element.style.removeProperty("padding-bottom");
    element.style.removeProperty("margin-top");
    element.style.removeProperty("margin-bottom");
    element.style.removeProperty("overflow");
    element.style.removeProperty("transition-duration");
    element.style.removeProperty("transition-property");
  }, duration);
};

exports.slideUp = slideUp;

var slideDown = function slideDown(element) {
  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 300;
  element.style.removeProperty("display");
  var display = window.getComputedStyle(element).display;

  if (display === "none") {
    display = "block";
  }

  element.style.display = display;
  var height = element.offsetHeight;
  var paddingTop = window.getComputedStyle(element).paddingTop;
  var paddingBottom = window.getComputedStyle(element).paddingBottom;
  var marginTop = window.getComputedStyle(element).marginTop;
  var marginBottom = window.getComputedStyle(element).marginBottom;
  element.style.height = 0;
  element.style.paddingTop = 0;
  element.style.paddingBottom = 0;
  element.style.marginTop = 0;
  element.style.marginBottom = 0;
  element.style.overflow = "hidden";
  element.style.boxSizing = "border-box";
  element.style.transitionProperty = "height";
  element.style.transitionDuration = "".concat(duration, "ms");
  setTimeout(function () {
    element.style.height = "".concat(height, "px");

    if (paddingTop !== "0px" || paddingBottom !== "0px") {
      element.style.transitionProperty = "padding";
      element.style.transitionDuration = "".concat(duration / 1.2, "ms");
      element.style.paddingTop = paddingTop;
      element.style.paddingBottom = paddingBottom;
      element.style.marginTop = marginTop;
      element.style.marginBottom = marginBottom;
    }
  }, 10);
  window.setTimeout(function () {
    element.style.removeProperty("height");
    element.style.removeProperty("overflow");
    element.style.removeProperty("transition-duration");
    element.style.removeProperty("transition-property");
    element.style.removeProperty("padding-top");
    element.style.removeProperty("padding-bottom");
    element.style.removeProperty("margin-top");
    element.style.removeProperty("margin-bottom");
  }, duration);
};

exports.slideDown = slideDown;

var fadeIn = function fadeIn(element) {
  var _options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

  var options = {
    opacity: 1,
    speed: "normal",
    display: null,
    callback: null
  };
  Object.assign(options, _options);
  element.style.opacity = 0;
  element.style.display = !!options.display || "block";

  var fade = function fade() {
    var opacity = parseFloat(element.style.opacity);

    if ((opacity += options.speed === "fast" ? 0.2 : 0.1) <= options.opacity) {
      element.style.opacity = opacity;

      if (opacity === 1 && options.callback) {
        callback();
      }

      window.requestAnimationFrame(fade);
    }
  };

  window.requestAnimationFrame(fade);
};

exports.fadeIn = fadeIn;

var fadeOut = function fadeOut(element) {
  var speed = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "normal";
  var display = arguments.length > 2 ? arguments[2] : undefined;
  var callback = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
  element.style.opacity = 1;
  element.style.display = display || "block";

  var fade = function fade() {
    var opacity = parseFloat(element.style.opacity);

    if ((opacity -= speed === "fast" ? 0.2 : 0.1) < 0) {
      element.style.display = "none";
    } else {
      element.style.opacity = opacity;

      if (opacity === 0 && callback) {
        callback();
      }

      window.requestAnimationFrame(fade);
    }
  };

  window.requestAnimationFrame(fade);
};

exports.fadeOut = fadeOut;

},{}],3:[function(require,module,exports){
"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var _base = _interopRequireDefault(require("./base/base"));

var _utils = require("./lib/utils");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _get(target, property, receiver) { if (typeof Reflect !== "undefined" && Reflect.get) { _get = Reflect.get; } else { _get = function _get(target, property, receiver) { var base = _superPropBase(target, property); if (!base) return; var desc = Object.getOwnPropertyDescriptor(base, property); if (desc.get) { return desc.get.call(receiver); } return desc.value; }; } return _get(target, property, receiver || target); }

function _superPropBase(object, property) { while (!Object.prototype.hasOwnProperty.call(object, property)) { object = _getPrototypeOf(object); if (object === null) break; } return object; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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
          modalWindowOpenButtons: ".omw-open-modal, .omw-open-modal a, .omw-open-modal a.elementor-button, li.sidr-class-omw-open-modal > a",
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

      if (!!this.elements.modalWindow && this.isDesktopBrowser()) {
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
      this.elements.modalWindowCloseBtn.addEventListener("click", this.closeModal.bind(this));
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
      this.modal.classList.remove("omw-open"); // Stop video

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
  }, {
    key: "isDesktopBrowser",
    value: function isDesktopBrowser() {
      return !navigator.userAgent.match(/(Android|iPod|iPhone|iPad|IEMobile|Opera Mini)/);
    }
  }]);

  return OW_ModalWindow;
}(_base["default"]);

"use script";
new OW_ModalWindow();

},{"./base/base":1,"./lib/utils":2}]},{},[3])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJhc3NldHMvc3JjL2pzL2Jhc2UvYmFzZS5qcyIsImFzc2V0cy9zcmMvanMvbGliL3V0aWxzLmpzIiwiYXNzZXRzL3NyYy9qcy9tb2RhbC13aW5kb3cuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7SUNBTSxPO0FBSUYscUJBQWM7QUFBQTs7QUFBQTtBQUFBO0FBQUE7QUFBQTs7QUFBQTs7QUFDVixTQUFLLE1BQUw7QUFDQSxTQUFLLFVBQUw7QUFDSDs7OztXQUVELDhCQUFxQjtBQUNqQixhQUFPLEVBQVA7QUFDSDs7O1dBRUQsOEJBQXFCO0FBQ2pCLGFBQU8sRUFBUDtBQUNIOzs7V0FFRCxrQkFBUztBQUNMLDZDQUFpQixLQUFLLGtCQUFMLEVBQWpCOztBQUNBLFdBQUssUUFBTCxHQUFnQixLQUFLLGtCQUFMLEVBQWhCO0FBQ0g7OztXQUVELHNCQUFhLENBQUU7OztXQUVmLHVCQUF3QjtBQUFBLFVBQVosR0FBWSx1RUFBTixJQUFNOztBQUNwQixVQUFJLENBQUMsQ0FBQyxHQUFOLEVBQVc7QUFDUCxlQUFPLHVDQUFlLEdBQWYsQ0FBUDtBQUNIOztBQUVELG1DQUFPLElBQVA7QUFDSDs7O1dBRUQsdUJBQTJCO0FBQUEsVUFBZixRQUFlLHVFQUFKLEVBQUk7O0FBQ3ZCLFVBQUksQ0FBQyxRQUFMLEVBQWU7QUFDWDtBQUNIOztBQUVELDZDQUFpQixNQUFNLENBQUMsTUFBUCx1QkFBYyxJQUFkLGNBQThCLFFBQTlCLENBQWpCO0FBQ0g7Ozs7OztlQUdVLE87Ozs7Ozs7Ozs7O0FDekNSLElBQU0sT0FBTyxHQUFHLFNBQVYsT0FBVSxDQUFDLE9BQUQsRUFBNkI7QUFBQSxNQUFuQixRQUFtQix1RUFBUixHQUFRO0FBQ2hELEVBQUEsT0FBTyxDQUFDLEtBQVIsQ0FBYyxTQUFkLEdBQTBCLFlBQTFCO0FBQ0EsRUFBQSxPQUFPLENBQUMs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QUFxQixNQUFyQixDQUE0QixVQUE1QixFQWJjLENBZWQ7O0FBQ0EsVUFBTSxPQUFPLEdBQUcsS0FBSyxLQUFMLENBQVcsZ0JBQVgsQ0FBNEIsUUFBNUIsQ0FBaEI7O0FBRUEsVUFBSSxDQUFDLENBQUMsT0FBTixFQUFlO0FBQ1gsUUFBQSxPQUFPLENBQUMsT0FBUixDQUFnQixVQUFDLE1BQUQsRUFBWTtBQUN4QixVQUFBLE1BQU0sQ0FBQyxHQUFQLEdBQWEsTUFBTSxDQUFDLEdBQXBCO0FBQ0gsU0FGRDtBQUdIOztBQUVELE1BQUEsVUFBVSxDQUFDLFlBQU07QUFDYixRQUFBLE1BQUksQ0FBQyxRQUFMLENBQWMsSUFBZCxDQUFtQixTQUFuQixDQUE2QixNQUE3QixDQUFvQyxNQUFJLENBQUMsS0FBTCxDQUFXLEVBQS9DO0FBQ0gsT0FGUyxFQUVQLEdBRk8sQ0FBVjtBQUdIOzs7V0FFRCx1QkFBYyxLQUFkLEVBQXFCO0FBQ2pCLFVBQU0sUUFBUSxHQUFHLEtBQUssQ0FBQyxPQUFOLEtBQWtCLEVBQWxCLEdBQXVCLElBQXZCLEdBQThCLEtBQS9DOztBQUVBLFVBQUksUUFBSixFQUFjO0FBQ1YsYUFBSyxVQUFMLENBQWdCLEtBQWhCO0FBQ0g7QUFDSjs7O1dBRUQsZ0NBQXVCO0FBQ25CLFVBQUksZ0JBQUosQ0FBcUIsS0FBSyxRQUFMLENBQWMsV0FBbkMsRUFBZ0Q7QUFDNUMsUUFBQSxVQUFVLEVBQUUsR0FEZ0M7QUFFNUMsUUFBQSxlQUFlLEVBQUUsS0FGMkI7QUFHNUMsUUFBQSxlQUFlLEVBQUU7QUFIMkIsT0FBaEQ7QUFLSDs7O1dBRUQsNEJBQW1CO0FBQ2YsYUFBTyxDQUFDLFNBQVMsQ0FBQyxTQUFWLENBQW9CLEtBQXBCLENBQTBCLGdEQUExQixDQUFSO0FBQ0g7Ozs7RUFqSHdCLGdCOztBQW9INUIsWUFBRDtBQUNBLElBQUksY0FBSiIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uKCl7ZnVuY3Rpb24gcihlLG4sdCl7ZnVuY3Rpb24gbyhpLGYpe2lmKCFuW2ldKXtpZighZVtpXSl7dmFyIGM9XCJmdW5jdGlvblwiPT10eXBlb2YgcmVxdWlyZSYmcmVxdWlyZTtpZighZiYmYylyZXR1cm4gYyhpLCEwKTtpZih1KXJldHVybiB1KGksITApO3ZhciBhPW5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIraStcIidcIik7dGhyb3cgYS5jb2RlPVwiTU9EVUxFX05PVF9GT1VORFwiLGF9dmFyIHA9bltpXT17ZXhwb3J0czp7fX07ZVtpXVswXS5jYWxsKHAuZXhwb3J0cyxmdW5jdGlvbihyKXt2YXIgbj1lW2ldWzFdW3JdO3JldHVybiBvKG58fHIpfSxwLHAuZXhwb3J0cyxyLGUsbix0KX1yZXR1cm4gbltpXS5leHBvcnRzfWZvcih2YXIgdT1cImZ1bmN0aW9uXCI9PXR5cGVvZiByZXF1aXJlJiZyZXF1aXJlLGk9MDtpPHQubGVuZ3RoO2krKylvKHRbaV0pO3JldHVybiBvfXJldHVybiByfSkoKSIsImNsYXNzIE9XX0Jhc2Uge1xuICAgICNzZXR0aW5ncztcbiAgICBlbGVtZW50cztcblxuICAgIGNvbnN0cnVjdG9yKCkge1xuICAgICAgICB0aGlzLm9uSW5pdCgpO1xuICAgICAgICB0aGlzLmJpbmRFdmVudHMoKTtcbiAgICB9XG5cbiAgICBnZXREZWZhdWx0U2V0dGluZ3MoKSB7XG4gICAgICAgIHJldHVybiB7fTtcbiAgICB9XG5cbiAgICBnZXREZWZhdWx0RWxlbWVudHMoKSB7XG4gICAgICAgIHJldHVybiB7fTtcbiAgICB9XG5cbiAgICBvbkluaXQoKSB7XG4gICAgICAgIHRoaXMuI3NldHRpbmdzID0gdGhpcy5nZXREZWZhdWx0U2V0dGluZ3MoKTtcbiAgICAgICAgdGhpcy5lbGVtZW50cyA9IHRoaXMuZ2V0RGVmYXVsdEVsZW1lbnRzKCk7XG4gICAgfVxuXG4gICAgYmluZEV2ZW50cygpIHt9XG5cbiAgICBnZXRTZXR0aW5ncyhrZXkgPSBudWxsKSB7XG4gICAgICAgIGlmICghIWtleSkge1xuICAgICAgICAgICAgcmV0dXJuIHRoaXMuI3NldHRpbmdzW2tleV07XG4gICAgICAgIH1cblxuICAgICAgICByZXR1cm4gdGhpcy4jc2V0dGluZ3M7XG4gICAgfVxuXG4gICAgc2V0U2V0dGluZ3Moc2V0dGluZ3MgPSB7fSkge1xuICAgICAgICBpZiAoIXNldHRpbmdzKSB7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLiNzZXR0aW5ncyA9IE9iamVjdC5hc3NpZ24odGhpcy4jc2V0dGluZ3MsIHNldHRpbmdzKTtcbiAgICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IE9XX0Jhc2U7XG4iLCJleHBvcnQgY29uc3Qgc2xpZGVVcCA9IChlbGVtZW50LCBkdXJhdGlvbiA9IDMwMCkgPT4ge1xuICAgIGVsZW1lbnQuc3R5bGUuYm94U2l6aW5nID0gXCJib3JkZXItYm94XCI7XG4gICAgZWxlbWVudC5zdHlsZS50cmFuc2l0aW9uUHJvcGVydHkgPSBcImhlaWdodCwgbWFyZ2luLCBwYWRkaW5nXCI7XG4gICAgZWxlbWVudC5zdHlsZS50cmFuc2l0aW9uRHVyYXRpb24gPSBgJHtkdXJhdGlvbn1tc2A7XG4gICAgZWxlbWVudC5zdHlsZS5oZWlnaHQgPSBgJHtlbGVtZW50Lm9mZnNldEhlaWdodH1weGA7XG4gICAgZWxlbWVudC5zdHlsZS5wYWRkaW5nVG9wID0gMDtcbiAgICBlbGVtZW50LnN0eWxlLnBhZGRpbmdCb3R0b20gPSAwO1xuICAgIGVsZW1lbnQuc3R5bGUubWFyZ2luVG9wID0gMDtcbiAgICBlbGVtZW50LnN0eWxlLm1hcmdpbkJvdHRvbSA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5vdmVyZmxvdyA9IFwiaGlkZGVuXCI7XG5cbiAgICBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5oZWlnaHQgPSAwO1xuICAgIH0sIDEwKTtcblxuICAgIHdpbmRvdy5zZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5kaXNwbGF5ID0gXCJub25lXCI7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJoZWlnaHRcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJwYWRkaW5nLXRvcFwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcInBhZGRpbmctYm90dG9tXCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwibWFyZ2luLXRvcFwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcIm1hcmdpbi1ib3R0b21cIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJvdmVyZmxvd1wiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcInRyYW5zaXRpb24tZHVyYXRpb25cIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJ0cmFuc2l0aW9uLXByb3BlcnR5XCIpO1xuICAgIH0sIGR1cmF0aW9uKTtcbn07XG5cbmV4cG9ydCBjb25zdCBzbGlkZURvd24gPSAoZWxlbWVudCwgZHVyYXRpb24gPSAzMDApID0+IHtcbiAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwiZGlzcGxheVwiKTtcblxuICAgIGxldCBkaXNwbGF5ID0gd2luZG93LmdldENvbXB1dGVkU3R5bGUoZWxlbWVudCkuZGlzcGxheTtcblxuICAgIGlmIChkaXNwbGF5ID09PSBcIm5vbmVcIikge1xuICAgICAgICBkaXNwbGF5ID0gXCJibG9ja1wiO1xuICAgIH1cblxuICAgIGVsZW1lbnQuc3R5bGUuZGlzcGxheSA9IGRpc3BsYXk7XG5cbiAgICBsZXQgaGVpZ2h0ID0gZWxlbWVudC5vZmZzZXRIZWlnaHQ7XG4gICAgbGV0IHBhZGRpbmdUb3AgPSB3aW5kb3cuZ2V0Q29tcHV0ZWRTdHlsZShlbGVtZW50KS5wYWRkaW5nVG9wO1xuICAgIGxldCBwYWRkaW5nQm90dG9tID0gd2luZG93LmdldENvbXB1dGVkU3R5bGUoZWxlbWVudCkucGFkZGluZ0JvdHRvbTtcbiAgICBsZXQgbWFyZ2luVG9wID0gd2luZG93LmdldENvbXB1dGVkU3R5bGUoZWxlbWVudCkubWFyZ2luVG9wO1xuICAgIGxldCBtYXJnaW5Cb3R0b20gPSB3aW5kb3cuZ2V0Q29tcHV0ZWRTdHlsZShlbGVtZW50KS5tYXJnaW5Cb3R0b207XG5cbiAgICBlbGVtZW50LnN0eWxlLmhlaWdodCA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5wYWRkaW5nVG9wID0gMDtcbiAgICBlbGVtZW50LnN0eWxlLnBhZGRpbmdCb3R0b20gPSAwO1xuICAgIGVsZW1lbnQuc3R5bGUubWFyZ2luVG9wID0gMDtcbiAgICBlbGVtZW50LnN0eWxlLm1hcmdpbkJvdHRvbSA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5vdmVyZmxvdyA9IFwiaGlkZGVuXCI7XG5cbiAgICBlbGVtZW50LnN0eWxlLmJveFNpemluZyA9IFwiYm9yZGVyLWJveFwiO1xuICAgIGVsZW1lbnQuc3R5bGUudHJhbnNpdGlvblByb3BlcnR5ID0gXCJoZWlnaHRcIjtcbiAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb25EdXJhdGlvbiA9IGAke2R1cmF0aW9ufW1zYDtcblxuICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICBlbGVtZW50LnN0eWxlLmhlaWdodCA9IGAke2hlaWdodH1weGA7XG4gICAgICAgIGlmIChwYWRkaW5nVG9wICE9PSBcIjBweFwiIHx8IHBhZGRpbmdCb3R0b20gIT09IFwiMHB4XCIpIHtcbiAgICAgICAgICAgIGVsZW1lbnQuc3R5bGUudHJhbnNpdGlvblByb3BlcnR5ID0gXCJwYWRkaW5nXCI7XG4gICAgICAgICAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb25EdXJhdGlvbiA9IGAke2R1cmF0aW9uIC8gMS4yfW1zYDtcbiAgICAgICAgICAgIGVsZW1lbnQuc3R5bGUucGFkZGluZ1RvcCA9IHBhZGRpbmdUb3A7XG4gICAgICAgICAgICBlbGVtZW50LnN0eWxlLnBhZGRpbmdCb3R0b20gPSBwYWRkaW5nQm90dG9tO1xuICAgICAgICAgICAgZWxlbWVudC5zdHlsZS5tYXJnaW5Ub3AgPSBtYXJnaW5Ub3A7XG4gICAgICAgICAgICBlbGVtZW50LnN0eWxlLm1hcmdpbkJvdHRvbSA9IG1hcmdpbkJvdHRvbTtcbiAgICAgICAgfVxuICAgIH0sIDEwKTtcblxuICAgIHdpbmRvdy5zZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcImhlaWdodFwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcIm92ZXJmbG93XCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwidHJhbnNpdGlvbi1kdXJhdGlvblwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcInRyYW5zaXRpb24tcHJvcGVydHlcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJwYWRkaW5nLXRvcFwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcInBhZGRpbmctYm90dG9tXCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwibWFyZ2luLXRvcFwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcIm1hcmdpbi1ib3R0b21cIik7XG4gICAgfSwgZHVyYXRpb24pO1xufTtcbmV4cG9ydCBjb25zdCBmYWRlSW4gPSAoZWxlbWVudCwgX29wdGlvbnMgPSB7fSkgPT4ge1xuICAgIGNvbnN0IG9wdGlvbnMgPSB7XG4gICAgICAgIG9wYWNpdHk6IDEsXG4gICAgICAgIHNwZWVkOiBcIm5vcm1hbFwiLFxuICAgICAgICBkaXNwbGF5OiBudWxsLFxuICAgICAgICBjYWxsYmFjazogbnVsbCxcbiAgICB9O1xuXG4gICAgT2JqZWN0LmFzc2lnbihvcHRpb25zLCBfb3B0aW9ucyk7XG5cbiAgICBlbGVtZW50LnN0eWxlLm9wYWNpdHkgPSAwO1xuICAgIGVsZW1lbnQuc3R5bGUuZGlzcGxheSA9ICEhb3B0aW9ucy5kaXNwbGF5IHx8IFwiYmxvY2tcIjtcblxuICAgIGNvbnN0IGZhZGUgPSAoKSA9PiB7XG4gICAgICAgIGxldCBvcGFjaXR5ID0gcGFyc2VGbG9hdChlbGVtZW50LnN0eWxlLm9wYWNpdHkpO1xuXG4gICAgICAgIGlmICgob3BhY2l0eSArPSBvcHRpb25zLnNwZWVkID09PSBcImZhc3RcIiA/IDAuMiA6IDAuMSkgPD0gb3B0aW9ucy5vcGFjaXR5KSB7XG4gICAgICAgICAgICBlbGVtZW50LnN0eWxlLm9wYWNpdHkgPSBvcGFjaXR5O1xuXG4gICAgICAgICAgICBpZiAob3BhY2l0eSA9PT0gMSAmJiBvcHRpb25zLmNhbGxiYWNrKSB7XG4gICAgICAgICAgICAgICAgY2FsbGJhY2soKTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgd2luZG93LnJlcXVlc3RBbmltYXRpb25GcmFtZShmYWRlKTtcbiAgICAgICAgfVxuICAgIH07XG5cbiAgICB3aW5kb3cucmVxdWVzdEFuaW1hdGlvbkZyYW1lKGZhZGUpO1xufTtcblxuZXhwb3J0IGNvbnN0IGZhZGVPdXQgPSAoZWxlbWVudCwgc3BlZWQgPSBcIm5vcm1hbFwiLCBkaXNwbGF5LCBjYWxsYmFjayA9IG51bGwpID0+IHtcbiAgICBlbGVtZW50LnN0eWxlLm9wYWNpdHkgPSAxO1xuICAgIGVsZW1lbnQuc3R5bGUuZGlzcGxheSA9IGRpc3BsYXkgfHwgXCJibG9ja1wiO1xuXG4gICAgY29uc3QgZmFkZSA9ICgpID0+IHtcbiAgICAgICAgbGV0IG9wYWNpdHkgPSBwYXJzZUZsb2F0KGVsZW1lbnQuc3R5bGUub3BhY2l0eSk7XG5cbiAgICAgICAgaWYgKChvcGFjaXR5IC09IHNwZWVkID09PSBcImZhc3RcIiA/IDAuMiA6IDAuMSkgPCAwKSB7XG4gICAgICAgICAgICBlbGVtZW50LnN0eWxlLmRpc3BsYXkgPSBcIm5vbmVcIjtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIGVsZW1lbnQuc3R5bGUub3BhY2l0eSA9IG9wYWNpdHk7XG5cbiAgICAgICAgICAgIGlmIChvcGFjaXR5ID09PSAwICYmIGNhbGxiYWNrKSB7XG4gICAgICAgICAgICAgICAgY2FsbGJhY2soKTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgd2luZG93LnJlcXVlc3RBbmltYXRpb25GcmFtZShmYWRlKTtcbiAgICAgICAgfVxuICAgIH07XG5cbiAgICB3aW5kb3cucmVxdWVzdEFuaW1hdGlvbkZyYW1lKGZhZGUpO1xufTtcbiIsImltcG9ydCBPV19CYXNlIGZyb20gXCIuL2Jhc2UvYmFzZVwiO1xuaW1wb3J0IHsgZmFkZUluLCBmYWRlT3V0IH0gZnJvbSBcIi4vbGliL3V0aWxzXCI7XG5cbmNsYXNzIE9XX01vZGFsV2luZG93IGV4dGVuZHMgT1dfQmFzZSB7XG4gICAgbW9kYWw7XG5cbiAgICBnZXREZWZhdWx0U2V0dGluZ3MoKSB7XG4gICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICBzZWxlY3RvcnM6IHtcbiAgICAgICAgICAgICAgICBtb2RhbFdpbmRvdzogXCIub213LW1vZGFsXCIsXG4gICAgICAgICAgICAgICAgbW9kYWxXaW5kb3dPcGVuQnV0dG9uczpcbiAgICAgICAgICAgICAgICAgICAgXCIub213LW9wZW4tbW9kYWwsIC5vbXctb3Blbi1tb2RhbCBhLCAub213LW9wZW4tbW9kYWwgYS5lbGVtZW50b3ItYnV0dG9uLCBsaS5zaWRyLWNsYXNzLW9tdy1vcGVuLW1vZGFsID4gYVwiLFxuICAgICAgICAgICAgICAgIG1vZGFsV2luZG93Q2xvc2VCdG46IFwiLm9tdy1jbG9zZS1tb2RhbFwiLFxuICAgICAgICAgICAgICAgIG92ZXJsYXk6IFwiLm9tdy1tb2RhbC1vdmVybGF5XCIsXG4gICAgICAgICAgICB9LFxuICAgICAgICB9O1xuICAgIH1cblxuICAgIGdldERlZmF1bHRFbGVtZW50cygpIHtcbiAgICAgICAgY29uc3Qgc2VsZWN0b3JzID0gdGhpcy5nZXRTZXR0aW5ncyhcInNlbGVjdG9yc1wiKTtcblxuICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgbW9kYWxXaW5kb3c6IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3Ioc2VsZWN0b3JzLm1vZGFsV2luZG93KSxcbiAgICAgICAgICAgIG1vZGFsV2luZG93T3BlbkJ1dHRvbnM6IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoc2VsZWN0b3JzLm1vZGFsV2luZG93T3BlbkJ1dHRvbnMpLFxuICAgICAgICAgICAgbW9kYWxXaW5kb3dDbG9zZUJ0bjogZG9jdW1lbnQucXVlcnlTZWxlY3RvcihzZWxlY3RvcnMubW9kYWxXaW5kb3dDbG9zZUJ0biksXG4gICAgICAgICAgICBvdmVybGF5OiBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKHNlbGVjdG9ycy5vdmVybGF5KSxcbiAgICAgICAgICAgIGJvZHk6IGRvY3VtZW50LmJvZHksXG4gICAgICAgIH07XG4gICAgfVxuXG4gICAgb25Jbml0KCkge1xuICAgICAgICBzdXBlci5vbkluaXQoKTtcblxuICAgICAgICBpZiAoISF0aGlzLmVsZW1lbnRzLm1vZGFsV2luZG93ICYmIHRoaXMuaXNEZXNrdG9wQnJvd3NlcigpKSB7XG4gICAgICAgICAgICB0aGlzLmluaXRQZXJmZWN0U2Nyb2xsYmFyKCk7XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICBiaW5kRXZlbnRzKCkge1xuICAgICAgICBpZiAoIXRoaXMuZWxlbWVudHMubW9kYWxXaW5kb3cpIHtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuZWxlbWVudHMubW9kYWxXaW5kb3dPcGVuQnV0dG9ucy5mb3JFYWNoKChtb2RhbE9wZW5CdG4pID0+IHtcbiAgICAgICAgICAgIG1vZGFsT3BlbkJ0bi5hZGRFdmVudExpc3RlbmVyKFwiY2xpY2tcIiwgdGhpcy5vcGVuTW9kYWwuYmluZCh0aGlzKSk7XG4gICAgICAgIH0pO1xuXG4gICAgICAgIHRoaXMuZWxlbWVudHMubW9kYWxXaW5kb3dDbG9zZUJ0bi5hZGRFdmVudExpc3RlbmVyKFwiY2xpY2tcIiwgdGhpcy5jbG9zZU1vZGFsLmJpbmQodGhpcykpO1xuICAgICAgICB0aGlzLmVsZW1lbnRzLm92ZXJsYXkuYWRkRXZlbnRMaXN0ZW5lcihcImNsaWNrXCIsIHRoaXMuY2xvc2VNb2RhbC5iaW5kKHRoaXMpKTtcblxuICAgICAgICB3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lcihcImtleXVwXCIsIHRoaXMub25XaW5kb3dLZXl1cC5iaW5kKHRoaXMpKTtcbiAgICB9XG5cbiAgICBvcGVuTW9kYWwoZXZlbnQpIHtcbiAgICAgICAgZXZlbnQucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgZXZlbnQuc3RvcFByb3BhZ2F0aW9uKCk7XG5cbiAgICAgICAgY29uc3QgbW9kYWxPcGVuQnRuID0gZXZlbnQuY3VycmVudFRhcmdldDtcbiAgICAgICAgY29uc3QgbW9kYWxJRCA9IG1vZGFsT3BlbkJ0bi5nZXRBdHRyaWJ1dGUoXCJocmVmXCIpO1xuICAgICAgICB0aGlzLm1vZGFsID0gZG9jdW1lbnQucXVlcnlTZWxlY3Rvcihtb2RhbElEKTtcblxuICAgICAgICBpZiAoISF0aGlzLm1vZGFsKSB7XG4gICAgICAgICAgICB0aGlzLmVsZW1lbnRzLmJvZHkuY2xhc3NMaXN0LmFkZCh0aGlzLm1vZGFsLmlkKTtcbiAgICAgICAgICAgIGZhZGVJbih0aGlzLmVsZW1lbnRzLm92ZXJsYXkpO1xuICAgICAgICAgICAgZmFkZUluKHRoaXMubW9kYWwpO1xuICAgICAgICAgICAgdGhpcy5tb2RhbC5jbGFzc0xpc3QuYWRkKFwib213LW9wZW5cIik7XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICBjbG9zZU1vZGFsKGV2ZW50KSB7XG4gICAgICAgIGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cbiAgICAgICAgaWYgKCF0aGlzLm1vZGFsKSB7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cblxuICAgICAgICBpZiAoIXRoaXMubW9kYWwuY2xhc3NMaXN0LmNvbnRhaW5zKFwib213LW9wZW5cIikpIHtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuXG4gICAgICAgIGZhZGVPdXQodGhpcy5lbGVtZW50cy5vdmVybGF5KTtcbiAgICAgICAgZmFkZU91dCh0aGlzLm1vZGFsKTtcbiAgICAgICAgdGhpcy5tb2RhbC5jbGFzc0xpc3QucmVtb3ZlKFwib213LW9wZW5cIik7XG5cbiAgICAgICAgLy8gU3RvcCB2aWRlb1xuICAgICAgICBjb25zdCBpZnJhbWVzID0gdGhpcy5tb2RhbC5xdWVyeVNlbGVjdG9yQWxsKFwiaWZyYW1lXCIpO1xuXG4gICAgICAgIGlmICghIWlmcmFtZXMpIHtcbiAgICAgICAgICAgIGlmcmFtZXMuZm9yRWFjaCgoaWZyYW1lKSA9PiB7XG4gICAgICAgICAgICAgICAgaWZyYW1lLnNyYyA9IGlmcmFtZS5zcmM7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuXG4gICAgICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICAgICAgdGhpcy5lbGVtZW50cy5ib2R5LmNsYXNzTGlzdC5yZW1vdmUodGhpcy5tb2RhbC5pZCk7XG4gICAgICAgIH0sIDMwMCk7XG4gICAgfVxuXG4gICAgb25XaW5kb3dLZXl1cChldmVudCkge1xuICAgICAgICBjb25zdCBpc0VTQ0tleSA9IGV2ZW50LmtleUNvZGUgPT09IDI3ID8gdHJ1ZSA6IGZhbHNlO1xuXG4gICAgICAgIGlmIChpc0VTQ0tleSkge1xuICAgICAgICAgICAgdGhpcy5jbG9zZU1vZGFsKGV2ZW50KTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIGluaXRQZXJmZWN0U2Nyb2xsYmFyKCkge1xuICAgICAgICBuZXcgUGVyZmVjdFNjcm9sbGJhcih0aGlzLmVsZW1lbnRzLm1vZGFsV2luZG93LCB7XG4gICAgICAgICAgICB3aGVlbFNwZWVkOiAwLjUsXG4gICAgICAgICAgICBzdXBwcmVzc1Njcm9sbFg6IGZhbHNlLFxuICAgICAgICAgICAgc3VwcHJlc3NTY3JvbGxZOiBmYWxzZSxcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgaXNEZXNrdG9wQnJvd3NlcigpIHtcbiAgICAgICAgcmV0dXJuICFuYXZpZ2F0b3IudXNlckFnZW50Lm1hdGNoKC8oQW5kcm9pZHxpUG9kfGlQaG9uZXxpUGFkfElFTW9iaWxlfE9wZXJhIE1pbmkpLyk7XG4gICAgfVxufVxuXG4oXCJ1c2Ugc2NyaXB0XCIpO1xubmV3IE9XX01vZGFsV2luZG93KCk7XG4iXX0=
