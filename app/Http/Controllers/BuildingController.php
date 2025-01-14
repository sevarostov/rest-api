<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResourceCollection;
use App\Http\Resources\BuildingCollection;
use App\Http\Resources\CompanyResourceCollection;
use App\Models\Company;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Filters\BuildingFilter;
use App\Http\Requests\BuildingRequest;
use App\Http\Resources\BuildingResource;
use App\Models\Building;
use Illuminate\Support\Facades\DB;

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
     *       tags={"Building"},
     *       summary="Get list of buildings",
     *       description="Returns list of buildings",
     *       @OA\Response(
     *           response=200,
     *           description="successful operation",
     *          @OA\MediaType(
     *                 mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                               property="meta",
     *                               type="array",
     *                             @OA\Items(ref="#/components/schemas/ApiResourceCollection")
     *                      ),
     *                       @OA\Property(
     *                                property="data",
     *                                type="array",
     *                                @OA\Items(ref="#/components/schemas/Building")
     *                       ),
     *                 ),
     *          ),
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

    /**
     * @OA\Get(
     *       security={{"apiKey": {}}},
     *       path="/api/auth/buildings/map/point/{latitude}/{longitude}/{radius}",
     *       operationId="getBuildingsByMapPoint",
     *       tags={"Building"},
     *       summary="Get list of Buildings by map point and radius",
     *       description="Returns list of buildings by map point and radius",
     *           @OA\Parameter(
     *           description="latitude",
     *           in="path",
     *           name="latitude",
     *           required=true,
     *           @OA\Schema(
     *               type="string",
     *               example="47.897709"
     *           )
     *       ),
     *            @OA\Parameter(
     *            description="longitude",
     *            in="path",
     *            name="longitude",
     *            required=true,
     *            @OA\Schema(
     *                type="string",
     *                example="40.082366"
     *            )
     *        ),
     *             @OA\Parameter(
     *             description="radius (km)",
     *             in="path",
     *             name="radius",
     *             required=true,
     *             @OA\Schema(
     *                 type="integer",
     *                 example="1"
     *             )
     *         ),
     *       @OA\Response(
     *           response=200,
     *           description="successful operation",
     *          @OA\MediaType(
     *                mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                              property="meta",
     *                              type="array",
     *                            @OA\Items(ref="#/components/schemas/ApiResourceCollection")
     *                     ),
     *                      @OA\Property(
     *                               property="data",
     *                               type="array",
     *                               @OA\Items(ref="#/components/schemas/Building")
     *                      ),
     *                ),
     *         ),
     *       )
     *  )
     *
     *  Returns list of Buildings by map point and radius
     * /
     * @return JsonResource
     */
    public function getByMapPoint(string $latitude, string $longitude, int $radius)
    : JsonResource
    {
        $this->filter->lat = $latitude;
        $this->filter->lon = $longitude;
        $this->filter->radius = $radius;
        $buildings = Building::filter($this->filter)->paginate(10);

        return ApiResourceCollection::make($buildings);
    }

    /**
     * @OA\Get(
     *       security={{"apiKey": {}}},
     *       path="/api/auth/buildings/rectangle/{latitude1}/{longitude1}/{latitude2}/{longitude2}",
     *       operationId="getBuildingByRectangle",
     *       tags={"Building"},
     *       summary="Get list of buildings by rectangle",
     *       description="Returns list of buildings by rectangle",
     *           @OA\Parameter(
     *           description="latitude1",
     *           in="path",
     *           name="latitude1",
     *           required=true,
     *           @OA\Schema(
     *               type="string",
     *               example="47.897709"
     *           )
     *       ),
     *            @OA\Parameter(
     *            description="longitude1",
     *            in="path",
     *            name="longitude1",
     *            required=true,
     *            @OA\Schema(
     *                type="string",
     *                example="40.082366"
     *            )
     *        ),
     *            @OA\Parameter(
     *            description="latitude2",
     *            in="path",
     *            name="latitude2",
     *            required=true,
     *            @OA\Schema(
     *                type="string",
     *                example="48.897709"
     *            )
     *        ),
     *             @OA\Parameter(
     *             description="longitude2",
     *             in="path",
     *             name="longitude2",
     *             required=true,
     *             @OA\Schema(
     *                 type="string",
     *                 example="41.082366"
     *             )
     *         ),
     *       @OA\Response(
     *           response=200,
     *           description="successful operation",
     *          @OA\MediaType(
     *                 mediaType="application/json",
     *                  @OA\Schema(
     *                      @OA\Property(
     *                               property="meta",
     *                               type="array",
     *                             @OA\Items(ref="#/components/schemas/ApiResourceCollection")
     *                      ),
     *                       @OA\Property(
     *                                property="data",
     *                                type="array",
     *                                @OA\Items(ref="#/components/schemas/Building")
     *                       ),
     *                 ),
     *          ),
     *        )
     *      )
     *
     *  Returns list of buildings by rectangle
     * /
     * @return JsonResource
     */
    public function getByRectangle(string $latitude1, string $longitude1, string $latitude2, string $longitude2)
    : JsonResource
    {
        $this->filter->lat = $latitude1;
        $this->filter->lon = $longitude1;
        $this->filter->lat2 = $latitude2;
        $this->filter->lon2 = $longitude2;
        $buildings = Building::filter($this->filter)->paginate(10);

        return ApiResourceCollection::make($buildings);
    }
}
