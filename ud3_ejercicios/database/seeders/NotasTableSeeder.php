<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotasTableSeeder extends Seeder
{
    public function run()
    {
        // We'll add notes after making sure we have alumnos and asignaturas
        $alumnos = DB::table('alumnos')->pluck('id');
        $asignaturas = DB::table('asignaturas')->pluck('id');

        foreach ($alumnos as $alumno_id) {
            foreach ($asignaturas as $asignatura_id) {
                DB::table('notas')->insert([
                    'alumno_id' => $alumno_id,
                    'asignatura_id' => $asignatura_id,
                    'nota' => rand(50, 100) / 10, // Random grade between 5.0 and 10.0
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
