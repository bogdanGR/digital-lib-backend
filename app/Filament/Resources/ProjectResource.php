<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('project_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('framework')
                    ->required()
                    ->maxLength(255),
                TextInput::make('contract_number')
                    ->required()
                    ->maxLength(255),
                Select::make('status')
                    ->options(Project::getStatuses())
                    ->required(),
                Select::make('type')
                    ->options(Project::getTypes())
                    ->required(),
                Textarea::make('full_title')
                    ->required(),
                Textarea::make('participants')
                    ->required(),
                TextInput::make('budget')
                    ->required()
                    ->numeric(),
                Textarea::make('description')
                    ->required(),
                TextInput::make('project_url')
                    ->url()
                    ->required(),
                DatePicker::make('date_start')
                    ->required(),
                DatePicker::make('date_end')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project_name')->label('Project Name')->searchable()->sortable(),
                TextColumn::make('framework')->label('Framework')->searchable()->sortable(),
                TextColumn::make('contract_number')->label('Contract Number')->searchable()->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => Project::getStatuses()[$state] ?? '-')
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn($state) => Project::getTypes()[$state] ?? '-')
                    ->sortable(),
                TextColumn::make('budget')->label('Budget')->sortable(),
                TextColumn::make('date_start')->label('Start Date')->date()->sortable(),
                TextColumn::make('date_end')->label('End Date')->date()->sortable(),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
