
import { Vue, createApp } from 'vue';
require('./bootstrap');

import App from './App.vue';
import SubComponent from './components/SubComponent.vue';

function init() {
  const app = createApp({});
  app.config.warnHandler = () => null;
  app.component('app', App).component('sub-component', SubComponent).mount('#app');
}

document.addEventListener('DOMContentLoaded', init, false);
