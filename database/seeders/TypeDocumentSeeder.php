<?php

namespace Database\Seeders;

use App\Models\TypeDocument;
use Illuminate\Database\Seeder;

class TypeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeDocument::upsert([
            ['name' => 'Cédula de Identidad','description' => 'Cédula de Identidad'],
            [
                'name'        => 'Pasaporte',
                'description' => 'Pasaporte'
            ],
            [
                'name'        => 'RIF',
                'description' => 'RIF'
            ]
        ],['name'],['description']);
    }
}
