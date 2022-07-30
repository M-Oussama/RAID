<?php

namespace App\Http\Controllers;

use App\Models\Baladia;
use App\Models\Daira;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;


class ConsoleController extends Controller
{
    public function index() {
        return view('dashboard.settings.developers.index');
    }

    public function ideHelper() {
        shell_exec('cd '.base_path().' && php artisan ide-helper:models -W');
        shell_exec('cd '.base_path().' && php artisan ide-helper:generate -W');
        shell_exec('cd '.base_path().' && php artisan ide-helper:meta -W');

        return redirect('dash/console');
    }

    public function clearCache() {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        return redirect('dash/console');
    }

    public function optimizeCache() {
        Artisan::call('config:cache');
        Artisan::call('view:cache');
        Artisan::call('route:cache');

        return redirect('dash/console');
    }

    public function addModel(Request $request){
        return redirect('dash/console');
    }

    public function getBaladias($id){

        $baladias = Baladia::whereIn('daira_id',function ($query) use ($id){
            $query->select('id')->from(with(new Daira)->getTable())->where('wilaya_id',$id)->pluck('id')->toArray();
        })->get();

        return response()->json(["baladias"=>$baladias]);
    }
}
