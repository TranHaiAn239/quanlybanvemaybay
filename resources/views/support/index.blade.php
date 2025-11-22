<x-app-layout>
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{--
              Khởi tạo Alpine.js
              'activeTab' sẽ lưu tab đang được chọn (mặc định là 'lien-he')
            --}}
            <div x-data="{ activeTab: 'lien-he' }" class="flex flex-col md:flex-row md:space-x-8">

                <div class="w-full md:w-1/5 mb-8 md:mb-0">
                    <div class="space-y-4">

                        {{-- Nút Liên Hệ --}}
                        <button
                            @click="activeTab = 'lien-he'"
                            :class="{ 'bg-blue-800 scale-105': activeTab === 'lien-he', 'bg-blue-600 hover:bg-blue-700': activeTab !== 'lien-he' }"
                            class="w-full text-left text-white font-semibold text-lg px-8 py-4 rounded-full shadow-lg transform transition-all">
                            Liên hệ
                        </button>

                        {{-- Nút Hoàn đổi vé --}}
                        <button
                            @click="activeTab = 'hoan-doi-ve'"
                            :class="{ 'bg-blue-800 scale-105': activeTab === 'hoan-doi-ve', 'bg-blue-600 hover:bg-blue-700': activeTab !== 'hoan-doi-ve' }"
                            class="w-full text-left text-white font-semibold text-lg px-8 py-4 rounded-full shadow-lg transform transition-all">
                            Hoàn đổi vé
                        </button>

                        {{-- Nút Thủ tục sân bay --}}
                        <button
                            @click="activeTab = 'thu-tuc-san-bay'"
                            :class="{ 'bg-blue-800 scale-105': activeTab === 'thu-tuc-san-bay', 'bg-blue-600 hover:bg-blue-700': activeTab !== 'thu-tuc-san-bay' }"
                            class="w-full text-left text-white font-semibold text-lg px-8 py-4 rounded-full shadow-lg transform transition-all">
                            Thủ tục sân bay
                        </button>

                        {{-- Nút Điều khoản --}}
                        <button
                            @click="activeTab = 'dieu-khoan'"
                            :class="{ 'bg-blue-800 scale-105': activeTab === 'dieu-khoan', 'bg-blue-600 hover:bg-blue-700': activeTab !== 'dieu-khoan' }"
                            class="w-full text-left text-white font-semibold text-lg px-8 py-4 rounded-full shadow-lg transform transition-all">
                            Điều khoản sử dụng
                        </button>

                        {{-- Nút Chính sách --}}
                        <button
                            @click="activeTab = 'chinh-sach'"
                            :class="{ 'bg-blue-800 scale-105': activeTab === 'chinh-sach', 'bg-blue-600 hover:bg-blue-700': activeTab !== 'chinh-sach' }"
                            class="w-full text-left text-white font-semibold text-lg px-8 py-4 rounded-full shadow-lg transform transition-all">
                            Chính sách bảo mật
                        </button>
                    </div>
                </div>

                <div class="w-full md:w-4/5">
                    {{--
                      Các khối div này dùng x-show.
                      Nó sẽ chỉ hiển thị khi 'activeTab' khớp với tên.
                    --}}
                    {{-- ===== BẮT ĐẦU TAB LIÊN HỆ (ĐÃ CẬP NHẬT) ===== --}}
                    <div x-show="activeTab === 'lien-he'" x-transition
                        class="bg-white rounded-3xl p-10 md:p-16 min-h-[500px] shadow-lg border">

                        <h2 class="text-3xl font-bold text-gray-900 mb-4">
                            LIÊN HỆ VỚI <span class="text-red-500">SANVEMAYBAY.VN</span>
                        </h2>

                        <div class="prose prose-lg max-w-none text-gray-700 mb-8">
                            <p>
                                Thắc mắc về phương thức thanh toán, đặt vé online hoặc khiếu nại. Vui lòng điền đầy đủ thông tin vào form dưới đây.
                            </p>
                        </div>

                        <form action="{{ route('support.store') }}" method="POST" class="space-y-6">
                            @csrf
                            {{-- Lấy ID người dùng nếu đã đăng nhập --}}
                            @auth
                            <input type="hidden" name="id_nguoi_dung" value="{{ Auth::id() }}">
                            @endauth

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Mã Booking --}}
                                <div>
                                    <label for="ma_booking" class="block text-sm font-medium text-gray-700">Mã Booking (Nếu có)</label>
                                    <input type="text" id="ma_booking" name="ma_booking"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="VD: VMBXYZ123">
                                </div>

                                {{-- Loại Yêu Cầu --}}
                                <div>
                                    <label for="loai_yeu_cau" class="block text-sm font-medium text-gray-700">Loại Yêu Cầu</label>
                                    <select id="loai_yeu_cau" name="loai_yeu_cau" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="huy_ve">Yêu cầu Hủy vé</option>
                                        <option value="hoan_tien">Yêu cầu Hoàn tiền</option>
                                        <option value="thong_tin">Yêu cầu Thông tin</option>
                                        <option value="khac">Khác</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                {{-- Họ tên --}}
                                <div>
                                    <label for="ho_ten" class="block text-sm font-medium text-gray-700">Họ Tên <span class="text-red-500">*</span></label>
                                    <input type="text" id="ho_ten" name="ho_ten" required
                                        value="{{ Auth::user()->ho_ten ?? '' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                {{-- Email --}}
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                    <input type="email" id="email" name="email" required
                                        value="{{ Auth::user()->email ?? '' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                {{-- Số điện thoại --}}
                                <div>
                                    <label for="so_dien_thoai" class="block text-sm font-medium text-gray-700">SĐT</label>
                                    <input type="tel" id="so_dien_thoai" name="so_dien_thoai"
                                        value="{{ Auth::user()->so_dien_thoai ?? '' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>

                            {{-- Nội dung chi tiết --}}
                            <div>
                                <label for="noi_dung_yeu_cau" class="block text-sm font-medium text-gray-700">Nội dung chi tiết <span class="text-red-500">*</span></label>
                                <textarea id="noi_dung_yeu_cau" name="noi_dung_yeu_cau" rows="4" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg shadow-md">
                                    Gửi Yêu Cầu Hỗ Trợ
                                </button>
                            </div>

                            {{-- Hiển thị thông báo sau khi gửi --}}
                            @if (session('support_success'))
                            <div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                                {{ session('support_success') }}
                            </div>
                            @endif
                        </form>

                        <div class="border-t border-gray-200 pt-8">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Liên Hệ Sanvemaybay.vn</h3>

                            {{-- Dùng Grid để chia cột chi nhánh --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-gray-700">

                                <div>
                                    <h4 class="text-xl font-bold text-red-500 mb-2">Chi nhánh Quận 1</h4>
                                    <p>109 Nguyễn Thị Minh Khai, P.Bến Thành, Quận 1, TP.HCM</p>
                                    <p>Email: info@sanvemaybay.vn</p>
                                    <p>Tel: 1900 2690 - 02871 065 065 - 0898 400 254</p>
                                </div>

                                <div>
                                    <h4 class="text-xl font-bold text-red-500 mb-2">Chi nhánh Quận 3</h4>
                                    <p>232-234 Cách Mạng Tháng 8, Phường 10, Quận 3, TP.HCM</p>
                                    <p>Tel: 1900 2690 - 02871 065 065 - 0909 421 005</p>
                                </div>

                                <div>
                                    <h4 class="text-xl font-bold text-red-500 mb-2">Chi nhánh Gò Vấp</h4>
                                    <p>55A Quang Trung, Phường 10, Quận Gò Vấp, TP.HCM</p>
                                    <p>Tel: 1900 2690 - 02871 065 065 - 0899 400 254</p>
                                </div>

                                <div>
                                    <h4 class="text-xl font-bold text-red-500 mb-2">Chi nhánh Tân Bình</h4>
                                    <p>114B Hoàng Hoa Thám, Phường 12, Quận Tân Bình, TP.HCM</p>
                                    <p>Tel: 1900 2690 - 02871 065 065 - 0932 110 336</p>
                                </div>

                                <div>
                                    <h4 class="text-xl font-bold text-red-500 mb-2">Chi nhánh Tân Phú</h4>
                                    <p>47A Lê Trọng Tấn, P.Sơn Kỳ, Q.Tân Phú, TP.HCM</p>
                                    <p>Tel: 1900 2690 - 02871 065 065 - 0903 413 264</p>
                                </div>

                                <div>
                                    <h4 class="text-xl font-bold text-red-500 mb-2">Chi nhánh Hà Nội</h4>
                                    <p>414 Xã Đàn, Phường Nam Đồng, Quận Đống Đa, Hà Nội</p>
                                    <p>Tel: 1900 2690 - 02871 065 065 - 0903 413 264</p>
                                </div>

                                <div>
                                    <h4 class="text-xl font-bold text-red-500 mb-2">Chi nhánh Đồng Tháp</h4>
                                    <p>76 Tôn Đức Thắng, P.1, TP.Cao Lãnh, Đồng Tháp</p>
                                    <p>Tel: 1900 2690 - 02871 065 065 - 0899 400 254</p>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- ===== KẾT THÚC TAB LIÊN HỆ ===== --}}

                    {{-- ===== BẮT ĐẦU TAB HOÀN ĐỔI VÉ (ĐÃ CẬP NHẬT) ===== --}}
                    <div x-show="activeTab === 'hoan-doi-ve'" x-transition
                        class="bg-white rounded-3xl p-10 md:p-16 min-h-[500px] shadow-lg border">

                        <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-4">
                            Chính sách đổi trả và hoàn tiền
                        </h2>

                        {{-- Dùng class 'prose' của Tailwind để tự động định dạng văn bản --}}
                        <div class="prose prose-lg max-w-none text-gray-700">
                            <p>
                                Người sử dụng có thể mua vé máy bay theo hình thức "đặt chỗ", cho bản thân Người sử dụng hoặc cho một bên thứ ba khi:
                            </p>
                            <ul>
                                <li>Người sử dụng có đủ năng lực để thực hiện và chịu trách nhiệm về các hành vi của mình;</li>
                                <li>Người sử dụng cung cấp thông tin thật về cá nhân hoặc về hành khách (bên thứ ba);</li>
                                <li>Người sử dụng hoặc hành khách có đầy đủ giấy tờ hợp pháp phục vụ cho việc đi lại;</li>
                            </ul>
                            <p>
                                Người sử dụng sử dụng thẻ tín dụng mà bản thân Người sử dụng là chủ sở hữu hoặc được sự cho phép của chủ sở hữu để thực hiện việc thanh toán vé máy bay. Người sử dụng hiểu rằng, việc sử dụng thẻ tín dụng giả hoặc lấy trộm là hành vi vi phạm Bộ Luật Hình sự.
                            </p>
                            <p>
                                Sanvemaybay.vn thực hiện việc xuất vé máy bay sau khi đã nhận được đầy đủ các khoản thanh toán từ Người sử dụng trong giờ làm việc của sanvemaybay.vn và phù hợp với các quy định trong Điều khoản sử dụng. Phụ thuộc vào hình thức thanh toán và trong một số trường hợp nhất định, Sanvemaybay.vn có thể thực hiện việc xuất vé ngoài giờ làm việc.
                            </p>
                            <p>
                                Sanvemaybay.vn sẽ gửi vé máy bay điện tử tới Người sử dụng qua email và SMS trong ngày mà vé điện tử được xuất. Chúng tôi không chịu trách nhiệm về việc Người sử dụng không nhận được vé điện tử do Người sử dụng cung cấp địa chỉ email sai hay số điện thoại sai. Trong trường hợp không nhận được vé máy bay, Người sử dụng nên kiểm tra lại các chương trình chống virus, chống spam xem các chương trình đó có ngăn cản việc nhận vé máy bay không hoặc liên hệ với chúng tôi.
                            </p>

                            <h3 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Huỷ vé máy bay và các dịch vụ khác</h3>
                            <ul>
                                <li>
                                    Người sử dụng chấp thuận rằng các hãng hàng không có thể hủy chuyến bay mặc dù đã bán vé cho hành khách vì lý do kỹ thuật, an toàn, an ninh hay các lý do bất khả kháng. Chúng tôi sẽ ngay lập tức thông báo cho khách hàng ngay sau khi nhận được thông báo từ các hãng hàng không về việc hủy vé, hủy chuyến và giải pháp đề xuất của hãng hàng không.
                                </li>
                                <li>
                                    Điều kiện hoàn/hủy vé sẽ được thực hiện theo qui định của hãng hàng không. Chúng tôi có trách nhiệm hoàn trả khách hàng khoản tiền hoàn lại từ hãng hàng không ngay sau khi nhận được từ hãng hàng không nhưng không có nghĩa vụ và trách nhiệm phải hoàn lại khoản phí dịch vụ mà khách hàng đã trả cho chúng tôi.
                                </li>
                                <li>
                                    Khách hàng đã mua vé nhưng vì lý do cá nhân không muốn tiếp tục hành trình mà muốn thay đổi hành trình hoặc hoàn vé đối với hành trình đã mua, khách hàng sẽ phải chịu các khoản phí, phụ phí, chênh lệch giá liên quan tới việc hoàn/thay đổi hành trình theo qui định của các hãng hàng không áp dụng đối với loại vé mà khách hàng đã mua và chúng tôi không có trách nhiệm phải hoàn lại phí dịch vụ khách hàng đã trả cho chúng tôi.
                                </li>
                                <li>
                                    Khách hàng đã mua vé nhưng không thực hiện hành trình mà muốn đổi tên cho bạn bè hay người thân, tùy theo qui định của các hãng hàng không, chúng tôi sẽ hỗ trợ khách hàng trong việc đổi tên nếu được phép với điều kiện khách hàng phải thanh toán các khoản phí đổi tên theo qui định của các hãng hàng không.
                                </li>
                                <li>
                                    Các hãng hàng không có thể thay đổi giờ bay sớm hoặc muộn hơn so với giờ bay đã định, chi tiết ký hiệu chuyến bay vì lý do kỹ thuật hay an ninh hàng không, trong trường hợp này khách hàng sẽ nhận được tin nhắn từ các hãng hàng không đối với các thay đổi đó theo số điện thoại đã đăng ký khi mua vé máy bay. Mặc dù vậy, chúng tôi cũng thông tin ngay tới khách hàng các thay đổi này ngay sau khi nhận được thông báo từ các hãng hàng không và chúng tôi hoàn toàn được miễn trừ mọi trách nhiệm đối với việc thay đổi giờ bay.
                                </li>
                            </ul>
                        </div>
                    </div>
                    {{-- ===== KẾT THÚC TAB HOÀN ĐỔI VÉ ===== --}}

                    {{-- ===== BẮT ĐẦU TAB THỦ TỤC SÂN BAY (MỚI) ===== --}}
                        <div x-show="activeTab === 'thu-tuc-san-bay'" x-transition
                            class="bg-white rounded-3xl p-10 md:p-16 min-h-[500px] shadow-lg border">

                            <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-4">
                                Thủ Tục Sân Bay Cần Biết
                            </h2>

                            <div class="prose prose-lg max-w-none text-gray-700">
                                <p>
                                    Để có một chuyến bay thuận lợi, Quý khách vui lòng lưu ý các thủ tục sân bay quan trọng sau đây. Việc chuẩn bị kỹ lưỡng sẽ giúp Quý khách tiết kiệm thời gian và tránh các rắc rối không đáng có.
                                </p>

                                <h3 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">1. Làm thủ tục (Check-in)</h3>
                                <ul>
                                    <li>
                                        <strong>Quầy thủ tục:</strong> Quý khách nên có mặt tại sân bay trước giờ khởi hành ít nhất 2 tiếng (đối với chuyến bay nội địa) và 3 tiếng (đối với chuyến bay quốc tế) để làm thủ tục. Quầy check-in thường đóng 40 phút trước giờ bay.
                                    </li>
                                    <li>
                                        <strong>Check-in trực tuyến (Online):</strong> Hầu hết các hãng hàng không đều cho phép check-in trực tuyến 24 tiếng trước giờ bay. Điều này giúp bạn tiết kiệm thời gian xếp hàng và được chọn chỗ ngồi trước.
                                    </li>
                                </ul>

                                <h3 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">2. Hành lý</h3>
                                <ul>
                                    <li>
                                        <strong>Hành lý xách tay:</strong> Phải tuân thủ đúng quy định về trọng lượng (thường là 7kg) và kích thước. Quá cước xách tay tại cửa khởi hành sẽ bị tính phí rất cao hoặc phải chuyển sang hành lý ký gửi.
                                    </li>
                                    <li>
                                        <strong>Hành lý ký gửi:</strong> Phải được đóng gói cẩn thận. Không để các vật dụng có giá trị (tiền, trang sức, laptop) hoặc vật cấm (pin sạc dự phòng) trong hành lý ký gửi.
                                    </li>
                                </ul>

                                <h3 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">3. An ninh soi chiếu</h3>
                                <ul>
                                    <li>
                                        Tháo bỏ tất cả các vật dụng kim loại (thắt lưng, đồng hồ, chìa khóa) và áo khoác, đặt vào khay soi chiếu.
                                    </li>
                                    <li>
                                        Chất lỏng (nước hoa, mỹ phẩm) mang theo trong hành lý xách tay không được vượt quá 100ml mỗi chai/lọ và phải được đựng trong túi nhựa trong suốt.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {{-- ===== KẾT THÚC TAB THỦ TỤC SÂN BAY ===== --}}

                        {{-- ===== BẮT ĐẦU TAB ĐIỀU KHOẢN (MỚI) ===== --}}
                            <div x-show="activeTab === 'dieu-khoan'" x-transition
                                class="bg-white rounded-3xl p-10 md:p-16 min-h-[500px] shadow-lg border">

                                <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-4">
                                    Điều Khoản Sử Dụng
                                </h2>

                                <div class="prose prose-lg max-w-none text-gray-700">
                                    <p>
                                        Vui lòng đọc kỹ các Điều khoản và Điều kiện này trước khi sử dụng dịch vụ đặt vé máy bay trực tuyến tại Sanvemaybay.vn. Bằng việc truy cập và sử dụng website, bạn đồng ý tuân thủ các điều khoản dưới đây.
                                    </p>

                                    <h3 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Điều 1: Chấp nhận điều khoản</h3>
                                    <p>
                                        Bằng việc truy cập và sử dụng website này, Người sử dụng (bạn) đồng ý với tất cả các điều khoản, điều kiện, và thông báo trong Thỏa thuận sử dụng này mà không có bất kỳ sửa đổi hay giới hạn nào.
                                    </p>

                                    <h3 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Điều 2: Nghĩa vụ của Người sử dụng</h3>
                                    <p>
                                        Bạn cam kết cung cấp thông tin chính xác, đầy đủ và trung thực khi thực hiện các giao dịch đặt vé. Bạn chịu hoàn toàn trách nhiệm về tính chính xác của thông tin hành khách (Họ tên, ngày sinh, giấy tờ tùy thân).
                                    </p>
                                    <p>
                                        Bạn có trách nhiệm tự bảo mật mã đặt chỗ (PNR) và các thông tin vé. Mọi giao dịch phát sinh từ việc lộ thông tin này sẽ do bạn chịu trách nhiệm.
                                    </p>

                                    <h3 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">Điều 3: Miễn trừ trách nhiệm</h3>
                                    <p>
                                        Chúng tôi không chịu trách nhiệm trong các trường hợp bất khả kháng (thiên tai, đình công, chiến tranh, sự cố kỹ thuật từ phía hãng hàng không) dẫn đến việc thay đổi hoặc hủy chuyến bay. Chúng tôi sẽ cố gắng hỗ trợ khách hàng trong phạm vi cho phép, dựa trên chính sách của hãng hàng không.
                                    </p>
                                </div>
                            </div>
                            {{-- ===== KẾT THÚC TAB ĐIỀU KHOẢN ===== --}}

                            {{-- ===== BẮT ĐẦU TAB CHÍNH SÁCH BẢO MẬT (MỚI) ===== --}}
                            <div x-show="activeTab === 'chinh-sach'" x-transition
                                class="bg-white rounded-3xl p-10 md:p-16 min-h-[500px] shadow-lg border">

                                <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-4">
                                    Chính Sách Bảo Mật Thông Tin
                                </h2>

                                <div class="prose prose-lg max-w-none text-gray-700">
                                    <p>
                                        Sanvemaybay.vn cam kết bảo vệ thông tin cá nhân của Quý khách. Chính sách này mô tả cách chúng tôi thu thập, sử dụng và bảo vệ dữ liệu của bạn khi bạn sử dụng dịch vụ của chúng tôi.
                                    </p>

                                    <h3 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">1. Mục đích thu thập thông tin</h3>
                                    <p>
                                        Chúng tôi thu thập thông tin cá nhân của bạn (như họ tên, email, số điện thoại, ngày sinh, thông tin hộ chiếu/CCCD) cho các mục đích sau:
                                    </p>
                                    <ul>
                                        <li>Xử lý đặt chỗ và xuất vé máy bay với các hãng hàng không.</li>
                                        <li>Cung cấp hỗ trợ khách hàng và xử lý các yêu cầu (hoàn, hủy, đổi vé).</li>
                                        <li>Gửi thông tin xác nhận vé và các thông báo thay đổi chuyến bay.</li>
                                        <li>Gửi các thông tin khuyến mãi (nếu bạn đồng ý nhận).</li>
                                    </ul>

                                    <h3 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">2. Phạm vi sử dụng thông tin</h3>
                                    <p>
                                        Thông tin của bạn chỉ được sử dụng trong nội bộ công ty để phục vụ các mục đích đã nêu. Chúng tôi bắt buộc phải chia sẻ thông tin của bạn cho các bên thứ ba là các Hãng hàng không để hoàn tất việc đặt vé cho bạn. Ngoài ra, chúng tôi không cung cấp thông tin của bạn cho bất kỳ bên nào khác trừ khi có yêu cầu từ cơ quan pháp luật.
                                    </p>

                                    <h3 class="text-2xl font-semibold text-gray-800 mt-10 mb-4">3. Bảo mật thông tin</h3>
                                    <p>
                                        Chúng tôi áp dụng các công nghệ bảo mật tiên tiến (như SSL - Secure Sockets Layer) để mã hóa thông tin thanh toán và dữ liệu cá nhân của bạn. Dữ liệu được lưu trữ trên máy chủ được bảo vệ an toàn.
                                    </p>
                                </div>
                            </div>
                            {{-- ===== KẾT THÚC TAB CHÍNH SÁCH BẢO MẬT ===== --}}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
