import { createApp } from 'vue';
import './app';


createApp({

    data() {

        return {
            loading: false,
            isEdit: false,

            formNV: {
                MaNV: '',
                HoTen: '',
                BoPhan: ''
            },
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
            searchNV: "",
            toastMessage: "",
            toastType: "success"
        }
    },
    computed: {

        //================ NHÂN VIÊN =================

        filterNV() {
            let data = this.nhanViens;
            if (this.searchNV != "") {
                let key = this.searchNV.toLowerCase();
                data = data.filter(x =>
                    x.MaNV.toLowerCase().includes(key)
                    ||
                    x.HoTen.toLowerCase().includes(key)
                    ||
                    x.BoPhan.toLowerCase().includes(key)
                );
            }
            return data;
        },

        nhanVienPage() {
            const start = (this.currentPage.nv - 1) * this.perPage;
            return this.filterNV.slice(
                start,
                start + this.perPage
            );
        },

        totalNVPage() {
            return Math.ceil(
                this.filterNV.length / this.perPage
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

        openAddNV() {
            this.isEdit = false;
            this.formNV = {
                MaNV: '',
                HoTen: '',
                BoPhan: 'Công tác sinh viên',
            };
            new bootstrap.Modal(
                document.getElementById("nhanVienModal")
            ).show();
        },

        editNV(item) {
            this.isEdit = true;
            this.formNV = { ...item };
            new bootstrap.Modal(
                document.getElementById("nhanVienModal")
            ).show();
        },

        saveNV() {
            if (this.formNV.MaNV == "") {

                alert("Chưa nhập mã nhân viên");
                return;
            }
            if (this.formNV.HoTen == "") {

                alert("Chưa nhập họ tên");
                return;
            }
            if (this.formNV.BoPhan == "") {
                alert("Chưa chọn bộ phận");
                return;
            }
            this.loading = true;
            fetch(
                this.isEdit
                    ? '/api-nhanvien/update'
                    : '/api-nhanvien/add',
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name=csrf-token]')
                            .content
                    },
                    body: JSON.stringify(this.formNV)
                }
            )
                .then(async res => {
                    const data = await res.json();
                    console.log(data);
                    if (!res.ok) {
                        alert(data.message);
                        return;
                    }
                    bootstrap.Modal
                        .getInstance(document.getElementById("nhanVienModal"))
                        .hide();
                    this.loadNhanVien();
                    this.loadDashboard();
                    alert(this.isEdit ? "Đã cập nhật nhân viên" : "Đã thêm nhân viên");

                })
                .then(() => {
                    bootstrap.Modal
                        .getInstance(
                            document.getElementById("nhanVienModal")
                        )
                        .hide();
                    this.loadNhanVien();
                    this.loadDashboard();
                    alert(
                        this.isEdit
                            ? "Đã cập nhật nhân viên"
                            : "Đã thêm nhân viên"
                    );
                })
                .catch(err => {
                    console.log(err);
                    alert("Có lỗi xảy ra.");
                })
                .finally(() => {
                    this.loading = false;
                });

        },

        resetPassword(maNV) {

            if (!confirm("Reset mật khẩu về 123456?")) {
                return;
            }

            fetch('/api-nhanvien/reset-password/' + maNV, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name=csrf-token]'
                        ).content
                }
            })
                .then(res => res.json())
                .then(() => {
                    alert("Đã reset mật khẩu.");
                });

        },

        deleteNV(id) {
            if (!confirm("Bạn chắc chắn muốn xóa?")) {
                return;
            }
            this.loading = true;
            fetch(
                '/api-nhanvien/delete/' + id,
                {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name=csrf-token]')
                            .content
                    }
                }
            )
                .then(res => {
                    if (!res.ok) {
                        throw new Error();
                    }
                    return res.json();
                })
                .then(() => {
                    this.loadNhanVien();
                    this.loadDashboard();
                    alert("Đã xóa nhân viên");
                })
                .catch(() => {
                    alert("Không thể xóa.");
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        openPage(page) {
            this.show = page;
            const pages = {
                nv: this.loadNhanVien,
                yc: this.loadYeuCau,
                dxl: this.loadDangXuLy,
                ht: this.loadHoanThanh,
                tk: this.loadThongKe
            };
            if (page == 'tk') {
                if (!this.tuNgay || !this.denNgay) return;
            }
            pages[page]?.call(this);
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

        loadData(url, target) {
            this.loading = true;
            return fetch(url)
                .then(res => res.json())
                .then(data => {
                    this[target] = data;
                })
                .finally(() => {
                    this.loading = false;
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

        getTrangThaiClass(trangThai) {
            if (trangThai === null || trangThai === undefined) {
                return 'yc-other';
            }
            const t = String(trangThai)
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '') // bỏ dấu tiếng Việt
                .toLowerCase()
                .trim();
            if (t.includes('cho')) return 'yc-wait';
            if (t.includes('dang')) return 'yc-process';
            if (t.includes('hoan')) return 'yc-done';
            return 'yc-other';
        },

        loadNhanVien() {
            this.loading = true;
            this.loadData(
                '/api-nhanvien',
                'nhanViens'
            )
                .finally(() => {
                    this.loading = false;
                });
        },

        loadYeuCau() {
            this.loadData(
                '/api-yeucau-admin',
                'yeuCaus');
        },

        loadDangXuLy() {
            this.loadData(
                '/api-dangxuly',
                'dangXuLys'

            );
        },

        loadHoanThanh() {
            this.loadData(
                '/api-hoanthanh',
                'hoanThanhs'
            );
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