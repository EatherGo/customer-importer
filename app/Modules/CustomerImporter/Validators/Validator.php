<?php

namespace App\Modules\CustomerImporter\Validators;

use Illuminate\Database\Eloquent\Model;

interface Validator
{
    /**
     * Run a validation and return bool
     *
     * @param Model $model
     * @return bool
     */
    static public function validate(Model $model): bool;

    /**
     * Get the score of validator for setting the dirtiness
     *
     * @return int
     */
    static public function score(): int;

    /**
     * Get an error message for the validator
     *
     * @return string
     */
    static public function message(): string;
}
