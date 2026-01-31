<?php
namespace Modules\Payment\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'config'];

    protected $casts = [
        'config' => 'array',
    ];
}
