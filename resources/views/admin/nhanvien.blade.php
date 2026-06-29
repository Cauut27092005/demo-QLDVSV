<div class="card shadow table-box">
    <div class="card-header bg-primary text-white">
        Danh sách nhân viên
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Họ tên</th>
                    <th>Bộ phận</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="item in nhanViens"
                    :key="item.MaNV">
                    <td>@{{ item.MaNV }}</td>
                    <td>@{{ item.HoTen }}</td>
                    <td>@{{ item.BoPhan }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>