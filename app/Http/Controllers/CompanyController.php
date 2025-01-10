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
}
