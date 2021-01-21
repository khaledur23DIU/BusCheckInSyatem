<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes([
	'register' => false
]);

Route::get('/dashboard','HomeController@index')->name('home')->middleware('auth');

Route::group(['prefix'=>'dashboard','namespace'=>'Admin','middleware' => ['auth']], function () {
	Route::resource('users', 'UserController', ['except' => ['show','create']]);
	Route::get('profile', 'ProfileController@edit')->name('profile.edit');
	Route::put('profile', 'ProfileController@update')->name('profile.update');
	Route::put('profile/password', 'ProfileController@password')->name('profile.password');

	Route::get('roles','RoleController@index')->name('roles.index');
    Route::post('roles','RoleController@store')->name('roles.store');
    Route::get('roles/{role}/edit','RoleController@edit')->name('roles.edit');
    Route::put('roles/{role}','RoleController@update')->name('roles.update');
    Route::delete('roles/{role}','RoleController@destroy')->name('roles.destroy');

    Route::get('checkers','CheckerController@index')->name('checkers.index');
    Route::post('checkers','CheckerController@store')->name('checkers.store');
    Route::get('checkers/{id}/edit','CheckerController@edit')->name('checkers.edit');
    Route::put('checkers/{id}','CheckerController@update')->name('checkers.update');
    Route::delete('checkers/{id}','CheckerController@destroy')->name('checkers.destroy');

	Route::get('bus','BusController@index')->name('bus.index');
	Route::post('bus','BusController@store')->name('bus.store');
	Route::get('bus/{id}','BusController@edit')->name('bus.edit');
	Route::put('bus/{id}','BusController@update')->name('bus.update');
	Route::delete('bus/{id}','BusController@destroy')->name('bus.destroy');

	Route::get('passenger-category','PassengerCategoryController@index')->name('passengerCategory.index');
	Route::get('passenger-category/{id}','PassengerCategoryController@edit')->name('passengerCategory.edit');
	Route::put('passenger-category/{id}','PassengerCategoryController@update')->name('passengerCategory.update');

	Route::get('bus-route','BusRouteController@index')->name('busRoute.index');
	Route::post('bus-route','BusRouteController@store')->name('busRoute.store');
	Route::get('bus-route/{id}','BusRouteController@edit')->name('busRoute.edit');
	Route::put('bus-route/{id}','BusRouteController@update')->name('busRoute.update');
	Route::delete('bus-route/{id}','BusRouteController@destroy')->name('busRoute.destroy');

	Route::get('bus-stops','BusStopController@index')->name('busStop.index');
	Route::post('bus-stops','BusStopController@store')->name('busStop.store');
	Route::get('bus-stops/{id}','BusStopController@edit')->name('busStop.edit');
	Route::put('bus-stops/{id}','BusStopController@update')->name('busStop.update');
	Route::delete('bus-stops/{id}','BusStopController@destroy')->name('busStop.destroy');

	Route::get('ticket-price','TicketPricingController@index')->name('ticketPrice.index');
	Route::get('ticket-price/getBusStopFromWhere','TicketPricingController@getBusStopFromWhere')->name('ticketPrice.getBusStopFromWhere');
	Route::get('ticket-price/getBusStopToWhere','TicketPricingController@getBusStopToWhere')->name('ticketPrice.getBusStopToWhere');
	Route::post('ticket-price','TicketPricingController@store')->name('ticketPrice.store');
	Route::get('ticket-price/{id}','TicketPricingController@edit')->name('ticketPrice.edit');
	Route::get('ticket-price/{id}/getBusStopFromWhere','TicketPricingController@getBusStopFromWhere')->name('ticketPrice.getBusStopFromWhere');
	Route::get('ticket-price/{id}/getBusStopToWhere','TicketPricingController@getBusStopToWhere')->name('ticketPrice.getBusStopToWhere');
	Route::put('ticket-price/{id}','TicketPricingController@update')->name('ticketPrice.update');
	Route::delete('ticket-price/{id}','TicketPricingController@destroy')->name('ticketPrice.destroy');

	Route::get('bus-in-route','BusesInRouteController@index')->name('busInRoute.index');
	Route::post('bus-in-route','BusesInRouteController@store')->name('busInRoute.store');
	Route::get('bus-in-route/{id}','BusesInRouteController@edit')->name('busInRoute.edit');
	Route::put('bus-in-route/{id}','BusesInRouteController@update')->name('busInRoute.update');
	Route::delete('bus-in-route/{id}','BusesInRouteController@destroy')->name('busInRoute.destroy');

	Route::get('assign-checker','AssignCheckerController@index')->name('assignChecker.index');
	Route::get('assign-checker/getCheckInPlace','AssignCheckerController@getCheckInPlace')->name('assignChecker.getCheckInPlace');
	Route::post('assign-checker','AssignCheckerController@store')->name('assignChecker.store');
	Route::get('assign-checker/{id}','AssignCheckerController@edit')->name('assignChecker.edit');
	Route::get('assign-checker/{id}/getCheckInPlace','AssignCheckerController@getCheckInPlace')->name('assignChecker.getCheckInPlace');
	Route::put('assign-checker/{id}','AssignCheckerController@update')->name('assignChecker.update');
	Route::delete('assign-checker/{id}','AssignCheckerController@destroy')->name('assignChecker.destroy');

	Route::get('check-in/all','CheckInController@index')->name('allCheckIn.index');
	Route::get('check-in/checker/{id}/check-in','CheckInController@checkInsByChecker')->name('checkInByChecker.checkIns');

	Route::get('complains/all','ComplainController@index')->name('allComplains.index');
	Route::get('complains/complain/{id}','ComplainController@complainSeen')->name('allComplains.complainSeen');

	Route::get('income/daily/by-buses','IncomeReportController@dailyIncomePerBus')->name('incomeReport.dailyIncomePerBus');
	Route::get('income/daily/per-day','IncomeReportController@totalDailyIncome')->name('incomeReport.totalDailyIncome');
	Route::get('income/monthly/per-month','IncomeReportController@totalMonthlyIncome')->name('incomeReport.totalMonthlyIncome');

	Route::get('settings','SiteSettingsController@settings')->name('siteSetting.settings');
    Route::put('settings/basic-info','SiteSettingsController@updateBasicInfo')->name('siteSetting.updateBasicInfo');
    Route::put('settings/meta','SiteSettingsController@updateMeta')->name('siteSetting.updateMeta');
    Route::put('settings/mail-service','SiteSettingsController@updateMailService')->name('siteSetting.updateMailService');
    
});



Route::group(['prefix'=>'dashboard','namespace'=>'Checker','middleware' => ['auth']], function () {

	Route::get('check-in','CheckInController@index')->name('checkIn.index');
	Route::post('check-in','CheckInController@store')->name('checkIn.store');
	Route::get('check-in/{id}','CheckInController@edit')->name('checkIn.edit');
	Route::put('check-in/{id}','CheckInController@update')->name('checkIn.update');

	Route::get('my-complain','ComplainController@index')->name('checkerComplain.index');
	Route::post('my-complain','ComplainController@store')->name('checkerComplain.store');
	Route::get('my-complain/{id}','ComplainController@show')->name('checkerComplain.show');


});


