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
        if (window.Echo) {
            window.Echo.channel("yeucau")
                .listen(".DuLieuCapNhat", (e) => {
                    console.log("Realtime:", e.type, e.data);
                    switch (e.type) {
                        case "TaoYeuCau":
                        case "NhanYeuCau":
                        case "HoanThanh":
                            this.loadData();
                            break;
                    }
                });
        } else {
            console.log("Echo chưa được khởi tạo");
        }
    }
}).mount('#app');