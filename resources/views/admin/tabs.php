<div class="menu-tabs shadow-sm">

    <div
        class="tab-item"
        :class="{active:show=='tk'}"
        @click="openPage('tk')">

        📊
        <span>Thống kê</span>

    </div>

    <div
        class="tab-item"
        :class="{active:show=='nv'}"
        @click="openPage('nv')">

        👨‍💼
        <span>Nhân viên</span>

    </div>

    <div
        class="tab-item"
        :class="{active:show=='yc'}"
        @click="openPage('yc')">

        📄
        <span>Yêu cầu</span>

    </div>

    <div
        class="tab-item"
        :class="{active:show=='dxl'}"
        @click="openPage('dxl')">

        ⏳
        <span>Đang xử lý</span>

    </div>

    <div
        class="tab-item"
        :class="{active:show=='ht'}"
        @click="openPage('ht')">

        ✔
        <span>Hoàn thành</span>

    </div>

</div>