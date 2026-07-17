<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div>
            <h4>Trưởng phòng</h4>
        </div>
    </div>
    <ul class="menu">
        <li
            :class="{active:menu=='dashboard'}"
            @click="menu='dashboard'">
            <i class="fa-solid fa-chart-pie"></i>
            Dashboard
        </li>
        <li
            :class="{active:menu=='yeucau'}"
            @click="menu='yeucau'">
            <i class="fa-solid fa-list-check"></i>
            Theo dõi yêu cầu
        </li>
        <li
            :class="{active:menu=='thongke'}"
            @click="menu='thongke'">
            <i class="fa-solid fa-users"></i>
            Hiệu suất nhân viên
        </li>
        <li
            @click="xuatExcel()">
            <i class="fa-solid fa-file-excel"></i>
            Xuất Excel
        </li>
    </ul>
    <div class="logout">
        <a href="/logout">
            <i class="fa-solid fa-right-from-bracket"></i>
            Đăng xuất
        </a>
    </div>
</aside>