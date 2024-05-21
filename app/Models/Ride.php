<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * RIDE MODEL
 */
class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'pickup_location', 'dropoff_location', 'status',
    ];

    /**
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
