<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cargo_code',
        'cargo_status',
        'cargo_description',
        'official_address',
        'contact_person'
    ];

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class);
    }
}
