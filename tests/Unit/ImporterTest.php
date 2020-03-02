<?php

namespace Tests\Unit;

use App\Customer;
use App\Modules\CustomerImporter\Importer;
use App\Modules\CustomerImporter\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImporterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_import_the_data_and_flag_them()
    {
        $data = [
            [
                'name' => 'Test Name',
                'telephone' => '07222 555555',
            ],
            [
                'name' => '',
                'telephone' => '070222',
            ],
        ];
        $importer = new Importer(Customer::class);

        $importer->process(collect($data), ['name', 'telephone']);

        $this->assertTrue(Customer::count() === 2);
        $this->assertTrue(Customer::valid()->get()->count() === 1);
        $this->assertTrue(Customer::invalid()->get()->count() === 1);
    }

    /** @test */
    public function it_should_set_the_dirtiness_score_and_error_message_if_invalid()
    {
        $data = [
            [
                'name' => '',
                'telephone' => '070222',
            ],
        ];
        $importer = new Importer(Customer::class);

        $importer->process(collect($data), ['name', 'telephone']);

        $validator = new Validator();
        $c = Customer::first();
        $this->assertTrue($c->dirtiness === $validator->calculateDirtiness($validator->getValidators()));
        $this->assertTrue($c->errors === $validator->getErrorMessages($validator->getValidators()));
    }

    /** @test */
    public function it_should_import_only_data_set_to_fill()
    {
        $toFill = ['name'];
        $data = [
            [
                'name' => 'Test Name',
                'telephone' => '07222 555555',
            ],
        ];
        $importer = new Importer(Customer::class);

        $importer->process(collect($data), $toFill);

        $c = Customer::first();
        $this->assertTrue($c->telephone === null);
        $this->assertTrue($c->name === $data[0]['name']);

    }
}
