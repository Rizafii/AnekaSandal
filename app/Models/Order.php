<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total_amount',
        'shipping_cost',
        'final_amount',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'payment_proof',
        'payment_status',
        'courier',
        'tracking_number',
        'shipping_image',
        'shipped_at',
        'delivered_at',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime'
    ];

    // Status constants
    const STATUS_MENUNGGU_PEMBAYARAN = 'menunggu_pembayaran';
    const STATUS_SEDANG_DIKIRIM = 'sedang_dikirim'; // Updated to match database
    const STATUS_SELESAI = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';

    const PAYMENT_STATUS_BELUM_BAYAR = 'belum_bayar';
    const PAYMENT_STATUS_MENUNGGU_KONFIRMASI = 'menunggu_konfirmasi';
    const PAYMENT_STATUS_TERKONFIRMASI = 'terkonfirmasi';
    const PAYMENT_STATUS_DITOLAK = 'ditolak';

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    // Boot method to generate order number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        });
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }

    // Helper methods
    public function getStatusLabelAttribute()
    {
        $labels = [
            self::STATUS_MENUNGGU_PEMBAYARAN => 'Menunggu Pembayaran',
            self::STATUS_SEDANG_DIKIRIM => 'Sedang Dikirim',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DIBATALKAN => 'Dibatalkan'
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            self::PAYMENT_STATUS_BELUM_BAYAR => 'Belum Bayar',
            self::PAYMENT_STATUS_MENUNGGU_KONFIRMASI => 'Menunggu Konfirmasi',
            self::PAYMENT_STATUS_TERKONFIRMASI => 'Terkonfirmasi',
            self::PAYMENT_STATUS_DITOLAK => 'Ditolak'
        ];

        return $labels[$this->payment_status] ?? $this->payment_status;
    }

    public function addStatusLog($status, $notes = null, $changedBy = null)
    {
        return $this->statusLogs()->create([
            'status' => $status,
            'notes' => $notes,
            'changed_by' => $changedBy ?? auth()->id()
        ]);
    }

    // Check if order can be cancelled
    public function canBeCancelled()
    {
        return in_array($this->status, [
            self::STATUS_MENUNGGU_PEMBAYARAN
        ]);
    }

    // Check if payment can be uploaded
    public function canUploadPayment()
    {
        return $this->payment_status === self::PAYMENT_STATUS_BELUM_BAYAR ||
            $this->payment_status === self::PAYMENT_STATUS_DITOLAK;
    }

    // Check if order is completed
    public function isCompleted()
    {
        return $this->status === self::STATUS_SELESAI;
    }
}
