<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Subscription extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'subscriptions';

    protected $fillable = ['user_id', 'plan_id', 'active', 'expired', 'activation_date', 'expiration_date', 'vehicules_ids', 'periode', 'reciept', 'invoice', 'montant'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
}
