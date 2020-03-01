<?php


namespace App\Modules\CustomerImporter;


use Illuminate\Support\Collection;

class Importer implements ImporterInterface
{
    /**
     * @inheritDoc
     */
    public function process(Collection $data)
    {
        $data->each('tryImport');
    }

    private function tryImport($item)
    {
        dd($item);
    }
}
