<?php

namespace App\Modules\CustomerImporter;

use Illuminate\Support\Collection;

interface ImporterInterface
{
    /**
     * It will import the data of customers
     * and flag the incorrect one
     *
     * @param Collection $data
     * @param array $fill
     * @return Collection
     */
    public function process(Collection $data, array $fill = []);
}
