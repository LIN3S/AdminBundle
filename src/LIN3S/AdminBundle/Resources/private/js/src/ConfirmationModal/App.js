import React, {Component} from 'react';

import ConfirmationModal from './Component';

class App extends Component {
  static propTypes = {
    callback: React.PropTypes.func,
    description: React.PropTypes.string,
    title: React.PropTypes.string,
    trigger: React.PropTypes.object,
  };

  constructor() {
    super();
    this.state = {
      modalIsOpen: false
    };
  }

  openModal() {
    this.setState({
      modalIsOpen: true
    });

    document.getElementsByTagName('body')[0].style.overflow = 'hidden';
  }

  closeModal() {
    this.setState({
      modalIsOpen: false
    });

    document.getElementsByTagName('body')[0].style.overflow = '';
  }

  buildContent() {
    return {
      title: this.props.title ? this.props.title : '',
      message: this.props.description ? this.props.description : ''
    };
  }

  buildTrigger() {
    return (
      <button
        className={this.props.trigger.style}
        dangerouslySetInnerHTML={{__html: this.props.trigger.content}}
        onClick={this.openModal.bind(this)}/>
    );
  }

  render() {
    return (
      <div>
        {this.buildTrigger()}
        <ConfirmationModal
          callback={this.props.callback}
          closeModal={this.closeModal.bind(this)}
          content={this.buildContent()}
          isOpen={this.state.modalIsOpen}
        />
      </div>
    );
  }
}

export default App;
