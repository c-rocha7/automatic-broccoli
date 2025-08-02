<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulários Disponíveis</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Formulários Disponíveis</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Olá, {{ Auth::user()->name }}</span>
                <a href="/admin" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Painel Admin
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Sair
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($forms as $form)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">{{ $form->title }}</h2>
                    <p class="text-gray-600 mb-4">{{ Str::limit($form->description, 150) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            {{ $form->questions->count() }} pergunta(s)
                        </span>
                        <a href="{{ route('forms.show', $form) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Responder
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Nenhum formulário ativo disponível.</p>
                </div>
            @endforelse
        </div>
    </div>
</body>

</html>
