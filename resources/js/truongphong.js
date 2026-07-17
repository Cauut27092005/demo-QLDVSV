import { createApp } from 'vue';
import Chart from 'chart.js/auto';
import './app';

createApp({
    delimiters: ['[[', ']]'],
    data() {
        const today = new Date().toISOString().split('T')[0];
        return {
            statusChart: null,
            serviceChart: null,
            staffChart: null,
            menu: 'dashboard',
            keyword: '',
            trangThai: '',
            tuNgay: today,
            denNgay: today,
            dashboard: {
                tongYC: 0,
                choXuLy: 0,
                dangXuLy: 0,
                hoanThanh: 0,
                tongNhanVien: 0,
                homNay: 0,
                hoanThanhHomNay: 0
            },
            yeuCaus: [],
            thongKe: [],
            topNhanVien: [],
            chiTiet: [],
            pagination: {
                current_page: 1,
                last_page: 1
            }
        };
    },
    computed: {
        pageTitle() {
            switch (this.menu) {
                case 'dashboard':
                    return 'Dashboard';
                case 'yeucau':
                    return 'Quản lý yêu cầu';
                case 'thongke':
                    return 'Thống kê nhân viên';
            }
            return '';
        }
    },
    mounted() {
        this.loadChartTrangThai();
        this.loadChartLoaiDV();
        this.loadDashboard();
        this.loadThongKe();
        this.loadTop();
        this.loadYeuCau();
        if (window.Echo) {
            window.Echo.channel('yeucau')
                .listen('.DuLieuCapNhat', () => {
                    this.loadChartTrangThai();
                    this.loadChartLoaiDV();
                    this.loadDashboard();
                    this.loadThongKe();
                    this.loadTop();
                    this.loadYeuCau(
                        this.pagination.current_page
                    );
                });
        }
    },
    methods: {
        loadDashboard() {
            fetch('/api-tp-dashboard')
                .then(r => r.json())
                .then(data => {
                    this.dashboard = data;
                });
        },
        loadChartTrangThai() {
            fetch('/api-tp-chart-trangthai')
                .then(async r => {
                    let text = await r.text();
                    console.log(text);
                    return JSON.parse(text);
                })
                .then(data => {
                    if (this.statusChart) {
                        this.statusChart.destroy();
                    }
                    this.statusChart = new Chart(
                        document.getElementById('statusChart'),
                        {
                            type: 'doughnut',
                            data: {
                                labels: [
                                    'Chờ xử lý',
                                    'Đang xử lý',
                                    'Hoàn thành'
                                ],
                                datasets: [{
                                    data: [
                                        data.ChoXuLy,
                                        data.DangXuLy,
                                        data.HoanThanh
                                    ]
                                }]
                            }
                        }
                    );
                });
        },
        loadChartLoaiDV() {
            fetch('/api-tp-chart-loaidv')
                .then(r => r.json())
                .then(data => {
                    if (this.serviceChart) {
                        this.serviceChart.destroy();
                    }
                    this.serviceChart = new Chart(
                        document.getElementById('serviceChart'),
                        {
                            type: 'bar',
                            data: {
                                labels: data.map(x => x.TenLoai),
                                datasets: [{
                                    label: 'Số yêu cầu',
                                    data: data.map(x => x.Tong)
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                }
                            }
                        }
                    );
                });
        },
        loadTop() {
            fetch('/api-tp-top')
                .then(r => r.json())
                .then(data => {
                    this.topNhanVien = data;
                });
        },
        loadThongKe() {
            fetch('/api-tp-thongke')
                .then(r => r.json())
                .then(data => {
                    this.thongKe = data;
                });
        },
        loadYeuCau(page = 1) {
            let url =
                "/api-tp-yeucau?page=" + page;
            if (this.keyword != "") {
                url +=
                    "&keyword="
                    + encodeURIComponent(this.keyword);
            }
            if (this.trangThai != "") {
                url +=
                    "&trangThai="
                    + this.trangThai;
            }
            if (this.tuNgay != "") {
                url +=
                    "&tuNgay="
                    + this.tuNgay;
            }
            if (this.denNgay != "") {
                url +=
                    "&denNgay="
                    + this.denNgay;
            }
            fetch(url)
                .then(r => r.json())
                .then(data => {
                    this.yeuCaus = data.data;
                    this.pagination = {
                        current_page:
                            data.current_page,
                        last_page:
                            data.last_page
                    };
                });
        },
        xemChiTiet(maNV) {
            fetch(
                "/api-tp-chitiet/" + maNV
            )
                .then(r => r.json())
                .then(data => {
                    this.chiTiet = data;
                    new bootstrap.Modal(
                        document.getElementById(
                            "chiTietModal"
                        )
                    ).show();
                });
        },
        xuatExcel() {
            window.location =
                "/truongphong/excel";
        }
    },

}).mount("#app");