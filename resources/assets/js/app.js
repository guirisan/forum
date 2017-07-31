
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.Vue.prototype.authorize = function(handler) {
    //////////////////////////
    // set admin privileges here//
    //////////////////////////
    
    let user = window.App.user;

    return user ? handler(user) : false;
}

////////////////////////
// guirisan lesson 29 //
////////////////////////
window.events = new Vue(); 

window.flash = function (message){
    window.events.$emit('flash', message);
}

////////////////////////
// guirisan lesson 29 //
////////////////////////



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
// Vue.component('reply', require('./components/Reply.vue'));
// Vue.component('favorite', require('./components/Favorite.vue'));

// PAGES
Vue.component('thread-view', require('./pages/Thread.vue'));

const app = new Vue({
    el: '#app'
});
