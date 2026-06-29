<div class="card shadow table-box">
    <div class="card-header bg-info text-white">
        Danh sách đang xử lý
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
                    v-for="item in dangXuLyPage"
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
                    :class="{disabled:currentPage.dxl==1}">
                    <a class="page-link"
                        @click.prevent="changePage('dxl',currentPage.dxl-1)">«</a>
                </li>

                <li
                    v-for="i in totalDXLPage"
                    :key="i"
                    class="page-item"
                    :class="{active:i==currentPage.dxl}">

                    <a class="page-link"
                        @click.prevent="changePage('dxl',i)">
                        @{{i}}
                    </a>

                </li>

                <li class="page-item"
                    :class="{disabled:currentPage.dxl==totaldxlPage}">
                    <a class="page-link"
                        @click.prevent="changePage('dxl',currentPage.dxl+1)">»</a>
                </li>

            </ul>
        </nav>
    </div>
</div>