<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    public function transactionLogs ()
    {
        return $this->hasMany(TransactionLog::class);
    }
}
