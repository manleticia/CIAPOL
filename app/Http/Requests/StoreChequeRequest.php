<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreChequeRequest extends FormRequest
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
            'entreprise_id'     => 'required|exists:entreprises,id',
            'taxe_entreprise'   => 'required|string|max:255',
            'montant'           => [
                'required',
                'string',
                Rule::notIn(['0.00 FCFA']),
            ],
            'NaturePaiement'    => 'required|in:CHEQUE,ESPECE,VIREMENT,AUTRE',
            'numero_cheque'     => 'required|string|max:255',
            'banque'            => 'required|string|max:255',
            'autre_banque'      => 'nullable|required_if:banque,AUTRE|string|max:255',
            'date_emission'     => 'required|date',
            'titulaire'         => 'required|string|max:255',
            'notes'             => 'nullable|string',
        ];
    }
    public function messages(): array
    {
        return [
            'entreprise_id.required'     => 'Le champ entreprise est requis.',
            'entreprise_id.exists'       => 'L’entreprise sélectionnée est invalide.',

            'taxe_entreprise.required'   => 'Le champ taxe entreprise est requis.',
            'taxe_entreprise.string'     => 'Le champ taxe entreprise doit être une chaîne de caractères.',
            'taxe_entreprise.max'        => 'Le champ taxe entreprise ne doit pas dépasser 255 caractères.',

            'montant.required'           => 'Le montant est requis.',
            'montant.string'             => 'Le montant doit être une chaîne de caractères.',
            'montant.not_in'             => 'Le montant ne peut pas être égal à 0 FCFA.',

            'NaturePaiement.required'    => 'Le mode de paiement est requis.',
            'NaturePaiement.in'          => 'Le mode de paiement sélectionné est invalide.',

            'numero_cheque.required'     => 'Le numéro du chèque est requis.',
            'numero_cheque.string'       => 'Le numéro du chèque doit être une chaîne de caractères.',
            'numero_cheque.max'          => 'Le numéro du chèque ne doit pas dépasser 255 caractères.',

            'banque.required'            => 'Le nom de la banque est requis.',
            'banque.string'              => 'La banque doit être une chaîne de caractères.',
            'banque.max'                 => 'Le nom de la banque ne doit pas dépasser 255 caractères.',

            'autre_banque.required_if' => 'Le champ "Autre banque" est requis lorsque la banque sélectionnée est "AUTRE".',
            'autre_banque.string'      => 'Le champ "Autre banque" doit être une chaîne de caractères.',
            'autre_banque.max'         => 'Le champ "Autre banque" ne doit pas dépasser 255 caractères.',

            'date_emission.required'     => 'La date d’émission est requise.',
            'date_emission.date'         => 'La date d’émission n’est pas valide.',

            'titulaire.required'         => 'Le nom du titulaire est requis.',
            'titulaire.string'           => 'Le nom du titulaire doit être une chaîne de caractères.',
            'titulaire.max'              => 'Le nom du titulaire ne doit pas dépasser 255 caractères.',

            'notes.string'               => 'Les notes doivent être une chaîne de caractères.',
        ];
    }
}
