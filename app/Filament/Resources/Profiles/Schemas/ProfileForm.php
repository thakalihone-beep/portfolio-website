<?php

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('headline')
                    ->default(null),
                Textarea::make('bio')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('profile_image')
                    ->image(),
                FileUpload::make('cover_image')
                    ->image(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('location')
                    ->default(null),
                TextInput::make('resume')
                    ->default(null),
                TextInput::make('availability')
                    ->default(null),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
