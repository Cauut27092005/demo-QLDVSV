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
        <li @click="moLoaiDV">
            <i class="fa-solid fa-list-check"></i>
            <span>Loại dịch vụ của tôi</span>
        </li>
        <li @click="moDoiMK">
            <i class="fa-solid fa-key"></i>
            <span>Đổi mật khẩu</span>
        </li>

    </ul>
    <div class="logout">
        <a href="/logout">
            <i class="fa-solid fa-right-from-bracket"></i>
            Đăng xuất
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
<div class="modal fade"
     id="loaiDVModal"
     tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    Loại dịch vụ của tôi
                </h5>
                <button
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div
                    v-for="item in loaiDV"
                    :key="item.MaLoai"
                    class="mb-3">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            :value="item.MaLoai"
                            v-model="chonLoai"
                            :disabled="biKhoa(item)">
                        <label class="form-check-label">
                            [[ item.TenLoai ]]
                        </label>
                    </div>
                    <small
                        v-if="item.MaNV!=null && item.MaNV!=maNV"
                        class="text-danger">
                        Đã có
                        <strong>
                            [[ item.HoTen ]]
                        </strong>
                        phụ trách
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Đóng
                </button>
                <button
                    class="btn btn-primary"
                    @click="luuLoaiDV">
                    Lưu
                </button>
            </div>
        </div>
    </div>
</div>