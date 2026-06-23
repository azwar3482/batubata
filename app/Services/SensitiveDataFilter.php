<?php

namespace App\Services;

class SensitiveDataFilter
{
    // Patterns for sensitive data
    private static array $patterns = [
        // Religion keywords
        '/\b(islam|kristen|katolik|hindu|budha|konghucu|protestan|muslim|nasrani|yahudi)\b/i',
        // Ethnicity keywords  
        '/\b(jawa|sunda|batak|minang|bugis|madura|betawi|dayak|asmat|papua|bali|aceh|makassar|toraja|sasak|flores)\b/i',
        // Marital status
        '/\b(kawin|menikah|belum menikah|cerai|janda|duda|single|married|divorced)\b/i',
        // Political affiliation
        '/\b(pkb|gerindra|pdip|golkar|nasdem|demokrat|pan|ppp|psi|perindo|hanura|pks|garuda|berkarya|pkpi)\b/i',
        // Health conditions
        '/\b(hiv|aids|hepatitis|tbc|diabetes|kanker|asma|cacat|difabel|disabilitas)\b/i',
        // Blood type (already handled separately, but filter from CV too)
        '/\b(gol\.?\s*darah|blood\s*type)\s*[:.]?\s*(A|B|AB|O)[\s\+]?\b/i',
    ];

    // Replacement patterns for structured data
    private static array $structuredPatterns = [
        // NIK (Indonesian ID number - 16 digits)
        '/\b\d{6}(0[1-9]|[12]\d|3[01])(0[1-9]|1[0-2])\d{5}\d{4}\b/',
        // Phone numbers
        '/\b(\+62|62|0)[\s-]?\d{2,4}[\s-]?\d{3,4}[\s-]?\d{3,4}\b/',
        // Bank account numbers (common patterns)
        '/\b\d{10,16}\b(?=.*(?:bank|rekening|account))/i',
    ];

    /**
     * Filter sensitive data from CV text
     */
    public static function filter(string $text): string
    {
        $filtered = $text;

        // Replace sensitive categories with [REDACTED]
        foreach (self::$patterns as $pattern) {
            $filtered = preg_replace($pattern, '[DATA SENSITIF DIHAPUS]', $filtered);
        }

        // Replace structured sensitive data
        foreach (self::$structuredPatterns as $pattern) {
            $filtered = preg_replace($pattern, '[DATA SENSITIF DIHAPUS]', $filtered);
        }

        // Clean up multiple consecutive redactions
        $filtered = preg_replace('/(\[DATA SENSITIF DIHAPUS\]\s*){2,}/', '[DATA SENSITIF DIHAPUS] ', $filtered);

        return $filtered;
    }

    /**
     * Check if text contains sensitive data
     */
    public static function containsSensitiveData(string $text): array
    {
        $found = [];

        foreach (self::$patterns as $index => $pattern) {
            if (preg_match($pattern, $text)) {
                $categories = ['agama', 'suku', 'status_perkawinan', 'orientasi_politik', 'kesehatan', 'golongan_darah'];
                $found[] = $categories[$index] ?? 'unknown';
            }
        }

        return array_unique($found);
    }
}
