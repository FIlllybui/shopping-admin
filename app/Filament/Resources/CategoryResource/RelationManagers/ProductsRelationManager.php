<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
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
                TextInput::make('image_url')
                    ->label('รูปภาพ'),
                TextInput::make('name')
                    ->required()
                    ->label('ชื่อ'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->suffix('บาท')
                    ->label('ราคา'),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->suffix('ชิ้น')
                    ->label('จำนวนสินค้า'),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('image_url')
                    ->label('รูปภาพ'),
                TextColumn::make('name')
                    ->label('ชื่อ'),
                TextColumn::make('category.name')
                    ->label('ประเภทสินค้า'),
                TextColumn::make('price')
                    ->numeric(),
                TextColumn::make('stock')
                    ->label('สินค้าคงเหลือ')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
