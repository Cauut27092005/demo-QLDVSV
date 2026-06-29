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
                    v-for="item in yeuCauPage"
                    :key="item.MaYC">
                    <td>@{{ item.MaYC }}</td>
                    <td>@{{ item.MaSV }}</td>
                    <td>@{{ item.LoaiDichVu }}</td>
                    <td>@{{ item.NgayGui }}</td>
                    <td>@{{ item.TrangThai }}</td>
                </tr>
            </tbody>
        </table>
        <nav class="mt-3">
            <ul class="pagination justify-content-center">

                <li class="page-item"
                    :class="{disabled:currentPage.yc==1}">
                    <a class="page-link"
                        @click.prevent="changePage('yc',currentPage.yc-1)">«</a>
                </li>

                <li
                    v-for="i in totalYCPage"
                    :key="i"
                    class="page-item"
                    :class="{active:i==currentPage.yc}">

                    <a class="page-link"
                        @click.prevent="changePage('yc',i)">
                        @{{i}}
                    </a>

                </li>

                <li class="page-item"
                    :class="{disabled:currentPage.yc==totalYCPage}">
                    <a class="page-link"
                        @click.prevent="changePage('yc',currentPage.yc+1)">»</a>
                </li>

            </ul>
        </nav>
    </div>
</div>