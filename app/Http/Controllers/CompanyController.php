<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResourceCollection;
use App\Models\Building;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Filters\CompanyFilter;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Info(title="Rest API for catalog", version="1")
 */
class CompanyController extends Controller
{
    private CompanyFilter $filter;

    public function __construct(CompanyRequest $request)
    {
        $this->filter = new CompanyFilter($request);
    }

    public function index(): JsonResource
    {
        $companies = Company::filter($this->filter)->paginate(10);
        return CompanyCollection::make($companies);
    }

    public function show(int $id): JsonResource
    {
        $companies = Company::filter($this->filter)->findOrFail($id);
        return CompanyResource::make($companies);
    }
    /**
     * @OA\Get(
     *       security={{"apiKey": {}}},
     *       path="/api/auth/companies/building/{id}",
     *       operationId="getByBuilding",
     *       tags={"Company"},
     *       summary="Get list of companies by building",
     *       description="Returns list of companies by building",
     *           @OA\Parameter(
     *           description="building id",
     *           in="path",
     *           name="id",
     *           required=true,
     *           @OA\Schema(
     *               type="integer",
     *               example="1"
     *           )
     *       ),
     *       @OA\Response(
     *           response=200,
     *           description="successful operation"
     *        )
     *      )
     *
     *  Returns list of companies by building
     * /
     * @return JsonResource
     */
    public function getByBuilding(int $id): JsonResource
    {
        $companies = Company::withWhereHas('building', fn($query) => $query->where('id', '=', $id))->get();

        return CompanyResourceCollection::make($companies);
    }

    /**
     * @OA\Get(
     *       security={{"apiKey": {}}},
     *       path="/api/auth/companies/rubric/{id}",
     *       operationId="getByRubric",
     *       tags={"Company"},
     *       summary="Get list of companies by rubric",
     *       description="Returns list of companies by rubric",
     *           @OA\Parameter(
     *           description="rubric id",
     *           in="path",
     *           name="id",
     *           required=true,
     *           @OA\Schema(
     *               type="integer",
     *               example="1"
     *           )
     *       ),
     *       @OA\Response(
     *           response=200,
     *           description="successful operation"
     *        )
     *      )
     *
     *  Returns list of companies by rubric
     * /
     * @return JsonResource
     */
    public function getByRubric(int $id): JsonResource
    {
        $companies = Company::withWhereHas('rubrics', fn($query) => $query->where('rubric_id', '=', $id))->get();

        return CompanyResourceCollection::make($companies);
    }

    /**
     * @OA\Get(
     *       security={{"apiKey": {}}},
     *       path="/api/auth/companies/map/point/{latitude}/{longitude}/{radius}",
     *       operationId="getByMapPoint",
     *       tags={"Company"},
     *       summary="Get list of companies by map point and radius",
     *       description="Returns list of companies by map point and radius",
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
     *           description="successful operation"
     *        )
     *      )
     *
     *  Returns list of companies by map point and radius
     * /
     * @return JsonResource
     */
    public function getByMapPoint(string $latitude, string $longitude, int $radius)
    : JsonResource
    {
        $this->filter->lat = $latitude;
        $this->filter->lon = $longitude;
        $this->filter->radius = $radius;
        $companies = Company::filter($this->filter)->paginate(10);

        return CompanyResourceCollection::make($companies);
    }

    /**
     * @OA\Get(
     *       security={{"apiKey": {}}},
     *       path="/api/auth/companies/rectangle/{latitude1}/{longitude1}/{latitude2}/{longitude2}",
     *       operationId="getByRectangle",
     *       tags={"Company"},
     *       summary="Get list of companies by rectangle",
     *       description="Returns list of companies by rectangle",
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
     *           description="successful operation"
     *        )
     *      )
     *
     *  Returns list of companies by rectangle
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
        $companies = Company::filter($this->filter)->paginate(10);

        return CompanyResourceCollection::make($companies);
    }
}
