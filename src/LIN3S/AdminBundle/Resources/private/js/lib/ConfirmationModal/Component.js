'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _react = require('react');

var _react2 = _interopRequireDefault(_react);

var _reactModal = require('react-modal');

var _reactModal2 = _interopRequireDefault(_reactModal);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var styles = {
  reactModalOverlay: {
    zIndex: 1000
  },
  reactModalContent: {
    alignItems: 'center',
    display: 'flex',
    height: '30%',
    justifyContent: 'center',
    left: '50%',
    padding: '0',
    top: '50%',
    transform: 'translate(-50%, -50%)',
    width: '30%'
  },
  root: {
    backgroundColor: '#fff',
    marginLeft: 'auto',
    marginRight: 'auto',
    maxWidth: '400px',
    position: 'relative',
    textAlign: 'center',
    width: '100%'
  },
  content: {
    marginBottom: '15px',
    marginLeft: '10px',
    marginRight: '10px'
  },
  actions: {
    display: 'flex',
    justifyContent: 'space-around',
    marginBottom: '15px',
    marginLeft: '10px',
    marginRight: '10px'
  }
};

var ConfirmationModal = function (_Component) {
  _inherits(ConfirmationModal, _Component);

  function ConfirmationModal() {
    _classCallCheck(this, ConfirmationModal);

    return _possibleConstructorReturn(this, (ConfirmationModal.__proto__ || Object.getPrototypeOf(ConfirmationModal)).apply(this, arguments));
  }

  _createClass(ConfirmationModal, [{
    key: 'callback',
    value: function callback() {
      this.props.callback(this.props.args);
      this.props.closeModal();
    }
  }, {
    key: 'render',
    value: function render() {
      return _react2.default.createElement(
        _reactModal2.default,
        {
          isOpen: this.props.isOpen,
          onRequestClose: this.props.closeModal,
          style: { overlay: styles.reactModalOverlay, content: styles.reactModalContent } },
        _react2.default.createElement(
          'div',
          { style: styles.root },
          _react2.default.createElement(
            'h2',
            null,
            this.props.content.title
          ),
          _react2.default.createElement(
            'div',
            { style: styles.content },
            _react2.default.createElement(
              'p',
              null,
              this.props.content.message
            )
          ),
          _react2.default.createElement(
            'div',
            { style: styles.actions },
            _react2.default.createElement(
              'button',
              { className: 'button button--secondary',
                onClick: this.callback.bind(this),
                type: 'button' },
              '\u2714'
            ),
            _react2.default.createElement(
              'button',
              { className: 'button',
                onClick: this.props.closeModal.bind(this),
                type: 'button' },
              '\u2718'
            )
          )
        )
      );
    }
  }]);

  return ConfirmationModal;
}(_react.Component);

ConfirmationModal.propTypes = {
  isOpen: _react2.default.PropTypes.bool,
  closeModal: _react2.default.PropTypes.func,
  content: _react2.default.PropTypes.object,
  callback: _react2.default.PropTypes.func,
  args: _react2.default.PropTypes.array
};
exports.default = ConfirmationModal;