<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

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

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function gateway ()
    {
        return $this->belongsTo(Gateway::class);
    }

    public function scopeTransactionType ($query, $transactionType)
    {
        return $query->where('transaction_type', $transactionType);
    }
}
