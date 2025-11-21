<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{--
              Bọc mọi thứ trong x-data để quản lý trạng thái
              'paymentMethod' sẽ lưu giá trị của radio button
            --}}
            <div x-data="{ paymentMethod: 'momo' }">

                @if (session('payment_error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Thanh toán thất bại!</strong>
                        <span class="block sm:inline">{{ session('payment_error') }}</span>
                    </div>
                @endif

                <div class="bg-white shadow-lg rounded-lg overflow-hidden">

                    <div class="bg-gray-50 p-6 border-b">
                        <h2 class="text-3xl font-semibold text-gray-800 text-center">Xác Nhận Thanh Toán</h2>
                    </div>

                    <form action="{{ route('payment.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="ma_booking" value="{{ $booking->ma_booking }}">

                        <div class="p-8">
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Tóm tắt đơn hàng</h3>
                                <div class="border border-gray-200 rounded-lg p-6 space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Mã đơn hàng:</span>
                                        <span class="font-bold text-gray-900">{{ $booking->ma_booking }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Tổng tiền vé & thuế:</span>
                                        <span class="font-semibold text-gray-900">{{ number_format($booking->tong_tien + $booking->giam_gia, 0, ',', '.') }} VND</span>
                                    </div>
                                    @if ($booking->giam_gia > 0)
                                    <div class="flex justify-between items-center text-green-600">
                                        <span class="font-semibold">Giảm giá khứ hồi:</span>
                                        <span class="font-semibold">- {{ number_format($booking->giam_gia, 0, ',', '.') }} VND</span>
                                    </div>
                                    @endif
                                    <hr class="border-dashed">
                                    <div class="flex justify-between items-center text-2xl">
                                        <span class="font-bold text-gray-900">Tổng cộng thanh toán:</span>
                                        <span class="font-bold text-red-600">{{ number_format($booking->tong_tien, 0, ',', '.') }} VND</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Chọn phương thức thanh toán</h3>
                                <div class="space-y-4">

                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                        <input type="radio" name="phuong_thuc_tt" value="vnpay" class="h-5 w-5 text-blue-600" x-model="paymentMethod">
                                        <span class="ml-4 flex items-center">
                                            {{-- Bạn có thể tìm logo VNPay trên mạng --}}
                                            <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Icon-VNPAY-QR.png" alt="VNPay" class="h-8 w-auto">
                                            <span class="text-lg font-medium text-gray-700 ml-2">Thanh toán qua VNPay (ATM/QR)</span>
                                        </span>
                                    </label>


                                    {{-- 1. MOMO --}}
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                        <input type="radio" name="phuong_thuc_tt" value="momo" class="h-5 w-5 text-blue-600" x-model="paymentMethod" checked>
                                        <span class="ml-4 flex items-center">
                                            <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-MoMo-Square.png" alt="MOMO" class="h-8 w-auto">
                                                                                        <span class="text-lg font-medium text-gray-700 ml-2">Thanh toán qua Ví Momo</span>
                                        </span>
                                    </label>

                                    {{-- 2. ZALOPAY --}}
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                        <input type="radio" name="phuong_thuc_tt" value="zalopay" class="h-5 w-5 text-blue-600" x-model="paymentMethod">
                                        <span class="ml-4 flex items-center">
                                            <img src="https://cdn.brandfetch.io/id_T-oXJkN/w/1624/h/1624/theme/dark/icon.jpeg?c=1dxbfHSJFAPEGdCLU4o5B" alt="ZaloPay" class="h-8 w-auto">
                                                                                        <span class="text-lg font-medium text-gray-700 ml-2">Thanh toán qua Ví ZaloPay</span>
                                        </span>
                                    </label>

                                    {{-- 3. THẺ TÍN DỤNG --}}
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                        <input type="radio" name="phuong_thuc_tt" value="the_tin_dung" class="h-5 w-5 text-blue-600" x-model="paymentMethod">
                                        <span class="ml-4 flex items-center">
                                            <img src="https://as2.ftcdn.net/v2/jpg/16/09/83/77/1000_F_1609837704_7ZqSU0ZnY9FQYWbvoT8aXWe6yxSt8vao.jpg" alt="ttd" class="h-8 w-auto">
                                                                                        <span class="text-lg font-medium text-gray-700 ml-2">Thẻ tín dụng/ghi nợ (Visa, Master)</span>
                                        </span>
                                    </label>

                                    {{-- 4. TIỀN MẶT --}}
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                        <input type="radio" name="phuong_thuc_tt" value="tien_mat" class="h-5 w-5 text-blue-600" x-model="paymentMethod">
                                        <span class="ml-4 flex items-center">
                                            <img src="https://img.pikbest.com/element_our/20230221/bg/ebab41b9c1ab9.png!w700wp" alt="tm" class="h-8 w-auto">
                                                                                        <span class="text-lg font-medium text-gray-700 ml-2">Thanh toán tiền mặt tại văn phòng</span>
                                        </span>
                                    </label>

                                </div>
                                @error('phuong_thuc_tt')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-8 border-t pt-8">

                                {{-- FORM CHO MOMO (HIỂN THỊ MÃ QR) --}}
                                <div x-show="paymentMethod === 'momo'" class="text-center">
                                    <h4 class="text-lg font-semibold mb-4">Quét mã QR Momo để thanh toán</h4>
                                                                        <p class="mt-4 text-gray-600">Mở ứng dụng Momo và quét mã này để hoàn tất.</p>
                                    <p class="text-sm text-gray-500">(Đây là giao diện giả lập, vui lòng nhấn "Xác Nhận" để tiếp tục).</p>
                                </div>

                                {{-- FORM CHO ZALOPAY (HIỂN THỊ MÃ QR) --}}
                                <div x-show="paymentMethod === 'zalopay'" class="text-center">
                                    <h4 class="text-lg font-semibold mb-4">Quét mã QR ZaloPay để thanh toán</h4>
                                                                        <p class="mt-4 text-gray-600">Mở ứng dụng ZaloPay và quét mã này để hoàn tất.</p>
                                    <p class="text-sm text-gray-500">(Đây là giao diện giả lập, vui lòng nhấn "Xác Nhận" để tiếp tục).</p>
                                </div>

                                {{-- FORM CHO THẺ TÍN DỤNG --}}
                                <div x-show="paymentMethod === 'the_tin_dung'" class="space-y-4">
                                    <h4 class="text-lg font-semibold mb-2">Thông tin thẻ tín dụng</h4>
                                    <div>
                                        <label for="so_the" class="block font-medium text-sm text-gray-700 mb-1">Số thẻ</label>
                                        <input type="text" id="so_the" class="block w-full rounded-md border-gray-300 shadow-sm" placeholder="4005 5500 0000 0001">
                                    </div>
                                    <div>
                                        <label for="ten_in_tren_the" class="block font-medium text-sm text-gray-700 mb-1">Tên in trên thẻ</label>
                                        <input type="text" id="ten_in_tren_the" class="block w-full rounded-md border-gray-300 shadow-sm" placeholder="TRAN QUANG KHAI">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="ngay_het_han" class="block font-medium text-sm text-gray-700 mb-1">Ngày hết hạn (MM/YY)</label>
                                            <input type="text" id="ngay_het_han" class="block w-full rounded-md border-gray-300 shadow-sm" placeholder="05/28">
                                        </div>
                                        <div>
                                            <label for="ma_bao_mat" class="block font-medium text-sm text-gray-700 mb-1">Mã bảo mật (CVV)</label>
                                            <input type="text" id="ma_bao_mat" class="block w-full rounded-md border-gray-300 shadow-sm" placeholder="234">
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500">(Đây là giao diện giả lập, thông tin thẻ sẽ không được gửi đi. Vui lòng nhấn "Xác Nhận" để tiếp tục).</p>
                                </div>

                                {{-- THÔNG BÁO CHO TIỀN MẶT --}}
                                <div x-show="paymentMethod === 'tien_mat'" class="text-center p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <h4 class="text-lg font-semibold text-blue-800">Xác nhận đặt vé tiền mặt</h4>
                                    <p class="mt-2 text-gray-700">Đơn hàng của bạn sẽ được tạo và giữ chỗ. Vui lòng thanh toán tại văn phòng trong vòng 24 giờ.</p>
                                </div>

                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 text-right">
                            <button type="submit"
                                    class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-10 rounded-lg text-lg text-center shadow-lg transition-colors">
                                Xác Nhận & Thanh Toán
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
