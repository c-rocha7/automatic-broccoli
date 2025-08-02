<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormResponse;
use App\Models\ResponseAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FormAnswerController extends Controller
{
    public function index()
    {
        $forms = Form::where('status', 'ativo')
            ->with(['questions.alternatives'])
            ->get();

        return view('forms.index', compact('forms'));
    }

    public function show(Form $form)
    {
        if ('ativo' !== $form->status) {
            abort(404, 'Formulário não está ativo.');
        }

        $form->load(['questions.alternatives']);

        return view('forms.show', compact('form'));
    }

    public function store(Request $request, Form $form)
    {
        if ('ativo' !== $form->status) {
            abort(404, 'Formulário não está ativo.');
        }

        $form->load(['questions.alternatives']);

        // Validate that all questions are answered
        $rules = [];
        foreach ($form->questions as $question) {
            $rules["answers.{$question->id}"] = 'required|exists:alternatives,id';
        }

        try {
            $validated = $request->validate($rules);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        DB::transaction(function () use ($form, $validated) {
            // Create form response
            $formResponse = FormResponse::create([
                'form_id'      => $form->id,
                'user_id'      => Auth::id(),
                'submitted_at' => now(),
                'form_data'    => [
                    'title'       => $form->title,
                    'description' => $form->description,
                ],
            ]);

            // Create response answers
            foreach ($validated['answers'] as $questionId => $alternativeId) {
                $question    = $form->questions->find($questionId);
                $alternative = $question->alternatives->find($alternativeId);

                ResponseAnswer::create([
                    'form_response_id' => $formResponse->id,
                    'question_text'    => $question->text,
                    'alternative_text' => $alternative->text,
                    'is_correct'       => $alternative->is_correct,
                ]);
            }
        });

        return redirect()->route('forms.index')
            ->with('success', 'Formulário respondido com sucesso!');
    }
}
