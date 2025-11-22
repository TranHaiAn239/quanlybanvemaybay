<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YeuCauHoTroResource\Pages;
use App\Models\YeuCauHoTro;
use App\Models\Booking;
use Filament\Forms;
use Filament\Resources\Form as ResourceForm;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Resources\Table as ResourceTable;

// Import các components
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action; // Custom Action
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportResponseMail;
use Illuminate\Support\Facades\DB;

class YeuCauHoTroResource extends Resource
{
    protected static ?string $model = YeuCauHoTro::class;

    protected static ?string $navigationIcon = 'heroicon-o-support';
    protected static ?string $navigationLabel = 'Yêu cầu Hỗ trợ';
    protected static ?string $pluralLabel = 'Yêu cầu Hỗ trợ';
    protected static ?string $navigationGroup = 'Chăm sóc Khách hàng';
    protected static ?int $navigationSort = 1;

    public static function form(ResourceForm $form): ResourceForm
    {
        return $form
            ->schema([
                // Cột Trái: Thông tin khách hàng & Yêu cầu
                Forms\Components\Group::make()
                    ->schema([
                        Card::make()->schema([
                            TextInput::make('ho_ten')->label('Họ tên')->disabled(),
                            TextInput::make('email')->label('Email')->disabled(),
                            TextInput::make('so_dien_thoai')->label('SĐT')->disabled(),
                            TextInput::make('ma_booking')->label('Mã Booking Liên Quan')->disabled(),

                            Select::make('loai_yeu_cau')
                                ->label('Loại yêu cầu')
                                ->options([
                                    'huy_ve' => 'Hủy vé',
                                    'hoan_tien' => 'Hoàn tiền',
                                    'thong_tin' => 'Thông tin',
                                    'khac' => 'Khác',
                                ])->disabled(),

                            Textarea::make('noi_dung_yeu_cau')
                                ->label('Nội dung khách gửi')
                                ->rows(4)
                                ->disabled(),
                        ])
                    ])->columnSpan(['lg' => 2]),

                // Cột Phải: Xử lý của Admin
                Forms\Components\Group::make()
                    ->schema([
                        Card::make()->schema([
                            Select::make('trang_thai')
                                ->label('Trạng thái xử lý')
                                ->options([
                                    'moi' => 'Mới tiếp nhận',
                                    'dang_xu_ly' => 'Đang xử lý',
                                    'hoan_tat' => 'Hoàn tất',
                                    'tu_choi' => 'Từ chối',
                                ])
                                ->required(),

                            TextInput::make('phu_phi_huy')
                                ->label('Phí hủy vé (VND)')
                                ->numeric()
                                ->default(0)
                                ->disabled(fn ($get) => $get('loai_yeu_cau') !== 'huy_ve') // Chỉ hiện khi hủy vé
                                ->helperText('Mặc định 300.000 nếu là yêu cầu hủy vé'),

                            Textarea::make('phan_hoi_admin')
                                ->label('Ghi chú / Phản hồi nội bộ')
                                ->rows(4),

                            Forms\Components\Placeholder::make('created_at')
                                ->label('Ngày tạo')
                                ->content(fn (?YeuCauHoTro $record): string => $record ? $record->ngay_tao->diffForHumans() : '-'),
                        ])
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(ResourceTable $table): ResourceTable
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->label('ID'),
                TextColumn::make('ho_ten')->searchable()->label('Khách hàng'),
                BadgeColumn::make('loai_yeu_cau')
                    ->colors([
                        'danger' => 'huy_ve',
                        'warning' => 'hoan_tien',
                        'primary' => 'thong_tin',
                    ])
                    ->label('Loại'),

                TextColumn::make('ma_booking')->searchable()->label('Booking'),

                BadgeColumn::make('trang_thai')
                    ->colors([
                        'gray' => 'moi',
                        'warning' => 'dang_xu_ly',
                        'success' => 'hoan_tat',
                        'danger' => 'tu_choi',
                    ])
                    ->label('Trạng thái'),

                TextColumn::make('ngay_tao')->dateTime('d/m/Y H:i')->sortable()->label('Ngày gửi'),
            ])
            ->defaultSort('ngay_tao', 'desc')
            ->actions([
                // Nút 1: Xem/Sửa chi tiết
                Tables\Actions\EditAction::make(),

                // Nút 2: Xử lý HỦY VÉ & Gửi Mail (Custom Action)
                Action::make('process_cancel')
                    ->label('Xử lý Hủy vé')
                    ->icon('heroicon-o-ban')
                    ->color('danger')
                    // Chỉ hiện nút này nếu là yêu cầu Hủy vé và chưa hoàn tất
                    ->visible(fn (YeuCauHoTro $record) =>
                        $record->loai_yeu_cau === 'huy_ve' &&
                        $record->trang_thai !== 'hoan_tat' &&
                        $record->ma_booking
                    )
                    ->requiresConfirmation()
                    ->modalHeading('Xác nhận Hủy vé & Gửi mail')
                    ->modalSubheading('Hành động này sẽ: Chuyển trạng thái Booking sang "Hủy", tính phí 300k, và gửi email thông báo cho khách.')
                    ->action(function (YeuCauHoTro $record) {

                        // 1. Tìm Booking
                        $booking = Booking::where('ma_booking', $record->ma_booking)->first();

                        if (!$booking) {
                            Notification::make()->title('Không tìm thấy Booking ' . $record->ma_booking)->danger()->send();
                            return;
                        }

                        DB::beginTransaction();
                        try {
                            // 2. Cập nhật Booking -> Hủy
                            $booking->update(['trang_thai' => 'huy']);
                            $booking->ves()->update(['trang_thai' => 'huy']);
                            if($booking->hoaDon) $booking->hoaDon->update(['trang_thai' => 'huy']);

                            // 3. Cập nhật Yêu cầu -> Hoàn tất
                            $record->update([
                                'trang_thai' => 'hoan_tat',
                                'phan_hoi_admin' => 'Đã xử lý hủy vé tự động. Phí hủy: 300.000 VND.',
                                'phu_phi_huy' => 300000
                            ]);

                            // 4. Gửi Email
                            Mail::to($record->email)->send(
                                new SupportResponseMail($record, "Yêu cầu hủy vé của bạn đã được xử lý thành công.", true)
                            );

                            DB::commit();
                            Notification::make()->title('Đã hủy vé và gửi mail thành công')->success()->send();

                        } catch (\Exception $e) {
                            DB::rollBack();
                            Notification::make()->title('Lỗi: ' . $e->getMessage())->danger()->send();
                        }
                    }),

                // Nút 3: Gửi Phản hồi thường (Cho các yêu cầu khác)
                Action::make('reply_email')
                    ->label('Gửi Phản hồi')
                    ->icon('heroicon-o-mail')
                    ->color('primary')
                    ->form([
                        Textarea::make('noi_dung')
                            ->label('Nội dung phản hồi')
                            ->required()
                            ->default('Cảm ơn quý khách đã liên hệ. Về vấn đề của quý khách...'),
                        Select::make('status')
                            ->label('Cập nhật trạng thái')
                            ->options([
                                'dang_xu_ly' => 'Đang xử lý',
                                'hoan_tat' => 'Hoàn tất',
                            ])
                            ->default('hoan_tat')
                    ])
                    ->action(function (YeuCauHoTro $record, array $data) {
                        // Cập nhật yêu cầu
                        $record->update([
                            'trang_thai' => $data['status'],
                            'phan_hoi_admin' => $data['noi_dung']
                        ]);

                        // Gửi mail
                        Mail::to($record->email)->send(
                            new SupportResponseMail($record, $data['noi_dung'], false)
                        );

                        Notification::make()->title('Đã gửi phản hồi')->success()->send();
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListYeuCauHoTros::route('/'),
            'create' => Pages\CreateYeuCauHoTro::route('/create'),
            'edit' => Pages\EditYeuCauHoTro::route('/{record}/edit'),
        ];
    }
}
