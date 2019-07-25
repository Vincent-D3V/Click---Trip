import React from 'react';
import ReactDOM from 'react-dom';

// ROUTING
import Routing from '../../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
const routes = require('../../../../public/js/fos_js_routes.json');
Routing.setRoutingData(routes);

// COMPONENTS
import Messages from './components/Messages/Messages';

// CSS
import 'semantic-ui-css/semantic.min.css';
import './Mailbox.css'

function Mailbox() {
  const id=document.getElementById('root').getAttribute('user-id');
  const type=document.getElementById('root').getAttribute('user-type');

  return (
    <div className="Mailbox">
      <Messages userId={id} userType={type} />
    </div>
  );
}
ReactDOM.render(<Mailbox />, document.getElementById('root'));
