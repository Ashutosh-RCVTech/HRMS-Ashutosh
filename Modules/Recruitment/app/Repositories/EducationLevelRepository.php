<?php

namespace Modules\Recruitment\Repositories;

use Modules\Recruitment\Models\EducationLevel;
use Illuminate\Database\Eloquent\Model;

class EducationLevelRepository extends BaseRepository
{
    public function __construct(EducationLevel $model)
    {
        parent::__construct($model);
    }

    public function paginate($perPage = 10, $search = null)
    {
        $query = $this->model->query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        return $query->orderBy('name')->paginate($perPage);
    }
}
