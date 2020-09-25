<?php

use App\Operation;
use Illuminate\Database\Seeder;

class OperationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operation::truncate();

        Operation::create([
            'code'=>'SZ01',
            'name'=>'szlifowanie'
        ]);
        Operation::create([
            'code'=>'FR01',
            'name'=>'frezowanie'
        ]);
        Operation::create([
            'code'=>'CI01',
            'name'=>'cięcie'
        ]);
        Operation::create([
            'code'=>'WZMK01',
            'name'=>'wzór mini kwiat1'
        ]);
        Operation::create([
            'code'=>'WZDK01',
            'name'=>'wzór duzy kwiat1'
        ]);
    }
}
