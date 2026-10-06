<?php

namespace App\Filament\Resources\CollegeNotes;

use App\Filament\Resources\CollegeNotes\Pages\CreateCollegeNote;
use App\Filament\Resources\CollegeNotes\Pages\EditCollegeNote;
use App\Filament\Resources\CollegeNotes\Pages\ListCollegeNotes;
use App\Filament\Resources\CollegeNotes\Schemas\CollegeNoteForm;
use App\Filament\Resources\CollegeNotes\Tables\CollegeNotesTable;
use App\Models\CollegeNote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CollegeNoteResource extends Resource
{
    protected static ?string $model = CollegeNote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return CollegeNoteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CollegeNotesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCollegeNotes::route('/'),
            'create' => CreateCollegeNote::route('/create'),
            'edit' => EditCollegeNote::route('/{record}/edit'),
        ];
    }
}
