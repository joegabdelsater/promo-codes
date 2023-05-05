<?php

namespace YllwDigital\PromoCodes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'promo_codes';
    
    protected $casts = [
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    public function userPromoCodes()
    {
        return $this->hasMany(UserPromoCode::class);
    }
}
