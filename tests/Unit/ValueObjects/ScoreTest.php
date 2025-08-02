<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\Score;
use PHPUnit\Framework\TestCase;

/**
 * Score Value Object Tests.
 *
 * Following Clean Code principles in tests:
 * - Descriptive test names
 * - Clear arrange-act-assert structure
 * - One concept per test
 */
class ScoreTest extends TestCase
{
    /** @test */
    public function itCalculatesPercentageCorrectlyWithValidInputs(): void
    {
        // Arrange
        $correctAnswers = 8;
        $totalAnswers   = 10;

        // Act
        $score = new Score($correctAnswers, $totalAnswers);

        // Assert
        $this->assertEquals(80.0, $score->getPercentage());
    }

    /** @test */
    public function itReturnsZeroPercentageWhenTotalAnswersIsZero(): void
    {
        // Arrange
        $correctAnswers = 0;
        $totalAnswers   = 0;

        // Act
        $score = new Score($correctAnswers, $totalAnswers);

        // Assert
        $this->assertEquals(0.0, $score->getPercentage());
    }

    /** @test */
    public function itIdentifiesPerfectScoreCorrectly(): void
    {
        // Arrange
        $correctAnswers = 10;
        $totalAnswers   = 10;

        // Act
        $score = new Score($correctAnswers, $totalAnswers);

        // Assert
        $this->assertTrue($score->isPerfect());
    }

    /** @test */
    public function itIdentifiesNonPerfectScoreCorrectly(): void
    {
        // Arrange
        $correctAnswers = 9;
        $totalAnswers   = 10;

        // Act
        $score = new Score($correctAnswers, $totalAnswers);

        // Assert
        $this->assertFalse($score->isPerfect());
    }

    /** @test */
    public function itCalculatesIncorrectAnswersCorrectly(): void
    {
        // Arrange
        $correctAnswers = 7;
        $totalAnswers   = 10;

        // Act
        $score = new Score($correctAnswers, $totalAnswers);

        // Assert
        $this->assertEquals(3, $score->getIncorrectAnswers());
    }

    /** @test */
    public function itAssignsLetterGradesCorrectly(): void
    {
        // Test cases: [correct, total, expected_grade]
        $testCases = [
            [10, 10, 'A'], // 100%
            [9, 10, 'A'],  // 90%
            [8, 10, 'B'],  // 80%
            [7, 10, 'C'],  // 70%
            [6, 10, 'D'],  // 60%
            [5, 10, 'F'],  // 50%
        ];

        foreach ($testCases as [$correct, $total, $expectedGrade]) {
            // Arrange & Act
            $score = new Score($correct, $total);

            // Assert
            $this->assertEquals(
                $expectedGrade,
                $score->getLetterGrade(),
                "Failed for score {$correct}/{$total}"
            );
        }
    }

    /** @test */
    public function itThrowsExceptionForNegativeCorrectAnswers(): void
    {
        // Arrange & Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Correct answers cannot be negative');

        // Act
        new Score(-1, 10);
    }

    /** @test */
    public function itThrowsExceptionForNegativeTotalAnswers(): void
    {
        // Arrange & Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Total answers cannot be negative');

        // Act
        new Score(5, -1);
    }

    /** @test */
    public function itThrowsExceptionWhenCorrectExceedsTotal(): void
    {
        // Arrange & Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Correct answers cannot exceed total answers');

        // Act
        new Score(11, 10);
    }

    /** @test */
    public function itGeneratesStringRepresentationCorrectly(): void
    {
        // Arrange
        $score = new Score(8, 10);

        // Act
        $stringRepresentation = $score->toString();

        // Assert
        $this->assertEquals('8/10 (80.0%)', $stringRepresentation);
    }

    /** @test */
    public function itIdentifiesFailureCorrectly(): void
    {
        // Arrange - 50% is below 60% threshold
        $score = new Score(5, 10);

        // Act & Assert
        $this->assertTrue($score->isFailure());
    }

    /** @test */
    public function itIdentifiesPassingScoreCorrectly(): void
    {
        // Arrange - 70% is above 60% threshold
        $score = new Score(7, 10);

        // Act & Assert
        $this->assertFalse($score->isFailure());
    }
}
