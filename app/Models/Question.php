<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Question Model.
 *
 * Following Clean Code principles:
 * - Descriptive constants for magic strings
 * - Type declarations
 * - Business logic methods
 */
class Question extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TYPE_MULTIPLE_CHOICE = 'múltipla escolha';

    protected $fillable = [
        'form_id',
        'text',
        'type',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    /**
     * Get the form this question belongs to.
     */
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Get all alternatives for this question.
     */
    public function alternatives(): HasMany
    {
        return $this->hasMany(Alternative::class);
    }

    /**
     * Get the correct alternative for this question.
     */
    public function correctAlternative(): ?Alternative
    {
        return $this->alternatives()->where('is_correct', true)->first();
    }

    /**
     * Check if this is a multiple choice question.
     */
    public function isMultipleChoice(): bool
    {
        return self::TYPE_MULTIPLE_CHOICE === $this->type;
    }

    /**
     * Get the total number of alternatives for this question.
     */
    public function getAlternativesCount(): int
    {
        return $this->alternatives()->count();
    }

    /**
     * Check if the question has any alternatives.
     */
    public function hasAlternatives(): bool
    {
        return $this->getAlternativesCount() > 0;
    }

    /**
     * Check if an alternative ID is valid for this question.
     */
    public function hasAlternative(int $alternativeId): bool
    {
        return $this->alternatives()->where('id', $alternativeId)->exists();
    }
}
