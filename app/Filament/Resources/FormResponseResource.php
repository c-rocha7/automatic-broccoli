<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResponseResource\Pages;
use App\Models\FormResponse;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FormResponseResource extends Resource
{
    protected static ?string $model = FormResponse::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Respostas';

    protected static ?string $modelLabel = 'Resposta';

    protected static ?string $pluralModelLabel = 'Respostas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form is read-only, no editing allowed
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('form_title')
                    ->label('Formulário')
                    ->getStateUsing(fn (FormResponse $record): string => $record->form_data['title'] ?? 'Formulário excluído')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Respondido por')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Data de submissão')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('answers_count')
                    ->label('Respostas')
                    ->counts('answers'),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // No bulk actions for responses
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormResponses::route('/'),
            'view'  => Pages\ViewFormResponse::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }
}
