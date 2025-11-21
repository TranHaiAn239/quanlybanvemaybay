<?php

namespace App\Filament\Resources\BookingResource\RelationManagers;

use Illuminate\Support\Facades\Mail;
use App\Mail\SeatUpdateMail;
use App\Mail\SeatUnavailableMail;
use Filament\Notifications\Notification; // Để hiện thông báo cho Admin

use Filament\Forms;
use Filament\Resources\Form as ResourceForm;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table as ResourceTable;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action; // Import Action

class VesRelationManager extends RelationManager
{
    protected static string $relationship = 'ves'; // Tên quan hệ trong Model Booking
    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $title = 'Danh sách Vé (Check-in)';

    public static function form(ResourceForm $form): ResourceForm
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('so_ghe')
                    ->label('Số ghế')
                    ->required()
                    ->maxLength(10),
            ]);
    }

    public static function table(ResourceTable $table): ResourceTable
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID Vé'),

                Tables\Columns\TextColumn::make('thongTinNguoiDi.ho_ten')
                    ->label('Hành khách'),

                Tables\Columns\TextColumn::make('chuyenBay.ma_chuyen_bay')
                    ->label('Chuyến bay'),

                Tables\Columns\TextColumn::make('loai_ghe')
                    ->label('Hạng ghế')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('so_ghe')
                    ->label('Số ghế')
                    ->weight('bold')
                    ->color('primary')
                    ->default('-- Chưa chọn --'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Không cho tạo vé mới ở đây, chỉ check-in vé đã có
            ])
            ->actions([
                // 1. Nút Check-in (Chọn ghế MỚI)
                Action::make('check_in')
                    ->label('Check-in (Chọn ghế)')
                    ->icon('heroicon-o-ticket')
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('so_ghe')
                            ->label('Nhập số ghế (VD: 12A)')
                            ->required()
                            ->maxLength(5),
                        // Thêm checkbox gửi mail
                        Forms\Components\Checkbox::make('send_mail')
                            ->label('Gửi email thông báo cho khách ngay')
                            ->default(true),
                    ])
                    ->action(function ($record, array $data) {
                        // Cập nhật số ghế
                        $record->update(['so_ghe' => $data['so_ghe']]);

                        // Gửi mail nếu được tick
                        if ($data['send_mail'] && $record->thongTinNguoiDi->email) {
                            Mail::to($record->thongTinNguoiDi->email)
                                ->send(new SeatUpdateMail($record, false)); // false = chọn mới

                            Notification::make()->title('Đã lưu ghế và gửi mail')->success()->send();
                        }
                    })
                    ->hidden(fn ($record) => $record->so_ghe !== null),

                // 2. Nút Đổi ghế (Sửa ghế)
                Action::make('edit_seat')
                    ->label('Đổi ghế')
                    ->icon('heroicon-o-pencil')
                    ->color('warning')
                    ->form([
                        Forms\Components\TextInput::make('so_ghe')
                            ->label('Số ghế mới')
                            ->required(),
                        Forms\Components\Checkbox::make('send_mail')
                            ->label('Gửi email thông báo thay đổi')
                            ->default(true),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update(['so_ghe' => $data['so_ghe']]);

                        if ($data['send_mail'] && $record->thongTinNguoiDi->email) {
                            Mail::to($record->thongTinNguoiDi->email)
                                ->send(new SeatUpdateMail($record, true)); // true = thay đổi

                            Notification::make()->title('Đã đổi ghế và gửi mail')->success()->send();
                        }
                    })
                    ->hidden(fn ($record) => $record->so_ghe === null),

                // 3. Nút Báo Hết Ghế (MỚI)
                Action::make('seat_unavailable')
                    ->label('Báo hết ghế Y/C')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Thông báo hết ghế theo yêu cầu')
                    ->modalSubheading('Gửi mail xin lỗi khách vì không đáp ứng được yêu cầu ghế (vd: cạnh cửa sổ, lối đi).')
                    ->form([
                        Forms\Components\Textarea::make('reason')
                            ->label('Lý do / Thông báo chi tiết')
                            ->default('Ghế cạnh cửa sổ/lối đi mà quý khách yêu cầu hiện đã hết. Chúng tôi đã xếp ghế tốt nhất còn lại.')
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        if ($record->thongTinNguoiDi->email) {
                            Mail::to($record->thongTinNguoiDi->email)
                                ->send(new SeatUnavailableMail($record, $data['reason']));

                            Notification::make()->title('Đã gửi mail xin lỗi')->success()->send();
                        } else {
                            Notification::make()->title('Khách không có email')->warning()->send();
                        }
                    }),
                ]);
    }
}
