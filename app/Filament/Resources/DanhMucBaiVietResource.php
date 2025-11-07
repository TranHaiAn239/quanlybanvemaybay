<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DanhMucBaiVietResource\Pages;
use App\Models\DanhMucBaiViet;

// Import các 'use' cho Filament v2
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

// Dùng cho Slug
use Illuminate\Support\Str;

class DanhMucBaiVietResource extends Resource
{
    protected static ?string $model = DanhMucBaiViet::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationLabel = 'Danh mục Bài viết';
    protected static ?string $pluralLabel = 'Danh mục Bài viết';

    // (MỚI) Nhóm chung với Bài Viết
    protected static ?string $navigationGroup = 'Quản lý Bài Viết';
    protected static ?int $navigationSort = 2; // Hiển thị bên dưới 'Bài Viết'

    public static function form(ResourceForm $form): ResourceForm
    {
        return $form
            ->schema([
                Section::make('Thông tin danh mục')
                    ->schema([
                        TextInput::make('ten_danh_muc')
                            ->label('Tên danh mục')
                            ->required()
                            ->maxLength(150)
                            // Tự động tạo slug khi gõ tên
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->label('Đường dẫn (URL)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(170),

                        Select::make('id_danh_muc_cha')
                            ->label('Danh mục cha (Nếu có)')
                            ->relationship('danhMucCha', 'ten_danh_muc') // Tự liên kết đến chính nó
                            ->searchable(), // Cho phép tìm kiếm

                        Select::make('trang_thai')
                            ->label('Trạng thái')
                            ->options([
                                'hien_thi' => 'Hiển thị',
                                'an' => 'Ẩn',
                            ])
                            ->default('hien_thi')
                            ->required(),

                        Textarea::make('mo_ta')
                            ->label('Mô tả')
                            ->rows(3)
                            ->columnSpanFull(), // Chiếm trọn 2 cột
                    ])
                    ->columns(2), // Chia form làm 2 cột
            ]);
    }

    public static function table(ResourceTable $table): ResourceTable
    {
        return $table
            ->columns([
                TextColumn::make('ten_danh_muc')
                    ->label('Tên danh mục')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('danhMucCha.ten_danh_muc') // Tải quan hệ cha
                    ->label('Danh mục cha')
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Đường dẫn'),

                BadgeColumn::make('trang_thai')
                    ->label('Trạng thái')
                    ->colors([
                        'success' => 'hien_thi',
                        'danger' => 'an',
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
            'index' => Pages\ListDanhMucBaiViets::route('/'),
            'create' => Pages\CreateDanhMucBaiViet::route('/create'),
            'edit' => Pages\EditDanhMucBaiViet::route('/{record}/edit'),
        ];
    }
}
