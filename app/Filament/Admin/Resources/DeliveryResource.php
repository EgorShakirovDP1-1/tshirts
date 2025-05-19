<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DeliveryResource\Pages;
use App\Models\Delivery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Deliveries';
    protected static ?string $pluralModelLabel = 'Deliveries';
    protected static ?string $modelLabel = 'Delivery';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('drawing_id')
                ->relationship('drawing', 'name')
                ->label('Drawing')
                ->required(),
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'username')
                ->label('User')
                ->required(),
            Forms\Components\Select::make('parcel_machine_id')
                ->relationship('parcelMachine', 'name')
                ->label('Parcel Machine')
                ->required(),
            Forms\Components\TextInput::make('total_price')
                ->label('Total Price (€)')
                ->numeric()
                ->required(),
            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'in_progress' => 'In Progress',
                    'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled',
                ])
                ->label('Status')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('drawing.name')->label('Drawing')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.username')->label('User')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('parcelMachine.name')->label('Parcel Machine')->sortable(),
                Tables\Columns\TextColumn::make('total_price')->label('Total Price (€)')->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'pending',
                        'warning' => 'in_progress',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->label('Status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Created')->sortable(),
            ])
            ->filters([
                // Можно добавить фильтры по статусу или дате
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
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDelivery::route('/create'),
            'edit' => Pages\EditDelivery::route('/{record}/edit'),
        ];
    }
}
