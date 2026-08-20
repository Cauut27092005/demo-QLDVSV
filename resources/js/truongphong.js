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
            moBaoCao: false,
            moExcel: false,
            keyword: '',
            trangThai: '',
            maLoai: '',
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
            loaiDichVu: [],
            yeuCaus: [],
            thongKe: [],
            topNhanVien: [],
            sla: [],
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
        this.loadDashboard();
        this.loadTop();
        this.loadThongKe();
        this.loadYeuCau();
        this.loadSLA();
        // Biểu đồ loại dịch vụ
        this.loadChartLoaiDV();
        if (window.Echo) {
            window.Echo.channel('yeucau')
                .listen('.DuLieuCapNhat', (e) => {
                    console.log(
                        "Realtime:",
                        e.type,
                        e.data
                    );
                    switch (e.type) {
                        case "TaoYeuCau":
                            this.loadDashboard();
                            this.loadChartLoaiDV();
                            this.loadYeuCau(
                                this.pagination.current_page
                            );
                            break;
                        case "NhanYeuCau":
                            this.loadDashboard();
                            this.loadChartLoaiDV();
                            this.loadTop();
                            this.loadThongKe();
                            this.loadYeuCau(
                                this.pagination.current_page
                            );
                            break;
                        case "HoanThanh":
                            this.loadDashboard();
                            this.loadChartLoaiDV();
                            this.loadTop();
                            this.loadThongKe();
                            this.loadYeuCau(
                                this.pagination.current_page
                            );
                            break;
                        case "HuyYeuCau":
                            this.loadDashboard();
                            this.loadChartLoaiDV();
                            this.loadTop();
                            this.loadThongKe();
                            this.loadYeuCau(
                                this.pagination.current_page
                            );
                            break;
                        case "CapNhatSLA":
                            this.loadSLA();
                            break;
                        case "LoaiDichVu":
                            this.loadYeuCau(
                                this.pagination.current_page
                            );
                            break;
                    }
                });
        }
    },
    methods: {
        // =========================
        // DASHBOARD
        // =========================
        loadDashboard() {
            fetch('/api-tp-dashboard')
                .then(r => r.json())
                .then(data => {
                    this.dashboard = data;
                })
                .catch(error => {
                    console.error(
                        'Lỗi load dashboard:',
                        error
                    );
                });
        },
        // =========================
        // BIỂU ĐỒ LOẠI DỊCH VỤ
        // =========================
        loadChartLoaiDV() {
            fetch('/api-tp-chart-loaidv')
                .then(r => r.json())
                .then(data => {
                    const canvas =
                        document.getElementById(
                            'serviceChart'
                        );
                    // Nếu không có canvas thì không tạo biểu đồ
                    if (!canvas) {
                        return;
                    }
                    // Hủy biểu đồ cũ
                    if (this.serviceChart) {
                        this.serviceChart.destroy();
                        this.serviceChart = null;
                    }
                    this.serviceChart = new Chart(
                        canvas,
                        {
                            type: 'bar',
                            data: {
                                labels: data.map(
                                    item => item.TenLoai
                                ),
                                datasets: [
                                    {
                                        data: data.map(
                                            item => item.Tong
                                        ),
                                        backgroundColor: [
                                            '#4CAF50',
                                            '#42A5F5',
                                            '#FFB74D',
                                            '#AB47BC',
                                            '#26C6DA',
                                            '#EF5350',
                                            '#66BB6A'
                                        ],
                                        hoverBackgroundColor: [
                                            '#43A047',
                                            '#1E88E5',
                                            '#FB8C00',
                                            '#8E24AA',
                                            '#00ACC1',
                                            '#E53935',
                                            '#43A047'
                                        ],
                                        borderRadius: 8,
                                        borderSkipped: false,
                                        barThickness: 20,
                                        categoryPercentage: 0.7,
                                        barPercentage: 0.9
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y',
                                layout: {
                                    padding: {
                                        top: 5,
                                        right: 20,
                                        left: 10,
                                        bottom: 0
                                    }
                                },
                                plugins: {
                                    // Không dùng datalabels
                                    legend: {
                                        display: false
                                    },
                                    tooltip: {
                                        backgroundColor: '#1f2937',
                                        cornerRadius: 8,
                                        padding: 10
                                    },
                                    datalabels: {
                                        color: "#fff",
                                        anchor: "center",
                                        align: "center",
                                        font: {
                                            size: 13,
                                            weight: "bold"
                                        },
                                        formatter: (value) => {
                                            return value;
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
                                            color: '#374151',
                                            font: {
                                                size: 13,
                                                weight: '600'
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    );
                })
                .catch(error => {
                    console.error(
                        'Lỗi biểu đồ loại dịch vụ:',
                        error
                    );
                });
        },
        // =========================
        // TOP NHÂN VIÊN
        // =========================
        loadTop() {
            fetch('/api-tp-top')
                .then(r => r.json())
                .then(data => {
                    this.topNhanVien = data;
                });
        },
        // =========================
        // SLA
        // =========================
        loadSLA() {
            fetch('/api-tp-sla')
                .then(r => r.json())
                .then(data => {
                    this.sla = data;
                    this.loaiDichVu = data;
                });
        },
        luuSLA(item) {
            fetch('/api-tp-sla', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':
                        document.querySelector(
                            'meta[name=csrf-token]'
                        ).content
                },
                body: JSON.stringify({
                    MaLoai: item.MaLoai,
                    SLA_Phut: item.SLA_Phut
                })
            })
                .then(r => r.json())
                .then(data => {
                    alert(data.message);

                });
        },
        // =========================
        // THỐNG KÊ
        // =========================
        loadThongKe() {
            fetch('/api-tp-thongke')
                .then(r => r.json())
                .then(data => {
                    this.thongKe = data;
                });
        },
        // =========================
        // YÊU CẦU
        // =========================
        loadYeuCau(page = 1) {
            let url =
                '/api-tp-yeucau?page=' + page;
            if (this.keyword != '') {
                url +=
                    '&keyword=' +
                    encodeURIComponent(
                        this.keyword
                    );
            }
            if (this.maLoai != '') {
                url +=
                    '&maLoai=' +
                    this.maLoai;
            }
            if (this.trangThai != '') {
                url +=
                    '&trangThai=' +
                    this.trangThai;
            }
            if (this.tuNgay != '') {
                url +=
                    '&tuNgay=' +
                    this.tuNgay;
            }
            if (this.denNgay != '') {
                url +=
                    '&denNgay=' +
                    this.denNgay;
            }
            fetch(url)
                .then(r => r.json())
                .then(data => {
                    this.yeuCaus =
                        data.data;
                    this.pagination = {
                        current_page:
                            data.current_page,
                        last_page:
                            data.last_page
                    };
                });
        },
        // =========================
        // THỐNG KÊ NHÂN VIÊN
        // =========================
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
        // =========================
        // EXPORT
        // =========================
        xuatExcelTopNhanVien() {
            window.location =
                '/truongphong/excel/topnhanvien';
        },
        xuatExcelYeuCau() {
            window.location =
                '/truongphong/excel/yeucau';
        },
        xuatBaoCao() {
            window.open(
                '/truongphong/baocao',
                '_blank'
            );
        }
    }
}).mount('#app');