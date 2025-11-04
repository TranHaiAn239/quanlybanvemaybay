import './bootstrap';

// ===== BẮT ĐẦU CODE THÊM MỚI =====

// 1. Import các module cốt lõi của Swiper
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

// 2. Import CSS của Swiper
import 'swiper/css';
import 'swiper/css/pagination'; // CSS cho dấu chấm tròn (pagination)
import 'swiper/css/autoplay';    // CSS cho autoplay (nếu cần)

// 3. Khởi tạo Swiper khi trang đã tải xong
document.addEventListener('DOMContentLoaded', () => {
    // Kiểm tra xem có phần tử .phone-slider trên trang không
    if (document.querySelector('.phone-slider')) {

        const swiper = new Swiper('.phone-slider', {
            // Sử dụng các module đã import
            modules: [Pagination, Autoplay],

            // Cấu hình
            loop: true,         // Lặp lại vô hạn
            slidesPerView: 1,   // Chỉ hiện 1 slide
            spaceBetween: 30,   // Khoảng cách giữa các slide

            // Tự động chạy
            autoplay: {
                delay: 3000, // 3 giây
                disableOnInteraction: false, // Không dừng khi người dùng tương tác
            },

            // Dấu chấm tròn (pagination)
            pagination: {
                el: '.swiper-pagination', // Chỉ định phần tử pagination
                clickable: true,          // Cho phép click vào dấu chấm
            },
        });
    }
});

// ===== KẾT THÚC CODE THÊM MỚI =====

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
