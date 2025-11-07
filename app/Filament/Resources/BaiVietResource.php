<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BaiVietResource\Pages;
use App\Models\BaiViet;

// Đảm bảo dùng đúng 'use' cho Filament v2
use Filament\Forms;
use Filament\Resources\Form as ResourceForm;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Table as ResourceTable;

// Import các trường Form
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

// Import các cột Table
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;

// Dùng cho Slug
use Illuminate\Support\Str;

class BaiVietResource extends Resource
{
    protected static ?string $model = BaiViet::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Quản lý Bài Viết';
    protected static ?string $pluralLabel = 'Bài viết';

    protected static ?string $navigationGroup = 'Quản lý Bài Viết';
    protected static ?int $navigationSort = 1; // Hiển thị bên dưới 'Bài Viết'

    public static function form(ResourceForm $form): ResourceForm
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        // Cột trái (Nội dung chính)
                        Section::make('Nội dung bài viết')
                            ->schema([
                                TextInput::make('tieu_de')
                                    ->label('Tiêu đề')
                                    ->required()
                                    ->maxLength(255)
                                    // Tự động tạo slug (đường dẫn)
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->label('Đường dẫn (URL)')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                Textarea::make('mo_ta_ngan')
                                    ->label('Mô tả ngắn (Sapo)')
                                    ->rows(3),

                                RichEditor::make('noi_dung')
                                    ->label('Nội dung đầy đủ')
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(2),

                        // Cột phải (Thông tin phụ)
                        Section::make('Thông tin')
                            ->schema([
                                FileUpload::make('hinh_anh_dai_dien')
                                    ->label('Ảnh đại diện')
                                    ->image()
                                    ->directory('bai-viet'), // Sẽ lưu vào storage/app/public/bai-viet

                                Select::make('id_danh_muc')
                                    ->label('Danh mục')
                                    ->relationship('danhMuc', 'ten_danh_muc')
                                    ->required(),

                                Select::make('id_tac_gia')
                                    ->label('Tác giả')
                                    ->relationship('tacGia', 'ho_ten')
                                    ->searchable()
                                    ->required()
                                    ->default(auth()->id()), // Tự động chọn người đang đăng nhập

                                Select::make('trang_thai')
                                    ->label('Trạng thái')
                                    ->options([
                                        'xuat_ban' => 'Xuất bản',
                                        'nhap' => 'Nháp',
                                        'cho_duyet' => 'Chờ duyệt',
                                    ])
                                    ->default('nhap')
                                    ->required(),

                                DateTimePicker::make('ngay_xuat_ban')
                                    ->label('Ngày xuất bản')
                                    ->default(now()),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(ResourceTable $table): ResourceTable
    {
        return $table
            ->columns([
                ImageColumn::make('hinh_anh_dai_dien')
                    ->label('Ảnh')
                    ->square(), // Hiển thị ảnh vuông

                TextColumn::make('tieu_de')
                    ->label('Tiêu đề')
                    ->searchable()
                    ->sortable()
                    ->limit(50), // Giới hạn độ dài

                TextColumn::make('danhMuc.ten_danh_muc')
                    ->label('Danh mục')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tacGia.ho_ten')
                    ->label('Tác giả')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('trang_thai')
                    ->label('Trạng thái')
                    ->colors([
                        'success' => 'xuat_ban',
                        'warning' => 'cho_duyet',
                        'danger' => 'nhap',
                    ]),

                TextColumn::make('ngay_xuat_ban')
                    ->label('Ngày đăng')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                // (Bạn có thể thêm bộ lọc theo danh mục ở đây)
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('ngay_xuat_ban', 'desc'); // Sắp xếp bài mới nhất lên đầu
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
            'index' => Pages\ListBaiViets::route('/'),
            'create' => Pages\CreateBaiViet::route('/create'),
            'edit' => Pages\EditBaiViet::route('/{record}/edit'),
        ];
    }
}
