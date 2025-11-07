<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;

// Đảm bảo dùng đúng 'use' cho Filament v2
use Filament\Forms;
use Filament\Resources\Form as ResourceForm;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Table as ResourceTable;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Quản lý Đơn hàng';
    protected static ?string $pluralLabel = 'Đơn hàng';

    public static function form(ResourceForm $form): ResourceForm
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin chính')
                    ->schema([
                        Forms\Components\TextInput::make('ma_booking')
                            ->label('Mã Booking')
                            ->disabled(), // Không cho sửa

                        Forms\Components\Select::make('id_nguoi_dung')
                            ->label('Khách hàng')
                            ->relationship('nguoiDung', 'ho_ten')
                            ->disabled(),

                        Forms\Components\TextInput::make('tong_tien')
                            ->label('Tổng tiền')
                            ->numeric() // Dùng ->numeric() thay thế
                            ->prefix('VND') // Thêm tiền tố
                            ->disabled(),

                        Forms\Components\TextInput::make('giam_gia')
                            ->label('Giảm giá')
                            ->numeric() // Dùng ->numeric() thay thế
                            ->prefix('VND') // Thêm tiền tố
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Trạng thái')
                    ->schema([
                        Forms\Components\Select::make('trang_thai')
                            ->label('Trạng thái')
                            ->options([
                                'cho_thanh_toan' => 'Chờ thanh toán',
                                'da_thanh_toan' => 'Đã thanh toán',
                                'huy' => 'Đã hủy',
                            ])
                            ->required(),

                        Forms\Components\Select::make('phuong_thuc_tt')
                            ->label('Phương thức TT')
                            ->options([
                                'momo' => 'Momo',
                                'zalopay' => 'ZaloPay',
                                'the_tin_dung' => 'Thẻ tín dụng',
                                'tien_mat' => 'Tiền mặt',
                                'khong' => 'Chưa chọn',
                            ])
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(ResourceTable $table): ResourceTable
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ma_booking')
                    ->label('Mã Booking')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nguoiDung.ho_ten')
                    ->label('Khách hàng')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tong_tien')
                    ->label('Tổng tiền')
                    ->formatStateUsing(fn ($state): string => number_format($state, 0, ',', '.') . ' VND')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('trang_thai') // Dùng BadgeColumn cho đẹp
                    ->label('Trạng thái')
                    ->colors([
                        'warning' => 'cho_thanh_toan',
                        'success' => 'da_thanh_toan',
                        'danger' => 'huy',
                    ]),

                Tables\Columns\TextColumn::make('ngay_dat')
                    ->label('Ngày đặt')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                // (Bạn có thể thêm bộ lọc theo trạng thái ở đây)
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('ngay_dat', 'desc'); // Sắp xếp đơn mới nhất lên đầu
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
