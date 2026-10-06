<?php

namespace App\Filament\Resources\Certifications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CertificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('issuer')
                    ->required(),
                TextInput::make('issuer_logo')
                    ->default(null),
                TextInput::make('credential_id')
                    ->default(null),
                TextInput::make('credential_url')
                    ->url()
                    ->default(null),
                TextInput::make('certificate_file')
                    ->default(null),
                FileUpload::make('certificate_image')
                    ->image(),
                DatePicker::make('issue_date'),
                DatePicker::make('expiry_date'),
                Toggle::make('does_not_expire')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
