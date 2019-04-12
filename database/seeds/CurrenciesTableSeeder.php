<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'cod' => 'COP',
            'name' => 'Peso colombiano',
        ]);
        DB::table('currencies')->insert([
            'cod' => 'USD',
            'name' => 'Dólar estadounidense',
        ]);
    }
}
