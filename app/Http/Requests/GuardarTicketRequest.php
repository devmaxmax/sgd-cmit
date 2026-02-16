<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'modulo_id' => 'required|exists:modulos,id',
            'prioridad' => 'required|in:urgente,alta,media,baja',
            'estado' => 'required|in:desarrollo,pausado,terminado',
            'descripcion' => 'required|string',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'El campo título es obligatorio.',
            'modulo_id.required' => 'El campo módulo es obligatorio.',
            'prioridad.required' => 'El campo prioridad es obligatorio.',
            'estado.required' => 'El campo estado es obligatorio.',
            'descripcion.required' => 'El campo descripción es obligatorio.',
            'imagenes.*.image' => 'El archivo debe ser una imagen.',
            'imagenes.*.mimes' => 'El archivo debe ser una imagen con extensión JPEG, PNG, JPG, GIF o SVG.',
            'imagenes.*.max' => 'El archivo debe tener un tamaño máximo de 2MB.',
        ];
    }
}
