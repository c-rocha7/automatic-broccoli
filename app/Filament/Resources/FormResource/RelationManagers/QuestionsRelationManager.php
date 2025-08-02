<?php

namespace App\Filament\Resources\FormResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    protected static ?string $title = 'Perguntas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('text')
                    ->label('Pergunta')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Hidden::make('type')
                    ->default('múltipla escolha'),
                Forms\Components\Repeater::make('alternatives')
                    ->relationship()
                    ->label('Alternativas')
                    ->schema([
                        Forms\Components\TextInput::make('text')
                            ->label('Texto da alternativa')
                            ->required(),
                        Forms\Components\Toggle::make('is_correct')
                            ->label('Alternativa correta')
                            ->default(false),
                    ])
                    ->defaultItems(2)
                    ->minItems(2)
                    ->maxItems(10)
                    ->columnSpanFull()
                    ->orderColumn('id'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('text')
            ->columns([
                Tables\Columns\TextColumn::make('text')
                    ->label('Pergunta')
                    ->limit(50),
                Tables\Columns\TextColumn::make('alternatives_count')
                    ->label('Alternativas')
                    ->counts('alternatives'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
