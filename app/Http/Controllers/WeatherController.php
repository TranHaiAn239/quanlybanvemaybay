<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public static function getWeather($city)
    {
        // Dùng Cache để tránh gọi API quá nhiều (60 phút)
        return Cache::remember("weather_{$city}", 3600, function () use ($city) {
            $apiKey = '1f590b09189fd403abc0e8ad92074e33'; // <-- DÁN API KEY CỦA BẠN VÀO ĐÂY (Lấy từ OpenWeatherMap)
            // Nếu chưa có key, dùng key test tạm thời này (nhưng nên dùng key của bạn):
            // 4669701558d949968e563231210310 (Ví dụ)

            try {
                $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                    'q' => $city,
                    'appid' => $apiKey,
                    'units' => 'metric',
                    'lang' => 'vi'
                ]);
                return $response->json();
            } catch (\Exception $e) {
                return null; // Tránh lỗi crash trang nếu mất mạng
            }
        });
    }
}
