<?php

declare(strict_types=1);

namespace App\Models;

use App\ValueObjects\Score;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * FormResponse Model.
 *
 * Following Clean Code principles:
 * - Descriptive method names
 * - Business logic encapsulation
 * - Type declarations
 */
class FormResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'user_id',
        'submitted_at',
        'form_data',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'form_data'    => 'array',
    ];

    /**
     * Get the form this response belongs to.
     */
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Get the user who submitted this response.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all answers for this form response.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(ResponseAnswer::class);
    }

    /**
     * Get the form title from stored data.
     */
    public function getFormTitle(): string
    {
        return $this->form_data['title'] ?? 'Formulário excluído';
    }

    /**
     * Get the form description from stored data.
     */
    public function getFormDescription(): string
    {
        return $this->form_data['description'] ?? '';
    }

    /**
     * Get the total number of answers.
     */
    public function getAnswersCount(): int
    {
        return $this->answers()->count();
    }

    /**
     * Get the number of correct answers.
     */
    public function getCorrectAnswersCount(): int
    {
        return $this->answers()->where('is_correct', true)->count();
    }

    /**
     * Get the number of incorrect answers.
     */
    public function getIncorrectAnswersCount(): int
    {
        return $this->answers()->where('is_correct', false)->count();
    }

    /**
     * Get the score as a value object.
     */
    public function getScore(): Score
    {
        return new Score(
            $this->getCorrectAnswersCount(),
            $this->getAnswersCount()
        );
    }

    /**
     * Calculate the score percentage.
     *
     * @deprecated Use getScore()->getPercentage() instead
     */
    public function getScorePercentage(): float
    {
        return $this->getScore()->getPercentage();
    }

    /**
     * Check if all answers are correct.
     *
     * @deprecated Use getScore()->isPerfect() instead
     */
    public function isPerfectScore(): bool
    {
        return $this->getScore()->isPerfect();
    }

    /**
     * Scope to get responses from a specific date.
     */
    public function scopeSubmittedOnDate($query, $date)
    {
        return $query->whereDate('submitted_at', $date);
    }

    /**
     * Scope to get responses from a specific user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
