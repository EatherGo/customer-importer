<?php

namespace App\Modules\CustomerImporter\Validators;

use Illuminate\Database\Eloquent\Model;

class Name implements Validator
{
    /**
     * @inheritDoc
     */
    static public function validate(Model $model): bool
    {
        return $model->name !== '';
    }

    /**
     * @inheritDoc
     */
    static public function score(): int
    {
        return 15;
    }

    /**
     * @inheritDoc
     */
    static public function message(): string
    {
        return "Name was not correct";
    }
}
