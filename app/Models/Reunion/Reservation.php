<?php

namespace App\Models\Reunion;

use App\Models\User;
use App\Traits\LogAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    /**
     * @use HasFactory<ReservationFactory>
     */
    use HasFactory;
    use SoftDeletes;
    use LogAction;

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

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
