<?php

use App\Http\Controllers\BackupController;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PaperController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/********************* App routes :: Start *****************************************/

Route::get('/', function () {
    return redirect('dash');
    //return view('welcome');
});

/********************* App routes :: End *******************************************/

/********************* Dashboard routes :: Start ***********************************/

Auth::routes();

// main dash route
Route::get('/dash', [HomeController::class, 'index'])->name('dash');

// any links that have resources route starters must be before the resources routes

// menu-items routes
Route::get('dash/menus/menu-items/{menu}/create', [MenuItemController::class, 'create'])->name('menus.menu-items.create');
Route::get('dash/menus/menu-items/{menu}/edit/{menu_item}', [MenuItemController::class, 'edit'])->name('menus.menu-items.edit');
Route::post('dash/menus/menu-items/{menu}', [MenuItemController::class, 'store']);
Route::post('dash/menus/menu-items/{menu}/update', [MenuItemController::class, 'update_menu']);
Route::post('dash/menus/menu-items/{menu}/update/{menu_item}', [MenuItemController::class, 'update_menuItem']);
Route::post('dash/menus/menu-items/{menu}/delete/{menu_item}', [MenuItemController::class, 'delete_menuItem']);

// menu delete
Route::get('dash/menus/{menu}/delete', [MenuController::class, 'destroy']);

//permissions multi delete
Route::post('dash/permissions/delete-multi', [PermissionController::class, 'deleteMulti']);

//roles multi delete
Route::post('dash/roles/delete-multi', [RoleController::class, 'deleteMulti']);

//users multi delete
Route::post('dash/users/delete-multi', [UserController::class, 'deleteMulti']);

//backups
Route::get('dash/backups', [BackupController::class, 'index']);
Route::get('dash/backups/{backup}/download', [BackupController::class, 'download']);
Route::Delete('dash/backups/{backup}/delete', [BackupController::class, 'delete']);
Route::get('dash/backups/backup', [BackupController::class, 'backup']);

//exports and imports and PDFs
//Users
Route::get('dash/users/export', [UserController::class, 'export']);
Route::get('dash/users/{user}/pdf', [UserController::class, 'generatePdf']);

//console route
Route::get('dash/console', [ConsoleController::class, 'index']);
Route::get('dash/ide-helper', [ConsoleController::class, 'ideHelper']);
Route::get('dash/clear-cache', [ConsoleController::class, 'clearCache']);
Route::get('dash/optimize-cache', [ConsoleController::class, 'optimizeCache']);
Route::get('dash/add-model', [ConsoleController::class, 'addModel']);
Route::get('dash/wilayas/{id}/get_baladias', [ConsoleController::class, 'getBaladias']);
Route::get('dash/wilayas/{id}/get_baladias_dairas', [ConsoleController::class, 'getBaladias']);
Route::get('dash/dairas/{id}/get_baladias_from_dairas', [ConsoleController::class, 'get_baladias_from_dairas']);
Route::get('dash/papers/{id}/create', [PaperController::class, 'exportPaper']);
Route::get('dash/papers/{id}/create', [PaperController::class, 'exportPaper']);
Route::post('dash/papers/{id}/export', [PaperController::class, 'exportPaper']);
Route::get('dash/contracts/{id}/pdf', [PaperController::class, 'exportContract']);
Route::get('dash/contracts/chief/create', [ContractController::class, 'createChiefContract'])->name('chief');
Route::get('dash/papers/list', [PaperController::class, 'papersList']);
Route::get('dash/papers/{paper_type}/{id}/exportFile', [PaperController::class, 'export']);
Route::post('dash/contracts/{id}/create', [ContractController::class, 'extendContract']);
Route::post('dash/contracts/{id}/cancel', [ContractController::class, 'cancelContract']);
Route::post('dash/contracts/cancel/{id}/pdf', [PaperController::class, 'exportCancelPDF']);
Route::post('dash/contracts/cancel/{id}/pdf', [PaperController::class, 'exportCancelPDF']);
Route::get('dash/contracts/{id}/pdf/5', [PaperController::class, 'exportPaiementPDF']);



// resources routes
Route::resources([
    'dash/permissions' => PermissionController::class,
    'dash/roles' => RoleController::class,
    'dash/menus' => MenuController::class,
    'dash/users' => UserController::class,
    'dash/security/assistance' => EmployeesController::class,
    'dash/contracts' => ContractController::class,
    'dash/papers' => PaperController::class,
]);

/********************* Dashboard routes :: End **************************************/

// The fallback route should always be the last route registered by your application.
Route::fallback(function(){
    //test if you are in the dashboard
    if (substr(request()->path(), 0, strlen('dash')) === 'dash')
        return view('errors.dashboard.404')->with('error',true);
    else
        return view('errors.app.404')->with('error',true);
});
