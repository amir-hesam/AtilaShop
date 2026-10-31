<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'receiver_name',
        'phone',
        'address',
        'total_amount',
        'payment_method',
        'status',
        'tracking_code',
        'receipt_image',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_amount) . ' تومان';
    }

    public function getReceiptImageUrlAttribute(): ?string
    {
        return $this->receipt_image ? asset('storage/' . $this->receipt_image) : null;
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'پرداخت شده', 'تأیید پرداخت' => 'badge-success',
            'در حال آماده‌سازی و بسته‌بندی' => 'badge-info',
            'تحویل به پست / ارسال شده' => 'badge-info',
            'تحویل داده شد' => 'badge-success',
            'در انتظار تأیید پرداخت' => 'badge-warning',
            'پرداخت ناموفق', 'لغو شده' => 'badge-danger',
            default => 'badge-warning',
        };
    }

    /**
     * Map current status to 5-step stepper index (1 to 5)
     * 1: ثبت سفارش
     * 2: تأیید پرداخت
     * 3: بسته‌بندی محرمانه
     * 4: تحویل به پست / ارسال
     * 5: تحویل مرسوله
     */
    public function getStepIndexAttribute(): int
    {
        return match($this->status) {
            'در انتظار پرداخت' => 1,
            'در انتظار تأیید پرداخت' => 1, // فیش ارسال شده، منتظر تأیید فیش
            'تأیید پرداخت', 'پرداخت شده' => 2,
            'در حال آماده‌سازی و بسته‌بندی' => 3,
            'تحویل به پست / ارسال شده' => 4,
            'تحویل داده شد' => 5,
            default => 1,
        };
    }

    public function isCancelled(): bool
    {
        return in_array($this->status, ['لغو شده', 'عدم تأیید پرداخت', 'پرداخت ناموفق']);
    }

    public static array $statusOptions = [
        'در انتظار پرداخت' => '۱. در انتظار پرداخت (قبل از فیش)',
        'در انتظار تأیید پرداخت' => '۲. در انتظار تأیید فیش (توسط کاربر ارسال شد)',
        'تأیید پرداخت' => '۳. تأیید پرداخت (فیش یا درگاه موفق)',
        'در حال آماده‌سازی و بسته‌بندی' => '۴. در حال آماده‌سازی و بسته‌بندی محرمانه',
        'تحویل به پست / ارسال شده' => '۵. تحویل به پست / ارسال شده (همراه با کد رهگیری)',
        'تحویل داده شد' => '۶. تحویل مرسوله به مشتری',
        'لغو شده' => '❌ لغو سفارش / عدم تأیید فیش',
    ];
}
