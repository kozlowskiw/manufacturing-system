<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Department;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        DB::table('role_user')->truncate();
        DB::table('department_user')->truncate();

        $admin = User::create([
            'name' => 'Dominik',
            'surname' => 'Kowalski',
            'login' => '111'
        ]);

        $worker = User::create([
            'name' => 'Stanisław',
            'surname' => 'Dach',
            'login' => '222'
        ]);

        $technologist = User::create([
            'name' => 'Marcin',
            'surname' => 'Swojski',
            'login' => '333'
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        $workerRole = Role::where('name', 'pracownik produkcji')->first();
        $technologistRole = Role::where('name', 'technolog')->first();

        $admin->roles()->attach($adminRole);
        $worker->roles()->attach($workerRole);
        $technologist->roles()->attach($technologistRole);

        $productionDepartment = Department::where('name', 'produkcja')->first();
        $machiningDepartment = Department::where('name', 'obróbka')->first();
        $hrDepartment = Department::where('name', 'rekrutacja')->first();

        $admin->departments()->attach($hrDepartment);
        $worker->departments()->attach($machiningDepartment);
        $technologist->departments()->attach($productionDepartment);
    }
}
