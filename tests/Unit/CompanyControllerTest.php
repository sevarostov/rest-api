<?php

namespace Tests\Unit;

use App\Http\Controllers\CompanyController;
use App\Http\Filters\CompanyFilter;
use App\Http\Requests\CompanyRequest;
use App\Models\Building;
use App\Models\Company;
use App\Models\Rubric;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }


    public function test_that_getByBuilding_returns_companies(): void
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


    public function test_that_getByRubric_returns_companies(): void
    {
        $rubric = Rubric::factory()->create(['id' => 1]);
        $company = Company::factory()->hasRubrics(2)->create(['id' => 1]);

        Company::all()->each(function ($company) use ($rubric) {
            $company->rubrics()->attach(
                $rubric->pluck('id')->toArray()
            );
        });

        $request = new CompanyRequest();
        $request->initialize(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            $rubric->id
        );

        $companyController               = $this
            ->getMockBuilder(CompanyController::class)
            ->setConstructorArgs([$request])
            ->onlyMethods([])
            ->getMock()
        ;
        $companies = $companyController->getByRubric($rubric->id);

        $this->assertTrue(count($companies) === 1);
    }

    public function test_that_getByMapPoint_returns_companies(): void
    {
        $radiusType    = 1;
        $rectangleType = 2;
        $inValidType   = 3;
        $lat = '47.897709';
        $long = '40.082366';
        $building1 = Building::factory()->create(['id' => 1, 'latitude' => $lat, 'longitude' => $long]);
        $building2 = Building::factory()->create(['id' => 2, 'latitude' => $lat, 'longitude' => $long]);
        $building3 = Building::factory()->create(['id' => 3, 'latitude' => $lat, 'longitude' => $long]);
        $building4 = Building::factory()->create(['id' => 4, 'latitude' => $lat, 'longitude' => $long]);
        $building5 = Building::factory()->create(['id' => 5, 'latitude' => $lat, 'longitude' => $long]);
        $company1 = Company::factory()->create([ 'building_id' => $building1->id ]);
        $company2 = Company::factory()->create([ 'building_id' => $building2->id ]);
        $company3 = Company::factory()->create([ 'building_id' => $building3->id ]);
        $company4 = Company::factory()->create([ 'building_id' => $building4->id ]);
        $company5 = Company::factory()->create([ 'building_id' => $building5->id ]);

        $request = new CompanyRequest();
        $request->initialize(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            [$lat, $long, $radiusType]
        );

        $companyController               = $this
            ->getMockBuilder(CompanyController::class)
            ->setConstructorArgs([$request])
            ->onlyMethods([])
            ->getMock()
        ;
        $companies = $companyController->getByMapPoint($lat, $long, $radiusType);

        $this->assertTrue(count($companies) === 5);
    }
}
