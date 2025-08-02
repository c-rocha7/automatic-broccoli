<?php

namespace App\Filament\Resources\FormResponseResource\Pages;

use App\Filament\Resources\FormResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormResponse extends EditRecord
{
    protected static string $resource = FormResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
