<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormAnswerRequest;
use App\Models\Form;
use App\Repositories\Contracts\FormRepositoryInterface;
use App\Services\FormResponseService;
use App\Services\FormValidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controller for handling form answers.
 *
 * Following Clean Code and SOLID principles:
 * - SRP: Only handles HTTP requests/responses for form answers
 * - DIP: Depends on abstractions (interfaces) not concretions
 * - OCP: Open for extension, closed for modification
 */
class FormAnswerController extends Controller
{
    public function __construct(
        private readonly FormRepositoryInterface $formRepository,
        private readonly FormResponseService $responseService,
        private readonly FormValidationService $validationService,
    ) {
    }

    /**
     * Display a listing of active forms.
     */
    public function index(): View
    {
        $forms = $this->formRepository->getActiveFormsWithQuestions();

        return view('forms.index', compact('forms'));
    }

    /**
     * Show a specific form for answering.
     */
    public function show(Form $form): View
    {
        $this->ensureFormIsAvailable($form);

        $form->load(['questions.alternatives']);

        return view('forms.show', compact('form'));
    }

    /**
     * Store a form response.
     */
    public function store(StoreFormAnswerRequest $request, Form $form): RedirectResponse
    {
        $this->ensureFormIsAvailable($form);

        $this->responseService->submitResponse($form, $request->validated());

        return redirect()
            ->route('forms.index')
            ->with('success', 'Formulário respondido com sucesso!');
    }

    /**
     * Ensure the form is available for answering.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function ensureFormIsAvailable(Form $form): void
    {
        if (!$this->validationService->isFormAvailable($form)) {
            abort(404, 'Formulário não está ativo.');
        }
    }
}
