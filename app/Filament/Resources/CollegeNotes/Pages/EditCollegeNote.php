<?php

namespace App\Filament\Resources\CollegeNotes\Pages;

use App\Filament\Resources\CollegeNotes\CollegeNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCollegeNote extends EditRecord
{
    protected static string $resource = CollegeNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
