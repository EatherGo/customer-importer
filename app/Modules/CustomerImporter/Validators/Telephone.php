<?php

namespace App\Modules\CustomerImporter\Validators;

use Illuminate\Database\Eloquent\Model;

class Telephone implements Validator
{
    /**
     * @inheritDoc
     */
    static public function validate(Model $model): bool
    {
        $pattern = "/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/";

        return preg_match($pattern, $model->telephone);
    }

    /**
     * @inheritDoc
     */
    static public function score(): int
    {
        return 10;
    }

    /**
     * @inheritDoc
     */
    static public function message(): string
    {
        return "Telephone must have a correct format";
    }
}
