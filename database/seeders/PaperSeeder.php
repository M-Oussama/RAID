<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'list-paper',
            'create-paper',
            'edit-paper',
            'delete-paper',
            'confirm-paper'
        ];



        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::find(1)->givePermissionTo($permissions);
        $dash_side_menu = Menu::find(1);

        $people_section = new Menu();
        $people_section->menu_id = $dash_side_menu->id;
        $people_section->name = 'الأوراق الادارية';
        $people_section->url = '#';
        $people_section->order = 4;
        $people_section->icon = 'flaticon-layers';
        $people_section->isSection = true;
        $people_section->permissions = 'list-paper';
        $people_section->save();

        $people_menu = new Menu();
        $people_menu->menu_id = $dash_side_menu->id;
        $people_menu->name = 'الأوراق الادارية';
        $people_menu->url = '#';
        $people_menu->order = 4;
        $people_menu->icon = 'fa fa-handshake';
        $people_menu->isSection = false;
        $people_menu->permissions = 'list-paper';
        $people_menu->save();

        $users = new Menu();
        $users->menu_id = $people_menu->id;
        $users->name = 'الأوراق الادارية';
        $users->url = '#';
        $users->order = 4;
        $users->icon = 'flaticon-layers';
        $users->isSection = false;
        $users->permissions = 'list-paper';
        $users->save();

       /* $users_index = new Menu();
        $users_index->menu_id = $users->id;
        $users_index->name = 'الأوراق الادارية';
        $users_index->url = 'dash/papers';
        $users_index->order = 4;
        $users_index->icon = 'flaticon-layers';
        $users_index->isSection = false;
        $users_index->permissions = 'list-paper';
        $users_index->save();*/

        $users_create = new Menu();
        $users_create->menu_id = $users->id;
        $users_create->name = 'استخراج';
        $users_create->url = 'dash/papers/create';
        $users_create->order = 4;
        $users_create->icon = 'flaticon-layers';
        $users_create->isSection = false;
        $users_create->permissions = 'create-paper';
        $users_create->save();


    }
}
