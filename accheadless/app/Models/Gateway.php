<?php

namespace App\Models;

use App\Filters\Transaction\TransactionFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Gateway extends Model
{
    use HasFactory;

    public function transactions ()
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeFilter(Builder $builder, Request $request)
    {
        return (new TransactionFilters($request))->filter($builder);
    }
}
