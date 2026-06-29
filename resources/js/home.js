import { createApp } from 'vue';

createApp({
    delimiters: ['[[', ']]'],
    data() {
        return {
            masv: '',
            numbers: [
                '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
            ],

            row1: [
                'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P'
            ],

            row2: [
                'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L'
            ],

            row3: [
                'Z', 'X', 'C', 'V', 'B', 'N', 'M'
            ],
        }
    },
    methods: {
        addKey(key) {
            this.masv += key;
        },
        backspace() {
            this.masv = this.masv.slice(0, -1);
        },
    }
}).mount('#app');