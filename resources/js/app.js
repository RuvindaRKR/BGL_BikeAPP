require('./bootstrap');

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'

InertiaProgress.init()

const Swal = require('sweetalert2').default

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    timer: 2000,
    timerProgressBar: true
})

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})
