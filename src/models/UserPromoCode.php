<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPromoCode extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'user_promo_codes';

    public function users() {
        return $this->belongsTo('App\Models\User');
    }
}
