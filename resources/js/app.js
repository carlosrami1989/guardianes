require('./bootstrap');

import Vue from "vue";
import VueTelInputVuetify from 'vue-tel-input-vuetify';
import App from "./components/home/components/AppBar";

import { funcionesGlobales } from "./funciones.js";


import routes from "./routes/index";
import VueRouter from "vue-router";

import vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import store from "./vueX/store";
import "./plugins";

//import Paintable from 'vue-paintable';

import VueVideoPlayer from 'vue-video-player'

// require videojs style
import 'video.js/dist/video-js.css'
// import 'vue-video-player/src/custom-theme.css'

import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';



const utf8 = require('utf8');
Vue.prototype.utf8 = utf8;

Vue.prototype.$funcionesGlobales = funcionesGlobales;
Vue.use(vuetify);

Vue.use(VueRouter);
const router = new VueRouter({
    mode: "hash",
    routes,
    mode: 'history',
});

Vue.use(VueVideoPlayer, /* {
    options: global default options,
    events: global videojs events
  } */);
  const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
  };
  Vue.use(VueSweetalert2, options);

  Vue.use(VueTelInputVuetify, {
    vuetify,
});

Vue.component(
    "home",
    require("./components/home/index").default
);
Vue.component(
    "home-app-bar",
    require("./components/home/components/AppBar").default
);
Vue.component(
    "home-view",
    require("./components/home/components/View").default
);
//*componentes de pacientes //
Vue.component(
    "paciente-informacion",
    require("./components/modulos/Administracion/PacientesComponents/informacionpersonal.vue").default
);
Vue.component(
    "paciente-representante",
    require("./components/modulos/Administracion/PacientesComponents/informacionrepresentante.vue").default
);

 

 
//**  fin */
new Vue({
    store,

    vuetify: new vuetify(), //<-----
    el: "#app",
    components: {
        App
    },
    
    router
})