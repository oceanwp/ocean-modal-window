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
exports.slideDown = exports.slideUp = void 0;

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

      if (this.isDesktopBrowser()) {
        this.initPerfectScrollbar();
      }
    }
  }, {
    key: "bindEvents",
    value: function bindEvents() {
      var _this2 = this;

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJhc3NldHMvc3JjL2pzL2Jhc2UvYmFzZS5qcyIsImFzc2V0cy9zcmMvanMvbGliL3V0aWxzLmpzIiwiYXNzZXRzL3NyYy9qcy9tb2RhbC13aW5kb3cuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7SUNBTSxPO0FBSUYscUJBQWM7QUFBQTs7QUFBQTtBQUFBO0FBQUE7QUFBQTs7QUFBQTs7QUFDVixTQUFLLE1BQUw7QUFDQSxTQUFLLFVBQUw7QUFDSDs7OztXQUVELDhCQUFxQjtBQUNqQixhQUFPLEVBQVA7QUFDSDs7O1dBRUQsOEJBQXFCO0FBQ2pCLGFBQU8sRUFBUDtBQUNIOzs7V0FFRCxrQkFBUztBQUNMLDZDQUFpQixLQUFLLGtCQUFMLEVBQWpCOztBQUNBLFdBQUssUUFBTCxHQUFnQixLQUFLLGtCQUFMLEVBQWhCO0FBQ0g7OztXQUVELHNCQUFhLENBQUU7OztXQUVmLHVCQUF3QjtBQUFBLFVBQVosR0FBWSx1RUFBTixJQUFNOztBQUNwQixVQUFJLENBQUMsQ0FBQyxHQUFOLEVBQVc7QUFDUCxlQUFPLHVDQUFlLEdBQWYsQ0FBUDtBQUNIOztBQUVELG1DQUFPLElBQVA7QUFDSDs7O1dBRUQsdUJBQTJCO0FBQUEsVUFBZixRQUFlLHVFQUFKLEVBQUk7O0FBQ3ZCLFVBQUksQ0FBQyxRQUFMLEVBQWU7QUFDWDtBQUNIOztBQUVELDZDQUFpQixNQUFNLENBQUMsTUFBUCx1QkFBYyxJQUFkLGNBQThCLFFBQTlCLENBQWpCO0FBQ0g7Ozs7OztlQUdVLE87Ozs7Ozs7Ozs7O0FDekNSLElBQU0sT0FBTyxHQUFHLFNBQVYsT0FBVSxDQUFDLE9BQUQsRUFBNkI7QUFBQSxNQUFuQixRQUFtQix1RUFBUixHQUFRO0FBQ2hELEVBQUEsT0FBTyxDQUFDLEtBQVIsQ0FBYyxTQUFkLEdBQTBCLFlBQTFCO0FBQ0EsRUFBQSxPQUFPLENBQUMs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OztXQUVELDRCQUFtQjtBQUNmLGFBQU8sQ0FBQyxTQUFTLENBQUMsU0FBVixDQUFvQixLQUFwQixDQUEwQixnREFBMUIsQ0FBUjtBQUNIOzs7O0VBN0d3QixnQjs7QUFnSDVCLFlBQUQ7QUFDQSxJQUFJLGNBQUoiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbigpe2Z1bmN0aW9uIHIoZSxuLHQpe2Z1bmN0aW9uIG8oaSxmKXtpZighbltpXSl7aWYoIWVbaV0pe3ZhciBjPVwiZnVuY3Rpb25cIj09dHlwZW9mIHJlcXVpcmUmJnJlcXVpcmU7aWYoIWYmJmMpcmV0dXJuIGMoaSwhMCk7aWYodSlyZXR1cm4gdShpLCEwKTt2YXIgYT1uZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiK2krXCInXCIpO3Rocm93IGEuY29kZT1cIk1PRFVMRV9OT1RfRk9VTkRcIixhfXZhciBwPW5baV09e2V4cG9ydHM6e319O2VbaV1bMF0uY2FsbChwLmV4cG9ydHMsZnVuY3Rpb24ocil7dmFyIG49ZVtpXVsxXVtyXTtyZXR1cm4gbyhufHxyKX0scCxwLmV4cG9ydHMscixlLG4sdCl9cmV0dXJuIG5baV0uZXhwb3J0c31mb3IodmFyIHU9XCJmdW5jdGlvblwiPT10eXBlb2YgcmVxdWlyZSYmcmVxdWlyZSxpPTA7aTx0Lmxlbmd0aDtpKyspbyh0W2ldKTtyZXR1cm4gb31yZXR1cm4gcn0pKCkiLCJjbGFzcyBPV19CYXNlIHtcbiAgICAjc2V0dGluZ3M7XG4gICAgZWxlbWVudHM7XG5cbiAgICBjb25zdHJ1Y3RvcigpIHtcbiAgICAgICAgdGhpcy5vbkluaXQoKTtcbiAgICAgICAgdGhpcy5iaW5kRXZlbnRzKCk7XG4gICAgfVxuXG4gICAgZ2V0RGVmYXVsdFNldHRpbmdzKCkge1xuICAgICAgICByZXR1cm4ge307XG4gICAgfVxuXG4gICAgZ2V0RGVmYXVsdEVsZW1lbnRzKCkge1xuICAgICAgICByZXR1cm4ge307XG4gICAgfVxuXG4gICAgb25Jbml0KCkge1xuICAgICAgICB0aGlzLiNzZXR0aW5ncyA9IHRoaXMuZ2V0RGVmYXVsdFNldHRpbmdzKCk7XG4gICAgICAgIHRoaXMuZWxlbWVudHMgPSB0aGlzLmdldERlZmF1bHRFbGVtZW50cygpO1xuICAgIH1cblxuICAgIGJpbmRFdmVudHMoKSB7fVxuXG4gICAgZ2V0U2V0dGluZ3Moa2V5ID0gbnVsbCkge1xuICAgICAgICBpZiAoISFrZXkpIHtcbiAgICAgICAgICAgIHJldHVybiB0aGlzLiNzZXR0aW5nc1trZXldO1xuICAgICAgICB9XG5cbiAgICAgICAgcmV0dXJuIHRoaXMuI3NldHRpbmdzO1xuICAgIH1cblxuICAgIHNldFNldHRpbmdzKHNldHRpbmdzID0ge30pIHtcbiAgICAgICAgaWYgKCFzZXR0aW5ncykge1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy4jc2V0dGluZ3MgPSBPYmplY3QuYXNzaWduKHRoaXMuI3NldHRpbmdzLCBzZXR0aW5ncyk7XG4gICAgfVxufVxuXG5leHBvcnQgZGVmYXVsdCBPV19CYXNlO1xuIiwiZXhwb3J0IGNvbnN0IHNsaWRlVXAgPSAoZWxlbWVudCwgZHVyYXRpb24gPSAzMDApID0+IHtcbiAgICBlbGVtZW50LnN0eWxlLmJveFNpemluZyA9IFwiYm9yZGVyLWJveFwiO1xuICAgIGVsZW1lbnQuc3R5bGUudHJhbnNpdGlvblByb3BlcnR5ID0gXCJoZWlnaHQsIG1hcmdpbiwgcGFkZGluZ1wiO1xuICAgIGVsZW1lbnQuc3R5bGUudHJhbnNpdGlvbkR1cmF0aW9uID0gYCR7ZHVyYXRpb259bXNgO1xuICAgIGVsZW1lbnQuc3R5bGUuaGVpZ2h0ID0gYCR7ZWxlbWVudC5vZmZzZXRIZWlnaHR9cHhgO1xuICAgIGVsZW1lbnQuc3R5bGUucGFkZGluZ1RvcCA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5wYWRkaW5nQm90dG9tID0gMDtcbiAgICBlbGVtZW50LnN0eWxlLm1hcmdpblRvcCA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5tYXJnaW5Cb3R0b20gPSAwO1xuICAgIGVsZW1lbnQuc3R5bGUub3ZlcmZsb3cgPSBcImhpZGRlblwiO1xuXG4gICAgc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUuaGVpZ2h0ID0gMDtcbiAgICB9LCAxMCk7XG5cbiAgICB3aW5kb3cuc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUuZGlzcGxheSA9IFwibm9uZVwiO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwiaGVpZ2h0XCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwicGFkZGluZy10b3BcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJwYWRkaW5nLWJvdHRvbVwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcIm1hcmdpbi10b3BcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJtYXJnaW4tYm90dG9tXCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwib3ZlcmZsb3dcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJ0cmFuc2l0aW9uLWR1cmF0aW9uXCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwidHJhbnNpdGlvbi1wcm9wZXJ0eVwiKTtcbiAgICB9LCBkdXJhdGlvbik7XG59O1xuXG5leHBvcnQgY29uc3Qgc2xpZGVEb3duID0gKGVsZW1lbnQsIGR1cmF0aW9uID0gMzAwKSA9PiB7XG4gICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcImRpc3BsYXlcIik7XG5cbiAgICBsZXQgZGlzcGxheSA9IHdpbmRvdy5nZXRDb21wdXRlZFN0eWxlKGVsZW1lbnQpLmRpc3BsYXk7XG5cbiAgICBpZiAoZGlzcGxheSA9PT0gXCJub25lXCIpIHtcbiAgICAgICAgZGlzcGxheSA9IFwiYmxvY2tcIjtcbiAgICB9XG5cbiAgICBlbGVtZW50LnN0eWxlLmRpc3BsYXkgPSBkaXNwbGF5O1xuXG4gICAgbGV0IGhlaWdodCA9IGVsZW1lbnQub2Zmc2V0SGVpZ2h0O1xuICAgIGxldCBwYWRkaW5nVG9wID0gd2luZG93LmdldENvbXB1dGVkU3R5bGUoZWxlbWVudCkucGFkZGluZ1RvcDtcbiAgICBsZXQgcGFkZGluZ0JvdHRvbSA9IHdpbmRvdy5nZXRDb21wdXRlZFN0eWxlKGVsZW1lbnQpLnBhZGRpbmdCb3R0b207XG4gICAgbGV0IG1hcmdpblRvcCA9IHdpbmRvdy5nZXRDb21wdXRlZFN0eWxlKGVsZW1lbnQpLm1hcmdpblRvcDtcbiAgICBsZXQgbWFyZ2luQm90dG9tID0gd2luZG93LmdldENvbXB1dGVkU3R5bGUoZWxlbWVudCkubWFyZ2luQm90dG9tO1xuXG4gICAgZWxlbWVudC5zdHlsZS5oZWlnaHQgPSAwO1xuICAgIGVsZW1lbnQuc3R5bGUucGFkZGluZ1RvcCA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5wYWRkaW5nQm90dG9tID0gMDtcbiAgICBlbGVtZW50LnN0eWxlLm1hcmdpblRvcCA9IDA7XG4gICAgZWxlbWVudC5zdHlsZS5tYXJnaW5Cb3R0b20gPSAwO1xuICAgIGVsZW1lbnQuc3R5bGUub3ZlcmZsb3cgPSBcImhpZGRlblwiO1xuXG4gICAgZWxlbWVudC5zdHlsZS5ib3hTaXppbmcgPSBcImJvcmRlci1ib3hcIjtcbiAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb25Qcm9wZXJ0eSA9IFwiaGVpZ2h0XCI7XG4gICAgZWxlbWVudC5zdHlsZS50cmFuc2l0aW9uRHVyYXRpb24gPSBgJHtkdXJhdGlvbn1tc2A7XG5cbiAgICBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5oZWlnaHQgPSBgJHtoZWlnaHR9cHhgO1xuICAgICAgICBpZiAocGFkZGluZ1RvcCAhPT0gXCIwcHhcIiB8fCBwYWRkaW5nQm90dG9tICE9PSBcIjBweFwiKSB7XG4gICAgICAgICAgICBlbGVtZW50LnN0eWxlLnRyYW5zaXRpb25Qcm9wZXJ0eSA9IFwicGFkZGluZ1wiO1xuICAgICAgICAgICAgZWxlbWVudC5zdHlsZS50cmFuc2l0aW9uRHVyYXRpb24gPSBgJHtkdXJhdGlvbiAvIDEuMn1tc2A7XG4gICAgICAgICAgICBlbGVtZW50LnN0eWxlLnBhZGRpbmdUb3AgPSBwYWRkaW5nVG9wO1xuICAgICAgICAgICAgZWxlbWVudC5zdHlsZS5wYWRkaW5nQm90dG9tID0gcGFkZGluZ0JvdHRvbTtcbiAgICAgICAgICAgIGVsZW1lbnQuc3R5bGUubWFyZ2luVG9wID0gbWFyZ2luVG9wO1xuICAgICAgICAgICAgZWxlbWVudC5zdHlsZS5tYXJnaW5Cb3R0b20gPSBtYXJnaW5Cb3R0b207XG4gICAgICAgIH1cbiAgICB9LCAxMCk7XG5cbiAgICB3aW5kb3cuc2V0VGltZW91dCgoKSA9PiB7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJoZWlnaHRcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJvdmVyZmxvd1wiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcInRyYW5zaXRpb24tZHVyYXRpb25cIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJ0cmFuc2l0aW9uLXByb3BlcnR5XCIpO1xuICAgICAgICBlbGVtZW50LnN0eWxlLnJlbW92ZVByb3BlcnR5KFwicGFkZGluZy10b3BcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJwYWRkaW5nLWJvdHRvbVwiKTtcbiAgICAgICAgZWxlbWVudC5zdHlsZS5yZW1vdmVQcm9wZXJ0eShcIm1hcmdpbi10b3BcIik7XG4gICAgICAgIGVsZW1lbnQuc3R5bGUucmVtb3ZlUHJvcGVydHkoXCJtYXJnaW4tYm90dG9tXCIpO1xuICAgIH0sIGR1cmF0aW9uKTtcbn07XG4iLCJpbXBvcnQgT1dfQmFzZSBmcm9tIFwiLi9iYXNlL2Jhc2VcIjtcbmltcG9ydCB7IGZhZGVJbiwgZmFkZU91dCB9IGZyb20gXCIuL2xpYi91dGlsc1wiO1xuXG5jbGFzcyBPV19Nb2RhbFdpbmRvdyBleHRlbmRzIE9XX0Jhc2Uge1xuICAgIG1vZGFsO1xuXG4gICAgZ2V0RGVmYXVsdFNldHRpbmdzKCkge1xuICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgc2VsZWN0b3JzOiB7XG4gICAgICAgICAgICAgICAgbW9kYWxXaW5kb3c6IFwiLm9tdy1tb2RhbFwiLFxuICAgICAgICAgICAgICAgIG1vZGFsV2luZG93T3BlbkJ1dHRvbnM6XG4gICAgICAgICAgICAgICAgICAgIFwiLm9tdy1vcGVuLW1vZGFsLCAub213LW9wZW4tbW9kYWwgYSwgLm9tdy1vcGVuLW1vZGFsIGEuZWxlbWVudG9yLWJ1dHRvbiwgbGkuc2lkci1jbGFzcy1vbXctb3Blbi1tb2RhbCA+IGFcIixcbiAgICAgICAgICAgICAgICBtb2RhbFdpbmRvd0Nsb3NlQnRuOiBcIi5vbXctY2xvc2UtbW9kYWxcIixcbiAgICAgICAgICAgICAgICBvdmVybGF5OiBcIi5vbXctbW9kYWwtb3ZlcmxheVwiLFxuICAgICAgICAgICAgfSxcbiAgICAgICAgfTtcbiAgICB9XG5cbiAgICBnZXREZWZhdWx0RWxlbWVudHMoKSB7XG4gICAgICAgIGNvbnN0IHNlbGVjdG9ycyA9IHRoaXMuZ2V0U2V0dGluZ3MoXCJzZWxlY3RvcnNcIik7XG5cbiAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgIG1vZGFsV2luZG93OiBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKHNlbGVjdG9ycy5tb2RhbFdpbmRvdyksXG4gICAgICAgICAgICBtb2RhbFdpbmRvd09wZW5CdXR0b25zOiBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKHNlbGVjdG9ycy5tb2RhbFdpbmRvd09wZW5CdXR0b25zKSxcbiAgICAgICAgICAgIG1vZGFsV2luZG93Q2xvc2VCdG46IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3Ioc2VsZWN0b3JzLm1vZGFsV2luZG93Q2xvc2VCdG4pLFxuICAgICAgICAgICAgb3ZlcmxheTogZG9jdW1lbnQucXVlcnlTZWxlY3RvcihzZWxlY3RvcnMub3ZlcmxheSksXG4gICAgICAgICAgICBib2R5OiBkb2N1bWVudC5ib2R5LFxuICAgICAgICB9O1xuICAgIH1cblxuICAgIG9uSW5pdCgpIHtcbiAgICAgICAgc3VwZXIub25Jbml0KCk7XG5cbiAgICAgICAgaWYgKHRoaXMuaXNEZXNrdG9wQnJvd3NlcigpKSB7XG4gICAgICAgICAgICB0aGlzLmluaXRQZXJmZWN0U2Nyb2xsYmFyKCk7XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICBiaW5kRXZlbnRzKCkge1xuICAgICAgICB0aGlzLmVsZW1lbnRzLm1vZGFsV2luZG93T3BlbkJ1dHRvbnMuZm9yRWFjaCgobW9kYWxPcGVuQnRuKSA9PiB7XG4gICAgICAgICAgICBtb2RhbE9wZW5CdG4uYWRkRXZlbnRMaXN0ZW5lcihcImNsaWNrXCIsIHRoaXMub3Blbk1vZGFsLmJpbmQodGhpcykpO1xuICAgICAgICB9KTtcblxuICAgICAgICB0aGlzLmVsZW1lbnRzLm1vZGFsV2luZG93Q2xvc2VCdG4uYWRkRXZlbnRMaXN0ZW5lcihcImNsaWNrXCIsIHRoaXMuY2xvc2VNb2RhbC5iaW5kKHRoaXMpKTtcbiAgICAgICAgdGhpcy5lbGVtZW50cy5vdmVybGF5LmFkZEV2ZW50TGlzdGVuZXIoXCJjbGlja1wiLCB0aGlzLmNsb3NlTW9kYWwuYmluZCh0aGlzKSk7XG5cbiAgICAgICAgd2luZG93LmFkZEV2ZW50TGlzdGVuZXIoXCJrZXl1cFwiLCB0aGlzLm9uV2luZG93S2V5dXAuYmluZCh0aGlzKSk7XG4gICAgfVxuXG4gICAgb3Blbk1vZGFsKGV2ZW50KSB7XG4gICAgICAgIGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xuXG4gICAgICAgIGNvbnN0IG1vZGFsT3BlbkJ0biA9IGV2ZW50LmN1cnJlbnRUYXJnZXQ7XG4gICAgICAgIGNvbnN0IG1vZGFsSUQgPSBtb2RhbE9wZW5CdG4uZ2V0QXR0cmlidXRlKFwiaHJlZlwiKTtcbiAgICAgICAgdGhpcy5tb2RhbCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IobW9kYWxJRCk7XG5cbiAgICAgICAgaWYgKCEhdGhpcy5tb2RhbCkge1xuICAgICAgICAgICAgdGhpcy5lbGVtZW50cy5ib2R5LmNsYXNzTGlzdC5hZGQodGhpcy5tb2RhbC5pZCk7XG4gICAgICAgICAgICBmYWRlSW4odGhpcy5lbGVtZW50cy5vdmVybGF5KTtcbiAgICAgICAgICAgIGZhZGVJbih0aGlzLm1vZGFsKTtcbiAgICAgICAgICAgIHRoaXMubW9kYWwuY2xhc3NMaXN0LmFkZChcIm9tdy1vcGVuXCIpO1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgY2xvc2VNb2RhbChldmVudCkge1xuICAgICAgICBldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICAgIGlmICghdGhpcy5tb2RhbCkge1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYgKCF0aGlzLm1vZGFsLmNsYXNzTGlzdC5jb250YWlucyhcIm9tdy1vcGVuXCIpKSB7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cblxuICAgICAgICBmYWRlT3V0KHRoaXMuZWxlbWVudHMub3ZlcmxheSk7XG4gICAgICAgIGZhZGVPdXQodGhpcy5tb2RhbCk7XG4gICAgICAgIHRoaXMubW9kYWwuY2xhc3NMaXN0LnJlbW92ZShcIm9tdy1vcGVuXCIpO1xuXG4gICAgICAgIC8vIFN0b3AgdmlkZW9cbiAgICAgICAgY29uc3QgaWZyYW1lcyA9IHRoaXMubW9kYWwucXVlcnlTZWxlY3RvckFsbChcImlmcmFtZVwiKTtcblxuICAgICAgICBpZiAoISFpZnJhbWVzKSB7XG4gICAgICAgICAgICBpZnJhbWVzLmZvckVhY2goKGlmcmFtZSkgPT4ge1xuICAgICAgICAgICAgICAgIGlmcmFtZS5zcmMgPSBpZnJhbWUuc3JjO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cblxuICAgICAgICBzZXRUaW1lb3V0KCgpID0+IHtcbiAgICAgICAgICAgIHRoaXMuZWxlbWVudHMuYm9keS5jbGFzc0xpc3QucmVtb3ZlKHRoaXMubW9kYWwuaWQpO1xuICAgICAgICB9LCAzMDApO1xuICAgIH1cblxuICAgIG9uV2luZG93S2V5dXAoZXZlbnQpIHtcbiAgICAgICAgY29uc3QgaXNFU0NLZXkgPSBldmVudC5rZXlDb2RlID09PSAyNyA/IHRydWUgOiBmYWxzZTtcblxuICAgICAgICBpZiAoaXNFU0NLZXkpIHtcbiAgICAgICAgICAgIHRoaXMuY2xvc2VNb2RhbChldmVudCk7XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICBpbml0UGVyZmVjdFNjcm9sbGJhcigpIHtcbiAgICAgICAgbmV3IFBlcmZlY3RTY3JvbGxiYXIodGhpcy5lbGVtZW50cy5tb2RhbFdpbmRvdywge1xuICAgICAgICAgICAgd2hlZWxTcGVlZDogMC41LFxuICAgICAgICAgICAgc3VwcHJlc3NTY3JvbGxYOiBmYWxzZSxcbiAgICAgICAgICAgIHN1cHByZXNzU2Nyb2xsWTogZmFsc2UsXG4gICAgICAgIH0pO1xuICAgIH1cblxuICAgIGlzRGVza3RvcEJyb3dzZXIoKSB7XG4gICAgICAgIHJldHVybiAhbmF2aWdhdG9yLnVzZXJBZ2VudC5tYXRjaCgvKEFuZHJvaWR8aVBvZHxpUGhvbmV8aVBhZHxJRU1vYmlsZXxPcGVyYSBNaW5pKS8pO1xuICAgIH1cbn1cblxuKFwidXNlIHNjcmlwdFwiKTtcbm5ldyBPV19Nb2RhbFdpbmRvdygpO1xuIl19
