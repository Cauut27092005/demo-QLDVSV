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
                    v-for="item in hoanThanhPage"
                    :key="item.MaYC">
                    <td>@{{ item.MaYC }}</td>
                    <td>@{{ item.MaSV }}</td>
                    <td>@{{ item.LoaiDichVu }}</td>
                    <td>@{{ item.NgayGui }}</td>
                </tr>
            </tbody>
        </table>
        <nav class="mt-3">
            <ul class="pagination justify-content-center">

                <li class="page-item"
                    :class="{disabled:currentPage.ht==1}">
                    <a class="page-link"
                        @click.prevent="changePage('ht',currentPage.ht-1)">«</a>
                </li>

                <li
                    v-for="i in totalHTPage"
                    :key="i"
                    class="page-item"
                    :class="{active:i==currentPage.ht}">

                    <a class="page-link"
                        @click.prevent="changePage('ht',i)">
                        @{{i}}
                    </a>

                </li>

                <li class="page-item"
                    :class="{disabled:currentPage.ht==totalhtPage}">
                    <a class="page-link"
                        @click.prevent="changePage('ht',currentPage.ht+1)">»</a>
                </li>

            </ul>
        </nav>
    </div>
</div>