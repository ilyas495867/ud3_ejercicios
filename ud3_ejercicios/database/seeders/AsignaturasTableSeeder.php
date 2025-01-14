<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsignaturasTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('asignaturas')->insert([
            [
                'nombre' => 'Matemáticas',
                'descripcion' => 'Curso básico de matemáticas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Física',
                'descripcion' => 'Introducción a la física',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Programación',
                'descripcion' => 'Fundamentos de programación',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
