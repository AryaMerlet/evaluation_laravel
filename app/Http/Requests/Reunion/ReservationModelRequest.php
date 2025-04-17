<?php

namespace App\Http\Requests\Reunion;

use App;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ReservationModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return App::environment('testing')
        ? true
        : Auth::user()->can('reservation-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @example https://laravel.com/docs/validation#available-validation-rules
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [];
        $rules['date'] = 'required|date';
        $rules['heure_debut'] = 'required|date_format:H:i';
        $rules['heure_fin'] = 'required|date_format:H:i|after:heure_debut';
        $rules['motif'] = 'nullable|string|max:255';
        $rules['salle_id'] = 'required|exists:salles,id';

        return $rules;
    }

    /**
     * @return array<string>
     */
    public function messages()
    {
        return [
            'date.required' => 'La date est requise',
            'date.date' => 'Format de date invalide',
            'heure_debut.required' => 'L\'heure de début est requise',
            'heure_debut.date_format' => 'Format d\'heure invalide',
            'heure_fin.required' => 'L\'heure de fin est requise',
            'heure_fin.date_format' => 'Format d\'heure invalide',
            'heure_fin.after' => 'L\'heure de fin doit être après l\'heure de début',
            'motif.string' => 'Le motif doit être une chaîne de caractères',
            'motif.max' => 'Le motif ne doit pas dépasser 255 caractères',
            'salle_id.required' => 'La salle est requise',
            'salle_id.exists' => 'La salle sélectionnée n\'existe pas'
        ];
    }
}
