<?php

namespace App\Models\Conge;

use App\Traits\LogAction;
use Database\Factories\Conge\MotifFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Conge\Absence> $absences
 * @property-read int|null $absences_count
 * @property-read string $actions
 *
 * @method static \Database\Factories\Conge\MotifFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Motif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Motif newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Motif onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Motif query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Motif withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Motif withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Motif extends Model
{
    /**
     * @use HasFactory<MotifFactory>
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
     * Summary of absences
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Absence, $this>
     */
    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
}
