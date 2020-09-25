<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::truncate();

        Department::create([
            'name'=>'produkcja',
            'name_shortcut'=>'prod'
        ]);
        Department::create([
            'name'=>'obróbka',
            'name_shortcut'=>'obr'
        ]);
        Department::create([
            'name'=>'rekrutacja',
            'name_shortcut'=>'hr'
        ]);
    }
}
