<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Alternative;
use App\Models\Form;
use App\Models\FormResponse;
use App\Models\Question;
use App\Models\ResponseAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Service responsible for handling form responses.
 *
 * Following SRP (Single Responsibility Principle):
 * This class has only one responsibility - managing form responses
 */
class FormResponseService
{
    /**
     * Submit a response to a form.
     *
     * @param Form  $form             The form being answered
     * @param array $validatedAnswers The validated answers data
     *
     * @return FormResponse The created form response
     *
     * @throws \Exception If submission fails
     */
    public function submitResponse(Form $form, array $validatedAnswers): FormResponse
    {
        return DB::transaction(function () use ($form, $validatedAnswers): FormResponse {
            $formResponse = $this->createFormResponse($form);
            $this->createResponseAnswers($form, $formResponse, $validatedAnswers);

            return $formResponse;
        });
    }

    /**
     * Create a form response record.
     */
    private function createFormResponse(Form $form): FormResponse
    {
        return FormResponse::create([
            'form_id'      => $form->id,
            'user_id'      => $this->getCurrentUserId(),
            'submitted_at' => now(),
            'form_data'    => $this->prepareFormData($form),
        ]);
    }

    /**
     * Get the current authenticated user ID.
     *
     * @throws \Exception If user is not authenticated
     */
    private function getCurrentUserId(): int
    {
        $userId = Auth::id();

        if (null === $userId) {
            throw new \Exception('User must be authenticated to submit form response');
        }

        return $userId;
    }

    /**
     * Prepare form data for storage.
     */
    private function prepareFormData(Form $form): array
    {
        return [
            'title'       => $form->title,
            'description' => $form->description,
        ];
    }

    /**
     * Create response answers for each question.
     */
    private function createResponseAnswers(Form $form, FormResponse $formResponse, array $validatedAnswers): void
    {
        foreach ($validatedAnswers['answers'] as $questionId => $alternativeId) {
            $question    = $this->findQuestion($form, $questionId);
            $alternative = $this->findAlternative($question, $alternativeId);

            $this->createResponseAnswer($formResponse, $question, $alternative);
        }
    }

    /**
     * Find a question within a form.
     *
     * @throws \Exception If question not found
     */
    private function findQuestion(Form $form, int $questionId): Question
    {
        $question = $form->questions->find($questionId);

        if (null === $question) {
            throw new \Exception("Question with ID {$questionId} not found in form {$form->id}");
        }

        return $question;
    }

    /**
     * Find an alternative within a question.
     *
     * @throws \Exception If alternative not found
     */
    private function findAlternative(Question $question, int $alternativeId): Alternative
    {
        $alternative = $question->alternatives->find($alternativeId);

        if (null === $alternative) {
            throw new \Exception("Alternative with ID {$alternativeId} not found in question {$question->id}");
        }

        return $alternative;
    }

    /**
     * Create a single response answer.
     */
    private function createResponseAnswer(FormResponse $formResponse, Question $question, Alternative $alternative): ResponseAnswer
    {
        return ResponseAnswer::create([
            'form_response_id' => $formResponse->id,
            'question_text'    => $question->text,
            'alternative_text' => $alternative->text,
            'is_correct'       => $alternative->is_correct,
        ]);
    }
}
