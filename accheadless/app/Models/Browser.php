<?php

namespace App\Models;

use App\Filters\Transaction\TransactionFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Browser extends Model
{
    use HasFactory;

    public function transactionLogs ()
    {
        return $this->hasMany(TransactionLog::class);
    }

    public function scopeFilter(Builder $builder, Request $request)
    {
        return (new TransactionFilters($request))->filter($builder);
    }
}
