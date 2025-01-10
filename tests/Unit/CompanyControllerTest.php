<?php

namespace Tests\Unit;

use App\Http\Controllers\CompanyController;
use App\Http\Filters\CompanyFilter;
use App\Http\Requests\CompanyRequest;
use App\Models\Building;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class CompanyControllerTest extends TestCase
{
//    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * A basic test example.
     */
    public function test_that_getByBuilding_return_companies(): void
    {
        $building = Building::factory()->create(['id' => 1]);
        $company = Company::factory()->create([ 'building_id' => $building->id ]);

        $request = new CompanyRequest();
        $request->initialize(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            $building->id
        );

        $companyController               = $this
            ->getMockBuilder(CompanyController::class)
            ->setConstructorArgs([$request])
            ->onlyMethods([])
            ->getMock()
        ;
        $companies = $companyController->getByBuilding($building->id);

        $this->assertTrue(count($companies) === 1);
    }
}
