<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResouceResource\Widgets\CategorySaleChart;
use App\Filament\Resources\OrderResouceResource\Widgets\Top_product;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\ProductsRelationManager;
use App\Filament\Resources\OrderResource\Widgets\OrderOverview;
use App\Filament\Resources\OrderResoureResource\Widgets\Order as WidgetsOrder;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->label('รหัส')
                    ->sortable()
                    ->required(),
                TextInput::make('user.name')
                    ->label('ชื่อผู้สั่งซื้อ')
                    
                    ->searchable()
                    ->required(),
                Select::make('status')
                    ->label('สถานะ')
                    ->options([
                        'pending' => 'รอดำเนินการ',
                        'processing' => 'กำลังดำเนินการ',
                        'completed' => 'เสร็จสิ้น',
                        'cancelled' => 'ยกเลิก',
                    ])
                    ->required(),
                TextInput::make('total_price')
                    ->label('ราคารวม')
                    ->numeric()
                    ->prefix('฿')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              
                TextColumn::make('id')
                    ->label('รหัส')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('ชื่อผู้สั่งซื้อ')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('สถานะ')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_price')
                    ->label('ราคารวม')
                    ->sortable()
                    ->searchable(),
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
          ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
    public static function getWidgets(): array
    {
        return [
            OrderOverview::class,
            CategorySaleChart::class,
            Top_product::class,
        ];
    }
    
}
