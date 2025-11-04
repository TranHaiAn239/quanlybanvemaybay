<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ===== HIỂN THỊ LỖI (NẾU CÓ) ===== --}}
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Lỗi!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Có lỗi xảy ra:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- ===== KẾT THÚC HIỂN THỊ LỖI ===== --}}


            <div x-data="bookingForm()">
                {{-- Form chính --}}
                <form action="{{ route('booking.store') }}" method="POST" @submit.prevent="submitForm">
                    @csrf
                    {{-- Input ẩn sẽ được Alpine.js điền vào --}}
                    <input type="hidden" name="form_data">

                    <input type="hidden" name="id_chuyen_bay_di" value="{{ $departureFlight->id }}">
                    @if($isRoundTrip)
                    <input type="hidden" name="id_chuyen_bay_ve" value="{{ $returnFlight->id }}">
                    @endif

                    <div class="flex flex-col lg:flex-row lg:space-x-8">

                        <div class="w-full lg:w-2/3">
                            <div class="bg-white shadow-lg rounded-lg mb-6 overflow-hidden">
                                <div class="bg-gray-50 p-4 border-b">
                                    <h3 class="text-xl font-semibold text-gray-800">Thông tin hành trình</h3>
                                </div>
                                <div class="p-6 space-y-4">
                                    <h4 class="text-lg font-semibold text-gray-700">Chuyến đi</h4>
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold">Chặng:</span>
                                        <span class="text-gray-700">
                                            {{ $departureFlight->sanBayDi->tinh_thanh }} &rarr; {{ $departureFlight->sanBayDen->tinh_thanh }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold">Thời gian:</span>
                                        <span class="text-gray-700">
                                            {{ $departureFlight->thoi_gian_di->format('H:i d/m/Y') }}
                                        </span>
                                    </div>

                                    @if($isRoundTrip)
                                    <hr class="my-3">
                                    <h4 class="text-lg font-semibold text-gray-700">Chuyến về</h4>
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold">Chặng:</span>
                                        <span class="text-gray-700">
                                            {{ $returnFlight->sanBayDi->tinh_thanh }} &rarr; {{ $returnFlight->sanBayDen->tinh_thanh }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold">Thời gian:</span>
                                        <span class="text-gray-700">
                                            {{ $returnFlight->thoi_gian_di->format('H:i d/m/Y') }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-white shadow-lg rounded-lg mb-6">
                                <div class="bg-gray-50 p-4 border-b">
                                    <h3 class="text-xl font-semibold text-gray-800">Thông tin hành khách</h3>
                                </div>
                                <div class="p-6 space-y-8">
                                    <template x-for="(passenger, index) in passengers" :key="index">
                                        @include('booking.partials.passenger-form', [
                                            'baggage_options' => $baggage_options,
                                        ])
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="w-full lg:w-1/3">
                            <div class="bg-white shadow-lg rounded-lg sticky top-8">
                                <div class="bg-orange-500 text-white p-4 rounded-t-lg">
                                    <h3 class="text-xl font-semibold">THÔNG TIN ĐƠN HÀNG</h3>
                                </div>
                                <div class="p-6 space-y-3">
                                    <div class="flex justify-between text-gray-700">
                                        <span>Giá vé cơ bản</span>
                                        <span class="font-semibold" x-text="formatCurrency(baseFare)"></span>
                                    </div>
                                    <div class="flex justify-between text-gray-700">
                                        <span>Phụ thu ghế</span>
                                        <span class="font-semibold" x-text="formatCurrency(seatFeeTotal)"></span>
                                    </div>
                                    <div class="flex justify-between text-gray-700">
                                        <span>Thuế và phí</span>
                                        <span class="font-semibold" x-text="formatCurrency(tax)"></span>
                                    </div>
                                    <div class="flex justify-between text-gray-700">
                                        <span>Hành lý ký gửi</span>
                                        <span class="font-semibold" x-text="formatCurrency(baggageTotal)"></span>
                                    </div>

                                    <hr class="my-2 border-dashed">

                                    <div class="flex justify-between text-gray-900 font-medium">
                                        <span>Tổng (chưa giảm)</span>
                                        <span x-text="formatCurrency(subTotal)"></span>
                                    </div>

                                    @if ($isRoundTrip)
                                    <div class="flex justify-between text-green-600">
                                        <span class="font-semibold">Giảm giá khứ hồi (40%)</span>
                                        <span class="font-semibold" x-text="'- ' + formatCurrency(roundTripDiscount)"></span>
                                    </div>
                                    @endif

                                    <div x-show="promoDiscount > 0" class="flex justify-between text-green-600">
                                        <span class="font-semibold" x-text="'Giảm giá (' + promoCode + ')'"></span>
                                        <span class="font-semibold" x-text="'- ' + formatCurrency(promoDiscount)"></span>
                                    </div>

                                    <hr class="my-2">

                                    <div class="flex justify-between items-center text-gray-900">
                                        <span class="text-xl font-bold">TỔNG CỘNG</span>
                                        <span class="text-2xl font-bold text-red-600" x-text="formatCurrency(grandTotal)"></span>
                                    </div>
                                </div>

                                <div class="p-6 bg-gray-50 border-t">
                                    <div class="flex space-x-2">
                                        <input type="text" x-model="promoCodeInput" placeholder="Nhập mã khuyến mãi"
                                               class="block w-full rounded-md border-gray-300 shadow-sm"
                                               :disabled="isDiscountApplied">
                                        <button type="button" @click="applyPromoCode"
                                                class="bg-blue-600 text-white px-4 py-2 rounded-md font-semibold"
                                                :disabled="isDiscountApplied">
                                            Áp dụng
                                        </button>
                                    </div>
                                    <p x-show="promoMessage" x-text="promoMessage"
                                       class="text-sm mt-2"
                                       :class="isDiscountApplied ? 'text-green-600' : 'text-red-600'"></p>
                                </div>

                                <div class="p-6 bg-gray-50 rounded-b-lg border-t">
                                    <button type="submit"
                                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg text-lg text-center shadow-lg">
                                        Hoàn Tất Đơn Hàng
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Alpine.js (ĐÃ SỬA LỖI) --}}
    <script>
        // Hàm helper để tìm hoặc tạo input ẩn (nếu cần)
        function findOrCreateInput(form, name) {
            let input = form.querySelector(`input[name="${name}"]`);
            if (!input) {
                input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', name);
                form.appendChild(input);
            }
            return input;
        }

        function bookingForm() {
            return {
                // 1. Dữ liệu gốc
                baseFare: {{ $price_breakdown['tong_tien_ve'] }},
                taxRate: 0.08, // Thuế 8%
                isRoundTrip: {{ $isRoundTrip ? 'true' : 'false' }},

                // 2. Trạng thái hành khách (ĐÃ SỬA LỖI $loop VÀ THÊM TRƯỜNG)
                passengers: [
                    @php $passenger_index = 0; @endphp
                    @for ($i = 0; $i < $passengers['nguoi_lon']; $i++, $passenger_index++)
                        { type: 'nguoi_lon', title: 'Người lớn {{ $i + 1 }}', ho_ten: '', so_dien_thoai: '', email: '', dia_chi: '', ghi_chu: '', baggage_fee: 0, seat_type: 'phổ thông', baggage_enabled: true }{{ ($i < $passengers['nguoi_lon'] - 1) || $passengers['tre_em'] > 0 || $passengers['em_be'] > 0 ? ',' : '' }}
                    @endfor
                    @for ($i = 0; $i < $passengers['tre_em']; $i++, $passenger_index++)
                        { type: 'tre_em', title: 'Trẻ em {{ $i + 1 }}', ho_ten: '', so_dien_thoai: '', email: '', dia_chi: '', ghi_chu: '', baggage_fee: 0, seat_type: 'phổ thông', baggage_enabled: true }{{ ($i < $passengers['tre_em'] - 1) || $passengers['em_be'] > 0 ? ',' : '' }}
                    @endfor
                    @for ($i = 0; $i < $passengers['em_be']; $i++, $passenger_index++)
                        { type: 'em_be', title: 'Em bé {{ $i + 1 }}', ho_ten: '', so_dien_thoai: '', email: '', dia_chi: '', ghi_chu: '', baggage_fee: 0, seat_type: 'phổ thông', baggage_enabled: false }{{ $i < $passengers['em_be'] - 1 ? ',' : '' }}
                    @endfor
                ],

                // 3. Trạng thái khuyến mãi
                promoCodeInput: '',
                promoCode: '',
                promoMessage: '',
                isDiscountApplied: false,
                promoDiscountValue: 0, // % hoặc tiền mặt
                promoDiscountType: 'phan_tram',

                // 4. Các giá trị tính toán (getter của Alpine)
                get seatFeeTotal() {
                    let total = 0;
                    this.passengers.forEach(p => {
                        let base = 0;

                        if (p.type === 'nguoi_lon') {
                            base = {{ $departureFlight->gia_ve }};
                        } else if (p.type === 'tre_em') {
                            base = {{ $departureFlight->gia_ve * 0.75 }};
                        } else if (p.type === 'em_be') {
                            base = {{ $departureFlight->gia_ve * 0.10 }};
                        }

                        // (ĐÃ SỬA LỖI gia_ve on null)
                        @if ($isRoundTrip)
                        if (p.type === 'nguoi_lon') {
                            base += {{ $returnFlight->gia_ve }};
                        } else if (p.type === 'tre_em') {
                            base += {{ $returnFlight->gia_ve * 0.75 }};
                        } else if (p.type === 'em_be') {
                            base += {{ $returnFlight->gia_ve * 0.10 }};
                        }
                        @endif

                        if (p.seat_type === 'thương gia') {
                            total += base * 0.05; // Thêm 5%
                        } else if (p.seat_type === 'hạng nhất') {
                            total += base * 0.10; // Thêm 10%
                        }
                    });
                    return total;
                },
                get baggageTotal() {
                    return this.passengers.reduce((total, p) => total + parseFloat(p.baggage_fee), 0);
                },
                get tax() {
                    return (this.baseFare + this.seatFeeTotal) * this.taxRate;
                },
                get subTotal() {
                    return this.baseFare + this.seatFeeTotal + this.tax + this.baggageTotal;
                },
                get roundTripDiscount() {
                    return this.isRoundTrip ? (this.subTotal * 0.40) : 0;
                },
                get promoDiscount() {
                    if (!this.isDiscountApplied) return 0;
                    let baseForPromo = this.subTotal - this.roundTripDiscount;
                    if (this.promoDiscountType === 'phan_tram') {
                        return baseForPromo * (this.promoDiscountValue / 100);
                    } else {
                        return Math.min(baseForPromo, this.promoDiscountValue);
                    }
                },
                get grandTotal() {
                    let total = this.subTotal - this.roundTripDiscount - this.promoDiscount;
                    return Math.max(0, total); // Đảm bảo tổng tiền không bao giờ âm
                },

                // 5. Hành động (Actions)
                formatCurrency(value) {
                    return new Intl.NumberFormat('vi-VN').format(value) + ' VND';
                },

                // 6. Hàm kiểm tra mã khuyến mãi
                applyPromoCode() {
                    if (!this.promoCodeInput) {
                        this.promoMessage = "Vui lòng nhập mã.";
                        return;
                    }

                    fetch(`/kiem-tra-khuyen-mai/${this.promoCodeInput}`)
                        .then(res => {
                            if (!res.ok) { // Kiểm tra 404/500
                                throw new Error('Network response was not ok');
                            }
                            return res.json();
                        })
                        .then(data => {
                            if (data.success) {
                                this.promoMessage = `Áp dụng thành công: ${data.mo_ta}`;
                                this.isDiscountApplied = true;
                                this.promoCode = data.ma_khuyen_mai;
                                this.promoDiscountValue = data.gia_tri;
                                this.promoDiscountType = data.loai_gia_tri;
                            } else {
                                this.promoMessage = data.message;
                                this.isDiscountApplied = false;
                            }
                        })
                        .catch(err => {
                            this.promoMessage = "Lỗi! Không thể kết nối máy chủ hoặc mã không hợp lệ.";
                        });
                },

                // 7. Hàm GET DATA ĐỂ SUBMIT (MỚI)
                getFormData() {
                    return {
                        passengers_data: this.passengers,
                        promo_code: this.promoCode,
                        promo_discount: this.promoDiscount, // Giá trị đã tính
                        roundtrip_discount: this.roundTripDiscount // Giá trị đã tính
                    };
                },

                // 8. HÀM SUBMIT (ĐÃ SỬA LỖI form_data required)
                submitForm(event) {
                    const form = event.target;

                    // 1. Tìm input ẩn 'form_data'
                    let input = findOrCreateInput(form, 'form_data');

                    // 2. Tự tay gán giá trị JSON mới nhất vào input
                    input.value = JSON.stringify(this.getFormData());

                    // 3. Submit form
                    form.submit();
                }
            }
        }
    </script>
</x-app-layout>
