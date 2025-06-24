<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdministrateurRequest extends FormRequest
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
            //7
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'genre' => 'required|in:Homme,Femme',
            'email' => 'required|email',
            'adresse' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'lien_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'genre.required' => 'Le genre est obligatoire.',
            'genre.in' => 'Le genre doit être Homme ou Femme.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            // 'email.unique' => 'Cet email est déjà utilisé.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'contact.required' => 'Le contact est obligatoire.',
            'lien_photo.image' => 'Le fichier doit être une image.',
            'lien_photo.mimes' => 'Seules les images JPG, JPEG et PNG sont autorisées.',
            'lien_photo.max' => 'L\'image ne doit pas dépasser 2 Mo.',
        ];
    }
}
