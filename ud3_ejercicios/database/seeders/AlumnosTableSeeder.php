<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlumnosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('alumnos')->insert([
            [
                'nombre' => 'Juan Martínez',
                'email' => 'juan.martinez@escuela.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Ana García',
                'email' => 'ana.garcia@escuela.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Pedro Sánchez',
                'email' => 'pedro.sanchez@escuela.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'María López',
                'email' => 'maria.lopez@escuela.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
