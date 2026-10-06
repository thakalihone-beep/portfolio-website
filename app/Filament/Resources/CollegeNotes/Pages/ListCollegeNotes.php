<?php

namespace App\Filament\Resources\CollegeNotes\Pages;

use App\Filament\Resources\CollegeNotes\CollegeNoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCollegeNotes extends ListRecords
{
    protected static string $resource = CollegeNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
