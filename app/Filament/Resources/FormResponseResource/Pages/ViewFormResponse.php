<?php

namespace App\Filament\Resources\FormResponseResource\Pages;

use App\Filament\Resources\FormResponseResource;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewFormResponse extends ViewRecord
{
    protected static string $resource = FormResponseResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informações do Formulário')
                    ->schema([
                        Infolists\Components\TextEntry::make('form_title')
                            ->label('Título')
                            ->getStateUsing(fn ($record) => $record->form_data['title'] ?? 'N/A'),
                        Infolists\Components\TextEntry::make('form_description')
                            ->label('Descrição')
                            ->getStateUsing(fn ($record) => $record->form_data['description'] ?? 'N/A'),
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('Respondido por'),
                        Infolists\Components\TextEntry::make('submitted_at')
                            ->label('Data de submissão')
                            ->dateTime(),
                    ])->columns(2),

                Infolists\Components\Section::make('Respostas')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('answers')
                            ->schema([
                                Infolists\Components\TextEntry::make('question_text')
                                    ->label('Pergunta')
                                    ->columnSpanFull(),
                                Infolists\Components\TextEntry::make('alternative_text')
                                    ->label('Resposta selecionada')
                                    ->badge()
                                    ->color(fn ($state, $record) => $record->is_correct ? 'success' : 'danger'),
                                Infolists\Components\IconEntry::make('is_correct')
                                    ->label('Correta')
                                    ->boolean(),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            // No actions for viewing responses
        ];
    }
}
