require('./bootstrap');

require('alpinejs');
var moment = require('moment');

console.log(moment().format());

import '@fortawesome/fontawesome-free/js/all.min';

import 'livewire-vue'

window.Vue = Vue //this is important! Do not use require('vue')

Vue.component('example-component', require('./components/Example.vue').default);
 const app = new Vue({
   el: '#app',
 });
