<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Education extends Model
{
    use HasFactory;
     protected $table = 'educations'; // ← wajib ada
    protected $fillable = [
        'user_id',
        'degree',
        'major',
        'institution',
        'institution_type',
        'location',
        'description',
        'gpa',
        'start_date',
        'end_date',
        'is_current',
        'achievements',
        'sort_order',
    ];

    protected $casts = [
        'achievements' => 'array',
        'start_date'   => 'date',
        'end_date'     => 'date',
        'is_current'   => 'boolean',
        'gpa'          => 'float',
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

    /** "2 thn 3 bln" */
    public function getDurationAttribute(): string
    {
        $start       = $this->start_date;
        $end         = $this->is_current ? now() : ($this->end_date ?? now());
        $totalMonths = $start->diffInMonths($end);
        $years       = intdiv($totalMonths, 12);
        $months      = $totalMonths % 12;

        $parts = [];
        if ($years)  $parts[] = "{$years} thn";
        if ($months) $parts[] = "{$months} bln";

        return implode(' ', $parts) ?: '< 1 bln';
    }

    /** "2020 – 2024" atau "2022 – Sekarang" */
    public function getPeriodAttribute(): string
    {
        $start = $this->start_date->format('Y');
        $end   = $this->is_current ? 'Sekarang' : ($this->end_date?->format('Y') ?? 'Sekarang');
        return "{$start} – {$end}";
    }

    /** Tahun lulus atau "Sekarang" */
    public function getGraduationYearAttribute(): string
    {
        return $this->is_current ? 'Sekarang' : ($this->end_date?->format('Y') ?? '-');
    }

    /** Safe array achievements */
    public function getAchievementsListAttribute(): array
    {
        return $this->achievements ?? [];
    }

    /** Label GPA berwarna: 'green' | 'blue' | 'yellow' | 'gray' */
    public function getGpaColorAttribute(): string
    {
        if (!$this->gpa) return 'gray';
        return match(true) {
            $this->gpa >= 3.75 => 'green',
            $this->gpa >= 3.50 => 'blue',
            $this->gpa >= 3.00 => 'yellow',
            default            => 'gray',
        };
    }
}
