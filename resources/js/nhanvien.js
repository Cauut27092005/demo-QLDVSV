import { createApp } from 'vue';
import './app';

createApp({
    delimiters: ['[[', ']]'],
    data() {
        return {
            yeucaus: [],
            lichSu: []
        };
    },
    mounted() {
        this.loadYeuCau();

        const initEcho = () => {
            window.Echo.channel('yeucau')
                .listen('.DuLieuCapNhat', () => {
                    this.loadYeuCau();
                });
        };

        if (window.Echo) {
            initEcho();
        }
    },
    methods: {
        hoanThanh(id) {
            fetch('/capnhat-hoanthanh/' + id)
                .then(() => this.loadYeuCau());
        },

        moLichSu() {
            fetch('/api-lichsu')
                .then(r => r.json())
                .then(data => {
                    this.lichSu = data;

                    const modal = new bootstrap.Modal(
                        document.getElementById('lichSuModal')
                    );

                    modal.show();
                });
        },

        loadYeuCau() {
            fetch('/api-yeucau')
                .then(r => r.json())
                .then(data => {
                    this.yeucaus = data;
                });
        }
    }
}).mount('#app');