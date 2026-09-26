<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Enums\EmploymentStatus;
use App\Enums\Position;
use App\Services\NigeriaLocationService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Personal Details')
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        TextInput::make('name')
                            ->autocapitalize('words')
                            ->trim()
                            ->placeholder('John Doe')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->placeholder('user@example.com')
                            ->required(),
                        TextInput::make('phone')
                            ->tel()
                            ->placeholder('08123456789')
                            ->required(),
                        Select::make('gender')
                            ->required()
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                            ]),
                        Select::make('marital_status')
                            ->required()
                            ->options([
                                'Single' => 'Single',
                                'Married' => 'Married',
                                'Divorced' => 'Divorced',
                                'Widowed' => 'Widowed',
                            ]),
                        TextInput::make('address')
                            ->placeholder('Address')
                            ->required(),
                        Select::make('state')
                            ->label('State')
                            ->placeholder('Select state')
                            ->options(NigeriaLocationService::getStates())
                            ->searchable()
                            ->preload()
                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.state" />')))
                            ->live()
                            ->afterStateUpdated(fn ($set) => $set('lga', null))
                            ->required(),
                        Select::make('lga')
                            ->label('LGA')
                            ->placeholder('Select LGA')
                            ->options(fn ($get) => NigeriaLocationService::getLgasForState($get('state')))
                            ->searchable()
                            ->preload()
                            ->disabled(fn ($get) => blank($get('state')))
                            ->required(),
                        TextInput::make('hometown')
                            ->placeholder('Hometown')
                            ->required(),
                        FileUpload::make('id_document')
                            ->label('ID Document')
                            ->disk('public')
                            ->directory('employee/ids')
                            ->visibility('public')
                            ->moveFiles()
                            ->maxSize(2048)
                            ->imagePreviewHeight('100')
                            ->panelLayout('integrated')
                            ->image(),
                        FileUpload::make('cv')
                            ->label('CV')
                            ->disk('public')
                            ->directory('employee/cv')
                            ->visibility('public')
                            ->moveFiles()
                            ->maxSize(2048)
                            ->imagePreviewHeight('100')
                            ->panelLayout('integrated')
                            ->image(),
                    ]),
                Fieldset::make('Emergency Contact Details')
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        Repeater::make('emergency_contact_details')
                            ->schema([
                                TextInput::make('name')
                                    ->placeholder('Name')
                                    ->required(),
                                TextInput::make('phone')
                                    ->placeholder('Phone Number')
                                    ->tel()
                                    ->required(),
                                TextInput::make('address')
                                    ->placeholder('Address')
                                    ->required(),
                                Select::make('relationship')->required()->options([
                                    'Spouse' => 'Spouse',
                                    'Parent' => 'Parent',
                                    'Sibling' => 'Sibling',
                                    'Friend' => 'Friend',
                                    'Other' => 'Other',
                                ]),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->defaultItems(1)
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->required(),
                    ]),
                Fieldset::make('Employment Details')
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        Select::make('position')
                            ->options(Position::class)
                            ->required(),
                        TextInput::make('salary')
                            ->label('Salary (NGN)')
                            ->placeholder('Salary')
                            ->required()
                            ->numeric()
                            ->minValue(1.00)
                            ->step(0.01)
                            ->prefix('₦'),
                        DatePicker::make('employment_date')
                            ->required(),
                        Select::make('employment_status')
                            ->required()
                            ->options(EmploymentStatus::class)
                            ->hint(new HtmlString(Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.employment_status" />')))
                            ->live(),
                        DatePicker::make('termination_date')
                            ->required()
                            ->visible(fn ($get) => $get('employment_status') === 'Terminated'),
                        Textarea::make('termination_reason')
                            ->label(('Reason for Termination'))
                            ->placeholder('Reason for Termination')
                            ->rows(2)
                            ->required()
                            ->visible(fn ($get) => $get('employment_status') === 'Terminated'),
                        Repeater::make('account_details')
                            ->schema([
                                TextInput::make('bank_name')->placeholder('Bank Name')->required(),
                                TextInput::make('account_name')->placeholder('Account Name')->required(),
                                TextInput::make('account_number')->placeholder('Account Number')->required(),
                            ])
                            ->columns(3)
                            ->columnSpanFull()
                            ->maxItems(1)
                            ->defaultItems(0)
                            // ->addable(false)
                            // ->deletable(false)
                            ->reorderable(false),
                    ]),
            ])->columns(1);
    }
}
