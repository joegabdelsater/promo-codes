# Promo Codes Description
This is a simple package to add the promocode discount feature to any website. It works independently from other features.

Note: You should have the users model/table present.

# Installation
`composer require joegabdelsater/promo-codes`
# Usage
To use the library you need to use the facade in your code by adding this line to the top of the file:

`use Joegabdelsater\PromoCodes\Facades\PromoCodes;`

# Functions

## Generate promo code

To generate a promo code, call the generate() method. The method accepts the following parameters:

- `$length (optional)`: The length of the promo code. Default is 8.
- `$prefix (optional)`: A prefix to add to the promo code. Default is an empty string.
- `$discount (optional)`: The discount amount. Default is 0.
- `$maxUses (optional)`: The maximum number of times the promo code can be used. Default is null.
- `$validFrom (optional)`: The date and time from which the promo code is valid. Default is null.
- `$validTo (optional)`: The date and time until which the promo code is valid. Default is null.

Example:

`PromoCodes::generate(10, 'DISCOUNT', 10, 100, '2022-01-01 00:00:00', '2022-12-31 23:59:59');`

## Validate promocode
To validate a promo code, call the validate() method. The method accepts the promo code as a parameter and returns either the promo code object if it is valid or an array with an error message if it is invalid.

Example usage:

`PromoCodes::validate('DISCOUNT-5D8S0A5K5L')`

```  // returns ['status' => false, 'message' => 'Reason why code is not valid']  ```

or

``` // returns ['status' => true, 'code' => 'code details'] ```

# Apply code
To apply the promocode use the apply() method. The method accepts the promo code as a parameter and returns either the promo code object if it is valid or an array with an error message if it is invalid.

Example usage:
`PromoCodes::apply('DISCOUNT-5D8S0A5K5L')`

## Calculate the discounted amount

To calculate the discounted amount after applying a promo code, call the calculate() method. The method accepts the following parameters:

- `$amount`: The original amount before the discount.
- `$discount_type`: The type of discount, either 'percentage' or 'fixed'.
- `$discount_amount`: The amount of the discount.

` PromoCodes::calculate(100, 'percentage', 10)`