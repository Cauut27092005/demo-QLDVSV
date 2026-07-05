import { createApp } from 'vue';
import './app';


createApp({
    data() {
        return {
            loading: false,
            isEdit: false,
            searchNV: "",
            nhanViens: [],
            formNV: {
                MaNV: "",
                HoTen: "",
                Quay: "",
                VaiTro: "NhanVien"
            }
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
        }


    },
    mounted() {
        console.log("mounted");
        this.loadNhanVien();
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
                alert("Chưa nhập tên đăng nhập");
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
                    console.log(data);
                    if (!res.ok) {
                        alert(data.message ?? "Có lỗi");
                        return;
                    }
                    bootstrap.Modal.getInstance(
                        document.getElementById("nhanVienModal")
                    ).hide();

                    this.loadNhanVien();
                })
                .catch(err => {
                    console.log(err);
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
                .then(res => res.json());
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
                })
                .catch(() => {
                    alert("Không thể xóa.");
                })
                .finally(() => {
                    this.loading = false;
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
        }
    }
}).mount('#app');