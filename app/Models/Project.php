<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'tech_stack',
        'github_url',
        'live_url',
        'is_featured',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'tech_stack'  => 'array',
        'is_featured' => 'boolean',
    ];

    // ── Relasi ────────────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeOwned($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOnline($query)
    {
        return $query->where('status', 'online');
    }

    // ── Auto slug ─────────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });

        static::updating(function (Project $project) {
            if ($project->isDirty('title') && ! $project->isDirty('slug')) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'online'      => 'success',
            'offline'     => 'danger',
            'development' => 'warning',
            default       => 'secondary',
        };
    }
}
