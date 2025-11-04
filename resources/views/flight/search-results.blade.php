<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{--
              Khởi tạo Alpine.js
              selectedDeparture: Lưu ID chuyến đi
              selectedReturn: Lưu ID chuyến về
            --}}
            <div x-data="{
                selectedDeparture: null,
                selectedReturn: null,
                isRoundTrip: {{ $isRoundTrip ? 'true' : 'false' }}
            }">

                <div class="flex flex-col lg:flex-row lg:space-x-6">

                    <div class="w-full lg:w-1/2">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <div class="bg-gray-800 text-white p-4">
                                <h2 class="text-2xl font-semibold">
                                    <i class="fas fa-plane-departure"></i> CHUYẾN ĐI
                                </h2>
                                {{-- Thêm thông tin ngày/chặng --}}
                            </div>

                            <div class="p-4 space-y-4">
                                @forelse ($chuyenBaysDi as $chuyenBay)
                                    <div class="border border-gray-200 rounded-lg p-3"
                                         :class="{ 'border-2 border-blue-500 bg-blue-50': selectedDeparture == {{ $chuyenBay->id }} }">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="font-bold text-lg">{{ $chuyenBay->thoi_gian_di->format('H:i') }} - {{ $chuyenBay->thoi_gian_den->format('H:i') }}</div>
                                                <div class="text-sm text-gray-600">{{ $chuyenBay->mayBay->hang_hang_khong ?? 'Hãng Bay' }}</div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xl font-bold text-red-600">{{ number_format($chuyenBay->gia_ve, 0, ',', '.') }} VND</div>
                                                <button
                                                    @click="selectedDeparture = {{ $chuyenBay->id }}"
                                                    class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-1 px-4 rounded mt-1">
                                                    Chọn
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-700 text-center p-4">Không tìm thấy chuyến bay đi.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    @if ($isRoundTrip)
                    <div class="w-full lg:w-1/2 mt-6 lg:mt-0">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <div class="bg-gray-800 text-white p-4">
                                <h2 class="text-2xl font-semibold">
                                    <i class="fas fa-plane-arrival"></i> CHUYẾN VỀ
                                </h2>
                            </div>

                            <div class="p-4 space-y-4">
                                @forelse ($chuyenBaysVe as $chuyenBay)
                                    <div class="border border-gray-200 rounded-lg p-3"
                                         :class="{ 'border-2 border-blue-500 bg-blue-50': selectedReturn == {{ $chuyenBay->id }} }">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="font-bold text-lg">{{ $chuyenBay->thoi_gian_di->format('H:i') }} - {{ $chuyenBay->thoi_gian_den->format('H:i') }}</div>
                                                <div class="text-sm text-gray-600">{{ $chuyenBay->mayBay->hang_hang_khong ?? 'Hãng Bay' }}</div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xl font-bold text-red-600">{{ number_format($chuyenBay->gia_ve, 0, ',', '.') }} VND</div>
                                                <button
                                                    @click="selectedReturn = {{ $chuyenBay->id }}"
                                                    class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-1 px-4 rounded mt-1">
                                                    Chọn
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-700 text-center p-4">Không tìm thấy chuyến bay về.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-8 text-center">
                    {{--
                      Nút này sẽ được kích hoạt (enabled) khi:
                      1. (isRoundTrip LÀ FALSE) VÀ (selectedDeparture CÓ GIÁ TRỊ)
                      HOẶC
                      2. (isRoundTrip LÀ TRUE) VÀ (cả selectedDeparture VÀ selectedReturn CÓ GIÁ TRỊ)
                    --}}
                    <a x-bind:href="isRoundTrip ?
                            '{{ route('booking.create') }}?departure_id=' + selectedDeparture + '&return_id=' + selectedReturn + '&nguoi_lon={{ $input['nguoi_lon'] ?? 1 }}&tre_em={{ $input['tre_em'] ?? 0 }}&em_be={{ $input['em_be'] ?? 0 }}' :
                            '{{ route('booking.create') }}?departure_id=' + selectedDeparture + '&nguoi_lon={{ $input['nguoi_lon'] ?? 1 }}&tre_em={{ $input['tre_em'] ?? 0 }}&em_be={{ $input['em_be'] ?? 0 }}'"
                       class="bg-red-600 text-white font-bold text-2xl py-3 px-10 rounded-lg shadow-lg"
                       :class="{ 'opacity-50 cursor-not-allowed': (!selectedDeparture) || (isRoundTrip && !selectedReturn) }"
                       :disabled="(!selectedDeparture) || (isRoundTrip && !selectedReturn)">
                        TIẾP TỤC
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
