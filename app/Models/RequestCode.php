<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCode extends Model
{
    use HasFactory;

    public function generated_by()
    {
        $this->belongsTo(User::class);
    }

    public function owner_id()
    {
        $this->belongsTo(User::class);
    }
}
