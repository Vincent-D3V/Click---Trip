// any CSS you require will output into a single css file (app.css in this case)
require('../scss/index.scss');
require('semantic-ui/dist/semantic.min.css')
require('semantic-ui/dist/semantic.min.js')
require('../scss/_footer.scss')
require('../scss/_navbar.scss')
require('./_navbar.js')

const IFRAME=document.getElementsByTagName('iframe')[0];
// IFRAME.onload(()=>{setTimeout(function() {e.click()},4000)});
setTimeout(() => {
    IFRAME.click();
    IFRAME.style.pointerEvents="none";
},3000);