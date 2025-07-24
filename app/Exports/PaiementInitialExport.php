<?php

namespace App\Exports;

use App\Models\PaiementInitial;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PaiementInitialExport  implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return PaiementInitial::all();

        return PaiementInitial::where('status', 1)
            ->get();
    }

    public function map($paiement): array
    {
        return [
            $paiement->entreprise->raison_sociale,
            $paiement->taxeEntreprise->periode ?? 'xxxxxxxxx',
            $paiement->referencePaiement ?? ($paiement->codePaiement ?? 'xxxxxxxxx'),
            $paiement->montant ?? 'xxxxxxxxx',
            $paiement->moyenPaiement ?? 'xxxxxxxxx',
            $paiement->contactPaiement ?? 'xxxxxxxxx',
            $paiement->datePaiement ?? 'xxxxxxxxx',
            $this->formatStatut($paiement->status),

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
            'Reference',
            'Montant',
            'Moyen de Paiement',
            'Numero de Paiement',
            'Date de Paiement',
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
                return 'Actif';
            case 2:
                return 'Inactif';
            default:
                return 'Inconnu';
        }
    }
}
