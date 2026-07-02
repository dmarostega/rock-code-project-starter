import '../css/app.css';
import { createInertiaApp } from '@inertiajs/vue3';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';

const appName = import.meta.env.VITE_APP_NAME || 'Rock Code Starter';
const pages = import.meta.glob<{ default: DefineComponent }>('./pages/**/*.vue', { eager: true });

createInertiaApp({
  title: (title) => (title ? `${title}` : appName),
  resolve: (name) => {
    const page = pages[`./pages/${name}.vue`];

    if (!page) {
      throw new Error(`Page not found: ${name}`);
    }

    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el);
  },
  progress: { color: '#2563eb' },
});
