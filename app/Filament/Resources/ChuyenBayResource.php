<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChuyenBayResource\Pages;
use App\Filament\Resources\ChuyenBayResource\RelationManagers;
use App\Models\ChuyenBay;

// SỬA LẠI CÁC 'USE' STATEMENT CHO V2
use Filament\Forms;
use Filament\Resources\Form as ResourceForm; // Dùng 'ResourceForm'
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Resources\Table as ResourceTable; // Dùng 'ResourceTable'

class ChuyenBayResource extends Resource
{
    protected static ?string $model = ChuyenBay::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?string $navigationLabel = 'Quản lý Chuyến bay';
    protected static ?string $pluralLabel = 'Chuyến bay';

    // SỬA LẠI ĐỊNH NGHĨA HÀM (dùng ResourceForm)
    public static function form(ResourceForm $form): ResourceForm
    {
        return $form
            ->schema([
                // Cột trái
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Thông tin chuyến bay')
                            ->schema([
                                Forms\Components\TextInput::make('ma_chuyen_bay')
                                    ->label('Mã chuyến bay')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50),

                                Forms\Components\Select::make('id_may_bay')
                                    ->label('Máy bay')
                                    ->relationship('mayBay', 'ten_may_bay')
                                    ->searchable()
                                    ->required(),

                                Forms\Components\Select::make('trang_thai')
                                    ->label('Trạng thái')
                                    ->options([
                                        'dang_ban' => 'Đang bán',
                                        'tam_hoan' => 'Tạm hoãn',
                                        'hoan_tat' => 'Hoàn tất',
                                        'huy' => 'Hủy',
                                    ])
                                    ->default('dang_ban')
                                    ->required(),
                            ]),

                        Forms\Components\Section::make('Thông tin giá')
                            ->schema([
                                Forms\Components\TextInput::make('gia_ve')
                                    ->label('Giá vé (VND)')
                                    ->required()
                                    ->numeric()
                                    ->default(0.00),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                // Cột phải
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Hành trình')
                            ->schema([
                                Forms\Components\Select::make('id_san_bay_di')
                                    ->label('Sân bay đi')
                                    ->relationship('sanBayDi', 'ten_san_bay')
                                    ->searchable()
                                    ->required(),

                                Forms\Components\Select::make('id_san_bay_den')
                                    ->label('Sân bay đến')
                                    ->relationship('sanBayDen', 'ten_san_bay')
                                    ->searchable()
                                    ->required(),
                            ]),

                        Forms\Components\Section::make('Thời gian')
                            ->schema([
                                Forms\Components\DateTimePicker::make('thoi_gian_di')
                                    ->label('Thời gian đi')
                                    ->required(),

                                Forms\Components\DateTimePicker::make('thoi_gian_den')
                                    ->label('Thời gian đến')
                                    ->required(),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    // SỬA LẠI ĐỊNH NGHĨA HÀM (dùng ResourceTable)
    public static function table(ResourceTable $table): ResourceTable
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ma_chuyen_bay')
                    ->label('Mã CB')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sanBayDi.ma_san_bay')
                    ->label('Đi từ')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sanBayDen.ma_san_bay')
                    ->label('Đến')
                    ->sortable(),

                Tables\Columns\TextColumn::make('thoi_gian_di')
                    ->label('Thời gian đi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('gia_ve')
                    ->label('Giá vé')
                    ->formatStateUsing(fn ($state): string => number_format($state, 0, ',', '.') . ' VND')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('trang_thai') // <-- SỬA THÀNH BadgeColumn
                    ->label('Trạng thái')
                    ->color(fn (string $state): string => match ($state) { // Bỏ dòng .badge()
                        'dang_ban' => 'success',
                        'tam_hoan' => 'warning',
                        'hoan_tat' => 'primary',
                        'huy' => 'danger',
                        default => 'gray',
                    }),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChuyenBays::route('/'),
            'create' => Pages\CreateChuyenBay::route('/create'),
            'edit' => Pages\EditChuyenBay::route('/{record}/edit'),
        ];
    }
}
