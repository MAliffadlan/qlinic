<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Rate limiter dinamis anti-spam pendaftaran pasien.
 *
 * Lapis 1: Rate limit per IP (10x per jam)
 * Lapis 2: Rate limit per NIK (1x pendaftaran per jam) — cegah spam 1 NIK sama dari banyak IP
 * Lapis 3: Jeda cooling-off (30 menit setelah berhasil daftar, IP tidak boleh daftar lagi)
 */
class ThrottleRegistration
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();

        // --- Lapis 1: Limit per IP (max 10 request/hari) ---
        $ipCount = Cache::get("reg_rate_ip_{$ip}", 0);
        if ($ipCount >= 10) {
            return response()->json([
                'message' => 'Terlalu banyak percobaan pendaftaran dari IP Anda. Silakan coba lagi besok.'
            ], 429);
        }

        // --- Lapis 2: Limit per NIK (max 1 registrasi aktif/hari) ---
        $nik = $request->input('nik');
        if ($nik && strlen($nik) === 16) {
            $nikKey = "reg_rate_nik_{$nik}";
            if (Cache::has($nikKey)) {
                return back()->withErrors([
                    'nik' => 'NIK ini sudah terdaftar atau baru saja diproses. Silakan gunakan NIK yang benar.'
                ])->onlyInput('nik');
            }
        }

        // --- Lapis 3: Cooling-off setelah sukses ---
        $successKey = "reg_success_ip_{$ip}";
        $lastSuccess = Cache::get($successKey, 0);
        if ($lastSuccess && (now()->timestamp - $lastSuccess) < 1800) { // 30 menit
            return back()->withErrors([
                'nik' => 'Terlalu banyak pendaftaran dalam 30 menit terakhir. Silakan tunggu sebentar.'
            ]);
        }

        // Hit counter IP
        Cache::put("reg_rate_ip_{$ip}", $ipCount + 1, now()->addHour());

        return $next($request);
    }
}
