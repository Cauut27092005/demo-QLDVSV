<div class="card shadow table-box">
    <div class="card-header bg-success text-white">
        Danh sách đã hoàn thành
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã YC</th>
                    <th>Mã SV</th>
                    <th>Loại DV</th>
                    <th>Ngày gửi</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="item in hoanThanhs"
                    :key="item.MaYC">
                    <td>@{{ item.MaYC }}</td>
                    <td>@{{ item.MaSV }}</td>
                    <td>@{{ item.LoaiDichVu }}</td>
                    <td>@{{ item.NgayGui }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>