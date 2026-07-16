<aside class="sidebar">
    <div class="sidebar-logo">
        <h2>Dịch vụ SV</h2>
        <span>Queue System</span>
    </div>
    <div class="sidebar-menu">
        <div class="menu-item" @click="moMenu=!moMenu">
            <i>📄</i>
            <span>Quản lý yêu cầu</span>
        </div>
        <transition name="slide">
            <div class="submenu" v-show="moMenu">
                <div
                    class="submenu-item"
                    :class="{active:tab=='xuly'}"
                    @click="doiTab('xuly')">
                    📥 Yêu cầu cần xử lý
                </div>
                <div
                    class="submenu-item"
                    :class="{active:tab=='lichsu'}"
                    @click="doiTab('lichsu')">
                    ✅ Đã xử lý
                </div>
            </div>
        </transition>
        <div class="menu-item" @click="moDoiMK">
            <i>🔑</i>
            <span>Đổi mật khẩu</span>
        </div>
        <a href="/logout" class="menu-item logout">
            <i>🚪</i>
            <span>Đăng xuất</span>
        </a>
    </div>
</aside>
<div
    class="modal fade"
    id="doiMKModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Đổi mật khẩu</h5>
                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <input
                    type="password"
                    class="form-control mb-3"
                    placeholder="Mật khẩu cũ"
                    v-model="mk.cu">
                <input
                    type="password"
                    class="form-control mb-3"
                    placeholder="Mật khẩu mới"
                    v-model="mk.moi">
                <input
                    type="password"
                    class="form-control"
                    placeholder="Nhập lại mật khẩu"
                    v-model="mk.nhaplai">

            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Đóng
                </button>
                <button
                    class="btn btn-primary"
                    @click="doiMatKhau">
                    Lưu
                </button>
            </div>
        </div>
    </div>
</div>