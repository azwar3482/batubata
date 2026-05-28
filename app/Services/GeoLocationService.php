<?php

namespace App\Services;

use App\Models\JobListing;
use App\Models\User;
use Illuminate\Support\Collection;

class GeoLocationService
{
    // Radius bumi dalam kilometer
    const EARTH_RADIUS_KM = 6371;

    /**
     * Hitung jarak antara dua titik koordinat menggunakan Haversine Formula.
     * Rumus ini menghasilkan jarak lengkung di permukaan bola (lebih akurat untuk GPS).
     *
     * @param float $lat1 Latitude titik 1
     * @param float $lon1 Longitude titik 1
     * @param float $lat2 Latitude titik 2
     * @param float $lon2 Longitude titik 2
     * @return float Jarak dalam kilometer
     */
    public function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2)
           + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
           * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round(self::EARTH_RADIUS_KM * $c, 1);
    }

    /**
     * Ambil semua lowongan dalam radius tertentu dari lokasi user.
     * Diurutkan dari yang paling dekat.
     *
     * @param User $user
     * @param int $radiusKm Radius pencarian dalam kilometer
     * @return Collection Koleksi JobListing yang sudah ditambahkan properti 'distance_km'
     */
    public function getNearbyJobs(User $user, int $radiusKm = 50): Collection
    {
        // Jika user belum punya koordinat, kembalikan collection kosong
        if (!$user->latitude || !$user->longitude) {
            return collect();
        }

        // Ambil semua job aktif yang memiliki koordinat (Satu query tunggal - Anti N+1)
        $jobs = JobListing::where('is_active', true)
            ->where('expires_date', '>', now())
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        // Filter dan hitung jarak menggunakan PHP in-memory (menghindari raw SQL yang kompleks)
        return $jobs->map(function (JobListing $job) use ($user) {
                $job->distance_km = $this->calculateDistance(
                    $user->latitude, $user->longitude,
                    $job->latitude, $job->longitude
                );
                return $job;
            })
            ->filter(fn($job) => $job->distance_km <= $radiusKm)
            ->sortBy('distance_km')
            ->values(); // Reset keys setelah filter
    }

    /**
     * Tambahkan informasi jarak ke koleksi jobs yang sudah ada.
     * Berguna untuk menambahkan kolom distance ke hasil pencarian yang sudah ada.
     *
     * @param Collection $jobs
     * @param User $user
     * @return Collection
     */
    public function appendDistanceToJobs(Collection $jobs, User $user): Collection
    {
        if (!$user->latitude || !$user->longitude) {
            return $jobs->map(function ($job) {
                $job->distance_km = null;
                $job->distance_label = 'Lokasi tidak tersedia';
                return $job;
            });
        }

        return $jobs->map(function ($job) use ($user) {
            if ($job->latitude && $job->longitude) {
                $distKm = $this->calculateDistance(
                    $user->latitude, $user->longitude,
                    $job->latitude, $job->longitude
                );
                $job->distance_km = $distKm;
                $job->distance_label = $distKm < 1
                    ? 'Kurang dari 1 km'
                    : number_format($distKm, 1) . ' km dari lokasi Anda';
            } else {
                $job->distance_km = null;
                $job->distance_label = 'Jarak tidak diketahui';
            }
            return $job;
        });
    }

    /**
     * Validasi apakah koordinat GPS valid.
     */
    public function isValidCoordinate(float $lat, float $lon): bool
    {
        return $lat >= -90 && $lat <= 90 && $lon >= -180 && $lon <= 180;
    }
}
