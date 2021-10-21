<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return Redirect::to('/login');
});

Auth::routes(
	['register' => false]
);

Route::middleware('auth')->group(function () {

	Route::get('/logout', function () {

    	Auth::logout();

    	return Redirect::to('/login')->with('msg', 'Gracias por visitarnos!.');
	});

	# Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

	# Route::get('/main', [App\Http\Controllers\HomeController::class, 'main']);

	Route::resource('provider/reference',App\Http\Controllers\ReferenceController::class);
	Route::resource('provider/truck',App\Http\Controllers\TruckController::class);
	Route::resource('provider/towing',App\Http\Controllers\TowingController::class);
	Route::resource('provider/operator',App\Http\Controllers\OperatorController::class);
	Route::resource('provider/traffic',App\Http\Controllers\TrafficController::class);
	Route::resource('provider/available_units',App\Http\Controllers\AvailableUnitsController::class);
	Route::resource('provider',App\Http\Controllers\ProviderController::class);
	Route::get('getProviders', [App\Http\Controllers\ProviderController::class,'getProviders']);
	Route::get('{id}/getReferences', [App\Http\Controllers\ReferenceController::class,'getReferences']);
	Route::get('{id}/getTrucks/{status?}', [App\Http\Controllers\TruckController::class,'getTrucks']);
	Route::get('{id}/getTowings/{status?}', [App\Http\Controllers\TowingController::class,'getTowings']);
	Route::get('{id}/getOperators/{status?}', [App\Http\Controllers\OperatorController::class,'getOperators']);

	Route::get('auditProviders/{status?}', [App\Http\Controllers\ProviderController::class,'getProviders']);
	Route::get('auditTrucks/{status?}/{line?}', [App\Http\Controllers\TruckController::class,'index']);
	Route::get('auditTowings/{status?}/{line?}', [App\Http\Controllers\TowingController::class,'index']);
	Route::get('auditOperators/{status?}/{line?}', [App\Http\Controllers\OperatorController::class,'index']);
	Route::post('setStatusLine', [App\Http\Controllers\ProviderController::class,'setStatusLine']);
	Route::post('setStatusTruck', [App\Http\Controllers\TruckController::class,'setStatusTruck']);
	Route::post('setStatusTowing', [App\Http\Controllers\TowingController::class,'setStatusTowing']);
	Route::post('setStatusOperator', [App\Http\Controllers\OperatorController::class,'setStatusOperator']);

	Route::resource('client/billing',App\Http\Controllers\BillingController::class);
	Route::resource('client/collect',App\Http\Controllers\CollectController::class);
	Route::resource('client/contact',App\Http\Controllers\ContactController::class);
	Route::resource('client/quotation',App\Http\Controllers\QuotationController::class);
	Route::resource('client',App\Http\Controllers\ClientController::class);
	Route::get('{id}/getBillings', [App\Http\Controllers\BillingController::class,'getBillings']);
	Route::get('{id}/getCollects', [App\Http\Controllers\CollectController::class,'getCollects']);
	Route::get('{id}/getContacts', [App\Http\Controllers\ContactController::class,'getContacts']);
	Route::get('{id}/getQuotations', [App\Http\Controllers\QuotationController::class,'getQuotations']);

	Route::get('cities',[App\Http\Controllers\ProviderController::class,'cities']);
	Route::get('rejectionMotives',[App\Http\Controllers\AvailableUnitsController::class,'rejectionMotives']);

	# Route::get('/provider', [App\Http\Controllers\ProviderController::class, 'index']);
	# Route::post('/provider/add', [App\Http\Controllers\ProviderController::class, 'store']);
	# Route::delete('/provider/{id}', [App\Http\HomeControllerers\ProviderController::class]);
});

Route::get('{any}', function () {

    if (Auth::check()) {
    	return view('main');
    }

    # abort(403, 'Unauthorized action.');

    return Redirect::to('/login');

})->where('any', '.*');
