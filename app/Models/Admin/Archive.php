<?php

namespace App\Models\Admin;

use App\Models\Planning\Planning;
use App\Models\User;
use App\Traits\LogAction;
use App\Traits\WhoActs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read string $actions
 * @property-read Planning|null $planning
 * @property-read User|null $user
 * @property-read User|null $userCreation
 * @property-read User|null $userModification
 * @property-read User|null $userSuppression
 *
 * @method static \Database\Factories\Admin\ArchiveFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archive onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archive query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archive withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archive withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Archive extends Model
{
    /** @use HasFactory<\Database\Factories\Admin\ArchiveFactory> */
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

    /**
     * @var list<string>
     */
    protected $fillable = [
        'planning_id',
        'user_id',
        'nom',
        'lieu',
        'plannifier_le',
        'heure_debut',
        'heure_fin',
        'duree_tache',
        'user_id_creation',
    ];

    /**
     * Get the actions attribute.
     *
     * @return string
     */
    public function getActionsAttribute(): string
    {
        return 'Task ID: ' . $this->planning_id . ', User: ' . $this->user_id;
    }

    /** @return BelongsTo<Planning, $this> */
    public function planning()
    {
        return $this->belongsTo(Planning::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
