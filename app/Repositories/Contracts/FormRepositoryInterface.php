<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Form;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface for Form Repository.
 *
 * Following DIP (Dependency Inversion Principle):
 * High-level modules should depend on abstractions, not concretions
 */
interface FormRepositoryInterface
{
    /**
     * Get all active forms with their questions and alternatives.
     *
     * @return Collection<Form>
     */
    public function getActiveFormsWithQuestions(): Collection;

    /**
     * Find a form by ID with questions and alternatives loaded.
     */
    public function findWithQuestions(int $id): ?Form;
}
