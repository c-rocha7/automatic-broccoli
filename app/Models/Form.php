<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Form Model.
 *
 * Following Clean Code principles:
 * - Clear, descriptive method names
 * - Type declarations for better code clarity
 * - Separation of concerns with dedicated methods
 */
class Form extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_ACTIVE   = 'ativo';
    public const STATUS_INACTIVE = 'inativo';

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the user who created this form.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all questions for this form.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get all responses for this form.
     */
    public function responses(): HasMany
    {
        return $this->hasMany(FormResponse::class);
    }

    /**
     * Check if the form is active.
     */
    public function isActive(): bool
    {
        return self::STATUS_ACTIVE === $this->status;
    }

    /**
     * Check if the form is inactive.
     */
    public function isInactive(): bool
    {
        return self::STATUS_INACTIVE === $this->status;
    }

    /**
     * Get the total number of questions in this form.
     */
    public function getQuestionsCount(): int
    {
        return $this->questions()->count();
    }

    /**
     * Get the total number of responses for this form.
     */
    public function getResponsesCount(): int
    {
        return $this->responses()->count();
    }

    /**
     * Scope to get only active forms.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope to get only inactive forms.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }
}
