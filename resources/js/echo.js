console.log('ECHO FILE LOADED');

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

console.log('Echo class:', Echo);
console.log('Pusher class:', Pusher);

window.Pusher = Pusher;

try {
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST,
        wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8080),
        wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8080),
        forceTLS: false,
        enabledTransports: ['ws', 'wss'],
    });

    console.log('Echo created:', window.Echo);
} catch (e) {
    console.error('Echo error:', e);
}