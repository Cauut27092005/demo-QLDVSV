import { createApp } from 'vue';
import Chart from 'chart.js/auto';
import './app';

createApp({
    delimiters: ['[[', ']]'],
    data() {
        const today = new Date().toISOString().split('T')[0];
        return {
            serviceChart: null,
            menu: 'dashboard',
            moExcel: false,
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
            }
            return '';
        }
    },
    mounted() {
        this.loadChartLoaiDV();
        this.loadDashboard();
        this.loadTop();
        this.loadYeuCau();
        if (window.Echo) {
            window.Echo.channel('yeucau')
                .listen('.DuLieuCapNhat', () => {
                    this.loadChartLoaiDV();
                    this.loadDashboard();
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
        loadChartLoaiDV() {
            fetch('/api-tp-chart-loaidv')
                .then(r => r.json())
                .then(data => {
                    if (this.serviceChart) {
                        this.serviceChart.destroy();
                    }
                    this.serviceChart = new Chart(
                        document.getElementById("serviceChart"),
                        {
                            type: "bar",
                            data: {
                                labels: data.map(x => x.TenLoai),
                                datasets: [{
                                    data: data.map(x => x.Tong),
                                    backgroundColor: [
                                        "#4CAF50",
                                        "#42A5F5",
                                        "#FFB74D",
                                        "#AB47BC",
                                        "#26C6DA",
                                        "#EF5350",
                                        "#66BB6A"
                                    ],
                                    hoverBackgroundColor: [
                                        "#43A047",
                                        "#1E88E5",
                                        "#FB8C00",
                                        "#8E24AA",
                                        "#00ACC1",
                                        "#E53935",
                                        "#43A047"
                                    ],
                                    borderRadius: 8,
                                    borderSkipped: false,
                                    barThickness: 20,
                                    categoryPercentage: 0.7,
                                    barPercentage: 0.9
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: "y",
                                layout: {
                                    padding: {
                                        top: 5,
                                        right: 20,
                                        left: 10,
                                        bottom: 0
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        backgroundColor: "#1f2937",
                                        cornerRadius: 8,
                                        padding: 10
                                    },
                                    datalabels: {
                                        color: "#333",
                                        anchor: "end",
                                        align: "end",
                                        offset: 6,
                                        font: {
                                            size: 13,
                                            weight: "bold"
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        display: false,
                                        grid: {
                                            display: false
                                        },
                                        border: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        grid: {
                                            display: false
                                        },
                                        border: {
                                            display: false
                                        },
                                        ticks: {
                                            color: "#374151",
                                            font: {
                                                size: 13,
                                                weight: "600"
                                            }
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
        xemThongKeNhanVien() {
            fetch('/api-tp-thongke')
                .then(r => r.json())
                .then(data => {
                    this.thongKe = data;
                    new bootstrap.Modal(
                        document.getElementById(
                            'thongKeNVModal'
                        )
                    ).show();

                });

        },
        xuatExcelTopNhanVien() {
            window.location =
                "/truongphong/excel/topnhanvien";
        },
        xuatExcelYeuCau() {
            window.location =
                "/truongphong/excel/yeucau";
        }
    },

}).mount("#app");