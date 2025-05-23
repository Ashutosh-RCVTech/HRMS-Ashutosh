<?php

namespace Modules\Recruitment\Repositories;

use Modules\Recruitment\Models\Client;

class ClientRepository extends BaseRepository
{
    public function __construct(Client $model)
    {
        parent::__construct($model);
    }

    public function newQuery()
    {
        return $this->model->newQuery();
    }
}
