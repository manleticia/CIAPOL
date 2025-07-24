<?php

namespace App\Exports;

use App\Models\Administrateur;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdministrateursExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Administrateur::all();
    }
}
