import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { MotionPlugin } from '@vueuse/motion'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

const appName = 'Luxy Formation'

createInertiaApp({
  title: (title) => title ? `${title} — ${appName}` : appName,
  resolve: (name) => resolvePageComponent(
    `./Pages/${name}.vue`,
    import.meta.glob('./Pages/**/*.vue'),
  ),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
    app.use(plugin)
    app.use(ZiggyVue)
    app.use(MotionPlugin)
    return app.mount(el)
  },
  progress: { color: '#4F46E5', showSpinner: false },
})