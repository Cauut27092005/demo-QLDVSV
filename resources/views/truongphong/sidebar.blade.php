<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">
            <i class="fa-solid fa-bolt"></i>
        </div>
        <div>
            <h4>Dashboard</h4>
            <small>Trưởng phòng</small>
        </div>
    </div>
    <ul class="menu">
        <li
            :class="{active:menu=='dashboard'}"
            @click="menu='dashboard'">
            <i class="fa-solid fa-chart-pie"></i>
            <span>Dashboard</span>
        </li>
        <li
            :class="{active:menu=='yeucau'}"
            @click="menu='yeucau'">
            <i class="fa-solid fa-list-check"></i>
            <span>Theo dõi yêu cầu</span>
        </li>
        <li @click="moExcel = !moExcel">
            <i class="fa-solid fa-file-excel"></i>
            <span>Xuất Excel</span>
            <i
                class="fa-solid fa-chevron-down ms-auto"
                :class="{ 'fa-rotate-180': moExcel }">
            </i>
        </li>
        <ul
            v-show="moExcel"
            class="submenu">
            <li @click="xuatExcelTopNhanVien()">
                <i class="fa-solid fa-users"></i>
                <span>Top nhân viên</span>
            </li>
            <li @click="xuatExcelYeuCau()">
                <i class="fa-solid fa-file-lines"></i>
                <span>Yêu cầu</span>
            </li>

        </ul>
    </ul>
    </ul>
    <div class="logout">
        <a href="/logout">
            <i class="fa-solid fa-right-from-bracket"></i>
            Đăng xuất
        </a>
    </div>
</aside>