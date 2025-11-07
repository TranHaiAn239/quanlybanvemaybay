<x-app-layout>
    {{--
      Chúng ta bỏ <x-slot name="header">...</x-slot>
      để xóa tiêu đề "Dashboard"
    --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 text-gray-900 text-center">

                    {{-- Lấy tên người dùng --}}
                    @php
                        $userName = Auth::user()->ho_ten;
                        $userRole = Auth::user()->vai_tro;
                    @endphp

                    <h2 class="text-3xl font-bold mb-4">
                        Chào mừng, {{ $userName }}!
                    </h2>

                    {{--
                      KIỂM TRA VAI TRÒ (ROLE)
                      (Đúng theo yêu cầu của bạn)
                    --}}
                    @if ($userRole == 'admin' || $userRole == 'nhan_vien')

                        {{-- Dành cho Admin / Nhân viên --}}
                        <p class="text-lg text-gray-700 mb-8">
                            Bạn có quyền truy cập vào hệ thống Quản trị (Admin Panel).
                        </p>

                        <a href="/admin"
                           class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold text-lg py-4 px-10 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                            Truy cập Trang Quản Trị
                        </a>

                    @else

                        {{-- Dành cho Khách hàng (khach_hang) --}}
                        <p class="text-lg text-gray-700 mb-8">
                            Cảm ơn bạn đã tin tưởng dịch vụ của Sanvemaybay.vn.
                        </p>
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('home') }}"
                               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                                Về Trang Chủ
                            </a>
                            <a href="{{ route('order.history') }}"
                               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg">
                                Kiểm Tra Đơn Hàng
                            </a>
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
