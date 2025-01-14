<?php

namespace Tests\Unit;

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CompanyController;
use App\Http\Filters\CompanyFilter;
use App\Http\Requests\BuildingRequest;
use App\Http\Requests\CompanyRequest;
use App\Models\Building;
use App\Models\Company;
use App\Models\Rubric;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class BuildingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_that_getByMapPoint_returns_buildings(): void
    {
        $radius    = 1;

        $lat = '47.897709';
        $long = '40.082366';
        $building1 = Building::factory()->create(['id' => 1, 'latitude' => $lat, 'longitude' => $long]);
        $building2 = Building::factory()->create(['id' => 2, 'latitude' => $lat, 'longitude' => $long]);
        $building3 = Building::factory()->create(['id' => 3, 'latitude' => $lat, 'longitude' => $long]);
        $building4 = Building::factory()->create(['id' => 4, 'latitude' => $lat, 'longitude' => $long]);
        $building5 = Building::factory()->create(['id' => 5, 'latitude' => $lat, 'longitude' => $long]);

        $request = new BuildingRequest();
        $request->initialize(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            [$lat, $long, $radius]
        );

        $buildingController               = $this
            ->getMockBuilder(BuildingController::class)
            ->setConstructorArgs([$request])
            ->onlyMethods([])
            ->getMock()
        ;
        $buildings = $buildingController->getByMapPoint($lat, $long, $radius);

        $this->assertTrue(count($buildings) === 5);
    }

    public function test_that_getByRectangle_returns_buildings(): void
    {
        $lat = '47.897709';
        $lat2 = '48.897709';
        $long = '40.082366';
        $long2 = '48.082366';
        $building1 = Building::factory()->create(['id' => 1, 'latitude' => $lat, 'longitude' => $long]);
        $building2 = Building::factory()->create(['id' => 2, 'latitude' => $lat, 'longitude' => $long]);
        $building3 = Building::factory()->create(['id' => 3, 'latitude' => $lat, 'longitude' => $long]);
        $building4 = Building::factory()->create(['id' => 4, 'latitude' => $lat, 'longitude' => $long]);
        $building5 = Building::factory()->create(['id' => 5, 'latitude' => $lat, 'longitude' => $long]);

        $request = new BuildingRequest();
        $request->initialize(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            [$lat, $long, $lat2, $long2]
        );

        $buildingController               = $this
            ->getMockBuilder(BuildingController::class)
            ->setConstructorArgs([$request])
            ->onlyMethods([])
            ->getMock()
        ;
        $buildings = $buildingController->getByRectangle($lat, $long, $lat2, $long2);

        $this->assertTrue(count($buildings) === 5);
    }
}
