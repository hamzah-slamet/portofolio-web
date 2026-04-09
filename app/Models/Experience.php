<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position',
        'company',
        'company_type',
        'location',
        'description',
        'start_date',
        'end_date',
        'is_current',
        'skills',
        'sort_order',
    ];

    protected $casts = [
        'skills'     => 'array',
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_current' => 'boolean',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('is_current')
                     ->orderByDesc('start_date');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    /**
     * Hitung durasi: "2 thn 3 bln", "10 bln", dsb.
     */
    public function getDurationAttribute(): string
    {
        $start = $this->start_date;
        $end   = $this->is_current ? now() : ($this->end_date ?? now());

        $totalMonths = $start->diffInMonths($end);
        $years       = intdiv($totalMonths, 12);
        $months      = $totalMonths % 12;

        $parts = [];
        if ($years)  $parts[] = "{$years} thn";
        if ($months) $parts[] = "{$months} bln";

        return implode(' ', $parts) ?: '< 1 bln';
    }

    /**
     * Format periode: "Jan 2023 – Sekarang" atau "Mar 2022 – Des 2022"
     */
    public function getPeriodAttribute(): string
    {
        $start = $this->start_date->translatedFormat('M Y');
        $end   = $this->is_current ? 'Sekarang' : ($this->end_date?->translatedFormat('M Y') ?? 'Sekarang');
        return "{$start} – {$end}";
    }

    /**
     * Array skills yang aman (tidak null)
     */
    public function getSkillsListAttribute(): array
    {
        return $this->skills ?? [];
    }
}
