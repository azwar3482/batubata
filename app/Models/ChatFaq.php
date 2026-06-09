<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatFaq extends Model
{
    protected $fillable = [
        'question', 'answer', 'category', 'roles',
        'keywords', 'deep_links', 'priority', 'is_active',
    ];

    protected $casts = [
        'roles' => 'array',
        'keywords' => 'array',
        'deep_links' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForRole($query, string $role)
    {
        return $query->where(function ($q) use ($role) {
            $q->whereNull('roles')
              ->orWhereJsonContains('roles', $role);
        });
    }

    public function scopeByCategory($query, ?string $category)
    {
        if ($category) {
            return $query->where('category', $category);
        }
        return $query;
    }

    public function scopeByPriority($query)
    {
        return $query->orderBy('priority', 'desc');
    }

    /**
     * Cari FAQ berdasarkan pertanyaan user
     */
    public static function searchFaq(string $query, string $role): ?self
    {
        $queryLower = strtolower($query);
        $queryWords = array_filter(explode(' ', $queryLower), fn($w) => strlen($w) > 2);

        $faqs = self::active()
            ->forRole($role)
            ->byPriority()
            ->get();

        $bestMatch = null;
        $bestScore = 0;

        foreach ($faqs as $faq) {
            $score = 0;

            // Exact match di question
            if (strtolower($faq->question) === $queryLower) {
                $score += 100;
            }

            // Partial match di question
            if (str_contains(strtolower($faq->question), $queryLower)) {
                $score += 50;
            }

            // Keyword match
            if ($faq->keywords) {
                foreach ($faq->keywords as $keyword) {
                    if (str_contains($queryLower, strtolower($keyword))) {
                        $score += 20;
                    }
                }
            }

            // Word match di question
            foreach ($queryWords as $word) {
                if (str_contains(strtolower($faq->question), $word)) {
                    $score += 5;
                }
                if (str_contains(strtolower($faq->answer), $word)) {
                    $score += 2;
                }
            }

            // Bonus priority
            $score += $faq->priority;

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $faq;
            }
        }

        // Minimum threshold
        return $bestScore >= 15 ? $bestMatch : null;
    }
}
