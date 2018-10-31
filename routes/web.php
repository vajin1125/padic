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

// Route::group(
//     ['prefix'=>'admin','middleware'=>'admin'],function(){
//         Route::get('/dashboard','Admin\DashboardController@index')->name('dashboard');
//         Route::get('/show_users','Admin\UserController@showUsers')->name('manage_users');

//         Route::post('/update_user_status',"Admin\UserController@updateUserStatus");
//         Route::get('/delete_user/{id}',"Admin\UserController@deleteUser");

//         Route::post('/upload_gallery_image',"Admin\GalleryController@upload");

//         Route::get('import-export-view', 'Admin\ExcelController@importExportView')->name('import.export.view');
//         Route::post('import-file', 'Admin\ExcelController@importFile')->name('import.file');
//         Route::get('export-file/{type}', 'Admin\ExcelController@exportFile')->name('export.file');
//         // Route::get('export-file/{type}',function(){
//         //     return \Excel::download(new App\Export\ReservateExport(1), 'email.xlsx');
//         // });
//     }    
// );

Auth::routes();

Route::get('/',"HomeController@index");
Route::get('/logout','Auth\LoginController@logout');
Route::get('/afterReg','HomeController@afterReg');

Route::group(
    ['prefix'=>'admin'],function(){
        Route::get('/index','admin\UserMngController@list');// ->name('dashboard');
        Route::get('/user_list','admin\UserMngController@list');
        Route::get('/user_update','admin\UserMngController@update');
        Route::post('/user_update','admin\UserMngController@save');
        Route::get('/user_delete','admin\UserMngController@delete');
        
        Route::get('/patient_add_get', "admin\patientController@patient_get");
        Route::get('/patient_add', "admin\patientController@patient_add");
        Route::post('/patient_add',"admin\patientController@patient_save");
        Route::get('/patient_search', "admin\patientController@patient_search");
        Route::post('/patient_search',"admin\patientController@patient_search_results");
        Route::get('/patient_all',"admin\patientController@patient_all_results");
        Route::get('/patient_update',"admin\patientController@patient_update");
        Route::post('/patient_update',"admin\patientController@patient_save");        
        Route::get('/patient_delete',"admin\patientController@patient_delete");
        Route::get('/patient_new',"admin\patientController@patient_new");
        Route::post('/patient_addnew',"admin\patientController@patient_addnew");
        
        Route::get('/patient_send_msg',"admin\ptpycontroller@index");
        Route::post('/patient_send_msg',"admin\ptpycontroller@send_msg");
        Route::get('/patient_vali_py',"admin\ptpycontroller@vali_py");
        Route::get('/ptpy_del',"admin\ptpycontroller@ptpy_del");
        
        Route::get('/physic_add_get', "admin\physicController@physic_get");
        Route::get('/physic_add', "admin\physicController@physic_add");
        Route::post('/physic_add',"admin\physicController@physic_save");
        Route::get('/physic_search', "admin\physicController@physic_search");
        Route::post('/physic_search',"admin\physicController@physic_search_results");
        Route::get('/physic_all',"admin\physicController@physic_all_results");
        Route::get('/physic_update',"admin\physicController@physic_update");
        Route::post('/physic_update',"admin\physicController@physic_save");        
        Route::get('/physic_delete',"admin\physicController@physic_delete");
        
        Route::get('/profile',"admin\AdminController@profile");
        Route::post('/profile_update',"admin\AdminController@profile_update");

        Route::get('/email_patient',  "admin\AdminController@bEmail_patient");
        Route::get('/email_user',  "admin\AdminController@bEmail_user");
    }
);

Route::group(
    ['prefix'=>'subadmin'],function(){
        Route::get('/index','subadmin\SubAdminController@admin_list'); 
        Route::get('/admin_list','subadmin\SubAdminController@admin_list'); 
        Route::get('/admin_view','subadmin\SubAdminController@admin_view');

        Route::get('/physic_search', "subadmin\SubAdminController@physic_search");
        Route::post('/physic_search',"subadmin\SubAdminController@physic_search_results");
        Route::get('/physic_all',"subadmin\SubAdminController@physic_all_results");
        Route::get('/physic_view',"subadmin\SubAdminController@physic_view");

        Route::get('/patient_search', "subadmin\SubAdminController@patient_search");
        Route::post('/patient_search',"subadmin\SubAdminController@patient_search_results");
        Route::get('/patient_all',"subadmin\SubAdminController@patient_all_results");
        Route::get('/patient_view',"subadmin\SubAdminController@patient_view");
        Route::get('/patient_physic',"subadmin\SubAdminController@patient_physic");
        
        Route::get('/profile',"subadmin\SubAdminController@profile");
        Route::post('/profile_update',"subadmin\SubAdminController@profile_update");

        Route::get('/email_user',  "subadmin\SubAdminController@bEmail_user");
    }
);

Route::group(
    ['prefix'=>'physic'],function(){
        Route::get('/index','physic\PhysicController@list');// ->name('dashboard');
        Route::get('/list','physic\PhysicController@list');// ->name('dashboard');
        Route::get('/edit','physic\PhysicController@edit'); // 
        Route::post('/edit','physic\PhysicController@save'); //
        Route::get('/view','physic\PhysicController@view'); //
        Route::get('/profile',"physic\PhysicController@edit");
    }
);

Route::group(
    ['prefix'=>'patient'],function(){
        Route::get('/index','patient\PatientController@list');// ->name('dashboard');
        Route::get('/list','patient\PatientController@list');// ->name('dashboard');
        Route::get('/edit','patient\PatientController@edit'); // 
        Route::post('/edit','patient\PatientController@save'); //
        Route::get('/view','patient\PatientController@view'); //
        Route::get('/profile','patient\PatientController@edit'); //
    }
);




