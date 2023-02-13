<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function provience ()
    {
        return $this->belongsTo(Provience::class);
    }

    public function operator ()
    {
        return $this->belongsTo(Operator::class);
    }

    public function browser ()
    {
        return $this->belongsTo(Browser::class);
    }

    public function operatingSystem ()
    {
        return $this->OperatingSystem()::class;
    }
}
