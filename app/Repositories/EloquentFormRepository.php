<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Form;
use App\Repositories\Contracts\FormRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Eloquent implementation of Form Repository.
 *
 * Following SRP: This class only handles data access for forms
 */
class EloquentFormRepository implements FormRepositoryInterface
{
    /**
     * Get all active forms with their questions and alternatives.
     *
     * @return Collection<Form>
     */
    public function getActiveFormsWithQuestions(): Collection
    {
        return Form::where('status', 'ativo')
            ->with(['questions.alternatives'])
            ->get();
    }

    /**
     * Find a form by ID with questions and alternatives loaded.
     */
    public function findWithQuestions(int $id): ?Form
    {
        return Form::with(['questions.alternatives'])->find($id);
    }
}
