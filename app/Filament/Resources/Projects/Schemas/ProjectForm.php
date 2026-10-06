<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(null),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('short_description')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('thumbnail')
                    ->default(null),
                TextInput::make('github_url')
                    ->url()
                    ->default(null),
                TextInput::make('live_url')
                    ->url()
                    ->default(null),
                TextInput::make('demo_url')
                    ->url()
                    ->default(null),
                TextInput::make('status')
                    ->required()
                    ->default('completed'),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                Toggle::make('featured')
                    ->required(),
                Toggle::make('is_published')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
