<?php

namespace App\Filament\Pages;

use App\Enums\Position;
use App\Models\Employee;
use App\Models\Shift;
use BackedEnum;
use Carbon\Carbon;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class WorkAllocationSchedule extends Page
{
    protected string $view = 'filament.pages.work-allocation-schedule';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    protected static ?string $navigationLabel = 'Work Allocation';

    protected static ?string $title = 'Work Allocation & Shift Schedule';

    protected static ?int $navigationSort = 3;

    public string $startOfWeekDate = '';

    public string $selectedPosition = '';

    public function mount(): void
    {
        $this->startOfWeekDate = now()->startOfWeek()->toDateString();
        $this->selectedPosition = Position::cases()[0]->value ?? 'Receptionist';
    }

    public function previousWeek(): void
    {
        $this->startOfWeekDate = Carbon::parse($this->startOfWeekDate)->subWeek()->startOfWeek()->toDateString();
    }

    public function nextWeek(): void
    {
        $this->startOfWeekDate = Carbon::parse($this->startOfWeekDate)->addWeek()->startOfWeek()->toDateString();
    }

    public function currentWeek(): void
    {
        $this->startOfWeekDate = now()->startOfWeek()->toDateString();
    }

    public function setPosition(string $position): void
    {
        $this->selectedPosition = $position;
    }

    public function assignShiftAction(): Action
    {
        return Action::make('assignShift')
            ->label('Assign Shift')
            ->icon(Heroicon::PlusCircle)
            ->modalHeading(fn () => "Assign Shift - {$this->selectedPosition}")
            ->modalDescription("Allocate a shift to a {$this->selectedPosition} for the selected day.")
            ->modalWidth('lg')
            ->fillForm(fn (array $arguments) => [
                'date' => $arguments['date'] ?? now()->toDateString(),
                'start_time' => '08:00',
                'end_time' => '16:00',
            ])
            ->form([
                Select::make('employee_id')
                    ->label(fn () => "Employee ({$this->selectedPosition})")
                    ->options(fn () => Employee::where('position', $this->selectedPosition)->orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->rules([
                        fn ($get) => function (string $attribute, $value, Closure $fail) use ($get) {
                            $date = $get('date');
                            if (! $value || ! $date) {
                                return;
                            }

                            $existingShift = Shift::where('employee_id', $value)
                                ->where('date', $date)
                                ->first();

                            if ($existingShift) {
                                $startTime = Carbon::parse($existingShift->start_time)->format('g:i A');
                                $endTime = Carbon::parse($existingShift->end_time)->format('g:i A');

                                $fail("This employee is already scheduled for a shift on this date ({$startTime} – {$endTime}).");
                            }
                        },
                    ]),
                DatePicker::make('date')
                    ->label('Shift Date')
                    ->required(),
                TimePicker::make('start_time')
                    ->label('Start Time')
                    ->seconds(false)
                    ->required(),
                TimePicker::make('end_time')
                    ->label('End Time')
                    ->seconds(false)
                    ->required()
                    ->rules([
                        fn ($get) => function (string $attribute, $value, Closure $fail) use ($get) {
                            $startTime = $get('start_time');
                            if (! $value || ! $startTime) {
                                return;
                            }

                            if (Carbon::parse($value)->lte(Carbon::parse($startTime))) {
                                $fail('End time must be after the start time.');
                            }
                        },
                    ]),
                TextInput::make('role_or_notes')
                    ->label('Assignment / Station / Notes')
                    ->placeholder('e.g. Front Desk, Housekeeping, Bar, Concierge'),
            ])
            ->action(function (array $data): void {
                Shift::create($data);

                Notification::make()
                    ->title('Shift Assigned')
                    ->body('Work shift successfully allocated.')
                    ->success()
                    ->send();
            });
    }

    public function editShiftAction(): Action
    {
        return Action::make('editShift')
            ->label('Edit Shift')
            ->modalHeading(fn () => "Edit Shift - {$this->selectedPosition}")
            ->modalWidth('lg')
            ->record(fn (array $arguments) => isset($arguments['shift_id']) ? Shift::find($arguments['shift_id']) : null)
            ->fillForm(fn (?Shift $record) => $record ? [
                'employee_id' => $record->employee_id,
                'date' => $record->date->toDateString(),
                'start_time' => $record->start_time,
                'end_time' => $record->end_time,
                'role_or_notes' => $record->role_or_notes,
            ] : [])
            ->form([
                Select::make('employee_id')
                    ->label(fn () => "Employee ({$this->selectedPosition})")
                    ->options(fn () => Employee::where('position', $this->selectedPosition)->orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->rules([
                        fn ($get, ?Shift $record) => function (string $attribute, $value, Closure $fail) use ($get, $record) {
                            $date = $get('date');
                            if (! $value || ! $date) {
                                return;
                            }

                            $query = Shift::where('employee_id', $value)
                                ->where('date', $date);

                            if ($record) {
                                $query->where('id', '!=', $record->id);
                            }

                            $existingShift = $query->first();

                            if ($existingShift) {
                                $startTime = Carbon::parse($existingShift->start_time)->format('g:i A');
                                $endTime = Carbon::parse($existingShift->end_time)->format('g:i A');

                                $fail("This employee is already scheduled for a shift on this date ({$startTime} – {$endTime}).");
                            }
                        },
                    ]),
                DatePicker::make('date')
                    ->label('Shift Date')
                    ->required(),
                TimePicker::make('start_time')
                    ->label('Start Time')
                    ->seconds(false)
                    ->required(),
                TimePicker::make('end_time')
                    ->label('End Time')
                    ->seconds(false)
                    ->required()
                    ->rules([
                        fn ($get) => function (string $attribute, $value, Closure $fail) use ($get) {
                            $startTime = $get('start_time');
                            if (! $value || ! $startTime) {
                                return;
                            }

                            if (Carbon::parse($value)->lte(Carbon::parse($startTime))) {
                                $fail('End time must be after the start time.');
                            }
                        },
                    ]),
                TextInput::make('role_or_notes')
                    ->label('Assignment / Station / Notes')
                    ->placeholder('e.g. Front Desk, Housekeeping, Bar, Concierge'),
            ])
            ->extraModalActions([
                Action::make('deleteShift')
                    ->label('Delete Shift')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Shift')
                    ->modalDescription('Are you sure you want to remove this shift allocation?')
                    ->action(function (?Shift $record): void {
                        if ($record) {
                            $record->delete();

                            Notification::make()
                                ->title('Shift Removed')
                                ->danger()
                                ->send();
                        }

                        $this->unmountAction();
                    }),
            ])
            ->action(function (?Shift $record, array $data): void {
                if (! $record) {
                    return;
                }

                $record->update($data);

                Notification::make()
                    ->title('Shift Updated')
                    ->success()
                    ->send();
            });
    }

    public function getViewData(): array
    {
        $startOfWeek = Carbon::parse($this->startOfWeekDate)->startOfWeek();
        $endOfWeek = $startOfWeek->copy()->endOfWeek();

        $days = [];
        for ($date = $startOfWeek->copy(); $date->lte($endOfWeek); $date->addDay()) {
            $days[] = [
                'date' => $date->toDateString(),
                'dayName' => $date->format('l'),
                'dayShort' => $date->format('D'),
                'formatted' => $date->format('M d'),
                'dayNumber' => $date->format('d'),
                'isToday' => $date->isToday(),
                'isPast' => $date->isPast() && ! $date->isToday(),
            ];
        }

        $query = Shift::with('employee')
            ->whereHas('employee', function ($q) {
                $q->where('position', $this->selectedPosition);
            })
            ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->orderBy('start_time');

        $shifts = $query->get()->groupBy(fn ($shift) => $shift->date->toDateString());

        $employees = Employee::where('position', $this->selectedPosition)->orderBy('name')->get();

        $totalShiftsCount = $shifts->flatten(1)->count();

        $positions = Position::cases();

        return [
            'days' => $days,
            'shifts' => $shifts,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'employees' => $employees,
            'totalShiftsCount' => $totalShiftsCount,
            'positions' => $positions,
            'selectedPosition' => $this->selectedPosition,
        ];
    }
}
