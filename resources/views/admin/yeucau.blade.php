<div class="card shadow table-box yc-box">
    <div class="card-header yc-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">
                <i class="fa-solid fa-clipboard-list me-2"></i>
                Danh sách yêu cầu
            </h5>
            <small>Quản lý các yêu cầu sinh viên gửi lên hệ thống</small>
        </div>
    </div>
    <div class="card-body">
        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table yc-table align-middle">
                <thead>
                    <tr>
                        <th>Mã YC</th>
                        <th>Mã SV</th>
                        <th>Loại dịch vụ</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in yeuCauPage" :key="item.MaYC">
                        <td>
                            <strong>@{{ item.MaYC }}</strong>
                        </td>
                        <td>@{{ item.MaSV }}</td>
                        <td>@{{ item.LoaiDichVu }}</td>
                        <td>@{{ item.NgayGui }}</td>
                        <td>
                            <!-- trạng thái màu -->
                            <span v-if="item.TrangThai=='Chờ xử lý'"
                                class="badge yc-badge yc-wait">
                                Chờ xử lý
                            </span>
                            <span v-else-if="item.TrangThai=='Đang xử lý'"
                                class="badge yc-badge yc-process">
                                Đang xử lý
                            </span>
                            <span v-else-if="item.TrangThai=='Hoàn thành'"
                                class="badge yc-badge yc-done">
                                Hoàn thành
                            </span>
                        
                            <span class="yc-status" :class="getTrangThaiClass(item.TrangThai)">
                                @{{ item.TrangThai }}
                            </span>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- PAGINATION -->
        <nav class="yc-pagination mt-3">
            <ul class="pagination justify-content-center">
                <li class="page-item"
                    :class="{disabled:currentPage.yc==1}">
                    <a class="page-link"
                        @click.prevent="changePage('yc',currentPage.yc-1)">
                        «
                    </a>
                </li>
                <li v-for="i in totalYCPage"
                    :key="i"
                    class="page-item"
                    :class="{active:i==currentPage.yc}">
                    <a class="page-link"
                        @click.prevent="changePage('yc',i)">
                        @{{ i }}
                    </a>
                </li>
                <li class="page-item"
                    :class="{disabled:currentPage.yc==totalYCPage}">
                    <a class="page-link"
                        @click.prevent="changePage('yc',currentPage.yc+1)">
                        »
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>