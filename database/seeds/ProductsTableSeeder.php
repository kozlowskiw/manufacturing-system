<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();

        Product::create([
            'code'=>'B200',
            'name'=>'blat 200'
        ]);

        Product::create([
            'code'=>'B100',
            'name'=>'blat 100'
        ]);

        Product::create([
            'code'=>'F050',
            'name'=>'front 50'
        ]);

        Product::create([
            'code'=>'BB100',
            'name'=>'boki blat 100'
        ]);

        Product::create([
            'code'=>'BB200',
            'name'=>'boki blat 200'
        ]);

        Product::create([
            'code'=>'RL050',
            'name'=>'rama lustro 50'
        ]);

        Product::create([
            'code'=>'KO050',
            'name'=>'kołek drewniany 50'
        ]);

        Product::create([
            'code'=>'KO100',
            'name'=>'kołek drewniany 100'
        ]);

        Product::create([
            'code'=>'KO200',
            'name'=>'kołek drewniany 200'
        ]);

        Product::create([
            'code'=>'PO050',
            'name'=>'półka 50x50'
        ]);

    }
}
