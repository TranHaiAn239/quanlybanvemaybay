<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:space-x-8">

                <div class="w-full md:w-1/5 mb-8 md:mb-0">
                    <div class="bg-white shadow-lg rounded-lg p-5 sticky top-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Danh Mục</h3>

                        <div class="space-y-3">
                            @foreach ($categories as $category)
                                <a href="{{ route('news.category', $category->slug) }}"
                                   class="block w-full text-center px-4 py-3 rounded-lg font-semibold text-white uppercase shadow transition-colors
                                          {{ $currentCategory && $currentCategory->id == $category->id
                                             ? 'bg-orange-500 hover:bg-orange-600'
                                             : 'bg-blue-600 hover:bg-blue-700'
                                          }}">
                                    {{ $category->ten_danh_muc }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-4/5">
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">

                        <div class="p-6 border-b">
                            <h2 class="text-3xl font-semibold text-gray-800 uppercase">
                                {{ $currentCategory->ten_danh_muc ?? 'Tin Tức' }}
                            </h2>
                        </div>

                        <div class="divide-y divide-gray-200">
                            @forelse ($baiViets as $baiViet)
                                <div class="p-6 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 hover:bg-gray-50">
                                    <div class="w-full md:w-1/3">
                                        <img src="{{ $baiViet->hinh_anh_dai_dien ? Storage::url($baiViet->hinh_anh_dai_dien) : 'https://via.placeholder.com/300x200' }}"
                                            alt="{{ $baiViet->tieu_de }}"
                                            class="w-full h-48 object-cover rounded-lg">
                                    </div>

                                    <div class="w-full md:w-2/3">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                                            <a href="{{ route('news.show', $baiViet->slug) }}" class="hover:text-blue-600">
                                                {{ $baiViet->tieu_de }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-700 text-sm mb-3">
                                            {{ $baiViet->mo_ta_ngan }}
                                        </p>
                                        <a href="{{ route('news.show', $baiViet->slug) }}" class="text-blue-600 font-semibold">
                                            Xem chi tiết &rarr;
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="p-10 text-center">
                                    <p class="text-xl text-gray-700">Chưa có bài viết nào trong danh mục này.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="p-6 bg-gray-50 border-t">
                            {{ $baiViets->links() }}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
