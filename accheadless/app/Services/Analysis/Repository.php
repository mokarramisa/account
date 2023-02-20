<?php

namespace App\Services\Analysis;

use Illuminate\Database\Eloquent\Model;

class Repository 
{
    public Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function model (Model $model)
    {
        return $model::class;
    }

    public function getModel ()
    {
        return $this->model;
    }

    public function setModel (Model $model)
    {
        $this->model = $model;

        return $this;
    }

    public static function getTop ($model, string $relation)
    {
        return $model->withCount($relation);
    }

    public function getTopAccourdingToTransactions ()
    {
        
    }
}