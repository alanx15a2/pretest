<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Make sure value only contain alphabet and space
 */
class AlphaSpace implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = "/^[a-zA-Z\s]+$/";
        if (preg_match($pattern, $value) === 0) {
            $fail( ucfirst($attribute) . ' contains non-english character.');
        }
    }
}
