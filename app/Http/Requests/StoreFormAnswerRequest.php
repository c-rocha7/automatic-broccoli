<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Form;
use App\Services\FormValidationService;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Request class for form answer submission.
 *
 * Following SRP: This class only handles request validation
 */
class StoreFormAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $form = $this->route('form');

        if (!$form instanceof Form) {
            return false;
        }

        $validationService = app(FormValidationService::class);

        return $validationService->isFormAvailable($form);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $form = $this->route('form');

        if (!$form instanceof Form) {
            return [];
        }

        $validationService = app(FormValidationService::class);

        return $validationService->buildValidationRules($form);
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'answers.*.required' => 'Por favor, responda todas as questões.',
            'answers.*.exists'   => 'Alternativa selecionada não é válida.',
        ];
    }
}
