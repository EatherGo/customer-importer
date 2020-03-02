<?php

namespace App\Modules\CustomerImporter;

use App\Modules\CustomerImporter\Validators\Name;
use App\Modules\CustomerImporter\Validators\Telephone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Validator
{
    /**
     * Set the validators
     * add new validators to this array
     * that implements Validator interface
     *
     * @var array
     */
    protected $validators = [
        Name::class,
        Telephone::class,
    ];

    /**
     * Run through validators and return a collection of invalid messages
     *
     * @param Model $model
     * @return Collection
     */
    public function checkValidators(Model $model): Collection
    {
        return collect($this->validators)->filter(function ($validator) use ($model) {
            return !$validator::validate($model);
        });
    }

    /**
     * Get the error messages of validators
     *
     * @param Collection $modelValidation
     * @return string
     */
    public function getErrorMessages(Collection $modelValidation): string
    {
        return $modelValidation->map(function ($validator) {
            return $validator::message();
        })->implode(', ');
    }

    /**
     * @param Collection $modelValidation
     * @return int
     */
    public function calculateDirtiness(Collection $modelValidation): int
    {
        return $modelValidation->map(function ($validator) {
            return $validator::score();
        })->sum();
    }

    /**
     * Check for validity
     *
     * @param Collection $modelValidation
     * @return bool
     */
    public function isValid(Collection $modelValidation): bool
    {
        return $modelValidation->count() === 0;
    }

    /**
     * Get the collection of validators
     *
     * @return Collection
     */
    public function getValidators(): Collection
    {
        return collect($this->validators);
    }
}
