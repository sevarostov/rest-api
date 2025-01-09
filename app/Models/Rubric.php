<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rubric extends Model
{
    public const MAX_DEPTH = 3;
    use HasFactory;
    use SoftDeletes;
    use Filterable;

    protected $fillable = ['title'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public static array $sortColumns = [
        'id',
        'title',
        'created_at'
    ];

    public static array $relationships = [
        'subrubrics',
        'companies',
    ];

    public function subrubrics(bool $recursive = true, bool $withCompanies = false)
    {
        $relation = $this->hasMany(Rubric::class, 'parent_id');

        if ($recursive) {
            if ($withCompanies)
                $relation->with('subrubrics.companies');
            else
                $relation->with('subrubrics');
        } elseif ($withCompanies)
            $relation->with('companies');

        return $relation;
    }

    public function rubrics() {
        return $this->hasMany(Rubric::class);
    }

    /**
     * ограничить уровень вложенности деятельностей 3 уровням
     * @param int $depth
     * @return void
     */
    public function loadNestedRelationships(int $depth = self::MAX_DEPTH)
    {
        $this->rubrics();
        if ($depth > 0) {
            foreach ($this->rubrics() as $rubric) {
                $rubric->loadNestedRelationships($depth - 1);
            }
        }
    }


    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
}
