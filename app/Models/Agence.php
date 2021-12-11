<?php

namespace App\Models;

use App\Models\City;
use App\Models\User;
use App\Models\Agence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agence extends Model
{
    use HasFactory;

    protected $table = 'agences';
    
    protected $fillable = [
        'user_id',
        'city_id',
        'tel',
        'name',
        'map_locale',
        'slug',
    ];

    public function vehicules(): HasMany
    {
        return $this->hasMany(Vehicule::class, 'agence_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
