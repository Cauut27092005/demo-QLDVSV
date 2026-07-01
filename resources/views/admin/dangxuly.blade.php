<div class="card shadow table-box dxl-box">

    <div class="card-header dxl-header text-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">
                <i class="fa-solid fa-spinner me-2"></i>
                Danh sách đang xử lý
            </h5>
            <small>Những yêu cầu đang được nhân viên xử lý</small>
        </div>
    </div>

    <div class="card-body">

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table dxl-table align-middle">
                <thead>
                    <tr>
                        <th>Mã YC</th>
                        <th>Mã SV</th>
                        <th>Loại DV</th>
                        <th>Ngày gửi</th>
                        <th>Tiến trình</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in dangXuLyPage" :key="item.MaYC">
                        <td><strong>@{{ item.MaYC }}</strong></td>
                        <td>@{{ item.MaSV }}</td>
                        <td class="dxl-service">
                            @{{ item.LoaiDichVu }}
                        </td>
                        <td>@{{ item.NgayGui }}</td>
                        <!-- PIPELINE -->
                        <td>
                            <div class="dxl-progress-text">
                                <span class="active">Đang xử lý</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- PAGINATION -->
        <nav class="dxl-pagination mt-3">
            <ul class="pagination justify-content-center">
                <li class="page-item"
                    :class="{disabled:currentPage.dxl==1}">
                    <a class="page-link"
                        @click.prevent="changePage('dxl',currentPage.dxl-1)">
                        «
                    </a>
                </li>
                <li v-for="i in totalDXLPage"
                    :key="i"
                    class="page-item"
                    :class="{active:i==currentPage.dxl}">
                    <a class="page-link"
                        @click.prevent="changePage('dxl',i)">
                        @{{ i }}
                    </a>
                </li>
                <li class="page-item"
                    :class="{disabled:currentPage.dxl==totalDXLPage}">
                    <a class="page-link"
                        @click.prevent="changePage('dxl',currentPage.dxl+1)">
                        »
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>