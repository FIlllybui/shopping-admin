<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('ชื่อสินค้า')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->label('ราคา')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('จำนวน')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->label('เพิ่มสินค้า')
                    ->form(fn($action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('quantity')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('price')
                            ->required()
                            ->maxLength(255),
                    ]),
















                // AttachAction::make()
                //     ->preloadRecordSelect()
                //     ->label('เพิ่มสินค้า')
                //     ->form(fn($action): array => [
                //         $action->getRecordSelect(),
                //         TextInput::make('quantity')
                //             ->required()
                //             ->maxLength(255),
                //         TextInput::make('price')
                //             ->required()
                //             ->maxLength(255),
                //     ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
