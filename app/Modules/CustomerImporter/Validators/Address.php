<?php

namespace App\Modules\CustomerImporter\Validators;

use Illuminate\Database\Eloquent\Model;

class Address implements Validator
{
    static public function validate(Model $model): bool
    {
        // Call an API
        $api = true;

        return $api;
    }

    static public function score(): int
    {
        return 10;
    }

    static public function message(): string
    {
        return "The address is not valid";
    }
}
