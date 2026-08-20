console.log('ECHO FILE LOADED');

const connection = window.Echo?.connector?.pusher?.connection;
if (connection) {
    connection.bind('connected', () => {
        console.log('✅ Reverb Connected');
    });
    connection.bind('connecting', () => {
        console.log('🔄 Reverb Connecting...');
    });
    connection.bind('disconnected', () => {
        console.log('❌ Reverb Disconnected');
    });
    connection.bind('error', (err) => {
        console.error('❌ Reverb Error:', err);
    });
    connection.bind('state_change', (states) => {
        console.log(
            `State: ${states.previous} -> ${states.current}`
        );
    });
} else {

    console.error('Không lấy được Reverb connection');

}