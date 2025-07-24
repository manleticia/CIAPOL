<?php

namespace App\Exports;

use App\Models\Cheque;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ChequeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cheque::all();
    }

     public function map($cheque): array
    {
        return [
            $cheque->entreprise->raison_sociale ?? 'xxxxxxxxx',
            $cheque->taxeEntreprise->periode ?? 'TOUT' ,
            $cheque->NaturePaiement ?? 'xxxxxxx',
            $cheque->numero_cheque ?? 'xxxxxxxxx',
            $cheque->montant ?? 'xxxxxxxxx',
            $cheque->banque ?? ($cheque->autre_banque ?? 'xxxxxxxxx'),
            $cheque->titulaire ?? 'xxxxxxxxx' ,
            $cheque->date_emission ?? 'xxxxxxxxx',
            $this->formatStatut($cheque->status),

        ];
    }





    /**
     * En-têtes du fichier Excel
     */
    public function headings(): array
    {
        return [
            'Raison Sociale',
            'Libelle de taxe',
            'Nature',
            'Numero du Cheque',
            'Montant',
            'Banque',
            'Titulaire',
            'Date emission',
            'Statut',
        ];



    }

    /**
     * Formatage du statut
     */
    private function formatStatut($status)
    {
        switch ($status) {
            case 1:
                return 'Valide';
            case 2:
                return 'Attente';

            default:
                return 'Refuse';
        }
    }




}
