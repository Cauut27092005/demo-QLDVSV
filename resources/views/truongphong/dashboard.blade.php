<div class="dashboard">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card-stat bg-blue">
                <h3>[[ dashboard.tongYC ]]</h3>
                <p>Tổng yêu cầu</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-stat bg-orange">
                <h3>[[ dashboard.choXuLy ]]</h3>
                <p>Chờ xử lý</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-stat bg-purple">
                <h3>[[ dashboard.dangXuLy ]]</h3>
                <p>Đang xử lý</p>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card-stat bg-green">
                <h3>[[ dashboard.hoanThanh ]]</h3>
                <p>Đã xử lý</p>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-4 d-flex">
            <div class="card w-100 top-card">
                <div class="card-header">
                    <h5 class="mb-0">🏆 Top nhân viên</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nhân viên</th>
                                <th>Hoàn thành</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item,index) in topNhanVien"
                                :key="item.MaNV">
                                <td class="fw-bold">[[ index+1 ]]</td>
                                <td>[[ item.HoTen ]]</td>
                                <td>[[ item.Tong ]]</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center mt-3">
                        <button
                            class="btn btn-primary"
                            @click="xemThongKeNhanVien">
                            Xem chi tiết
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 d-flex">
            <div class="card w-100 chart-card">
                <div class="card-header">
                    <h5>Thống kê theo loại dịch vụ</h5>
                </div>
                <div class="card-body">
                    <canvas id="serviceChart">
                    </canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Hoạt động hôm nay</h5>
                    <small class="text-muted">
                        [[ yeuCaus.length ]] yêu cầu
                    </small>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã YC</th>
                                <th>Nhân viên</th>
                                <th>Loại DV</th>
                                <th>Trạng thái</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="item in yeuCaus.slice(0,5)"
                                :key="item.MaYC">
                                <td>[[ item.MaYC ]]</td>
                                <td>[[ item.TenNhanVien ?? 'Chưa nhận' ]]</td>
                                <td>[[ item.LoaiDichVu ]]</td>
                                <td>[[ item.TrangThai ]] </td>
                                <td>[[ item.NgayGui ]]</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="thongKeNVModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Thống kê hiệu suất nhân viên</h5>
                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã NV</th>
                            <th>Nhân viên</th>
                            <th>Hoàn thành</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(nv,index) in thongKe"
                            :key="nv.MaNV">
                            <td>[[index+1]] </td>
                            <td>[[nv.MaNV]]</td>
                            <td>[[nv.HoTen]]</td>
                            <td>[[nv.HoanThanh]]</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>