<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'blood_group',
        'blood_rha',
        'donor_id',
        'expire_date',
        'quantity'
    ];

    public function donor() {
        return $this->belongsTo(User::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zones::class);
    }
}
