<?php

namespace Tests\Unit;

use App\Http\Controllers\CompanyController;
use App\Http\Filters\CompanyFilter;
use App\Http\Requests\CompanyRequest;
use App\Models\Building;
use App\Models\Company;
use App\Service\MessageService;
use PHPUnit\Framework\TestCase;

class CompanyControllerTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_getByBuilding_return_companies(): void
    {
        $building = Building::factory()->make(['id' => 1]);
        $company = Company::factory()->make([ 'building_id' => $building->id ]);

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
        $company = $companyController->getByBuilding($building->id);
        dd('$company2');
        $this->assertTrue(true);
    }
}
