<?php
namespace App\Http\Repositories\Reunion;

use App\Models\Reunion\Salle;
use Illuminate\Support\Facades\Auth;

class SalleRepository
{
    /**
     * @var Salle
     */
    protected $salle;

    /**
     * Constructor
     *
     * @param  Salle  $salle
     */
    public function __construct(Salle $salle)
    {
        $this->salle = $salle;
    }

    /**
     * Summary of store
     * @param array<string, mixed> $inputs
     * @return Salle
     */
    public function store(array $inputs): Salle
    {
        $salle = new $this->salle();
        /** @var int|null $userId */
        $userId = Auth::id();
        $salle->user_id_creation = $userId ?? 0; // Utilisation de 0 comme valeur par défaut si null
        $this->save($salle, $inputs);
        return $salle;
    }

    /**
     * Update the model instance
     *
     * @param  Salle  $salle
     * @param  array<string, mixed>  $inputs
     *
     * @return Salle
     */
    public function update(Salle $salle, array $inputs): Salle
    {
        /** @var int|null $userId */
        $userId = Auth::id();
        $salle->user_id_modification = $userId;
        $this->save($salle, $inputs);
        return $salle;
    }

    /**
     * Delete the model instance
     *
     * @param  Salle  $salle
     *
     * @return bool|null
     */
    public function destroy(Salle $salle)
    {
        /** @var int|null $userId */
        $userId = Auth::id();
        $salle->user_id_suppression = $userId;
        $salle->save();
        return $salle->delete();
    }

    /**
     * Undelete the model instance
     *
     * @param  Salle  $salle
     *
     * @return void
     */
    public function undelete(Salle $salle)
    {
        $salle->restore();
    }

    /**
     * Return a JSON for index datatable
     *
     * @return string|false — a JSON encoded string on success or FALSE on failure
     */
    public function json()
    {
        return json_encode(
            Salle::all()
        );
    }

    /**
     * Save the model instance
     *
     * @param  Salle  $salle
     * @param  array<string, mixed>  $inputs
     *
     * @return Salle
     */
    private function save(Salle $salle, array $inputs): Salle
    {
        $salle->name = $inputs['name'];
        $salle->capacity = $inputs['capacity'];
        $salle->surface = $inputs['surface'];
        $salle->equipments = $inputs['equipments'];
        $salle->save();
        return $salle;
    }
}
