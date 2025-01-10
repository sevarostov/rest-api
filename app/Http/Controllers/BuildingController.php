<?php

namespace App\Http\Controllers;

use App\Http\Resources\BuildingCollection;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Filters\BuildingFilter;
use App\Http\Requests\BuildingRequest;
use App\Http\Resources\BuildingResource;
use App\Models\Building;

class BuildingController extends Controller
{
    private BuildingFilter $filter;

    public function __construct(BuildingRequest $request)
    {
        $this->filter = new BuildingFilter($request);
    }

    /**
     *
     * @OA\Get(
     *       security={{"apiKey": {}}},
     *       path="/api/auth/buildings",
     *       operationId="index",
     *       tags={"Buildings"},
     *       summary="Get list of buildings",
     *       description="Returns list of buildings",
     *       @OA\Response(
     *           response=200,
     *           description="successful operation"
     *        )
     *      )
     *
     *  Returns list of clients
     * /
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $buildings = Building::filter($this->filter)->paginate(10);
        return BuildingCollection::make($buildings);
    }

    public function show(int $id): JsonResource
    {
        $buildings = Building::filter($this->filter)->findOrFail($id);
        return BuildingResource::make($buildings);
    }
}
