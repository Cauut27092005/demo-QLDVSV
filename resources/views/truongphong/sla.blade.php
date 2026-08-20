<div class="card shadow">
    <div class="card-header">
        <h5>
            Quản lý SLA
        </h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Loại dịch vụ</th>
                    <th>Nhân viên phụ trách</th>
                    <th width="180">
                        SLA (phút)
                    </th>
                    <th width="120">
                        Thao tác
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="item in sla"
                    :key="item.MaLoai">
                    <td>[[ item.TenLoai ]]</td>
                    <td>[[ item.HoTen ?? 'Chưa phân công' ]]</td>
                    <td>
                        <input
                            type="number"
                            min="1"
                            class="form-control"
                            v-model="item.SLA_Phut">
                    </td>
                    <td>
                        <button
                            class="btn btn-success"
                            @click="luuSLA(item)">
                            Lưu
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>