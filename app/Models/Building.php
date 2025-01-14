<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(@OA\Xml(name="Building"))
 */
class Building extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;
    /**
     * @OA\Property(
     *       property="id",
     *       type="integer",
     *       example=1
     *     ),
     */
    protected int $id;
    /**
     * @OA\Property(
     *       property="latitude",
     *       type="float",
     *       example=47.897709
     *     ),
     */
    protected float $latitude;
    /**
     * @OA\Property(
     *       property="longitude",
     *       type="float",
     *       example="40.082366"
     *     ),
     */
    protected float $longitude;
    /**
     * @OA\Property(
     *       property="distance",
     *       type="integer",
     *       example="1"
     *     ),
     */
    protected int $distance;
    protected $fillable = ['title', 'latitude', 'longitude'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public static array $sortColumns = [
        'id',
        /**
         * @OA\Property(
         *       property="title",
         *       type="string",
         *       example="67408 Frami Plains Apt. 051
         * North Linnie, DC 98000-2914"
         *     ),
         */
        'title',
        'created_at'
    ];

    public static array $relationships = [
        'companies',
    ];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
