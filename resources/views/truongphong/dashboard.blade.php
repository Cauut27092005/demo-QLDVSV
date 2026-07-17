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
                <p>Hoàn thành</p>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Nhân viên</h5>
                    <h2>[[ dashboard.tongNhanVien ]]</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Yêu cầu hôm nay</h5>
                    <h2>[[ dashboard.homNay ]]</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        🏆 Top nhân viên
                    </h5>
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
                                <td>
                                    [[ index+1 ]]
                                </td>
                                <td>
                                    [[ item.HoTen ]]
                                </td>
                                <td>
                                    [[ item.Tong ]]
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5>
                        Thống kê theo loại dịch vụ
                    </h5>
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
                    <h5>
                        Hoạt động gần đây
                    </h5>
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