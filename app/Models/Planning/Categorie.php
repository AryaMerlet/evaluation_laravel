<?php

namespace App\Models\Planning;

use App\Traits\LogAction;
use Database\Factories\Planning\CategorieFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read string $actions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Planning\Tache> $taches
 * @property-read int|null $taches_count
 *
 * @method static \Database\Factories\Planning\CategorieFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categorie withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Categorie extends Model
{
    /**
     * @use HasFactory<CategorieFactory>
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

    /** @return string  */
    public function getActionsAttribute()
    {
        return '';
    }

    /**
     * Summary of taches
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Tache, $this>
     */
    public function taches()
    {
        return $this->hasMany(Tache::class);
    }
}
