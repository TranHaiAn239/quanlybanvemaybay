<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KhuyenMaiResource\Pages;
use App\Models\KhuyenMai;

// Đảm bảo dùng đúng 'use' cho Filament v2
use Filament\Forms;
use Filament\Resources\Form as ResourceForm;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Table as ResourceTable;

// Import các trường Form v2
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;

// Import các cột Table v2
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class KhuyenMaiResource extends Resource
{
    protected static ?string $model = KhuyenMai::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationLabel = 'Quản lý Khuyến Mãi';
    protected static ?string $pluralLabel = 'Khuyến Mãi';

    // (Tùy chọn) Bạn có thể nhóm nó vào mục "Quản lý Đơn hàng" nếu muốn
    // protected static ?string $navigationGroup = 'Quản lý Đơn hàng';

    public static function form(ResourceForm $form): ResourceForm
    {
        return $form
            ->schema([
                Section::make('Thông tin khuyến mãi')
                    ->schema([
                        TextInput::make('ma_khuyen_mai')
                            ->label('Mã khuyến mãi')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Textarea::make('mo_ta')
                            ->label('Mô tả')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(1),

                Section::make('Giá trị & Thời gian')
                    ->schema([
                        TextInput::make('gia_tri')
                            ->label('Giá trị')
                            ->numeric()
                            ->required()
                            ->default(0),

                        Select::make('loai_gia_tri')
                            ->label('Loại giá trị')
                            ->options([
                                'phan_tram' => 'Phần trăm (%)',
                                'tien_mat' => 'Tiền mặt (VND)',
                            ])
                            ->default('phan_tram')
                            ->required(),

                        DatePicker::make('ngay_bat_dau')
                            ->label('Ngày bắt đầu')
                            ->default(now()),

                        DatePicker::make('ngay_ket_thuc')
                            ->label('Ngày kết thúc')
                            ->default(now()->addDays(30)),

                        Select::make('trang_thai')
                            ->label('Trạng thái')
                            ->options([
                                'hieu_luc' => 'Hiệu lực',
                                'het_han' => 'Hết hạn',
                            ])
                            ->default('hieu_luc')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(ResourceTable $table): ResourceTable
    {
        return $table
            ->columns([
                TextColumn::make('ma_khuyen_mai')
                    ->label('Mã KM')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('mo_ta')
                    ->label('Mô tả')
                    ->limit(40), // Giới hạn độ dài

                TextColumn::make('gia_tri')
                    ->label('Giá trị')
                    ->sortable()
                    // Thêm logic hiển thị % hoặc VND
                    ->formatStateUsing(fn (KhuyenMai $record): string =>
                        $record->loai_gia_tri === 'phan_tram'
                            ? $record->gia_tri . ' %'
                            : number_format($record->gia_tri, 0, ',', '.') . ' VND'
                    ),

                BadgeColumn::make('trang_thai')
                    ->label('Trạng thái')
                    ->colors([
                        'success' => 'hieu_luc',
                        'danger' => 'het_han',
                    ]),

                TextColumn::make('ngay_bat_dau')
                    ->label('Bắt đầu')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('ngay_ket_thuc')
                    ->label('Kết thúc')
                    ->date('d/m/Y')
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
            'index' => Pages\ListKhuyenMais::route('/'),
            'create' => Pages\CreateKhuyenMai::route('/create'),
            'edit' => Pages\EditKhuyenMai::route('/{record}/edit'),
        ];
    }
}
