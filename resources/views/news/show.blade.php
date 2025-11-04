<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">

                @if ($baiViet->hinh_anh_dai_dien)
                    <img src="{{ $baiViet->hinh_anh_dai_dien }}"
                         alt="{{ $baiViet->tieu_de }}"
                         class="w-full h-96 object-cover">
                @endif

                <div class="p-6 md:p-10">

                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ $baiViet->tieu_de }}
                    </h1>

                    <div class="text-sm text-gray-600 mb-6 border-b pb-4">
                        Đăng ngày: {{ $baiViet->ngay_xuat_ban ? $baiViet->ngay_xuat_ban->format('d/m/Y') : $baiViet->ngay_tao->format('d/m/Y') }}
                    </div>

                    {{--
                      Dùng {!! !!} để render HTML (ví dụ: xuống dòng, in đậm)
                      từ trình soạn thảo văn bản trong trang admin.
                    --}}
                    <div class="prose prose-lg max-w-none">
                        {!! $baiViet->noi_dung !!}
                    </div>

                    <div class="mt-10 border-t pt-6">
                        <a href="{{ route('news.index') }}"
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            &larr; Quay lại danh sách tin tức
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
