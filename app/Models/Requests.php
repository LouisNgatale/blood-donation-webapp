<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    use HasFactory;

    public function recipient() {
        return $this->belongsTo(User::class);
    }
    public function zone() {
        return $this->belongsTo(Zones::class);
    }
}
