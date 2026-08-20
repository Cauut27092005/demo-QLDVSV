import { createApp } from 'vue';
import './app';

createApp({
    data() {
        return {
            loading: false,
            isEdit: false,
            searchNV: "",
            googleAccounts: [],
            nhanViens: [],
            formNV: {
                MaNV: "",
                HoTen: "",
                Quay: "",
                VaiTro: "NhanVien"
            },
            formGoogle: {
                MaND: "",
                MaNV: "",
                VaiTro: "NhanVien"
            },
        }
    },
    computed: {
        filterNV() {
            let data = this.nhanViens;
            if (this.searchNV != "") {
                let key = this.searchNV.toLowerCase();
                data = data.filter(x =>
                    x.MaNV.toLowerCase().includes(key)
                    ||
                    x.HoTen.toLowerCase().includes(key)
                );
            }
            return data;
        },
        googleChoDuyet() {
            return this.googleAccounts.filter(x =>
                x.TrangThai == "ChoDuyet"
            );
        },
    },
    mounted() {
        console.log("mounted");
        // Load lần đầu
        this.loadNhanVien();
        this.loadGoogle();
        Echo.channel("yeucau")
            .listen(".DuLieuCapNhat", (e) => {
                console.log("Realtime:", e.type, e.data);
                switch (e.type) {
                    case "GoogleMoi":
                    case "GoogleDuyet":
                    case "GoogleTuChoi":
                        this.loadGoogle();
                        break;
                    case "ThemNhanVien":
                    case "SuaNhanVien":
                    case "XoaNhanVien":
                        this.loadNhanVien();
                        break;
                }
            });
    },
    methods: {
        openAddNV() {
            this.isEdit = false;
            this.formNV = {
                MaNV: "",
                HoTen: "",
                Quay: "",
                VaiTro: "NhanVien"
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
                alert("Chưa nhập tên người dùng");
                return;
            }
            this.loading = true;
            fetch(
                this.isEdit ? "/api-nhanvien/update" : "/api-nhanvien/add",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content
                    },
                    body: JSON.stringify(this.formNV)
                }
            )
                .then(async res => {
                    const data = await res.json();

                    if (!res.ok) {
                        alert(data.message ?? "Có lỗi");
                        return;
                    }
                    bootstrap.Modal.getInstance(
                        document.getElementById("nhanVienModal")
                    ).hide();
                })
                .catch(err => {
                    console.error(err);
                })
                .finally(() => {
                    this.loading = false;
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
                    console.log("Đã xóa nhân viên");
                })
                .catch(() => {
                    alert("Không thể xóa.");
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        openGoogleModal(item) {
            this.formGoogle = {
                MaND: item.MaND,
                MaNV: "",
                VaiTro: "NhanVien"
            };
            new bootstrap.Modal(
                document.getElementById("googleModal")
            ).show();
        },
        duyetGoogle() {
            this.loading = true;
            fetch("/api-google/duyet", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN":
                        document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content
                },
                body: JSON.stringify(this.formGoogle)
            })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        alert(data.message);
                        return;
                    }
                    bootstrap.Modal.getInstance(
                        document.getElementById("googleModal")
                    ).hide();
                })
                .catch(err => {
                    console.error(err);
                    alert("Có lỗi xảy ra.");
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        tuChoi(maND) {
            if (!confirm("Bạn có chắc muốn từ chối tài khoản này?")) {
                return;
            }
            fetch('/api-google/tuchoi', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content
                },
                body: JSON.stringify({
                    MaND: maND
                })
            })
                .then(r => r.json())
                .then(data => {
                    alert(data.message);
                });
        },
        loadNhanVien() {
            fetch('/api-nhanvien')
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    this.nhanViens = data;
                    console.log(this.nhanViens);
                });
        },
        loadGoogle() {
            fetch("/api-google")
                .then(res => res.json())
                .then(data => {
                    this.googleAccounts = data;
                });
        },
    }
}).mount('#app');