<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments_status')->insert([
            'cod' => 'OK',
            'name' => 'OK'
        ]);
        DB::table('payments_status')->insert([
            'cod' => 'FAILED',
            'name' => 'Fallida'
        ]);
        DB::table('payments_status')->insert([
            'cod' => 'APPROVED',
            'name' => 'Aprobada'
        ]);
        DB::table('payments_status')->insert([
            'cod' => 'APPROVED_PARTIAL',
            'name' => 'Parcialmente Aprobada'
        ]);
        DB::table('payments_status')->insert([
            'cod' => 'REJECTED',
            'name' => 'Rechazada'
        ]);
        DB::table('payments_status')->insert([
            'cod' => 'PENDING',
            'name' => 'Pendiente'
        ]);
        DB::table('payments_status')->insert([
            'cod' => 'PENDING_VALIDATION',
            'name' => 'Validación Pendiente'
        ]);
        DB::table('payments_status')->insert([
            'cod' => 'REFUNDED',
            'name' => 'Reintegrada'
        ]);
    }
}
