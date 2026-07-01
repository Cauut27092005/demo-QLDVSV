import { createApp } from 'vue';
import './app';

createApp({
    delimiters: ['[[', ']]'],
    data() {
        return {
            yeucaus: [],
            lichSu: [],
            mk: {
                cu: '',
                moi: '',
                nhaplai: ''
            }
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

        moDoiMK() { 
            console.log(document.getElementById('doiMKModal'));
            const modal = new bootstrap.Modal(
                document.getElementById('doiMKModal')
            );
            modal.show();
        },

        doiMatKhau() {

            if (this.mk.moi != this.mk.nhaplai) {
                alert("Nhập lại mật khẩu chưa đúng");
                return;
            }
            fetch('/api-doi-mat-khau', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name=csrf-token]'
                        ).content
                },
                body: JSON.stringify(this.mk)
            })
                .then(r => r.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        bootstrap.Modal.getInstance(
                            document.getElementById(
                                'doiMKModal'
                            )
                        ).hide();
                        this.mk = {
                            cu: '',
                            moi: '',
                            nhaplai: ''
                        };
                    }
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