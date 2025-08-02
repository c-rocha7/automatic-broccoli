<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Alternative Model.
 *
 * Following Clean Code principles:
 * - Clear method names that express intent
 * - Type declarations
 * - Business logic encapsulation
 */
class Alternative extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'question_id',
        'text',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Get the question this alternative belongs to.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Check if this alternative is the correct answer.
     */
    public function isCorrect(): bool
    {
        return $this->is_correct;
    }

    /**
     * Check if this alternative is incorrect.
     */
    public function isIncorrect(): bool
    {
        return !$this->is_correct;
    }

    /**
     * Mark this alternative as correct.
     */
    public function markAsCorrect(): void
    {
        $this->update(['is_correct' => true]);
    }

    /**
     * Mark this alternative as incorrect.
     */
    public function markAsIncorrect(): void
    {
        $this->update(['is_correct' => false]);
    }

    /**
     * Scope to get only correct alternatives.
     */
    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    /**
     * Scope to get only incorrect alternatives.
     */
    public function scopeIncorrect($query)
    {
        return $query->where('is_correct', false);
    }
}
