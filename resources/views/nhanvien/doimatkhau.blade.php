<div
    class="modal fade"
    id="doiMKModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>
                    Đổi mật khẩu
                </h5>
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