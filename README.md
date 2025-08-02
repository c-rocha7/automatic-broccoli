# 📝 Acto Forms

Um sistema moderno de criação e resposta de formulários desenvolvido em Laravel com interface administrativa Filament e design responsivo com Tailwind CSS.

## 🚀 Características

- ✅ **Sistema de Autenticação** - Login/logout seguro
- ✅ **Criação de Formulários** - Interface administrativa completa com Filament
- ✅ **Questões de Múltipla Escolha** - Suporte a alternativas com validação
- ✅ **Sistema de Respostas** - Armazenamento e histórico de respostas
- ✅ **Interface Responsiva** - Design moderno com Tailwind CSS
- ✅ **Soft Deletes** - Exclusão segura de dados
- ✅ **Docker Ready** - Ambiente completo com Laravel Sail

## 🛠️ Tecnologias

- **Backend**: Laravel 12.x com PHP 8.2+
- **Frontend**: Blade Templates + Tailwind CSS 4.0
- **Admin Panel**: Filament 3.0
- **Database**: MySQL 8.0
- **Cache**: Redis
- **Mail**: Mailpit (desenvolvimento)
- **Search**: Meilisearch
- **Testing**: Selenium
- **Containerização**: Docker com Laravel Sail

## 📊 Estrutura do Banco de Dados

### Tabelas Principais

```
users
├── id
├── name
├── email (unique)
├── password
└── timestamps

forms
├── id
├── title
├── description
├── status (ativo/inativo)
├── user_id (FK)
├── timestamps
└── soft_deletes

questions
├── id
├── form_id (FK)
├── text
├── type (default: múltipla escolha)
├── timestamps
└── soft_deletes

alternatives
├── id
├── question_id (FK)
├── text
├── is_correct (boolean)
├── timestamps
└── soft_deletes

form_responses
├── id
├── form_id (FK, nullable)
├── user_id (FK)
├── submitted_at
├── form_data (JSON)
└── timestamps

response_answers
├── id
├── form_response_id (FK)
├── question_text
├── alternative_text
├── is_correct (boolean)
└── timestamps
```

## 🔧 Instalação e Configuração

### Pré-requisitos

- Docker e Docker Compose
- Git

### 1. Clone o Repositório

```bash
git clone <url-do-repositorio>
cd acto-forms
```

### 2. Instale as Dependências

```bash
# Instalar dependências do Composer
composer install

# Instalar dependências do NPM
npm install
```

### 3. Configure o Ambiente

```bash
# Copiar arquivo de ambiente
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

### 4. Inicie os Containers

```bash
# Subir todos os serviços
./vendor/bin/sail up -d
```

### 5. Configure o Banco de Dados

```bash
# Executar migrações
./vendor/bin/sail artisan migrate

# Executar seeders (usuário de teste)
./vendor/bin/sail artisan db:seed
```

### 6. Compilar Assets (Opcional)

```bash
# Para desenvolvimento
./vendor/bin/sail npm run dev

# Para produção
./vendor/bin/sail npm run build
```

## 🚀 Como Usar

### Acessando a Aplicação

1. **Aplicação Principal**: http://localhost
2. **Painel Administrativo**: http://localhost/admin
3. **Mailpit (emails)**: http://localhost:8025

### Credenciais de Teste

```
Email: test@example.com
Senha: password
```

### Fluxo de Uso

1. **Login**: Acesse `/login` e faça login com as credenciais de teste
2. **Visualizar Formulários**: Vá para `/forms` para ver formulários disponíveis
3. **Responder Formulário**: Clique em "Responder" em qualquer formulário
4. **Administração**: Acesse `/admin` para gerenciar formulários (painel Filament)

## 📁 Estrutura do Projeto

```
acto-forms/
├── app/
│   ├── Filament/           # Painel administrativo
│   ├── Http/Controllers/   # Controladores
│   ├── Models/             # Modelos Eloquent
│   └── Providers/          # Service Providers
├── database/
│   ├── migrations/         # Migrações do banco
│   ├── factories/          # Factories para testes
│   └── seeders/            # Seeders
├── resources/
│   ├── views/              # Templates Blade
│   │   ├── forms/          # Views dos formulários
│   │   └── auth/           # Views de autenticação
│   ├── css/                # Arquivos CSS
│   └── js/                 # Arquivos JavaScript
├── routes/
│   ├── web.php             # Rotas web
│   └── api.php             # Rotas API
├── docker-compose.yml      # Configuração Docker
└── README.md               # Este arquivo
```

## 🎯 Funcionalidades Principais

### Para Usuários
- Login/logout seguro
- Visualização de formulários ativos
- Resposta a formulários com validação
- Interface responsiva e intuitiva

### Para Administradores
- Painel administrativo completo (Filament)
- Criação e edição de formulários
- Gerenciamento de questões e alternativas
- Visualização de respostas
- Controle de status dos formulários

## 🔄 Comandos Úteis

### Gerenciamento de Containers

```bash
# Iniciar containers
./vendor/bin/sail up -d

# Parar containers
./vendor/bin/sail down

# Ver logs
./vendor/bin/sail logs

# Acessar container PHP
./vendor/bin/sail bash
```

### Laravel Artisan

```bash
# Limpar caches
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan view:clear

# Executar migrações
./vendor/bin/sail artisan migrate

# Executar seeders
./vendor/bin/sail artisan db:seed

# Acessar Tinker
./vendor/bin/sail artisan tinker
```

### Desenvolvimento

```bash
# Modo de desenvolvimento (watch)
./vendor/bin/sail npm run dev

# Build para produção
./vendor/bin/sail npm run build

# Executar testes
./vendor/bin/sail test
```

## 🐛 Solução de Problemas

### Problemas Comuns

1. **Erro de Permissão**: 
   ```bash
   sudo chmod -R 755 storage bootstrap/cache
   ```

2. **Cache de Autoload**:
   ```bash
   ./vendor/bin/sail exec laravel.test composer dump-autoload
   ```

3. **Problemas de Container**:
   ```bash
   ./vendor/bin/sail down
   ./vendor/bin/sail up -d --force-recreate
   ```

### Logs

```bash
# Ver logs da aplicação
./vendor/bin/sail logs laravel.test

# Ver logs do banco
./vendor/bin/sail logs mysql

# Logs Laravel (dentro do container)
./vendor/bin/sail artisan tail
```

## 🎨 Personalização

### Styling
- O projeto usa **Tailwind CSS 4.0** para estilização
- Arquivos CSS em `resources/css/`
- Configuração do Tailwind em `tailwind.config.js`

### Componentes Filament
- Recursos administrativos em `app/Filament/Resources/`
- Customizações em `app/Filament/`

## 📦 Serviços Incluídos

O ambiente Docker inclui:

- **Laravel App** (PHP 8.4) - localhost:80
- **MySQL** - localhost:3306  
- **Redis** - localhost:6379
- **Mailpit** - localhost:8025 (interface), localhost:1025 (SMTP)
- **Meilisearch** - localhost:7700
- **Selenium** - Para testes automatizados

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

## 📧 Suporte

Para suporte ou dúvidas, abra uma issue no repositório ou entre em contato.

---

**Desenvolvido com ❤️ usando Laravel + Filament + Tailwind CSS**
