<?php

namespace App\Repository\Eloquent;

use App\Models\Transaction;
use App\Repository\TransactionRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;

class TransactionRepositoy extends BaseRepository implements TransactionRepositoryInterface
{
    public function __construct(private Transaction $model)
    {
        parent::__construct($model);
    }

    public function findTopTransactios (array $relations = [])
    {
        return $this->model->countWith($relations);
    }

    public function transactionType ($transactionType)
    {
        return $this->newQuery()->where('transaction_type', $transactionType);
    }

    public function newQuery ()
    {
        return $this->model->newQuery();
    }

}