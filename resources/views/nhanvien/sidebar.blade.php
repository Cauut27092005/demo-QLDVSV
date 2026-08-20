<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">
            <i class="fa-solid fa-bolt"></i>
        </div>
        <div>
            <h4>Dịch vụ SV</h4>
            <small>Nhân viên</small>
        </div>
    </div>
    <ul class="menu">
        <li @click="moMenu=!moMenu">
            <i class="fa-solid fa-folder-open"></i>
            <span>Quản lý yêu cầu</span>
            <i
                class="fa-solid fa-chevron-down ms-auto"
                :class="{ 'fa-rotate-180': moMenu }">
            </i>
        </li>
        <ul
            v-show="moMenu"
            class="submenu">
            <li
                :class="{active:tab=='xuly'}"
                @click="doiTab('xuly')">
                <i class="fa-solid fa-hourglass-half"></i>
                <span>Yêu cầu cần xử lý</span>
            </li>
            <li
                :class="{active:tab=='lichsu'}"
                @click="doiTab('lichsu')">
                <i class="fa-solid fa-check-circle"></i>
                <span>Đã xử lý</span>
            </li>
        </ul>
    </ul>
    <div class="logout">
        <a href="/logout">
            <i class="fa-solid fa-right-from-bracket"></i>
            Đăng xuất
        </a>
    </div>
</aside>