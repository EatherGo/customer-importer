<?php

namespace App\Modules\CustomerImporter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Importer implements ImporterInterface
{
    /**
     * @var Model
     */
    private $model;

    /**
     * @var array
     */
    private $fill;
    /**
     * @var Validator|null
     */
    private $validator;

    /**
     * Importer constructor.
     *
     * @param string $model
     * @param Validator|null $validator
     */
    public function __construct(string $model, Validator $validator = null)
    {
        if (is_null($validator)) {
            $validator = new Validator;
        }

        $this->model = $model;
        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     */
    public function process(Collection $data, array $fill = [])
    {
        $this->fill = $fill;

        $data->each($this->importItem());
    }

    /**
     * Importing the items
     *
     * @return callable
     */
    private function importItem(): callable
    {
        return function ($item) {
            $model = $this->prepareModel($item);
            $modelValidation = $this->validator->checkValidators($model);

            $model->fill([
                'valid' => $this->validator->isValid($modelValidation),
                'errors' => $this->validator->getErrorMessages($modelValidation),
                'dirtiness' => $this->validator->calculateDirtiness($modelValidation),
            ]);

            $model->save();
        };
    }

    /**
     * Will return original item if fill is an empty array
     * or only keys that are in fill array
     *
     * @param $item
     * @return array
     */
    private function allowed($item): array
    {
        if (count($this->fill) === 0) {
            return $item;
        }

        return array_intersect_key($item, array_flip($this->fill));
    }

    /**
     * Prepare model and fill the initial data into the model
     *
     * @param $item
     * @return Model
     */
    private function prepareModel($item): Model
    {
        /** @var Model $model */
        $model = new $this->model;

        return $model->fill($this->allowed($item));
    }
}
