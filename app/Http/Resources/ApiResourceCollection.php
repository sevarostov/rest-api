<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @OA\Info(title="Rest API for catalog", version="1")
 * @OA\Schema(@OA\Xml(name="ApiResourceCollection"))
 */
class ApiResourceCollection extends ResourceCollection
{
    /**
     * @OA\Property(
     *       property="total",
     *       type="integer",
     *       example=10
     *     ),
     */
    protected int $total;
    /**
     * @OA\Property(
     *       property="perPage",
     *       type="integer",
     *       example=10
     *     ),
     */
    protected int $perPage;
    /**
     * @OA\Property(
     *       property="currentPage",
     *       type="integer",
     *       example=1
     *     ),
     */
    protected int $currentPage;
    /**
     * @OA\Property(
     *       property="totalPages",
     *       type="integer",
     *       example=1
     *     ),
     */
    protected int $totalPages;
    /**
     * @OA\Property(
     *       property="nextPage",
     *       type="integer",
     *       example=null
     *     ),
     */
    protected int|null $nextPage;
    /**
     * @OA\Property(
     *       property="prevPage",
     *       type="integer",
     *       example=null
     *     ),
     */
    protected int|null $prevPage;
    protected array $meta;

    public function __construct(LengthAwarePaginator $resource)
    {

        $this->meta = [
            'total' => $resource->total(),
            'perPage' => $resource->perPage(),
            'currentPage' => $resource->currentPage(),
            'totalPages' => $resource->lastPage(),
            'nextPage'  => $resource->nextPageUrl(),
            'prevPage'  => $resource->previousPageUrl(),
        ];

        parent::__construct($resource->getCollection());
    }

    public function toArray($request): array
    {
        return [
            'meta' => $this->meta,
            'data' => $this->collection
        ];
    }
}
