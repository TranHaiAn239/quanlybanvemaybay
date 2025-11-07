<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SanBayResource\Pages;
use App\Models\SanBay;

// Đảm bảo dùng đúng 'use' cho Filament v2
use Filament\Forms;
use Filament\Resources\Form as ResourceForm;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Table as ResourceTable;

// Import các trường Form v2
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;

// Import các cột Table v2
use Filament\Tables\Columns\TextColumn;

class SanBayResource extends Resource
{
    protected static ?string $model = SanBay::class;

    protected static ?string $navigationIcon = 'heroicon-o-location-marker';
    protected static ?string $navigationLabel = 'Quản lý Sân Bay';
    protected static ?string $pluralLabel = 'Sân Bay';

    // (Tùy chọn) Nhóm nó vào mục "Cài đặt"
    protected static ?string $navigationGroup = 'Cài đặt Hệ thống';

    public static function form(ResourceForm $form): ResourceForm
    {
        return $form
            ->schema([
                Section::make('Thông tin Sân Bay')
                    ->schema([
                        TextInput::make('ma_san_bay')
                            ->label('Mã Sân Bay (IATA)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),

                        TextInput::make('ten_san_bay')
                            ->label('Tên Sân Bay')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('tinh_thanh')
                            ->label('Tỉnh/Thành phố')
                            ->maxLength(100),

                        TextInput::make('quoc_gia')
                            ->label('Quốc gia')
                            ->maxLength(100),

                        Textarea::make('dia_chi')
                            ->label('Địa chỉ chi tiết')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2), // Chia section này làm 2 cột
            ]);
    }

    public static function table(ResourceTable $table): ResourceTable
    {
        return $table
            ->columns([
                TextColumn::make('ma_san_bay')
                    ->label('Mã Sân Bay')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('ten_san_bay')
                    ->label('Tên Sân Bay')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                TextColumn::make('tinh_thanh')
                    ->label('Tỉnh/Thành')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('quoc_gia')
                    ->label('Quốc gia')
                    ->searchable()
                    ->sortable(),
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
            ])
            ->defaultSort('ten_san_bay', 'asc'); // Sắp xếp theo tên
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
            'index' => Pages\ListSanBays::route('/'),
            'create' => Pages\CreateSanBay::route('/create'),
            'edit' => Pages\EditSanBay::route('/{record}/edit'),
        ];
    }
}
