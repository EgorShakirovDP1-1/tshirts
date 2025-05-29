<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DrawingResource\Pages;
use App\Filament\Admin\Resources\DrawingResource\RelationManagers;
use App\Models\Drawing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DrawingResource extends Resource
{
    protected static ?string $model = Drawing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('path_to_drawing')
                    ->image()
                    ->directory('drawings')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\MultiSelect::make('categories')
                    ->relationship('categories', 'category_name')
                    ->label('Categories'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\ImageColumn::make('path_to_drawing')
                    ->disk('public')
                    ->label('Drawing')
                    ->height(60)
                    ->getStateUsing(fn($record) => $record->path_to_drawing), // явно указываем путь
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TagsColumn::make('categories.category_name')
                    ->label('Categories'),
                Tables\Columns\TextColumn::make('user_id')
                    ->label('Author ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Author Username')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // добавляем действие удаления
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
            'index' => Pages\ListDrawings::route('/'),
            'create' => Pages\CreateDrawing::route('/create'),
            'edit' => Pages\EditDrawing::route('/{record}/edit'),
        ];
    }
}
