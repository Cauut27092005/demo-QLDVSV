<div class="card shadow table-box ht-box">
    <div class="card-header ht-header text-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">
                <i class="fa-solid fa-circle-check me-2"></i>
                Danh sách đã hoàn thành
            </h5>
            <small>Lịch sử các yêu cầu đã xử lý xong</small>
        </div>
    </div>
    <div class="card-body">
        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table ht-table align-middle">
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
                    <tr v-for="item in hoanThanhPage" :key="item.MaYC">
                        <td><strong>@{{ item.MaYC }}</strong></td>
                        <td>@{{ item.MaSV }}</td>
                        <td class="ht-service">
                            @{{ item.LoaiDichVu }}
                        </td>
                        <td>@{{ item.NgayGui }}</td>
                        <td>
                            <span class="ht-badge">
                                Hoàn thành
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- PAGINATION -->
        <nav class="ht-pagination mt-3">
            <ul class="pagination justify-content-center">
                <li class="page-item"
                    :class="{disabled:currentPage.ht==1}">
                    <a class="page-link"
                       @click.prevent="changePage('ht',currentPage.ht-1)">
                        «
                    </a>
                </li>
                <li v-for="i in totalHTPage"
                    :key="i"
                    class="page-item"
                    :class="{active:i==currentPage.ht}">
                    <a class="page-link"
                       @click.prevent="changePage('ht',i)">
                        @{{ i }}
                    </a>
                </li>
                <li class="page-item"
                    :class="{disabled:currentPage.ht==totalHTPage}">
                    <a class="page-link"
                       @click.prevent="changePage('ht',currentPage.ht+1)">
                        »
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>