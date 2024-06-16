<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicationResource\Pages;
use App\Filament\Resources\PublicationResource\RelationManagers;
use App\Models\File;
use App\Models\People;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\Textarea::make('abstract')->required(),
                Forms\Components\TextInput::make('publisher')->required(),
                Forms\Components\DatePicker::make('publication_date')->required(),
                FileUpload::make('file')
                    ->required(fn (string $context) => $context === 'create')
                    ->directory('files')
                    ->disk('public')
                    ->maxFiles(1)
                    ->acceptedFileTypes(['application/pdf'])
                    ->getUploadedFileNameForStorageUsing(function (FileUpload $component, $file) {
                        return $file->hashName();
                    })
                    ->saveUploadedFileUsing(function ($file) {
                        $path = $file->store('files', 'public');

                        // Create a new File record
                        $fileModel = File::create([
                            'name' => $file->getClientOriginalName(),
                            'file_path' => $path,
                            'size' => $file->getSize(),
                            'type' => $file->getClientMimeType(),
                        ]);

                        return $fileModel->id;
                    })
                    ->afterStateUpdated(function ($state, $set) {
                        $set('file_id', $state);
                    }),
                Select::make('publication_type')
                    ->required()
                    ->options(Publication::getPublicationTypes()),
                Forms\Components\Select::make('authors')->multiple()
                    ->relationship('authors', 'id')
                    ->required()
                    ->options(function () {
                        return People::all()->mapWithKeys(function ($person) {
                            return [$person->id => $person->first_name . ' ' . $person->last_name];
                        });
                    })->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('authors.first_name')
                    ->label('Authors')
                    ->getStateUsing(function ($record) {
                        return $record->authors->pluck('first_name')->join(', ');
                    }),
                Tables\Columns\TextColumn::make('publisher'),
                Tables\Columns\TextColumn::make('publication_type')
                    ->label('Publication Type')
                    ->formatStateUsing(function ($state) {
                        $types = Publication::getPublicationTypes();
                        return $types[$state] ?? 'Unknown';
                    }),
                Tables\Columns\TextColumn::make('file.name')
                    ->label('File')
                    ->url(function ($record) {
                        return Storage::url(optional($record->file)->file_path);
                    })
                    ->getStateUsing(function ($record) {
                        return optional($record->file)->name;
                    }),
                Tables\Columns\TextColumn::make('publication_date')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}
