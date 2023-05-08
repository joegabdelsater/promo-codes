<?php

namespace Joegabdelsater\PromoCodes;

use Joegabdelsater\PromoCodes\Models\PromoCode;

class PromoCodeRunner
{

    public function generate($length = 8, $prefix = '', $discount = 0, $maxUses = null, $validFrom = null, $validTo = null)
    {
        // Generate a promo code
        $code = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', $length)), 0, $length);

        // Add the prefix if provided
        if ($prefix) {
            $code = $prefix . '-' . $code;
        }

        // Create a new PromoCode using the injected model
        $promoCode = PromoCode::create([
            'code' => $code,
            'discount' => $discount,
            'max_uses' => $maxUses,
            'valid_from' => $validFrom,
            'valid_to' => $validTo,
        ]);

        return $promoCode;
    }

    public static function validate($code)
    {
        $code = PromoCode::where('code', $code)->first();
        $user = auth()->user();

        if (!$code) {
            return [ 'status' => false, 'message' => "Invalid promo code" ];
        }

        if ($code->max_uses && $code->uses >= $code->max_uses) {
            return ['status' => false, 'message' => "Promo code has been used too many times"];
        }

        if ($code->valid_from && $code->valid_from > now()) {
            return ['status' => false, 'message' => "Promo code is not valid yet"];
        }

        if ($code->valid_to && $code->valid_to < now()) {
            return ['status' => false, 'message' => "Promo code has expired"];
        }

        if ($user && $code->userPromoCodes()->where('user_id', $user->id)->exists()) {
            return ['status' => false, 'message' => "Promo code has already been used by you"];
        }

        return $code;
    }

    public static function apply($code)
    {
        $promoCode = self::validate($code);

        if (!$promoCode) {
            return false;
        }

        $promoCode->uses += 1;
        $promoCode->save();

        $user = auth()->user();

        if ($user) {
            $promoCode->userPromoCodes()->create([
                'user_id' => $user->id
            ]);
        }

        return $promoCode;
    }

    public static function calculate($amount, $discount_type, $discount_amount) {
        if ($discount_type == 'percentage') {
            return [
                'total' =>  $amount - ($amount * ($discount_amount / 100)),
                'discount' => $amount * ($discount_amount / 100)
            ];
        }
        
        return [
            'total' => $amount - $discount_amount,
            'discount' => $discount_amount
        ];
    }
}
