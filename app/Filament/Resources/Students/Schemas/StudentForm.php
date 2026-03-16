<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('student_id')
                    ->required(),
                Select::make('program_id')
                    ->relationship('program', 'name'),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                DatePicker::make('date_of_birth'),
                TextInput::make('gender'),
                TextInput::make('nationality'),
                TextInput::make('national_id'),
                Textarea::make('address')
                    ->columnSpanFull(),
                TextInput::make('city'),
                TextInput::make('state'),
                TextInput::make('postal_code'),
                TextInput::make('country'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('emergency_contact_name'),
                TextInput::make('emergency_contact_phone')
                    ->tel(),
                DatePicker::make('admission_date'),
                DatePicker::make('expected_graduation'),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                Textarea::make('medical_notes')
                    ->columnSpanFull(),
                TextInput::make('registration_status')
                    ->required()
                    ->default('accepted_pending_payment'),
                DateTimePicker::make('registration_completed_at'),
            ]);
    }
}
