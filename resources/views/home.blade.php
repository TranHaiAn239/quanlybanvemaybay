<x-app-layout>

{{-- Hiển thị thông báo thành công (nếu có) --}}
    @if (session('payment_success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
             class="fixed top-20 right-5 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg z-50"
             role="alert">
            <strong class="font-bold">Thành công!</strong>
            <span class="block sm:inline">{{ session('payment_success') }}</span>
        </div>

        {{-- Tự động quay về trang chủ sau 5s (nếu bạn muốn trang tự F5) --}}
        {{-- <script>
            setTimeout(function() {
                window.location.href = "{{ route('home') }}";
            }, 5000);
        </script> --}}
    @endif

    <div class="w-full bg-cover bg-center py-16"
         style="background-image: url('/images/background-san-ve-may-bay.jpg');">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:space-x-8">

                <div class="w-full md:w-[45%]">

                    {{-- Form tìm kiếm với nền tối --}}
                    <div class="bg-gray-800 bg-opacity-80 rounded-lg shadow-2xl overflow-hidden">

                        {{-- Header của Form --}}
                        <div class="bg-gray-900 bg-opacity-70 text-white p-4">
                            <h4 class="text-lg font-bold uppercase flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path clip-rule="evenodd" fill-rule="evenodd" d="M19.122 4.06a.75.75 0 00-.773-.59H1.65a.75.75 0 00-.773.59c-.067.319-.028.647.11.932l2.67 5.51a.75.75 0 00.686.42h11.21l-3.235-2.07a.75.75 0 010-1.118l3.235-2.07zM1.08 10.998c.022.012.043.025.065.037l2.67 5.51c.138.285.421.455.736.455h11.21l-3.235-2.07a.75.75 0 010-1.118l3.235-2.07c.022.012.043.025.065.037a.75.75 0 01.35 1.018l-2.67 5.51a.75.75 0 01-1.372 0l-3.235-2.07a.75.75 0 00-1.022 1.118l3.235 2.07a.75.75 0 01-1.372 0l-3.235-2.07a.75.75 0 00-1.022 1.118l3.235 2.07a.75.75 0 01-1.372 0L2.11 12.016a.75.75 0 01.35-1.018z"></path></svg>
                                ĐẶT VÉ MÁY BAY ONLINE
                            </h4>
                        </div>

                        {{-- Nội dung Form --}}
                        <div class="p-6">

                            <div class="flex items-center space-x-6 mb-5">
                                <label class="flex items-center text-white cursor-pointer">
                                    <input type="radio" name="flight_type" value="roundtrip" class="form-radio text-blue-500 h-5 w-5" checked>
                                    <span class="ml-2 text-lg">Khứ hồi</span>
                                </label>
                                <label class="flex items-center text-white cursor-pointer">
                                    <input type="radio" name="flight_type" value="oneway" class="form-radio text-blue-500 h-5 w-5">
                                    <span class="ml-2 text-lg">Một chiều</span>
                                </label>
                            </div>

                            <form action="{{ route('flight.search') }}" method="GET">

                                {{-- Điểm đi --}}
                                <div class="mb-4">
                                    <select class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-lg p-3"
                                            id="san_bay_di" name="id_san_bay_di" required>
                                        <option value="">Chọn điểm xuất phát</option>
                                        @foreach($sanBays as $sanBay)
                                            <option value="{{ $sanBay->id }}">{{ $sanBay->ten_san_bay }} ({{ $sanBay->ma_san_bay }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Điểm đến --}}
                                <div class="mb-4">
                                    <select class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-lg p-3"
                                            id="san_bay_den" name="id_san_bay_den" required>
                                        <option value="">Chọn điểm đến</option>
                                        @foreach($sanBays as $sanBay)
                                            <option value="{{ $sanBay->id }}">{{ $sanBay->ten_san_bay }} ({{ $sanBay->ma_san_bay }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex flex-col sm:flex-row sm:space-x-4 mb-4">
                                    <div class="w-full sm:w-1/2 mb-4 sm:mb-0">
                                        <label for="ngay_di" class="block font-medium text-sm text-gray-300 mb-1">Ngày đi:</label>
                                        <input type="date" class="block w-full rounded-md border-gray-300 shadow-sm p-3" id="ngay_di" name="ngay_di" required>
                                    </div>
                                    <div class="w-full sm:w-1/2">
                                        <label for="ngay_ve" class="block font-medium text-sm text-gray-300 mb-1">Ngày về:</label>
                                        <input type="date" class="block w-full rounded-md border-gray-300 shadow-sm p-3" id="ngay_ve" name="ngay_ve">
                                    </div>
                                </div>

                                <div class="flex space-x-4 mb-6">
                                    <div class="w-1/3">
                                        <label for="nguoi_lon" class="block font-medium text-sm text-gray-300 mb-1">Người lớn</label>
                                        <select class="block w-full rounded-md border-gray-300 shadow-sm p-3" id="nguoi_lon" name="nguoi_lon">
                                            <option>1</option><option>2</option><option>3</option><option>4</option>
                                        </select>
                                    </div>
                                    <div class="w-1/3">
                                        <label for="tre_em" class="block font-medium text-sm text-gray-300 mb-1">Trẻ em</label>
                                        <select class="block w-full rounded-md border-gray-300 shadow-sm p-3" id="tre_em" name="tre_em">
                                            <option>0</option><option>1</option><option>2</option>
                                        </select>
                                    </div>
                                    <div class="w-1/3">
                                        <label for="em_be" class="block font-medium text-sm text-gray-300 mb-1">Em bé</label>
                                        <select class="block w-full rounded-md border-gray-300 shadow-sm p-3" id="em_be" name="em_be">
                                            <option>0</option><option>1</option><option>2</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Nút Tìm Kiếm --}}
                                <div class="mt-5">
                                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg text-lg uppercase shadow-lg">
                                        TÌM KIẾM VÉ
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-[55%] mt-12 md:mt-0 text-white md:pl-8">

                    <div class="swiper phone-slider mb-6 h-96">

                        <div class="swiper-wrapper">

                            <div class="swiper-slide flex justify-center items-center">
                                <img src="/images/app-ve-web.jpg" alt="App screenshot" class="h-80 object-contain drop-shadow-lg">
                            </div>

                            <div class="swiper-slide flex justify-center items-center">
                                <img src="/images/baseus-ve-web.jpg" alt="App screenshot 2" class="h-80 object-contain drop-shadow-lg">
                            </div>

                            </div>

                        <div class="swiper-pagination"></div>
                    </div>

                    <h2 class="text-4xl font-bold text-white text-center md:text-left" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                        Sanvemaybay.vn
                    </h2>

                    <p class="mt-4 text-gray-100 text-base leading-relaxed bg-black bg-opacity-30 p-4 rounded-lg shadow-inner">
                        Hệ thống săn vé máy bay giá rẻ Vietjet, Vietnam Airlines, Bamboo, Pacific, Vietravel.
                        Tìm vé đặt vé máy bay online, tìm vé rẻ nhất hệ thống, so sánh giá vé từ hơn
                        200 hãng hàng không quốc tế và nội địa. Hình thức thanh toán linh hoạt qua internet
                        banking, Visa, Master. Đặt vé máy bay online - Giao vé tận nhà. Đội ngũ booker
                        chuyên nghiệp, tận tâm phục vụ, uy tín, chu đáo, hỗ trợ 24/7.
                    </p>

                </div>
            </div>
        </div>
    </div>


    <div class="bg-white py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Dùng Grid 3 cột cho desktop, 1 cột cho mobile --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

                <div class="flex flex-col items-center p-4">
                    {{-- Icon máy bay (từ Heroicons) --}}
                    <svg class="w-12 h-12 text-red-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.875L6 12z" />
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-800">Luôn có vé máy bay giá rẻ</h4>
                </div>

                <div class="flex flex-col items-center p-4">
                    {{-- Icon Thẻ (từ Heroicons) --}}
                    <svg class="w-12 h-12 text-red-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h6m3-3.75l-3 3m0 0l-3-3m3 3V15m6-1.5l3 3m0 0l3-3m-3 3V15m-6 0h6m-6 6h6m-6-3h6m0 0v3m0 0v3m0-3h3m-3 0h-3m-3-3h3m3 0h3m3 0h3m-3 0h3" />
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-800">Đặt vé tiện lợi, thanh toán dễ dàng</h4>
                </div>

                <div class="flex flex-col items-center p-4">
                    {{-- Icon Điện thoại (từ Heroicons) --}}
                    <svg class="w-12 h-12 text-red-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-800">Hỗ trợ 24/7</h4>
                </div>

            </div>
        </div>
    </div>

    <div class="bg-gray-50 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Đây là ảnh bạn đã cắt và lưu ở Bước 1 --}}
            <a href="#">
                <img src="/images/datvefirstimage.jpg"
                    alt="Đặt vé máy bay giá tốt mỗi ngày, book ngay 1900.2690"
                    class="w-full h-auto rounded-lg shadow-lg hover:opacity-90 transition-opacity">
            </a>
        </div>
    </div>


    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h3 class="text-3xl font-semibold text-gray-800 text-center mb-10">
                Đối Tác Hàng Không
            </h3>

            <div class="flex flex-wrap justify-center items-center gap-x-12 gap-y-8 px-6">

                <img src="/images/logos/dv-bamboo-airways.png"
                    alt="Vietnam Airlines"
                    class="h-22 w-auto object-contain transition-all duration-300 ">

                <img src="/images/logos/dv-pacific-airlines.png"
                    alt="Vietjet Air"
                    class="h-20 w-auto object-contain transition-all duration-300 ">

                <img src="/images/logos/dv-vietjet-air.png"
                    alt="Pacific Airlines"
                    class="h-22 w-auto object-contain transition-all duration-300 ">

                <img src="/images/logos/dv-vietnam-airlines.png"
                    alt="Bamboo Airways"
                    class="h-24 w-auto object-contain transition-all duration-300 ">

                <img src="/images/logos/dv-vietravel-airlines.png"
                    alt="Vietravel Airlines"
                    class="h-22 w-auto object-contain transition-all duration-300 ">

            </div>
        </div>
    </div>


    <div class="bg-gray-50 py-16">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <h3 class="text-3xl font-semibold text-gray-800 text-center mb-10">
                Câu Hỏi Thường Gặp
            </h3>

            {{--
            Đây là nơi Alpine.js hoạt động:
            - x-data="{ openQuestion: 0 }" : Khai báo 1 biến 'openQuestion', ban đầu = 0 (không mở câu nào)
            --}}
            <div class="space-y-4" x-data="{ openQuestion: 0 }">

                @isset($faqs)
                    @forelse($faqs as $faq)
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200">

                        {{--
                        Đây là tiêu đề CÂU HỎI (Click được)
                        - @click="..." : Khi click, nó sẽ gán 'openQuestion' = số thứ tự của câu hỏi.
                        - Nếu câu hỏi đang mở (ví dụ 1), click lại nó sẽ gán = 0 (đóng lại)
                        --}}
                        <button
                            type="button"
                            class="flex justify-between items-center w-full px-6 py-4 text-left"
                            @click="openQuestion = (openQuestion === {{ $loop->iteration }} ? 0 : {{ $loop->iteration }})">

                            <span class="text-lg font-medium text-gray-800">
                                {{ $loop->iteration }} - {{ $faq->tieu_de }}
                            </span>

                            {{-- Icon mũi tên (tự động xoay) --}}
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300"
                                :class="{ '-rotate-180': openQuestion === {{ $loop->iteration }} }"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{--
                        Đây là nội dung CÂU TRẢ LỜI
                        - x-show="openQuestion === {{ $loop->iteration }}" : Chỉ hiển thị khi 'openQuestion' = số thứ tự
                        - x-transition : Thêm hiệu ứng trượt (slide) mượt mà
                        --}}
                        <div
                            class="px-6 pb-4 text-gray-700"
                            x-show="openQuestion === {{ $loop->iteration }}"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2">

                            {{-- Dùng {!! ... !!} để hiển thị HTML (nếu câu trả lời có định dạng) --}}
                            {!! $faq->noi_dung !!}
                        </div>
                    </div>

                    @empty
                    <div class="bg-white rounded-lg shadow-md p-6 text-center">
                        <p>Chưa có câu hỏi thường gặp nào.</p>
                    </div>
                    @endforelse
                @endisset

            </div>
        </div>
    </div>


    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-3xl font-semibold text-gray-800 border-b border-gray-300 pb-3 mb-6">TIN TỨC MỚI</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @isset($tinTuc)
                    @forelse($tinTuc as $baiViet)
                    {{-- Card tin tức viết bằng Tailwind --}}
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
                        <div>
                            <img src="{{ $baiViet->hinh_anh_dai_dien ? Storage::url($baiViet->hinh_anh_dai_dien) : 'https://via.placeholder.com/400x250' }}"
                                alt="{{ $baiViet->tieu_de }}" class="w-full h-56 object-cover">
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h5 class="text-xl font-bold text-gray-900 mb-3">{{ $baiViet->tieu_de }}</h5>
                            <p class="text-gray-700 text-sm mb-4 flex-grow">{{ $baiViet->mo_ta_ngan }}</p>
                            <a href="{{ route('news.show', $baiViet->slug) }}" class="text-blue-600 hover:text-blue-800 font-semibold self-start">
                                Xem chi tiết &rarr;
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 bg-white rounded-lg shadow-md p-6">
                        <p>Chưa có tin tức nào.</p>
                    </div>
                    @endforelse
                @endisset
            </div>
        </div>
    </div>

</x-app-layout>
