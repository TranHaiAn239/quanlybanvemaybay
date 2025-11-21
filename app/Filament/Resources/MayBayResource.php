<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MayBayResource\Pages;
use App\Models\MayBay;

// Đảm bảo dùng đúng 'use' cho Filament v2
use Filament\Forms;
use Filament\Resources\Form as ResourceForm;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Table as ResourceTable;

// Import các trường Form v2
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;

// Import các cột Table v2
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class MayBayResource extends Resource
{
    protected static ?string $model = MayBay::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck'; // (Tạm dùng icon xe tải, bạn có thể đổi)
    protected static ?string $navigationLabel = 'Quản lý Máy Bay';
    protected static ?string $pluralLabel = 'Máy Bay';

    // Nhóm chung với Sân Bay
    protected static ?string $navigationGroup = 'Cài đặt Hệ thống';

    public static function form(ResourceForm $form): ResourceForm
    {
        return $form
            ->schema([
                Section::make('Thông tin Máy Bay')
                    ->schema([
                        TextInput::make('ma_may_bay')
                            ->label('Mã máy bay (Số hiệu)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),

                        TextInput::make('ten_may_bay')
                            ->label('Tên máy bay (VD: Airbus A320)')
                            ->maxLength(100),

                        TextInput::make('hang_hang_khong')
                            ->label('Hãng hàng không (VD: Vietnam Airlines)')
                            ->maxLength(100),

                        TextInput::make('so_ghe')
                            ->label('Tổng số ghế')
                            ->numeric()
                            ->required()
                            ->default(0),

                        Select::make('trang_thai')
                            ->label('Trạng thái')
                            ->options([
                                'dang_bay' => 'Đang bay',
                                'bao_duong' => 'Bảo dưỡng',
                                'san_sang' => 'Sẵn sàng',
                            ])
                            ->default('san_sang')
                            ->required(),
                    ])
                    ->columns(2), // Chia section này làm 2 cột
            ]);
    }

    public static function table(ResourceTable $table): ResourceTable
    {
        return $table
            ->columns([
                TextColumn::make('ma_may_bay')
                    ->label('Mã máy bay')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('ten_may_bay')
                    ->label('Tên máy bay')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('hang_hang_khong')
                    ->label('Hãng hàng không')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('so_ghe')
                    ->label('Số ghế')
                    ->sortable(),

                BadgeColumn::make('trang_thai')
                    ->label('Trạng thái')
                    ->colors([
                        'primary' => 'dang_bay',
                        'warning' => 'bao_duong',
                        'success' => 'san_sang',
                    ]),
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
            ->defaultSort('ma_may_bay', 'asc');
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
            'index' => Pages\ListMayBays::route('/'),
            'create' => Pages\CreateMayBay::route('/create'),
            'edit' => Pages\EditMayBay::route('/{record}/edit'),
        ];
    }
}
