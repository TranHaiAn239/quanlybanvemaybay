<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NguoiDungResource\Pages;
use App\Models\NguoiDung;

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
use Filament\Forms\Components\Section;

// Import các cột Table v2
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

// Dùng cho Mật khẩu
use Illuminate\Support\Facades\Hash;
use Filament\Pages\Page;

class NguoiDungResource extends Resource
{
    protected static ?string $model = NguoiDung::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Quản lý Người Dùng';
    protected static ?string $pluralLabel = 'Người Dùng';

    // (Tùy chọn) Nhóm nó vào mục "Cài đặt"
    protected static ?string $navigationGroup = 'Cài đặt Hệ thống';

    public static function form(ResourceForm $form): ResourceForm
    {
        return $form
            ->schema([
                Section::make('Thông tin cá nhân')
                    ->schema([
                        TextInput::make('ho_ten')
                            ->label('Họ tên')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true) // Đảm bảo email là duy nhất
                            ->maxLength(100),

                        TextInput::make('so_dien_thoai')
                            ->label('Số điện thoại')
                            ->tel() // Định dạng điện thoại
                            ->maxLength(20),

                        Textarea::make('dia_chi')
                            ->label('Địa chỉ')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2), // Chia section này làm 2 cột

                Section::make('Thông tin mật khẩu & Phân quyền')
                    ->schema([
                        TextInput::make('mat_khau')
                            ->label('Mật khẩu')
                            ->password() // Che mật khẩu
                            ->maxLength(255)
                            // 1. Chỉ bắt buộc nhập khi TẠO MỚI (create)
                            ->required(fn (Page $livewire): bool => $livewire instanceof Pages\CreateNguoiDung)
                            // 2. Tự động băm (hash) mật khẩu khi lưu
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            // 3. Không điền (dehydrated) nếu để trống (khi edit)
                            ->dehydrated(fn ($state) => filled($state)),

                        Select::make('vai_tro')
                            ->label('Vai trò')
                            ->options([
                                'admin' => 'Admin (Quản trị viên)',
                                'nhan_vien' => 'Nhân viên',
                                'khach_hang' => 'Khách hàng',
                            ])
                            ->default('khach_hang')
                            ->required(),

                        Select::make('trang_thai')
                            ->label('Trạng thái')
                            ->options([
                                'hoat_dong' => 'Hoạt động',
                                'khoa' => 'Khóa',
                            ])
                            ->default('hoat_dong')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(ResourceTable $table): ResourceTable
    {
        return $table
            ->columns([
                TextColumn::make('ho_ten')
                    ->label('Họ tên')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('so_dien_thoai')
                    ->label('Số điện thoại')
                    ->searchable(),

                BadgeColumn::make('vai_tro')
                    ->label('Vai trò')
                    ->colors([
                        'danger' => 'admin',
                        'success' => 'nhan_vien',
                        'primary' => 'khach_hang',
                    ]),

                BadgeColumn::make('trang_thai')
                    ->label('Trạng thái')
                    ->colors([
                        'success' => 'hoat_dong',
                        'danger' => 'khoa',
                    ]),

                TextColumn::make('ngay_tao')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y')
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
            ->defaultSort('ngay_tao', 'desc'); // Sắp xếp người dùng mới lên đầu
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
            'index' => Pages\ListNguoiDungs::route('/'),
            'create' => Pages\CreateNguoiDung::route('/create'),
            'edit' => Pages\EditNguoiDung::route('/{record}/edit'),
        ];
    }
}
