<?php

namespace App\Models\Planning;

use App\Models\Admin\Lieu;
use App\Models\User;
use App\Traits\LogAction;
use App\Traits\WhoActs;
use Database\Factories\Planning\TacheFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read \App\Models\Planning\Categorie|null $categorie
 * @property-read string $actions
 * @property-read Lieu|null $lieu
 * @property-read User|null $user
 * @property-read User|null $userCreation
 * @property-read User|null $userModification
 * @property-read User|null $userSuppression
 *
 * @method static \Database\Factories\Planning\TacheFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tache withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Tache extends Model
{
    /**
     * @use HasFactory<TacheFactory>
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
        'user_id',
        'nom',
        'heure_debut',
        'heure_fin',
        'jour',
        'lieu_id',
        'user_id_creation',
    ];

    /** @return string */
    public function getActionsAttribute(): string
    {
        return '';
    }

    /** @return BelongsTo<Lieu, $this>  */
    public function lieu()
    {
        return $this->belongsTo(Lieu::class);
    }

    /** @return BelongsTo<User, $this>  */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Categorie, $this> */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }
}
