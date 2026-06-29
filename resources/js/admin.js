import { createApp } from 'vue';
import './app';


createApp({

    data() {
        return {
            show: 'tk',
            tongNV: 0,
            online: 0,
            tongYC: 0,
            choXuLy: 0,
            dangXuLy: 0,
            hoanThanh: 0,

            nhanViens: [],
            yeuCaus: [],
            dangXuLys: [],
            hoanThanhs: [],

            thongKeNhanVien: [],
            chiTietNV: [],

            currentPage: {
                nv: 1,
                yc: 1,
                dxl: 1,
                ht: 1,
                tk: 1
            },

            perPage: 8,

            tuNgay: new Date().getFullYear() + '-01-01',
            denNgay: new Date().getFullYear() + '-12-31',
            nhanVienDangXem: '',
            show: ''
        }
    },
    computed: {
        //================ NHÂN VIÊN =================
        nhanVienPage() {

            let start = (this.currentPage.nv - 1) * this.perPage;

            return this.nhanViens.slice(
                start,
                start + this.perPage
            );

        },

        totalNVPage() {

            return Math.ceil(
                this.nhanViens.length / this.perPage
            );

        },


        //================ YÊU CẦU =================

        yeuCauPage() {

            let start = (this.currentPage.yc - 1) * this.perPage;

            return this.yeuCaus.slice(
                start,
                start + this.perPage
            );

        },

        totalYCPage() {

            return Math.ceil(
                this.yeuCaus.length / this.perPage
            );

        },


        //================ ĐANG XỬ LÝ =================

        dangXuLyPage() {

            let start = (this.currentPage.dxl - 1) * this.perPage;

            return this.dangXuLys.slice(
                start,
                start + this.perPage
            );

        },

        totalDXLPage() {

            return Math.ceil(
                this.dangXuLys.length / this.perPage
            );

        },


        //================ HOÀN THÀNH =================

        hoanThanhPage() {

            let start = (this.currentPage.ht - 1) * this.perPage;

            return this.hoanThanhs.slice(
                start,
                start + this.perPage
            );

        },

        totalHTPage() {

            return Math.ceil(
                this.hoanThanhs.length / this.perPage
            );

        },


        //================ THỐNG KÊ =================

        thongKePage() {

            let start = (this.currentPage.tk - 1) * this.perPage;

            return this.thongKeNhanVien.slice(
                start,
                start + this.perPage
            );

        },

        totalTKPage() {

            return Math.ceil(
                this.thongKeNhanVien.length / this.perPage
            );

        },



        pageTitle() {

            switch (this.show) {

                case 'nv':
                    return 'Quản lý nhân viên';

                case 'yc':
                    return 'Danh sách yêu cầu';

                case 'dxl':
                    return 'Đang xử lý';

                case 'ht':
                    return 'Đã hoàn thành';

                case 'tk':
                    return 'Thống kê';

                default:
                    return 'Dashboard';

            }

        }

    },
    mounted() {
        this.loadDashboard();
        this.openPage('tk');
        window.Echo.channel('yeucau')
            .listen('.DuLieuCapNhat', () => {
                this.loadDashboard();
                switch (this.show) {
                    case 'nv':
                        this.loadNhanVien();
                        break;
                    case 'yc':
                        this.loadYeuCau();
                        break;
                    case 'dxl':
                        this.loadDangXuLy();
                        break;
                    case 'ht':
                        this.loadHoanThanh();
                        break;
                    case 'tk':

                        if (this.tuNgay && this.denNgay) {
                            this.loadThongKe();
                        }
                        break;
                }
            });
    },
    methods: {
        openPage(page) {
            console.log(page);
            this.show = page;
            switch (page) {
                case 'nv':
                    this.loadNhanVien();
                    break;
                case 'yc':
                    this.loadYeuCau();
                    break;
                case 'dxl':
                    this.loadDangXuLy();
                    break;
                case 'ht':
                    this.loadHoanThanh();
                    break;
                case 'tk':
                    if (this.tuNgay && this.denNgay) {
                        this.loadThongKe();
                    }
                    break;
            }
        },
        loadDashboard() {
            fetch('/api-dashboard')
                .then(res => res.json())
                .then(data => {
                    this.tongNV = data.tongNV;
                    this.online = data.online;
                    this.tongYC = data.tongYC;
                    this.choXuLy = data.choXuLy;
                    this.dangXuLy = data.dangXuLy;
                    this.hoanThanh = data.hoanThanh;
                });
        },
        loadThongKe() {
            if (!this.tuNgay || !this.denNgay) {
                alert('Chọn khoảng thời gian');
                return;
            }
            fetch(
                `/api-thongke-nhanvien?tuNgay=${this.tuNgay}&denNgay=${this.denNgay}`
            )
                .then(res => res.json())
                .then(data => {
                    this.thongKeNhanVien = data;
                });
        },
        xemChiTiet(maNV) {
            this.nhanVienDangXem = maNV;
            fetch('/api-chitiet-nhanvien/' + maNV)
                .then(res => res.json())
                .then(data => {
                    this.chiTietNV = data;
                    const modal = new bootstrap.Modal(
                        document.getElementById('chiTietModal')
                    );
                    modal.show();
                });
        },
        loadNhanVien() {
            fetch('/api-nhanvien')
                .then(r => r.json())
                .then(data => {
                    this.nhanViens = data;
                });
        },
        loadYeuCau() {
            fetch('/api-yeucau-admin')
                .then(r => r.json())
                .then(data => {
                    this.yeuCaus = data;
                });
        },
        loadDangXuLy() {
            fetch('/api-dangxuly')
                .then(r => r.json())
                .then(data => {
                    this.dangXuLys = data;
                });
        },

        loadHoanThanh() {
            fetch('/api-hoanthanh')
                .then(r => r.json())
                .then(data => {
                    this.hoanThanhs = data;
                });
        },
        changePage(type, page) {

            let total = 1;

            switch (type) {

                case 'nv':
                    total = this.totalNVPage;
                    break;

                case 'yc':
                    total = this.totalYCPage;
                    break;

                case 'dxl':
                    total = this.totalDXLPage;
                    break;

                case 'ht':
                    total = this.totalHTPage;
                    break;

                case 'tk':
                    total = this.totalTKPage;
                    break;
            }

            if (page < 1 || page > total) return;

            this.currentPage[type] = page;
        }
    }
}).mount('#app');