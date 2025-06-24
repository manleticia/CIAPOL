<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Administrateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdministrateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $user = User::create([
            'name' => "Super Admin",
            "contact" => "0707070707",
            "email" => "admin01@gmail.com",
            "password" => Hash::make('MENDOS012024')
        ]);

        // assign role
        $user->assignRole('super-administrateur');

        Administrateur::create([
            "user_id" => $user->id,
            "nom" => "Super",
            "prenom" => "Admin",
            "contact" => "0707070707",
            "email" => $user->email,
            "genre" => "Homme",
            "id_parains" => 0, // uniquement l'id du dev
            "adresse" => "Abidjan, Cocody Riviera Palmeraie",
        ]);
    }
}
