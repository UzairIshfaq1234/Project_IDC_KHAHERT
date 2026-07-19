<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\login_ctrl;
use App\Http\Controllers\admin_ctrl;
use App\Http\Controllers\LT_ctrl;
use App\Http\Controllers\pathologist_ctrl;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [login_ctrl::class, 'login'])->name('Page.login');
Route::post('/', [login_ctrl::class, 'login_auth'])->name('Page.login_auth');

Route::get('/logout', [login_ctrl::class, 'logout'])->name('Page.logout');


############## ADMIN ROUTES START #####################
Route::middleware(['admin'])->group(function () {

    Route::get('/AdminDashboard', [admin_ctrl::class, 'index'])->name('admin.dashboard_page');
    Route::get('/AddAdmin', [admin_ctrl::class, 'addadmin'])->name('admin.add');
    Route::post('/AddAdminData', [admin_ctrl::class, 'Add_Admin_data'])->name('admin.adddata');
    Route::get('/AllAdmin', [admin_ctrl::class, 'All_Admin_data'])->name('admin.alladmin');
    Route::post('/UpdateAdmin', [admin_ctrl::class, 'Update_Admin_data'])->name('admin.updateadmin');
    Route::get('/DelAdmin/{id}', [admin_ctrl::class, 'Del_Admin_data'])->name('admin.deladmin');






});
############## ADMIN ROUTES END #####################





############## LAB TECHNICIAN ROUTES START #####################

Route::middleware(['LT'])->group(function () {
    
    Route::get('/LTDashboard', [LT_ctrl::class, 'index'])->name('LT.dashboard_page');
    Route::get('/AddPatient', [LT_ctrl::class, 'addpatient'])->name('patient.add');
    Route::post('/AddPatient', [LT_ctrl::class, 'Add_Patient_data'])->name('patient.adddata');
    Route::get('/AllPatient', [LT_ctrl::class, 'All_Patient_data'])->name('patient.allpatient');

    Route::post('/Updatepatient', [LT_ctrl::class, 'Update_Patient_data'])->name('patient.updatepatient');


});

############## LAB TECHNICIAN ROUTES END #####################




############## PATHOLOGIST ROUTES START #####################

Route::middleware(['Path'])->group(function () {
    Route::get('/PathologistDashboard', [pathologist_ctrl ::class, 'index'])->name('Path.dashboard_page');
    Route::get('/Appointments', [pathologist_ctrl::class, 'Appointments'])->name('Path.Appointments');

    Route::post('/UpdateAppointment', [pathologist_ctrl::class, 'Update_Appointment_data'])->name('Path.updateAppointment');


});
############## PATHOLOGIST ROUTES END #####################

