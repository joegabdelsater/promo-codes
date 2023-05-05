<?php

namespace YllwDigital\PromoCodes;

use YllwDigital\PromoCodes\Models\PromoCode;

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
            return false;
        }

        if ($code->max_uses && $code->uses >= $code->max_uses) {
            return false;
        }

        if ($code->valid_from && $code->valid_from > now()) {
            return false;
        }

        if ($code->valid_to && $code->valid_to < now()) {
            return false;
        }

        if ($user && $code->userPromoCodes()->where('user_id', $user->id)->exists()) {
            return false;
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

        return true;
    }
}
