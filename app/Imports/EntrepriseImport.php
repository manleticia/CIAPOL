<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Entreprise;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class EntrepriseImport implements ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow, WithValidation
{

    public function bindValue(Cell $cell, $value)
    {
        // Force l'évaluation des formules
        if (str_starts_with($value, '=')) {
            $cell->getWorksheet()->getCell($cell->getCoordinate())->getCalculatedValue();
            return true;
        }

        // Traitement standard
        $cell->setValueExplicit($value, DataType::TYPE_STRING);
        return true;
    }
    public function collection(Collection $rows)
    {
        // foreach ($rows as $row) {
        //     Entreprise::create([
        //         'nom' => $row['nom'] ?? $row['name'] ?? null, // selon vos en-têtes
        //         'email' => $row['email'] ?? null,
        //         'telephone' => $row['telephone'] ?? $row['phone'] ?? null,
        //         // autres champs...
        //     ]);
        // }

        return $rows->map(function ($row) {
            // Conversion des dates Excel
            if (isset($row['date_de_depot']) && is_numeric($row['date_de_depot'])) {
                $row['date_de_depot'] = $this->excelToDateTime($row['date_de_depot']);
            }

            if (isset($row['date_limite_de_payement']) && is_numeric($row['date_limite_de_payement'])) {
                $row['date_limite_de_payement'] = $this->excelToDateTime($row['date_limite_de_payement']);
            }


            $row['nb_taxes_deposees'] = $this->cleanNumber($row['nb_taxes_deposees'] ?? 0);
            $row['nb_taxes_deposees_payees'] = $this->cleanNumber($row['nb_taxes_deposees_payees'] ?? 0);
            $row['nb_taxes_deposees_non_payees'] = $this->cleanNumber($row['nb_taxes_deposees_non_payees'] ?? 0);

            return $row;
        });
    }

    public function rules(): array
    {
        return [
            '*.nom' => 'required|string|max:255',
            '*.email' => 'required|email|unique:entreprises,email',
            '*.telephone' => 'nullable|string|max:20',
            // autres règles...
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 10000;
    }


    private function excelToDateTime($excelDate)
    {
        try {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($excelDate));
        } catch (\Exception $e) {
            return null;
        }
    }

     private function cleanNumber($value)
    {
        if (is_numeric($value)) {
            return (int)$value;
        }

        // Si c'est une formule Excel évaluée comme "=A1-B1"
        if (str_starts_with($value, '=')) {
            return 0; // Ou une valeur par défaut
        }

        // Supprime tous les caractères non numériques
        $cleaned = preg_replace('/[^0-9]/', '', $value);
        return $cleaned !== '' ? (int)$cleaned : 0;
    }
}
