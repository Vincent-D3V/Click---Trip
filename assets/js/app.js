
import React from 'react';
import ReactDOM from 'react-dom';

// ROUTING
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
const routes = require('../../public/js/fos_js_routes.json');
Routing.setRoutingData(routes);

const [etapes, setEtapes] = useState([]);
// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');
require('semantic-ui/dist/semantic.min.css')
require('semantic-ui/dist/semantic.min.js')
require('../scss/_footer.scss')
require('../scss/_navbar.scss')
require('./_navbar.js')
require('../scss/travelerDetailForm.scss')
// COMPONENTS
import Etapes from './components/Etapes/Etapes';

// CSS
import 'semantic-ui-css/semantic.min.css';
import './app.css'

function App() {
  return (
    <div className="App">
      <Etapes />
    </div>
  );
}

ReactDOM.render(<App />, document.getElementById('root'));
