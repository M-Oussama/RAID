<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'list-employee',
            'create-employee',
            'edit-employee',
            'delete-employee',
            'confirm-employee'
        ];



        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::find(1)->givePermissionTo($permissions);


        $people_menu = Menu::where('name','=','الأشخاص')
            ->where('isSection','=',false)->get()->first();

        $students = new Menu();
        $students->menu_id = $people_menu->id;
        $students->name = 'الموظفين';
        $students->url = '#';
        $students->order = 2;
        $students->icon = 'flaticon-layers';
        $students->isSection = false;
        $students->permissions = 'list-employee';
        $students->save();

        $students_index = new Menu();
        $students_index->menu_id = $students->id;
        $students_index->name = 'الموظفين';
        $students_index->url = 'dash/security/assistance';
        $students_index->order = 2;
        $students_index->icon = 'flaticon-layers';
        $students_index->isSection = false;
        $students_index->permissions = 'list-employee';
        $students_index->save();

        $students_create = new Menu();
        $students_create->menu_id = $students->id;
        $students_create->name = 'اضافة موظف جديد';
        $students_create->url = 'dash/security/assistance/create';
        $students_create->order = 2;
        $students_create->icon = 'flaticon-layers';
        $students_create->isSection = false;
        $students_create->permissions = 'create-employee';
        $students_create->save();

        $students_edit = new Menu();
        $students_edit->menu_id = $students_index->id;
        $students_edit->name = 'تعديل البيانات';
        $students_edit->url = 'dash/security/assistance/*/edit';
        $students_edit->order = 2;
        $students_edit->icon = 'flaticon-layers';
        $students_edit->isHidden = true;
        $students_edit->permissions = 'edit-employee';
        $students_edit->save();
    }
}
