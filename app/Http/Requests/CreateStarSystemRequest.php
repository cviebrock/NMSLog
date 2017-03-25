<?php

namespace App\Http\Requests;

use App\StarSystem;
use Illuminate\Foundation\Http\FormRequest;


class CreateStarSystemRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required',
            'class'         => 'required',
            'color'         => 'required|in:' . implode(',', array_keys(StarSystem::$colors)),
            'coordinates'   => [
                'required',
                'unique:star_systems',
                'regex:/^[a-z]{3,}(:[0-9a-f]{4}){4}/i',
            ],
            'planets'       => 'nullable|integer|min:0',
            'moons'         => 'nullable|integer|min:0',
            'black_hole'    => 'boolean',
            'notes'         => '',
            'discovered_on' => [
                'required',
                'date_format:Y-m-d H:i',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'coordinates.regex' => 'The coordinates must be in the format ALPHA:0000:0000:0000:0000',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'gc_distance' => 'distance to galactic center',
        ];
    }

}
