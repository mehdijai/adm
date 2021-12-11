<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Setting;
use App\Models\Vehicule;
use App\Mail\ContactForms;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\SAM;
use App\Notifications\User\SubSoon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Notifications\User\SubExpired;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Agence\VehsController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AgenceSupportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\VehiculesController;
use App\Http\Controllers\Admin\SubscriptionsController;

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

Route::get('/', [HomeController::class, 'index'])->name("home");

Route::get("sitemap.xml" , function () {
    return \Illuminate\Support\Facades\Redirect::to('sitemap.xml');
})->name('sitemap');
 
Route::get('/vehicules', [HomeController::class, 'vehicules'])->name("vehicules");

Route::get('/vehicule/{id}', [HomeController::class, 'vehicule'])->name("vehicule");

Route::get('/agence/{id}', [HomeController::class, 'agence'])->name("agence");

Route::post('/contact', function (Request $request){

    Mail::to(env('MAIL_TO'))->queue(new ContactForms($request->all()));

    if(Mail::failures()){
        return redirect('/#contact')->with('fail', "Il y'avait un prblème, l'email n'était pas envoyé!");
    }

    return redirect('/#contact')->with('status', 'Envoyé avec succès');

})->name("contact-send");

Route::prefix('dashboard')->middleware(['auth:sanctum', 'verified', 'role:agence'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Support
    Route::get('/support', [AgenceSupportController::class, 'index'])->name('support');
    Route::post('/support', [AgenceSupportController::class, 'support'])->name('send-support');

    // ADM Premium
    Route::get('/premium', [PlanController::class, 'index'])->name('premium.index');
    Route::get('/premium/{id}', [PlanController::class, 'view'])->name('premium.view');
    Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('premium.subscribe');

});


Route::middleware(['auth:sanctum', 'verified', 'role:agence'])->group(function () {
    // View Veh
    Route::get('/veh/{id}', [VehsController::class, 'view'])->name('vehs.view');
    
    // Create Veh Form
    Route::get('/vehs/create', [VehsController::class, 'create'])->name('vehs.create');
    
    // Save Veh
    Route::post('/vehs/store', [VehsController::class, 'store'])->name('vehs.store');
    
    // Delete Veh
    Route::post('/vehs/delete', [VehsController::class, 'delete'])->name('vehs.delete');
    
    // Edit Veh
    Route::get('/vehs/edit/{id}', [VehsController::class, 'edit'])->name('vehs.edit');
    
    // Update Veh
    Route::post('/vehs/update', [VehsController::class, 'update'])->name('vehs.update');
});




Route::middleware(['auth:sanctum', 'verified', 'role:agence'])->get('my_location', function ()
{
    $map_locale = Auth::user()->agence()->get()[0]->map_locale;
    
    if(!$map_locale){
        return response()->json(['message' => 'data not found'], 404);
    }
    
    return response()->json(json_decode($map_locale), 200);
});


Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', function () {

        $statisctics = [
            'users' => User::where('role_id', 1)->count(),
            'vehicules' => Vehicule::count(),
            'active_subscriptions' => Subscription::where('active', true)->count(),
            'pending_subscriptions' => Subscription::where('active', false)->where('expired', false)->count(),
            'expired_subscriptions' => Subscription::where('expired', true)->count(),
        ];

        return view('admins.index')->with(['statisctics' => $statisctics]);

    })->name('index');

    Route::prefix('admins')->name('admins.')->group(function () {

        Route::get('/', [AdminsController::class, 'index'])->name('index');

        Route::get('/create', [AdminsController::class, 'create'])->name('create');

        Route::post('/delete', [AdminsController::class, 'delete'])->name('delete');
        Route::post('/store', [AdminsController::class, 'store'])->name('store');
        
    });


    Route::prefix('users')->name('users.')->group(function () {
        
        Route::get('/', [UsersController::class, 'index'])->name('index');

        Route::post('/delete', [UsersController::class, 'delete'])->name('delete');
    });

    Route::prefix('vehicules')->name('vehicules.')->group(function () {

        Route::get('/', [VehiculesController::class, 'index'])->name('index');

        Route::post('/delete', [VehiculesController::class, 'delete'])->name('delete');
        Route::get('/edit/{id}', [VehiculesController::class, 'edit'])->name('edit');
        Route::post('/update', [VehiculesController::class, 'update'])->name('update');
        Route::get('/create/{id}', [VehiculesController::class, 'create'])->name('create');
        Route::post('/store', [VehiculesController::class, 'store'])->name('store');
        
    });

    Route::prefix('plans')->name('plans.')->group(function () {
        
        Route::get('/', [PlansController::class, 'index'])->name('index');

        Route::get('/edit/{id}', [PlansController::class, 'edit'])->name('edit');
        Route::post('/update', [PlansController::class, 'plan'])->name('update');
    });

    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {

        Route::get('/', [SubscriptionsController::class, 'index'])->name('index');

        Route::post('/activate', [SubscriptionsController::class, 'activate_subscription'])->name('activate');
        Route::post('/delete', [SubscriptionsController::class, 'delete'])->name('delete');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        
        Route::get('/', [SettingsController::class, 'index'])->name('index');

        Route::post('/update', [SettingsController::class, 'update'])->name('update');
        Route::post('/contacts', [SettingsController::class, 'contacts_update'])->name('contacts');
        Route::post('/provider', [SettingsController::class, 'provider_update'])->name('providers');

    });

});