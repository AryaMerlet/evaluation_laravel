<?php

namespace App\Models\Conge;

use App\Enums\ValidationStatus;
use App\Models\User;
use App\Traits\LogAction;
use Database\Factories\Conge\AbsenceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property ValidationStatus $status
 *
 * @property-read string $actions
 * @property-read \App\Models\Conge\Motif|null $motif
 * @property-read User|null $user
 *
 * @method static \Database\Factories\Conge\AbsenceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absence withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Absence extends Model
{
    /**
     * @use HasFactory<AbsenceFactory>
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
        'motif_id',
        'date_debut',
        'date_fin',
        'status',
        'user_id_modification',
    ];

    /**
     * Summary of casts
     *
     * @var array<string, string>
     */
    protected $casts = ['status' => ValidationStatus::class];

    /** @return string  */
    public function getActionsAttribute()
    {
        return '';
    }

    /**
     * Summary of user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Summary of motif
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Motif, $this>
     */
    public function motif()
    {
        return $this->belongsTo(Motif::class);
    }
}
