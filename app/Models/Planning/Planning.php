<?php

namespace App\Models\Planning;

use App\Models\Admin\Lieu;
use App\Models\User;
use App\Traits\LogAction;
use App\Traits\WhoActs;
use Database\Factories\Planning\PlanningFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read \App\Models\Planning\Categorie|null $categorie
 * @property-read string $actions
 * @property-read Lieu|null $lieu
 * @property-read \App\Models\Planning\Tache|null $tache
 * @property-read User|null $user
 * @property-read User|null $userCreation
 * @property-read User|null $userModification
 * @property-read User|null $userSuppression
 *
 * @method static \Database\Factories\Planning\PlanningFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Planning extends Model
{
    /**
     * @use HasFactory<PlanningFactory>
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

    protected $table = 'plannings';

    protected $fillable = [
        'user_id',
        'tache_id',
        'heure_debut',
        'heure_fin',
        'plannifier_le',
        'is_validated',
        'user_id_creation',
        'user_id_modification',
        'user_id_supression',
    ];

    /**
     * @return string
     */
    public function getActionsAttribute(): string
    {
        return '';
    }

    /** @return BelongsTo<Tache, $this>  */
    public function tache()
    {
        return $this->belongsTo(Tache::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Lieu, $this> */
    public function lieu(): BelongsTo
    {
        return $this->belongsTo(Lieu::class);
    }

    /**
     * Summary of categorie
     *
     * @return HasOneThrough<Categorie, Tache, $this>
     */
    public function categorie(): HasOneThrough
    {
        return $this->hasOneThrough(
            Categorie::class,
            Tache::class,
            'id', // Tache.id
            'id', // Categorie.id
            'tache_id', // Planning.tache_id
            'categorie_id' // Tache.categorie_id
        );
    }
}
