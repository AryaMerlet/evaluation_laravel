<?php

namespace App\Http\Requests\Reunion;

use App;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class SalleModelRequest extends FormRequest
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
            : Auth::user()->can('salle-create');
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
        $rules['name'] = 'required|string|unique:salles,name';
        $rules['capacity'] = 'required|integer|min:1';
        $rules['surface'] = 'required|numeric|min:0';
        $rules['equipments'] = 'required|string';
        $rules['available'] = 'boolean';

        return $rules;
    }

    /**
     * @return array<string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Le nom de la salle est requis',
            'name.string' => 'Le nom doit être une chaîne de caractères',
            'name.unique' => 'Ce nom de salle existe déjà',
            'capacity.required' => 'La capacité est requise',
            'capacity.integer' => 'La capacité doit être un nombre entier',
            'capacity.min' => 'La capacité minimale est de 1 personne',
            'surface.required' => 'La surface est requise',
            'surface.numeric' => 'La surface doit être un nombre',
            'surface.min' => 'La surface minimale est de 0',
            'equipments.required' => 'Les équipements sont requis',
            'equipments.string' => 'Les équipements doivent être une chaîne de caractères',
            'available.boolean' => 'La disponibilité doit être vraie ou fausse'
        ];
    }
}
