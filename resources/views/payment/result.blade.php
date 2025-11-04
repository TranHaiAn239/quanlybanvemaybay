<x-app-layout>

    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">

        <div class="bg-white rounded-lg shadow-xl overflow-hidden max-w-lg w-full mx-4 p-8 text-center">

            @if ($status == 'success')
                <svg class="w-20 h-20 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>

                <h2 class="text-3xl font-semibold text-green-600 mt-4">Thanh toán thành công!</h2>
                <p class="text-gray-700 text-lg mt-4">
                    Đơn hàng <span class="font-bold text-gray-900">{{ $maBooking }}</span> đã được xác nhận.
                </p>
                <p class="text-gray-600 mt-2">
                    Thông tin vé điện tử sẽ được gửi đến email của bạn.
                </p>

            @elseif ($status == 'pending_cash')
                <svg class="w-20 h-20 text-blue-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>

                <h2 class="text-3xl font-semibold text-blue-600 mt-4">Đặt vé thành công!</h2>
                <p class="text-gray-700 text-lg mt-4">
                    Đơn hàng <span class="font-bold text-gray-900">{{ $maBooking }}</span> đã được giữ chỗ.
                </p>
                <p class="text-gray-600 mt-2">
                    Vui lòng đến văn phòng để thanh toán trong vòng 24 giờ.
                </p>

            @else
                <svg class="w-20 h-20 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>

                <h2 class="text-3xl font-semibold text-red-600 mt-4">Thanh toán thất bại!</h2>
                <p class="text-gray-700 text-lg mt-4">
                    Đã có lỗi xảy ra với đơn hàng <span class="font-bold text-gray-900">{{ $maBooking }}</span>.
                </p>
                <p class="text-gray-600 mt-2">
                    Vui lòng liên hệ hỗ trợ hoặc thử lại.
                </p>

            @endif

            <div class="mt-8">
                @if ($status != 'failed')
                    {{-- Nếu Thành công hoặc Chờ tiền mặt --}}
                    <a href="{{ route('home') }}"
                       class="w-full inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors">
                        Quay Về Trang Chủ
                    </a>
                @else
                    {{-- Nếu Thất bại, cho phép thử lại --}}
                    <a href="{{ route('payment.show', $maBooking) }}"
                       class="w-full inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition-colors">
                        Thử Lại Thanh Toán
                    </a>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
