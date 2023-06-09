<?php

// use App\Http\Controllers\Auth\ForgotPasswordController;
// use App\Http\Controllers\Auth\ChangePasswordController;
Auth::routes();

Route::redirect('/', '/login');


Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

//Route::post('/login', 'Auth\LoginController@authenticated')->name('login');

//Route::group(['middleware' => 'password.expiration'], function () {    

    //Route::get('/passwords/expired', 'Auth\ExpiredPasswordController@index')->name('password.expired');
    
    Route::middleware(['auth'])->group(function () {
        Route::middleware(['password_expired'])->group(function () {
            Route::any('/dashboard', function () {
                return 'See dashboard';
            });
        });
    
        Route::get('/passwords/expired', 'Auth\ExpiredPasswordController@index')->name('password.expired');
        Route::post('password/post_expired', 'Auth\ExpiredPasswordController@post_expired')->name('password.post_expired');
    });
//});

Route::get('/change-password', 'Auth\ChangePasswordController@index')->name('password.change');
Route::post('/change-password/store', 'Auth\ChangePasswordController@store')->name('password.update');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Take Survey
    Route::delete('take-surveys/destroy', 'TakeSurveyController@massDestroy')->name('take-surveys.massDestroy');
    Route::resource('take-surveys', 'TakeSurveyController');

    // Abandoned Calls
    Route::delete('abandoned-calls/destroy', 'AbandonedCallsController@massDestroy')->name('abandoned-calls.massDestroy');
    Route::resource('abandoned-calls', 'AbandonedCallsController', ['except' => ['create', 'store']]);

    // Contact
    Route::delete('contacts/destroy', 'ContactController@massDestroy')->name('contacts.massDestroy');
    Route::resource('contacts', 'ContactController');
 
    // CSAT Answers 
    Route::get('answers','ReportController@answers')->name('csat.answers');

    //CSAT Horizontal Report
    Route::get('answers_horizontal','ReportController@answers_horizontal')->name('csat.answers_horizontal');

    //Live Dash
    Route::get('livedash','LiveDashController@livedash')->name('livedash');
     
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.change');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
//for survey submit
Route::group(['prefix' => 'csat', 'as' => 'csat.','namespace' => 'CSAT'], function () {
    Route::get('submit/{surveyid}/{uniqueid}','EntriesController@entry')->name('entry');
    Route::post('store/{surveyid}/{uniqueid}','EntriesController@store')->name('store');
});

Route::get('forget-password', 'Auth\ForgotPasswordController@index')->name('forget.password');
// Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');



 