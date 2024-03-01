<?php

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



Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/','HomeController@index')->name('home');

    Route::get('/home','HomeController@index')->name('home');

    //Matrix
    Route::get('/matrices','MatrixController@index')->name('settings');

    //companies
    Route::get('/companies','CompanyController@index')->name('settings');
    Route::get('/companies', 'CompanyController@index')->name('settings');
    Route::post('/new-company', 'CompanyController@store')->name('settings');
    Route::post('deactivate-company', 'CompanyController@deactivate')->name('settings');
    Route::post('activate-company', 'CompanyController@activate')->name('settings');

    Route::get('/users', 'UserController@index')->name('settings');
    Route::post('new-account', 'UserController@create')->name('settings');
    Route::post('/change-password/{id}', 'UserController@changepassword')->name('settings');
    Route::post('/edit-user/{id}', 'UserController@edit_user')->name('settings');
    Route::post('deactivate-user', 'UserController@deactivate_user')->name('settings');
    Route::post('activate-user', 'UserController@activate_user')->name('settings');
    Route::post('share/{id}','AttachmentUserController@store');

    Route::get('/calendar','ScheduleController@index')->name('calendar');
    Route::post('new-schedule','ScheduleController@store')->name('calendar');
    Route::post('new-schedule-special','ScheduleController@storeSpecial')->name('calendar');
    Route::get('monthly-report','ScheduleController@monthly_report')->name('calendar');
    Route::post('upload-monthly','ScheduleController@upload')->name('calendar');
    Route::post('upload-attachment/{id}','ScheduleController@attachment')->name('calendar');
    Route::get('remove-attachment/{id}','ScheduleController@remove_attachment')->name('calendar');
    Route::post('edit-schedule/{id}','ScheduleController@edit')->name('calendar');
    Route::get('view-calendar/{id}','ScheduleController@view');
    Route::get('autorithy/{id}','ScheduleController@authority')->name('calendar');
    Route::post('carbon-copy/{id}','ScheduleController@carbon')->name('calendar');
    Route::post('hbu/{id}','ScheduleController@hbu')->name('calendar');
    Route::get('initial-report/{id}','ScheduleController@initialReport')->name('engagements');
    Route::get('closing-report/{id}','ScheduleController@closingReport')->name('engagements');
    Route::post('observation/{id}','ScheduleController@save_observation')->name('for_audit');
    Route::get('new-observation/{id}','ScheduleController@new')->name('for_audit');
    Route::get('edit-observation/{id}','ScheduleController@edit_observation')->name('for_audit');
    Route::post('edit-observation/{id}','ScheduleController@save_edit')->name('for_audit');
    Route::post('move-observation','ScheduleController@move');
    Route::get('remove/{id}','ScheduleController@remove');  
    Route::get('for-approval-iad','EngagementController@forapproval')->name('for-approval-iad');
    Route::post('action-acr/{id}','EngagementController@action')->name('for-approval-iad');

    Route::get('findings','EngagementController@index')->name('findings');
    Route::get('view-observation/{id}','EngagementController@view')->name('findings');

    Route::get('for-audit','ScheduleController@forAudit')->name('for-audit');

    Route::get('/departments', 'DepartmentController@index')->name('settings');
    Route::post('/new-department', 'DepartmentController@store')->name('settings');
    Route::post('deactivate-department', 'DepartmentController@deactivate')->name('settings');
    Route::post('activate-department', 'DepartmentController@activate')->name('settings');
    Route::post('edit-department/{id}','DepartmentController@update')->name('settings');

    Route::get('engagements','EngagementController@index')->name('engagements');
    Route::get('view-engagement/{id}','EngagementController@show')->name('engagements');
    Route::get('acr','EngagementController@acr')->name('acr');
    Route::get('engagements_reports','EngagementController@report')->name('engagements');
    Route::get('engagements_each','EngagementController@report_each')->name('engagements');


    Route::get('for-explanation','EngagementController@forExplanation')->name('for-explanation');
    Route::get('for-review','EngagementController@forReview')->name('for-review');
    Route::get('for-verification-acr','EngagementController@forVerication')->name('for-verification-acr');
    Route::post('for-verification-acr/{id}','EngagementController@verified')->name('for-verification-acr');
    Route::post('explanation/{id}','EngagementController@store');
    Route::post('for-review/{id}','EngagementController@reviewed')->name('reviewed');

    Route::get('action-plans','ActionPlanController@index')->name('action-plans');
    Route::post('save-action-plan/{id}','ActionPlanController@upload_proof')->name('action-plans');
    Route::post('upload-attachment-close/{id}','ActionPlanController@upload_proof_close')->name('action-plans');
    Route::post('change-target-plan/{id}','ActionPlanController@change_target_date')->name('action-plans');
    Route::post('return-action-plan/{id}','ActionPlanController@return_action_plan')->name('action-plans');
    Route::post('close-action-plan/{id}','ActionPlanController@close_action_plan')->name('action-plans');
    Route::get('close-action-plans','ActionPlanController@close_action_plans')->name('closed-action-plans');
    Route::post('new-action-plan','ActionPlanController@new_action_plan');
    Route::post('edit-action-plan/{id}','ActionPlanController@edit_action_plan');
    
    // Route::get('autorithy/{id}','EngagementController@authority')->name('engagements');
    // Route::get('initial-report/{id}','EngagementController@initialReport')->name('engagements');

    Route::get('/logs', 'AuditController@index')->name('reports');

    Route::get('engagement-reports','ActionPlanController@engagementReports')->name('reports');


});
