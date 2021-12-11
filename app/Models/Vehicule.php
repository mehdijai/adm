<?php

namespace App\Models;

use App\Models\Pics;
use App\Models\Image;
use App\Models\Score;
use App\Models\Agence;
use App\Models\Marque;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicule extends Model
{
    use HasFactory;
    
    protected $table = 'vehicules';

    protected $fillable = [
        'agence_id',
        'marque_id',
        'type',
        'matricule',
        'prix',
        'assurance',
        'carb',
        'boite_de_vitesse',
        'description',
        'options',
        'score',
        'vip',
        'slug',
    ];

    public function agence(): BelongsTo
    {
        return $this->belongsTo(Agence::class, 'agence_id', 'id');
    }

    public function marque(): BelongsTo
    {
        return $this->belongsTo(Marque::class, 'marque_id', 'id');
    }

    public function pics(): HasMany
    {
        return $this->hasMany(Pics::class, 'vehicule_id', 'id');
    }

    public function score(): HasOne
    {
        return $this->hasOne(Score::class, 'score_id', 'id');
    }

    public static function updateScore($ids, $subscription)
    {
        $score = 0;
        $vp = false;

        if($subscription){
            if($subscription->active && !$subscription->expired){

                if($subscription->plan_id = 2){
                    $vp = true;
                    $score = $subscription->plan->price * $subscription->periode * count(json_decode($subscription->vehicules_ids)) * 20;
                }else{
                    $score = $subscription->plan->price * $subscription->periode * count(json_decode($subscription->vehicules_ids));
                }

            }
        }

        // dd($vp, $score);
        
        Vehicule::whereIn('id', $ids)->update(['score' => $score, 'vip' => $vp]);
    }

    


}
