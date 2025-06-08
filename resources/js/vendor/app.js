import { Vue, createApp } from 'vue';

require('./jquery-ui');
require('./bootstrap');
require('./selectize');

import App from '../App.vue';
// import SubComponent from '../SubComponent.vue';
import LorePage from '../Guide/LorePage.vue';

function init() {
  const app = createApp({});
  app.config.warnHandler = () => null;
  app.component('app', App)
  // .component('sub-component', SubComponent)
  .component('lore-page', LorePage)
  .mount('#app');
}
document.addEventListener('DOMContentLoaded', init, false);
