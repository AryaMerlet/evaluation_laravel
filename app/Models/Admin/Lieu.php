<?php

namespace App\Models\Admin;

use App\Models\Planning\Planning;
use App\Models\Planning\Tache;
use App\Traits\LogAction;
use App\Traits\WhoActs;
use Database\Factories\Admin\LieuFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read string $actions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Planning> $plannings
 * @property-read int|null $plannings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Tache> $taches
 * @property-read int|null $taches_count
 * @property-read \App\Models\User|null $userCreation
 * @property-read \App\Models\User|null $userModification
 * @property-read \App\Models\User|null $userSuppression
 *
 * @method static \Database\Factories\Admin\LieuFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lieu withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Lieu extends Model
{
    /**
     * @use HasFactory<LieuFactory>
     */
    use HasFactory;

    use LogAction;
    use SoftDeletes;
    use WhoActs;

    protected $fillable = [
        'nom',
        'user_id_creation',
    ];

    /**
     * @var list<string>
     */
    protected $appends = [
        'actions',
    ];

    protected $table = 'lieux';

    /** @return string  */
    public function getActionsAttribute(): string
    {
        return 'Lieu: ' . $this->nom . ', Created by User ID: ' . $this->user_id_creation;
    }

    /**
     * Summary of taches
     *
     * @return HasMany<Tache, $this>
     */
    public function taches()
    {
        return $this->hasMany(Tache::class);
    }

    /**
     * Summary of plannings
     *
     * @return HasMany<Planning, $this>
     */
    public function plannings()
    {
        return $this->hasMany(Planning::class);
    }
}
