<div class="modal fade"
    id="nhanVienModal"
    tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header modal-header-custom">
                <div class="d-flex align-items-center">
                    <div class="modal-avatar">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div class="ms-3">

                        <h4 class="mb-0">

                            @{{ isEdit ? 'Cập nhật nhân viên' : 'Thêm nhân viên mới' }}
                        </h4>
                        <small>
                            Nhập đầy đủ thông tin nhân viên
                        </small>
                    </div>
                </div>
                <button
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <!-- Body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Mã nhân viên
                        </label>
                        <input
                            class="form-control"
                            v-model="formNV.MaNV"
                            :disabled="isEdit"
                            placeholder="VD: nv01">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Họ và tên
                        </label>
                        <input
                            class="form-control"
                            v-model="formNV.HoTen"
                            placeholder="Nhập họ tên">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Bộ phận
                        </label>
                        <select
                            class="form-select"
                            v-model="formNV.BoPhan">
                            <option value="Công tác sinh viên">
                                Công tác sinh viên
                            </option>
                            <option value="Đào tạo">
                                Đào tạo
                            </option>
                            <option value="Khảo thí">
                                Khảo thí
                            </option>
                            <option value="Kế toán">
                                Kế toán
                            </option>
                            <option value="Thư viện">
                                Thư viện
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <div class="modal-footer">
                <button
                    class="btn btn-light"
                    data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                    Đóng
                </button>
                <button
                    class="btn btn-primary"
                    @click="saveNV">
                    <i class="fa-solid fa-floppy-disk"></i>
                    @{{ isEdit ? 'Cập nhật' : 'Lưu nhân viên' }}
                </button>
            </div>
        </div>
    </div>
</div>