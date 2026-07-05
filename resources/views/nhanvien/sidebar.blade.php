<aside class="sidebar">
    <div class="logo"></div>
    <ul class="menu">
        <li @click="moMenu=!moMenu">
            📄 Quản lý yêu cầu
        </li>
        <ul
            v-show="moMenu"
            class="submenu">
            <li
                :class="{active:tab=='xuly'}"
                @click="doiTab('xuly')">
                📥 Yêu cầu cần xử lý
            </li>
            <li
                :class="{active:tab=='lichsu'}"
                @click="doiTab('lichsu')">
                ✅ Đã xử lý
            </li>
        </ul>
        <li @click="moDoiMK">
            🔑 Đổi mật khẩu
        </li>
        <li>
            <a href="/logout">
                🚪 Đăng xuất
            </a>
        </li>
    </ul>
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