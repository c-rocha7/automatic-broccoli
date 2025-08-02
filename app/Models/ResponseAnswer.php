<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ResponseAnswer Model.
 *
 * Following Clean Code principles:
 * - Clear, intention-revealing method names
 * - Business logic encapsulation
 * - Type declarations
 */
class ResponseAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_response_id',
        'question_text',
        'alternative_text',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Get the form response this answer belongs to.
     */
    public function formResponse(): BelongsTo
    {
        return $this->belongsTo(FormResponse::class);
    }

    /**
     * Check if this answer is correct.
     */
    public function isCorrect(): bool
    {
        return $this->is_correct;
    }

    /**
     * Check if this answer is incorrect.
     */
    public function isIncorrect(): bool
    {
        return !$this->is_correct;
    }

    /**
     * Get the question text.
     */
    public function getQuestionText(): string
    {
        return $this->question_text;
    }

    /**
     * Get the selected alternative text.
     */
    public function getAlternativeText(): string
    {
        return $this->alternative_text;
    }

    /**
     * Scope to get only correct answers.
     */
    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    /**
     * Scope to get only incorrect answers.
     */
    public function scopeIncorrect($query)
    {
        return $query->where('is_correct', false);
    }

    /**
     * Scope to get answers for a specific form response.
     */
    public function scopeForFormResponse($query, $formResponseId)
    {
        return $query->where('form_response_id', $formResponseId);
    }
}
