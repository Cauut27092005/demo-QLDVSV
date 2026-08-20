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
            loaiDV: [],
            chonLoai: [],
            daCanhBao: []
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
        this.maNV = document.getElementById('app').dataset.username;
        this.handleShortcut = (e) => {
            if (e.altKey && e.key.toLowerCase() === 'q') {
                e.preventDefault();
                this.tuDongNhan();
            }
        };
        window.addEventListener('keydown', this.handleShortcut);
        this.loadLoaiDV();
        this.loadYeuCau();
        this.loadThongKe();
        setInterval(() => {
            this.kiemTraSLA();
        }, 60000); // kiểm tra mỗi 60 giây
        const initEcho = () => {
            window.Echo.channel('yeucau')
                .listen('.DuLieuCapNhat', (e) => {
                    console.log("Realtime:", e.type, e.data);
                    switch (e.type) {
                        // Có yêu cầu mới
                        case "TaoYeuCau":
                            this.loadYeuCau();
                            this.loadThongKe();
                            break;
                        // Nhân viên nhận yêu cầu
                        case "NhanYeuCau":
                            this.loadYeuCau();
                            this.loadThongKe();
                            break;
                        // Hoàn thành yêu cầu
                        case "HoanThanh":
                            this.loadYeuCau();
                            this.loadThongKe();
                            break;
                        // Hủy yêu cầu
                        case "HuyYeuCau":
                            this.loadYeuCau();
                            this.loadThongKe();
                            break;
                        // Thay đổi loại dịch vụ phụ trách
                        case "LoaiDichVu":
                            this.loadLoaiDV();
                            this.loadYeuCau();
                            break;    
                    }
                });
        };
        if (window.Echo) {
            initEcho();
        }
    },
    beforeUnmount() {
        window.removeEventListener('keydown', this.handleShortcut);
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
        moLoaiDV() {
            const modal = new bootstrap.Modal(
                document.getElementById("loaiDVModal")
            );
            modal.show();
        },
        xuatExcel() {
            window.location = "/xuat-excel";
        },
        loadLoaiDV() {
            fetch("/api-loai-dv")
                .then(r => r.json())
                .then(data => {
                    this.loaiDV = data;
                    this.chonLoai = [];
                    data.forEach(item => {
                        if (item.MaNV == this.maNV) {
                            this.chonLoai.push(item.MaLoai);
                        }
                    });
                });
        },
        biKhoa(item) {
            return item.MaNV != null && item.MaNV != this.maNV;
        },
        tenPhuTrach(item) {
            if (item.MaNV == null) {
                return "";
            }
            if (item.MaNV == this.maNV) {
                return "Bạn";
            }
            return item.HoTen;
        },
        luuLoaiDV() {
            fetch("/api-loai-dv", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN":
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content
                },
                body: JSON.stringify({
                    MaLoai: this.chonLoai
                })
            })
                .then(r => r.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        bootstrap.Modal
                            .getInstance(
                                document.getElementById(
                                    "loaiDVModal"
                                )
                            )
                            .hide();
                        this.loadLoaiDV();
                        this.loadYeuCau();
                    }
                });
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
        huyYeuCau(id) {
            if (!confirm("Bạn có chắc chắn muốn hủy yêu cầu này không?")) {
                return;
            }
            fetch('/nhanvien/huy/' + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(r => r.json())
                .then(data => {
                    alert(data.message);

                    if (data.success) {
                        this.loadYeuCau();
                        this.loadThongKe();
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert("Có lỗi xảy ra khi hủy yêu cầu.");
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
        },
        kiemTraSLA() {
            fetch('/api-canhbao-sla')
                .then(r => r.json())
                .then(data => {
                    data.forEach(item => {
                        if (this.daCanhBao.includes(item.MaYC)) {
                            return;
                        }
                        this.daCanhBao.push(item.MaYC);
                        alert(
                            "⚠ Yêu cầu #" +
                            item.MaYC +
                            " chỉ còn " +
                            item.ConLai +
                            " phút sẽ quá SLA."
                        );
                    });
                });
        },
    }
}).mount('#app');