<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyStat extends Model
{
    protected $fillable = ['date', 'metric', 'value'];
    protected $casts = ['date' => 'date', 'value' => 'integer'];
}
