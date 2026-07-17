<div class="card shadow">
    <div class="card-header">
        Thống kê nhân viên
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Họ tên</th>
                    <th>Đang xử lý</th>
                    <th>Hoàn thành</th>
                    <th>Tổng</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="item in thongKe"
                    :key="item.MaNV">
                    <td>[[ item.MaNV ]]</td>
                    <td>[[ item.HoTen ]]</td>
                    <td>[[ item.DangXuLy ]]</td>
                    <td>[[ item.HoanThanh ]]</td>
                    <td>[[ item.Tong ]]</td>
                    <td>
                        <button
                            class="btn btn-sm btn-primary"
                            @click="xemChiTiet(item.MaNV)">
                            Chi tiết
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>