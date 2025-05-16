<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\PasswordInput;
use Filament\Forms\Components\Toggle;
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
    return $form->schema([
        TextInput::make('name')
            ->required(),

        TextInput::make('surname'),

        TextInput::make('username')
            ->required()
            ->unique(ignoreRecord: true),

        TextInput::make('email')
            ->email()
            ->required()
            ->unique(ignoreRecord: true),

        TextInput::make('password')
            ->password()
            ->required(fn ($context) => $context === 'create')
            ->dehydrated(fn ($state) => filled($state))
            ->dehydrateStateUsing(fn ($state) => bcrypt($state)),

        FileUpload::make('avatar')
            ->image()
            ->directory('avatars'),

        TextInput::make('phone'),

        DateTimePicker::make('email_verified_at'),

        Toggle::make('is_admin')
            ->label('Admin Access')
            ->visible(fn () => auth()->user()?->email === 'egorsha2005@gmail.com')
            ->disabled(fn () => auth()->user()?->email !== 'egorsha2005@gmail.com'),
    ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('id')->sortable(),
            TextColumn::make('name')->searchable(),
            TextColumn::make('username')->searchable(),
            TextColumn::make('email')->searchable(),
            TextColumn::make('phone'),
            ImageColumn::make('avatar')->disk('public'),
            TextColumn::make('created_at')->dateTime()->sortable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
