<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ThingResource\Pages;
use App\Models\Thing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ThingResource extends Resource
{
    protected static ?string $model = Thing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('path_to_img')
                ->image()
                ->directory('things')
                ->required(),
            Select::make('material_id')
                ->relationship('material', 'material')
                ->searchable()
                ->nullable(),
            Select::make('drawing_id')
                ->relationship('drawing', 'name')
                ->searchable()
                ->nullable(),
            Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ImageColumn::make('path_to_img')
                    ->disk('public')
                    ->label('Image')
                    ->height(60), // по желанию
                TextColumn::make('material.material')->label('Material')->sortable(),
                TextColumn::make('drawing.name')->label('Drawing')->searchable(),
                TextColumn::make('drawing.id')->label('Drawing ID')->sortable(),
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListThings::route('/'),
            'create' => Pages\CreateThing::route('/create'),
            'edit' => Pages\EditThing::route('/{record}/edit'),
        ];
    }
}
