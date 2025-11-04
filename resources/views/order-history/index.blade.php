<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6 px-4 sm:px-0">Lịch Sử Đơn Hàng</h2>

            {{-- Hiển thị thông báo (Success/Error) từ Controller --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="space-y-8">

                    {{-- Dùng @forelse để lặp qua các đơn hàng --}}
                    @forelse ($bookings as $booking)
                        <div class="border-b border-gray-200">
                            <div class="bg-gray-50 p-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">
                                        Mã Đơn Hàng: <span class="text-blue-600">{{ $booking->ma_booking }}</span>
                                    </h3>
                                    <p class="text-sm text-gray-600">Ngày đặt: {{ $booking->ngay_dat->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="mt-2 md:mt-0 text-left md:text-right">
                                    <p class="text-lg font-semibold">
                                        Tổng tiền: <span class="text-red-600">{{ number_format($booking->tong_tien, 0, ',', '.') }} VND</span>
                                    </p>
                                    <p class="text-sm font-medium">
                                        Trạng thái:
                                        {{-- Hiển thị trạng thái thanh toán --}}
                                        @if ($booking->trang_thai == 'da_thanh_toan')
                                            <span class="font-bold text-green-600">Đã Thanh Toán</span>
                                        @elseif ($booking->trang_thai == 'cho_thanh_toan')
                                            <span class="font-bold text-yellow-600">Chờ Thanh Toán</span>
                                        @else
                                            <span class="font-bold text-gray-500">Đã Hủy</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="p-4 space-y-4">
                                @foreach ($booking->ves as $ve)
                                <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                                    <span class="text-blue-500">[✈️]</span>
                                    <div class="ml-3 flex-1">
                                        <p class="font-semibold text-gray-800">
                                            {{ $ve->chuyenBay->sanBayDi->tinh_thanh }} ({{ $ve->chuyenBay->sanBayDi->ma_san_bay }})
                                            &rarr;
                                            {{ $ve->chuyenBay->sanBayDen->tinh_thanh }} ({{ $ve->chuyenBay->sanBayDen->ma_san_bay }})
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $ve->chuyenBay->thoi_gian_di->format('H:i d/m/Y') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Loại khách: {{ ucfirst(str_replace('_', ' ', $ve->loai_hanh_khach)) }} |
                                            Ghế: {{ ucfirst($ve->loai_ghe) }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            @if ($booking->trang_thai == 'cho_thanh_toan')
                            <div class="p-4 bg-gray-50 border-t flex justify-end">
                                <form action="{{ route('order.cancel', $booking->id) }}" method="POST"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng {{ $booking->ma_booking }}?');">
                                    @csrf
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow">
                                        Hủy Đơn Hàng
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    @empty
                        {{-- Trường hợp người dùng chưa có đơn hàng nào --}}
                        <div class="p-10 text-center">
                            <p class="text-xl text-gray-700">Bạn chưa có đơn hàng nào.</p>
                            <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                                Đặt Vé Ngay
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- Hiển thị link phân trang (nếu có) --}}
                <div class="mt-6">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
