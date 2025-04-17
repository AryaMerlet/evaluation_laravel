<?php

namespace App\Models\Reunion;

use App\Traits\WhoActs;
use App\Traits\LogAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $capacity
 * @property float $surface
 * @property string $equipments
 * @property int $available
 * @property \Illuminate\Support\Carbon $created_at
 * @property int $user_id_creation
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id_modification
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id_suppression
 *
 * @property-read string $actions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reunion\Reservation> $reservations
 * @property-read int|null $reservations_count
 *
 * @method static \Database\Factories\Reunion\SalleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereEquipments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereUserIdCreation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereUserIdModification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereUserIdSuppression($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Salle extends Model
{
    /**
     * @use HasFactory<\Database\Factories\Reunion\SalleFactory>
     */
    use HasFactory;

    use LogAction;
    use SoftDeletes;
    use WhoActs;

    /**
     * @var list<string>
     */
    protected $appends = [
        'actions',
    ];

    protected $fillable = [
        'nom',
        'capacity',
        'surface',
        'available',
    ];

    /** @return string  */
    public function getActionsAttribute()
    {
        return '';
    }
    /**
     * Summary of reservations
     * @return HasMany<Reservation, $this>
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
