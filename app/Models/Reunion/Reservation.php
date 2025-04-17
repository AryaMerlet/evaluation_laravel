<?php

namespace App\Models\Reunion;

use App\Models\User;
use App\Traits\LogAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $date
 * @property string $heure_debut
 * @property string $heure_fin
 * @property string|null $motif
 * @property int $user_id
 * @property int $salle_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property int $user_id_creation
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id_modification
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id_suppression
 *
 * @property-read string $actions
 * @property-read \App\Models\Reunion\Salle|null $salle
 * @property-read User|null $user
 *
 * @method static \Database\Factories\Reunion\ReservationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereHeureDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereHeureFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereSalleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereUserIdCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereUserIdModification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereUserIdSuppression($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Reservation extends Model
{
    /**
     * @use HasFactory<ReservationFactory>
     */
    use HasFactory;

    use LogAction;
    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $appends = [
        'actions',
    ];

    protected $fillable = [
        'user_id',
        'salle_id',
        'date',
        'heure_debut',
        'heure_fin',
    ];

    /** @return string  */
    public function getActionsAttribute()
    {
        return '';
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
