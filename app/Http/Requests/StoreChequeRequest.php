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
            'banque'            => 'nullable|required_if:NaturePaiement,CHEQUE,VIREMENT| string|max:255',
            'autre_banque'      => 'nullable|required_if:banque,AUTRE|string|max:255',
            'date_emission'     => 'required|date',
            'titulaire'         => 'nullable|required_if:NaturePaiement,CHEQUE,VIREMENT|string|max:255',
            'notes'             => 'nullable|string',
        ];
    }
    public function messages(): array
    {
        return [
            'entreprise_id.required' => 'L\'entreprise est requise.',
            'entreprise_id.exists'   => 'L\'entreprise sélectionnée est invalide.',

            'taxe_entreprise.required' => 'La taxe entreprise est requise.',
            'taxe_entreprise.string'   => 'La taxe entreprise doit être une chaîne de caractères.',
            'taxe_entreprise.max'      => 'La taxe entreprise ne doit pas dépasser 255 caractères.',

            'montant.required' => 'Le montant est requis.',
            'montant.string'   => 'Le montant doit être une chaîne de caractères.',
            'montant.not_in'   => 'Le montant ne peut pas être égal à "0.00 FCFA".',

            'NaturePaiement.required' => 'La nature du paiement est requise.',
            'NaturePaiement.in'       => 'La nature du paiement doit être CHEQUE, ESPECE, VIREMENT ou AUTRE.',

            'numero_cheque.required' => 'Le numéro du chèque est requis.',
            'numero_cheque.string'   => 'Le numéro du chèque doit être une chaîne de caractères.',
            'numero_cheque.max'      => 'Le numéro du chèque ne doit pas dépasser 255 caractères.',

            'banque.required_if' => 'Le champ banque est requis si la nature du paiement est CHEQUE ou VIREMENT.',
            'banque.string'      => 'Le champ banque doit être une chaîne de caractères.',
            'banque.max'         => 'Le champ banque ne doit pas dépasser 255 caractères.',

            'autre_banque.required_if' => 'Le champ autre banque est requis si la banque est AUTRE.',
            'autre_banque.string'      => 'Le champ autre banque doit être une chaîne de caractères.',
            'autre_banque.max'         => 'Le champ autre banque ne doit pas dépasser 255 caractères.',

            'date_emission.required' => 'La date d\'émission est requise.',
            'date_emission.date'     => 'La date d\'émission doit être une date valide.',

            'titulaire.required_if' => 'Le titulaire est requis si la nature du paiement est CHEQUE ou VIREMENT.',
            'titulaire.string'      => 'Le titulaire doit être une chaîne de caractères.',
            'titulaire.max'         => 'Le titulaire ne doit pas dépasser 255 caractères.',

            'notes.string' => 'Le champ notes doit être une chaîne de caractères.',
        ];
    }
}
