<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $form->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="mb-8">
                    <a href="{{ route('forms.index') }}" class="text-blue-500 hover:text-blue-700 mb-4 inline-block">
                        ← Voltar aos formulários
                    </a>
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $form->title }}</h1>
                    <p class="text-gray-600 mb-6">{{ $form->description }}</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('forms.store', $form) }}">
                    @csrf
                    @foreach ($form->questions as $question)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                {{ $loop->iteration }}. {{ $question->text }}
                            </h3>
                            <div class="space-y-2">
                                @foreach ($question->alternatives as $alternative)
                                    <label
                                        class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input type="radio" name="answers[{{ $question->id }}]"
                                            value="{{ $alternative->id }}" class="mr-3 text-blue-600"
                                            {{ old("answers.{$question->id}") == $alternative->id ? 'checked' : '' }}>
                                        <span class="text-gray-700">{{ $alternative->text }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error("answers.{$question->id}")
                                <p class="text-red-500 text-sm mt-2">Por favor, selecione uma alternativa.</p>
                            @enderror
                        </div>
                    @endforeach

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg">
                            Enviar Respostas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
