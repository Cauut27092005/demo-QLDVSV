import { createApp } from 'vue';
import './app';
createApp({
    delimiters: ['[[', ']]'],
    data() {
        const today = new Date().toISOString().split('T')[0];
        return {
            tuNgay: today,
            denNgay: today,
            xuLy: [],
            daXuLy: [],
            lichSu: [],
            keyword: '',
            tab: 'xuly',
            moMenu: false,
            maNV: null,
            mk: {
                cu: '',
                moi: '',
                nhaplai: ''
            },
            thongKe: {
                cho: 0,
                dang: 0,
                tong: 0
            },
            pagination: {
                current_page: 1,
                last_page: 1
            },

        };
    },
    computed: {
        danhSachHienTai() {
            return this.tab === 'xuly'
                ? this.xuLy
                : this.daXuLy;
        }
    },
    mounted() {
        this.maNV = document.getElementById('app').dataset.manv;
        this.loadYeuCau();
        this.loadThongKe();
        const initEcho = () => {
            window.Echo.channel('yeucau')
                .listen('.DuLieuCapNhat', () => {
                    this.loadYeuCau()
                    this.loadThongKe();;
                });
        };
        if (window.Echo) {
            initEcho();
        }
    },
    methods: {
        xoaTimKiem() {
            this.keyword = "";
            this.loadYeuCau();
        },
        kiemTraTimKiem() {
            if (this.keyword.trim() === '') {
                this.loadYeuCau();
            }
        },
        loadThongKe() {
            fetch("/api-thongke-nhanvien")
                .then(r => r.json())
                .then(data => {
                    this.thongKe = data;
                });
        },
        xuatExcel() {
            window.location = "/xuat-excel";
        },
        doiTab(tab) {
            this.tab = tab;
            if (tab == "xuly" && this.xuLy.length == 0) {
                this.loadYeuCau();
            }
            if (tab == "lichsu" && this.daXuLy.length == 0) {
                this.loadYeuCau();
            }
        },
        hoanThanh(id) {
            fetch('/capnhat-hoanthanh/' + id)
                .then(r => r.json())
                .then(data => {
                    alert(data.message);
                    this.loadYeuCau();
                    this.loadThongKe();
                });
        },

        nhanYeuCau(id) {
            fetch('/nhan-yeu-cau/' + id)
                .then(r => r.json())
                .then(data => {
                    alert(data.message);
                    this.loadThongKe();
                    this.loadYeuCau();
                });
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

        tuDongNhan() {
            fetch('/nhanvien/tu-dong-nhan', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(r => r.json())
                .then(data => {
                    alert(data.message);
                    this.loadThongKe();
                    this.loadYeuCau();
                })
                .catch(() => {
                    alert("Không còn yêu cầu để nhận.");
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
            const token = document.querySelector('meta[name="csrf-token"]');

            if (!token) {
                alert("Không tìm thấy CSRF Token");
                return;
            }
            fetch('/api-doi-mat-khau', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token.content
                },
                body: JSON.stringify(this.mk)
            })
                .then(r => r.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        bootstrap.Modal.getInstance(
                            document.getElementById('doiMKModal')
                        ).hide();

                        this.mk = {
                            cu: '',
                            moi: '',
                            nhaplai: ''
                        };
                    }
                });
        },
        loadYeuCau(page = 1) {
            let url = "/api-yeucau?page=" + page + "&tab=" + this.tab;
            if (this.keyword != "") {
                url += "&keyword=" + encodeURIComponent(this.keyword);
            }
            if (this.tuNgay != "") {
                url += "&tuNgay=" + this.tuNgay;
            }
            if (this.denNgay != "") {
                url += "&denNgay=" + this.denNgay;
            }
            fetch(url)
                .then(r => r.json())
                .then(data => {

                    if (this.tab == "xuly") {
                        this.xuLy = data.data;
                    } else {
                        this.daXuLy = data.data;
                    }
                    this.pagination = {
                        current_page: data.current_page,
                        last_page: data.last_page
                    };
                });
        }
    }
}).mount('#app');