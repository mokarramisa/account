<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provience extends Model
{
    use HasFactory;

    // public function transactionLogTransaction ()
    // {
    //     return $this->hasOneThrough(Transaction::class, TransactionLog::class);
    // }

    public function tranactionLogs ()
    {
        return $this->hasMany(Provience::class);
    }

    public function transactionLogs ()
    {
        return $this->hasManyThrough(Transaction::class, TransactionLog::class);
    }
}
