<?php

namespace Modules\Recruitment\Repositories;

use Modules\Recruitment\Models\JobType;

class JobTypeRepository extends BaseRepository
{
    public function __construct(JobType $model)
    {
        parent::__construct($model);
    }
}
