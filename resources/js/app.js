import { createApp } from 'vue';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import * as bootstrap from 'bootstrap';
import { registerSW } from 'virtual:pwa-register';
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';

registerSW({
    immediate: true
});

Chart.register(ChartDataLabels);
window.bootstrap = bootstrap;
window.Pusher = Pusher;
window.createApp = createApp;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8090),
    wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8090),
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https',
    enabledTransports: ['ws', 'wss'],
});