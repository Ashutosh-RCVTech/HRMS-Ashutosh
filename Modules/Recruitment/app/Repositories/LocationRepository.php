<?php

namespace Modules\Recruitment\Repositories;

use Modules\Recruitment\Models\Location;

class LocationRepository extends BaseRepository
{
    public function __construct(Location $model)
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
