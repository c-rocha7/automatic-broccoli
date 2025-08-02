<?php

declare(strict_types=1);

namespace App\ValueObjects;

/**
 * Score Value Object.
 *
 * Following DDD principles and Clean Code:
 * - Immutable value object
 * - Self-contained validation
 * - Expressive methods
 */
readonly class Score
{
    public function __construct(
        private int $correctAnswers,
        private int $totalAnswers,
    ) {
        $this->validateInputs();
    }

    /**
     * Get the percentage score.
     */
    public function getPercentage(): float
    {
        if (0 === $this->totalAnswers) {
            return 0.0;
        }

        return ($this->correctAnswers / $this->totalAnswers) * 100;
    }

    /**
     * Get the number of correct answers.
     */
    public function getCorrectAnswers(): int
    {
        return $this->correctAnswers;
    }

    /**
     * Get the total number of answers.
     */
    public function getTotalAnswers(): int
    {
        return $this->totalAnswers;
    }

    /**
     * Get the number of incorrect answers.
     */
    public function getIncorrectAnswers(): int
    {
        return $this->totalAnswers - $this->correctAnswers;
    }

    /**
     * Check if this is a perfect score.
     */
    public function isPerfect(): bool
    {
        return 100.0 === $this->getPercentage();
    }

    /**
     * Check if this is a failing score (less than 60%).
     */
    public function isFailure(): bool
    {
        return $this->getPercentage() < 60.0;
    }

    /**
     * Get a letter grade based on percentage.
     */
    public function getLetterGrade(): string
    {
        $percentage = $this->getPercentage();

        return match (true) {
            $percentage >= 90 => 'A',
            $percentage >= 80 => 'B',
            $percentage >= 70 => 'C',
            $percentage >= 60 => 'D',
            default           => 'F',
        };
    }

    /**
     * Convert to string representation.
     */
    public function toString(): string
    {
        return sprintf(
            '%d/%d (%.1f%%)',
            $this->correctAnswers,
            $this->totalAnswers,
            $this->getPercentage()
        );
    }

    /**
     * Validate constructor inputs.
     */
    private function validateInputs(): void
    {
        if ($this->correctAnswers < 0) {
            throw new \InvalidArgumentException('Correct answers cannot be negative');
        }

        if ($this->totalAnswers < 0) {
            throw new \InvalidArgumentException('Total answers cannot be negative');
        }

        if ($this->correctAnswers > $this->totalAnswers) {
            throw new \InvalidArgumentException('Correct answers cannot exceed total answers');
        }
    }
}
