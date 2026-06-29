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
                    v-for="item in nhanVienPage"
                    :key="item.MaNV">
                    <td>@{{ item.MaNV }}</td>
                    <td>@{{ item.HoTen }}</td>
                    <td>@{{ item.BoPhan }}</td>
                </tr>
            </tbody>
        </table>
        <nav class="mt-3">
            <ul class="pagination justify-content-center">

                <li class="page-item"
                    :class="{disabled:currentPage.nv==1}">
                    <a class="page-link"
                        href="#"
                        @click.prevent="changePage('nv',currentPage.nv-1)">
                        «
                    </a>
                </li>

                <li
                    v-for="i in totalNVPage"
                    :key="i"
                    class="page-item"
                    :class="{active:i==currentPage.nv}">

                    <a class="page-link"
                        href="#"
                        @click.prevent="changePage('nv',i)">
                        @{{ i }}
                    </a>

                </li>

                <li class="page-item"
                    :class="{disabled:currentPage.nv==totalNVPage}">
                    <a class="page-link"
                        href="#"
                        @click.prevent="changePage('nv',currentPage.nv+1)">
                        »
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</div>