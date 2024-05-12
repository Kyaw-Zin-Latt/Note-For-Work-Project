import './bootstrap';
// import '../css/app.css';

// for css
import '../sass/app.scss';

// for custom js
import './custom';

// for bootstrap js
import * as bootstrap from '../../node_modules/bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { i18nVue, getActiveLanguage, isLoaded  } from 'laravel-vue-i18n'
import DataTable from 'laravel-vue-datatable';
import CKEditor from '@ckeditor/ckeditor5-vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

// import Swal from 'sweetalert2'
// import 'sweetalert2/src/sweetalert2.scss'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(i18nVue, {
                lang: getActiveLanguage(),
                loaded: isLoaded(),
                fallbackLang: 'en',
                resolve: lang => {
                    const langs = import.meta.globEager('../../lang/*.json');
                    const real = localStorage.getItem('lang');
                    return langs[`../../lang/${real}.json`].default;
                },
            })
            .use(VueSweetalert2)
            .use(DataTable)
            .use( CKEditor )
            .use(ZiggyVue, Ziggy)
            .component('Datepicker', Datepicker)
            .component('InertiaHead', Head)
            .component('InertiaLink', Link)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
