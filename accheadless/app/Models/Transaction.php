<?php

namespace App\Models;

use App\Builders\DateBuilder;
use App\Collections\GroupByCollection;
use App\Filters\Transaction\TransactionFilter;
use App\Filters\Transaction\TransactionFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Transaction extends Model
{
    use HasFactory;

    // protected $appends = [
    //     'create_day',
    // ];

    const LAST_SEVEN_DAYS = 'last_seven_days';
    const LAST_WEEK = 'last_week';
    const THIS_WEEK = 'this_week';
    const LAST_FIFTEEN_DAYS = 'last_fifteen_days';
    const LAST_THIRTY_DAYS = 'last_thirty_days';
    const LAST_MONTH = 'last_month';
    const LAST_THREE_MONTH = 'last_three_month';
    const LAST_SIX_MONTH = 'last_six_month';
    const THIS_YEAR = 'this_year';
    const LAST_YEAR = 'last_year';

    public function getCreateMonthAttribute ()
    {
        return $this->created_at()->month;
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function gateway ()
    {
        return $this->belongsTo(Gateway::class);
    }

    public function transactionLog ()
    {
        return $this->hasOne(TransactionLog::class);
    }

    // public function newEloquentBuilder($query): DateBuilder
    // {
    //     return new DateBuilder($query);
    // }

    public function scopeFilter(Builder $builder, Request $request)
    {
        return (new TransactionFilters($request))->filter($builder);
    }

    public function scopeTransactionType ($query, $transactionType)
    {
        return $query->where('transaction_type', $transactionType);
    }

    public function scopeCardNumber ($query)
    {
        return $query->selectRaw('count(card_number) as counts')->groupBy('card_number');
    }

    // public function scopeGroupByDay ($query) 
    // {
    //     return $query->groupBy(function($item) { 
    //         return $item->created_at->format('y-m-d'); 
    //         });
    // }

    // public function scopeGroupByMonth ($query) 
    // {
    //     return $query->groupBy(function($item) { 
    //         return $item->created_at->format('m'); 
    //         });
    // }

    // public function scopeGroupByYear ($query) 
    // {
    //     return $query->groupBy(function($item) { 
    //         return $item->created_at->format('y'); 
    //         });
    // }
}
