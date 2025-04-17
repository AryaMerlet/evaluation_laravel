<?php

namespace App\Models\Reunion;

use App\Traits\LogAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salle extends Model
{
    /**
     * @use HasFactory<SalleFactory>
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

    protected $fillable = [
        'nom',
        'capacity',
        'surface',
        'available'
    ];

    /** @return string  */
    public function getActionsAttribute()
    {
        return '';
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
