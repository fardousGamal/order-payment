<?php
namespace Modules\Order\App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Payments\App\Models\Payment;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'status', 'total_amount'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeFilter(Builder $query, ?array $filters): Builder
    {
        return $query->when($filters, function (Builder $query) use ($filters) {

            if (isset($filters['status']) ) {
                $query->where('status',$filters['status']);
            }

        });
    }
    protected static function newFactory()
    {
        return \Modules\Order\Database\Factories\OrderFactory::new();
    }
}
