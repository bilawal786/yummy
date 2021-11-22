<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class YummyCoinSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('yummycoins')->insert([
        [
          'nombre' => '25000',
          'actif'  => '1',
          'valeur' => '25',
        ],

        [
          'nombre' => '50000',
          'actif'  => '1',
          'valeur' => '50',
        ],

        [
          'nombre' => '75000',
          'actif'  => '1',
          'valeur' => '75',
        ],
        [
          'nombre' => '100000',
          'actif'  => '1',
          'valeur' => '100',
        ],
        [
          'nombre' => '125000',
          'actif'  => '1',
          'valeur' => '125',
        ],
        [
          'nombre' => '150000',
          'actif'  => '1',
          'valeur' => '150',
        ],
      ]);
    }
}
