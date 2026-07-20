<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\login_ctrl;
use App\Http\Controllers\admin_ctrl;
use App\Http\Controllers\LT_ctrl;
use App\Http\Controllers\pathologist_ctrl;
use App\Http\Controllers\profile_ctrl;

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

    Route::get('/BarcodeScanner', [LT_ctrl::class, 'Barcode_Scanner'])->name('patient.scanner');
    Route::post('/BarcodeLookup', [LT_ctrl::class, 'Barcode_Lookup'])->name('patient.barcodelookup');


});

############## LAB TECHNICIAN ROUTES END #####################




############## SHARED (ANY ROLE) ROUTES START #####################

Route::middleware(['AnyRole'])->group(function () {

    Route::get('/PatientCalendar', [LT_ctrl::class, 'Patient_Calendar'])->name('patient.calendar');
    Route::get('/PatientProfile/{id}', [LT_ctrl::class, 'Patient_Profile'])->name('patient.profile');
    Route::get('/PatientReceipt/{id}', [LT_ctrl::class, 'Patient_Receipt'])->name('patient.receipt');
    Route::get('/PatientReport/{id}', [LT_ctrl::class, 'Patient_Report'])->name('patient.report');
    Route::get('/PatientLabel/{id}', [LT_ctrl::class, 'Patient_Label'])->name('patient.label');

    Route::get('/MyProfile', [profile_ctrl::class, 'index'])->name('profile.my');
    Route::post('/MyProfile/Info', [profile_ctrl::class, 'updateInfo'])->name('profile.updateinfo');
    Route::post('/MyProfile/Password', [profile_ctrl::class, 'updatePassword'])->name('profile.updatepassword');
    Route::post('/MyProfile/Photo', [profile_ctrl::class, 'updatePhoto'])->name('profile.updatephoto');

});

############## SHARED (ANY ROLE) ROUTES END #####################




############## PATHOLOGIST ROUTES START #####################

Route::middleware(['Path'])->group(function () {
    Route::get('/PathologistDashboard', [pathologist_ctrl ::class, 'index'])->name('Path.dashboard_page');
    Route::get('/Appointments', [pathologist_ctrl::class, 'Appointments'])->name('Path.Appointments');

    Route::post('/UpdateAppointment', [pathologist_ctrl::class, 'Update_Appointment_data'])->name('Path.updateAppointment');


});
############## PATHOLOGIST ROUTES END #####################

