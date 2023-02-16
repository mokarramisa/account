<?php

namespace App\Repository;

//use App\Repository\EloquentRepositoryInterface;

interface TransactionRepositoryInterface
{
    public function findTopTransactios (array $relations = []);

    public function transactionType ($transactionType);

    public function newQuery ();
}