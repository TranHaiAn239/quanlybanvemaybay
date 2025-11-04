{{--
  File này giờ sẽ dùng x-model cho MỌI TRƯỜNG
--}}
<div class="border border-gray-200 rounded-lg p-4">
    <h4 class="text-lg font-semibold text-gray-700 mb-4" x-text="passenger.title"></h4>

    <div class="mb-4">
        <label :for="'ho_ten_' + index" class="block font-medium text-sm text-gray-700 mb-1">
            Họ và tên <span class="text-red-500">*</span>
        </label>
        <input type="text" :id="'ho_ten_' + index"
               class="block w-full rounded-md border-gray-300 shadow-sm"
               placeholder="NGUYEN VAN AN" x-model="passenger.ho_ten" required>
    </div>

    <div class="mb-4">
        <label :for="'loai_ghe_' + index" class="block font-medium text-sm text-gray-700 mb-1">
            Loại ghế
        </label>
        <select :id="'loai_ghe_' + index"
                class="block w-full rounded-md border-gray-300 shadow-sm"
                x-model="passenger.seat_type"
                :disabled="passenger.type === 'em_be'">
            <option value="phổ thông">Phổ thông (Mặc định)</option>
            <option value="thương gia">Thương gia (+5% giá vé)</option>
            <option value="hạng nhất">Hạng nhất (+10% giá vé)</option>
        </select>
    </div>

    <div class="mb-4">
        <label :for="'hanh_ly_' + index" class="block font-medium text-sm text-gray-700 mb-1">
            Hành lý ký gửi
        </label>
        <select :id="'hanh_ly_' + index"
                class="block w-full rounded-md border-gray-300 shadow-sm"
                x-model="passenger.baggage_fee"
                :disabled="passenger.baggage_enabled === false">

            @foreach ($baggage_options as $option)
                <option value="{{ $option['price'] }}">{{ $option['text'] }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label :for="'sdt_' + index" class="block font-medium text-sm text-gray-700 mb-1">Số điện thoại</label>
            <input type="tel" :id="'sdt_' + index"
                   class="block w-full rounded-md border-gray-300 shadow-sm"
                   placeholder="0901234567" x-model="passenger.so_dien_thoai">
        </div>
        <div>
            <label :for="'email_' + index" class="block font-medium text-sm text-gray-700 mb-1">Email</label>
            <input type="email" :id="'email_' + index"
                   class="block w-full rounded-md border-gray-300 shadow-sm"
                   placeholder="example@gmail.com" x-model="passenger.email">
        </div>
    </div>

    <div class="mb-4">
        <label :for="'dia_chi_' + index" class="block font-medium text-sm text-gray-700 mb-1">Địa chỉ</label>
        <input type="text" :id="'dia_chi_' + index"
               class="block w-full rounded-md border-gray-300 shadow-sm"
               placeholder="123 Đường ABC..." x-model="passenger.dia_chi">
    </div>

    <div class="mb-4">
        <label :for="'ghi_chu_' + index" class="block font-medium text-sm text-gray-700 mb-1">Ghi chú (CMND/CCCD...)</label>
        <textarea :id="'ghi_chu_' + index" rows="2"
                  class="block w-full rounded-md border-gray-300 shadow-sm"
                  placeholder="CMND/CCCD, v.v..." x-model="passenger.ghi_chu"></textarea>
    </div>
</div>
