import { createApp } from 'vue';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import * as bootstrap from 'bootstrap';
import { registerSW } from 'virtual:pwa-register';

registerSW({
    immediate: true
});

window.bootstrap = bootstrap;
window.Pusher = Pusher;
window.createApp = createApp;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: import.meta.env.VITE_REVERB_SCHEME === 'https',
    enabledTransports: ['ws', 'wss'],
});