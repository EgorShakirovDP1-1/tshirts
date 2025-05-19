<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ParcelMachineResource\Pages;
use App\Filament\Admin\Resources\ParcelMachineResource\RelationManagers;
use App\Models\ParcelMachine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParcelMachineResource extends Resource
{
    protected static ?string $model = ParcelMachine::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
               
                Forms\Components\TextInput::make('delivery_price')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                Forms\Components\TextInput::make('latitude')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('address')->limit(30),
                Tables\Columns\TextColumn::make('delivery_price'),
                Tables\Columns\TextColumn::make('latitude'),
                Tables\Columns\TextColumn::make('longitude'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
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
            'index' => Pages\ListParcelMachines::route('/'),
            'create' => Pages\CreateParcelMachine::route('/create'),
            'edit' => Pages\EditParcelMachine::route('/{record}/edit'),
        ];
    }
}
