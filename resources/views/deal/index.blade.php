<x-app-layout>

    {{-- Tôi dùng lại ảnh nền bầu trời ở trang chủ, bạn có thể đổi nếu muốn --}}
    <div class="w-full bg-cover bg-center py-16"
         style="background-image: url('/images/background-san-ve-may-bay.jpg');">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:space-x-8 justify-center">

                <div class="w-full md:w-2/5 bg-white bg-opacity-95 rounded-lg shadow-xl p-8 h-auto flex flex-col justify-center mb-6 md:mb-0">
                    <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Tìm khuyến mãi</h2>

                    {{-- Form tìm kiếm --}}
                    <form action="{{ route('deal.index') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="month" class="block text-sm font-medium text-gray-700">Tháng</label>
                                <select name="month" id="month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @for ($m = 1; $m <= 12; $m++)
                                        {{-- Giữ lại tháng đã chọn --}}
                                        <option value="{{ $m }}" {{ $input['month'] == $m ? 'selected' : '' }}>Tháng {{ $m }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700">Năm</label>
                                <select name="year" id="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @php $currentYear = now()->year; @endphp
                                    {{-- Giữ lại năm đã chọn --}}
                                    <option value="{{ $currentYear }}" {{ $input['year'] == $currentYear ? 'selected' : '' }}>{{ $currentYear }}</option>
                                    <option value="{{ $currentYear + 1 }}" {{ $input['year'] == $currentYear + 1 ? 'selected' : '' }}>{{ $currentYear + 1 }}</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg">
                            Tìm kiếm
                        </button>
                    </form>
                </div>

                <div class="w-full md:w-3/5 bg-white bg-opacity-95 rounded-lg shadow-xl p-8 h-auto max-h-[400px] flex flex-col">
                    <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">
                        Khuyến mãi Tháng {{ $input['month'] }}/{{ $input['year'] }}
                    </h2>

                    {{-- Khu vực hiển thị kết quả (scroll) --}}
                    <div class="space-y-4 flex-grow overflow-y-auto pr-2">
                        @forelse ($khuyenMais as $km)
                            <div class="border border-gray-200 rounded-lg p-4 shadow-sm">
                                <h4 class="text-lg font-bold text-blue-600">{{ $km->ma_khuyen_mai }}</h4>
                                <p class="text-sm text-gray-700 mt-1">{{ $km->mo_ta }}</p>
                                <p class="text-sm text-gray-500 mt-2">
                                    <span class="font-medium">Giá trị:</span> {{ $km->gia_tri }} ({{ $km->loai_gia_tri }})
                                    <br>
                                    <span class="font-medium">Hiệu lực:</span>
                                    {{ \Carbon\Carbon::parse($km->ngay_bat_dau)->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::parse($km->ngay_ket_thuc)->format('d/m/Y') }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-600 text-center py-10">
                                Không tìm thấy khuyến mãi nào đang hoạt động trong tháng đã chọn.
                            </p>
                        @endforelse
                    </div>

                    {{-- Link phân trang --}}
                    <div class="mt-4 border-t pt-4">
                        {{-- appends() giữ lại param (month/year) khi chuyển trang --}}
                        {{ $khuyenMais->appends(request()->query())->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden p-8 md:p-12">

                <h2 class="text-3xl font-bold text-gray-900 mb-6">
                    Kinh nghiệm săn vé máy bay giá rẻ
                </h2>

                {{-- Class "prose" của Tailwind sẽ tự động làm đẹp văn bản --}}
                <div class="prose prose-lg max-w-none text-gray-700 space-y-4">
                    <p>
                        Cập nhật thường xuyên các chương trình khuyến mãi từ các hãng hàng không. Đi vào những mùa thấp điểm thường không nên đi vào những ngày lễ, tết vì khi đó giá vé sẽ rất cao. Ngoài ra các chương trình khuyến mãi của các hãng hàng không vào những tháng sau: tháng 3, 4, 5, 9, 10, 11 có vé máy bay khuyến mãi 99K của Vietjet, Jetstar. Chương trình khủng khoảng 299K của Vietnamairlines (Đối với các chặng bay xuất phát từ Sài Gòn).
                    </p>
                    <p>
                        Vé máy bay giá rẻ từ hãng Vietnam Airlines, Vietjet Air, Jetstar và Bamboo Airways đều thường xuyên được tung ra các chương trình khuyến mãi hấp dẫn như: “Đón thu quyến rũ” của Vietnam Airlines, “12h rồi Vietjet thôi” của Vietjet Air, “3 tiếng mỗi ngày – thỏa ước mơ bay” của Jetstar, “Chào thứ 4, Bamboo vỗ tay” của Bamboo Airways…
                    </p>
                </div>

                <h3 class="text-2xl font-semibold text-gray-900 mt-10 mb-5">
                    Bảng tổng hợp khuyến mãi
                </h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Hãng hàng không</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Chương trình khuyến mãi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Khuyến mãi nổi bật</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Thời gian chương trình</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">Vietnam Airlines</td>
                                <td class="px-6 py-4">Thứ 5 rực rỡ</td>
                                <td class="px-6 py-4">Giảm 50% giá vé các chặng bay nội địa</td>
                                <td class="px-6 py-4">Thứ 5 hàng tuần. Thường diễn ra từ 1 – 2 lần/tháng</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">VietJet Air</td>
                                <td class="px-6 py-4">12h rồi, Vietjet thôi!</td>
                                <td class="px-6 py-4">Săn vé máy bay giá rẻ 0đ</td>
                                <td class="px-6 py-4">Diễn ra khoảng vài tháng một lần, mỗi đợt chỉ kéo dài khoảng 3-5 ngày, vào khung 12h-14h</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">Pacific Airlines</td>
                                <td class="px-6 py-4">Ba tiếng mỗi ngày, thỏa ước mơ bay</td>
                                <td class="px-6 py-4">Săn vé máy bay chỉ từ 11k</td>
                                <td class="px-6 py-4">Diễn ra vào khung giờ 11h – 14h hàng ngày</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">Bamboo Airways</td>
                                <td class="px-6 py-4">Chào thứ 4, Bamboo vỗ tay</td>
                                <td class="px-6 py-4">Sở hữu vé máy bay chỉ từ 99k</td>
                                <td class="px-6 py-4">Áp dụng săn vé máy bay giá rẻ cả chặng nội địa và quốc tế vào thứ 4 theo một số giai đoạn nhất định. Giá khuyến mãi chỉ từ 99.000đ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
