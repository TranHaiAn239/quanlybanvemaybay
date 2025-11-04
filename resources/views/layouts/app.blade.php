<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>

    <footer class="bg-gray-900 text-gray-400 pt-16 pb-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="px-4 mb-12">
                <img src="/images/logo-airline.jpg"
                    alt="Các đối tác hàng không"
                    class="w-full h-auto">
            </div>

            <div class="text-center border-t border-gray-700 pt-8 mb-8 px-4">
                <h5 class="font-semibold text-white mb-2 text-lg">Công Ty Cổ Phần Đầu Tư Công Nghệ GeekTek</h5>
                <p class="text-sm">Địa chỉ: 47A Lê Trung Tấn, Khu Phố 5, P.Tân Sơn Nhì, TP.HCM - MST: 0310318039</p>
                <p class="text-sm">Tel: 1900 2690 - 02871 065 065 (8h - 21h) - Email: info@sanvemaybay.vn</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-sm px-4 mb-12">

                <div>
                    <h6 class="font-semibold text-white mb-2">Chi nhánh Quận 1</h6>
                    <p>96C Nguyễn Du, P.Bến Thành, Quận 1, TP.HCM</p>
                    <p>Tel: 1900 2690 - 02871 065 065 - 0898 400 254</p>
                    <p>Giờ làm việc: 08:30 - 21:00</p>
                </div>

                <div>
                    <h6 class="font-semibold text-white mb-2">Chi nhánh Gò Vấp</h6>
                    <p>59 Quang Trung, P.10, Q.Gò Vấp, TP.HCM</p>
                    <p>Tel: 1900 2690 - 02871 065 065 - 0898 400 254</p>
                    <p>Giờ làm việc: 09:00 - 19:00</p>
                </div>

                <div>
                    <h6 class="font-semibold text-white mb-2">Chi nhánh Hà Nội</h6>
                    <p>414 Xã Đàn, Phường Nam Đồng, Quận Đống Đa, Hà Nội</p>
                    <p>Tel: 1900 2690 - 02871 065 065 - 0903 415 264</p>
                    <p>Giờ làm việc: 08:30 - 21:00</p>
                </div>

                <div>
                    <h6 class="font-semibold text-white mb-2">Chi nhánh Đồng Tháp</h6>
                    <p>21 Đường Số 4 (KDC P.6), P.6, Cao Lãnh, Đồng Tháp</p>
                    <p>Tel: 1900 2690 - 02871 065 065 - 0898 400 254</p>
                    <p>Giờ làm việc: 08:30 - 21:00</p>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-6 text-center text-sm">
                <p>&copy; {{ date('Y') }} Bản quyền thuộc về banvemaybay.vn.</p>
            </div>
        </div>
    </footer>
</html>
