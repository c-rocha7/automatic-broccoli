<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Form;

/**
 * Service responsible for form validation logic.
 *
 * Following SRP: This class only handles form validation concerns
 */
class FormValidationService
{
    /**
     * Build validation rules for a form.
     */
    public function buildValidationRules(Form $form): array
    {
        $rules = [];

        foreach ($form->questions as $question) {
            $rules["answers.{$question->id}"] = $this->getQuestionValidationRule();
        }

        return $rules;
    }

    /**
     * Check if a form is available for answering.
     */
    public function isFormAvailable(Form $form): bool
    {
        return 'ativo' === $form->status;
    }

    /**
     * Get validation rule for a question.
     */
    private function getQuestionValidationRule(): string
    {
        return 'required|exists:alternatives,id';
    }
}
