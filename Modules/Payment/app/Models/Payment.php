<?php
namespace Modules\Payment\App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\App\Models\Order;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'payment_method',
        'status',
        'amount',
    ];

    public function order()
    {
        return $this->belongsTo(
            Order::class
        );
    }
    public function scopeFilter(Builder $query, ?array $filters): Builder
    {
        return $query->when($filters, function (Builder $query) use ($filters) {

            if (isset($filters['status']) ) {
                $query->where('status',$filters['status']);
            }
            if (isset($filters['order']) ) {
                $query->where('order_id',$filters['order']);
            }

        });
    }
}
