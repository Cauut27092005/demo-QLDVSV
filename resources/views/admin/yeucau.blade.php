<div class="card shadow table-box">
    <div class="card-header bg-warning">
        Danh sách yêu cầu
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã YC</th>
                    <th>Mã SV</th>
                    <th>Loại DV</th>
                    <th>Ngày gửi</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="item in yeuCaus"
                    :key="item.MaYC">
                    <td>@{{ item.MaYC }}</td>
                    <td>@{{ item.MaSV }}</td>
                    <td>@{{ item.LoaiDichVu }}</td>
                    <td>@{{ item.NgayGui }}</td>
                    <td>@{{ item.TrangThai }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>