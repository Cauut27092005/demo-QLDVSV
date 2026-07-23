<aside class="sidebar">
    <div class="sidebar-logo">
        <h2>Dịch vụ SV</h2>
    </div>
    <div class="sidebar-menu">
        <div class="menu-item" @click="moMenu=!moMenu">
            <i class="fa-solid fa-folder-open"></i>
            <span>Quản lý yêu cầu</span>
        </div>
        <transition name="slide">
            <div class="submenu" v-show="moMenu">
                <div
                    class="submenu-item"
                    :class="{active:tab=='xuly'}"
                    @click="doiTab('xuly')">
                    Yêu cầu cần xử lý
                </div>
                <div
                    class="submenu-item"
                    :class="{active:tab=='lichsu'}"
                    @click="doiTab('lichsu')">
                    Đã xử lý
                </div>
            </div>
        </transition>
        <div class="menu-item" @click="moLoaiDV">
            <i class="fa-solid fa-list-check"></i>
            <span>Loại dịch vụ của tôi</span>
        </div>
        <div class="menu-item" @click="moDoiMK">
            <i class="fa-solid fa-key"></i>
            <span>Đổi mật khẩu</span>
        </div>
        <a href="/logout" class="menu-item logout">
            <i class="fa-solid fa-right-from-bracket"></i>
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