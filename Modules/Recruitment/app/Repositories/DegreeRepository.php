<?php

namespace Modules\Recruitment\Repositories;

use Modules\Recruitment\Models\Degree;

class DegreeRepository extends BaseRepository
{
    public function __construct(Degree $model)
    {

        parent::__construct($model);
    }

    public function paginate($perPage = 10)
    {
        return Degree::paginate($perPage);
    }

}
