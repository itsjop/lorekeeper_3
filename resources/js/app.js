import { createApp } from 'vue';

// require('./vendor/jquery-ui');
// require('./vendor/bootstrap');
// require('./vendor/selectize');

import App from './App.vue';
import SubComponent from './components/SubComponent.vue';

function init() {
  const app = createApp({});
  app.config.warnHandler = () => null;
  app.component('app', App).component('sub-component', SubComponent).mount('#app');
}
document.addEventListener('DOMContentLoaded', init, false);
