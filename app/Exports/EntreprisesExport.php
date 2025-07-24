<?php

namespace App\Exports;

use App\Models\Entreprise;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EntreprisesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * Récupère les données
     */
    public function collection()
    {
        return Entreprise::all([
            'raison_sociale',
            'inspection',
            'telephone',
            'telephone_2',
            'status'
        ]);
    }

    /**
     * Mapping des colonnes pour personnaliser chaque ligne
     */
    public function map($entreprise): array
    {
        return [
            $entreprise->raison_sociale,
            $entreprise->inspection,
            $entreprise->telephone,
            $entreprise->telephone_2,
            $this->formatStatut($entreprise->status),
        ];
    }

    /**
     * En-têtes du fichier Excel
     */
    public function headings(): array
    {
        return [
            'Raison Sociale',
            'Inspection',
            'Téléphone',
            'Téléphone 2',
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
