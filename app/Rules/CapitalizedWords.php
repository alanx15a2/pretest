<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CapitalizedWords implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^([A-Z][a-z]*)(\s[A-Z][a-z]*)*$/';
        if (preg_match($pattern, $value) === 0) {
            $fail( ucfirst($attribute) . ' is not capitalized.');
        }
    }
}
