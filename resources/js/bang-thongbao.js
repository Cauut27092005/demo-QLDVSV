import { createApp } from 'vue';
import './app';

createApp({
    delimiters: ['[[', ']]'],

    data() {
        return {
            yeucaus: []
        }
    },

    methods: {
        loadData() {
            fetch('/api-thongbao')
                .then(res => res.json())
                .then(data => {
                    this.yeucaus = data;
                });
        }
    },

    mounted() {
        this.loadData();
        console.log(window.Echo);
        if (window.Echo) {
            window.Echo.channel('yeucau')
                .listen('.DuLieuCapNhat', (e) => {
                    console.log("🎉 NHẬN EVENT", e);
                    this.loadData();
                });
        } else {
            console.log("Echo chưa được khởi tạo");
        }
    }
}).mount('#app');