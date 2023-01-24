<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\KabidController;
use App\Http\Controllers\OutcomingController;
use App\Http\Controllers\OutgoingController;
use App\Http\Controllers\StaffController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
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


Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->type === "admin") {
            return redirect(RouteServiceProvider::ADMINHOME);
        } elseif (Auth::user()->type === "kabid") {
            return redirect(RouteServiceProvider::KABIDHOME);
        } else {
            return redirect(RouteServiceProvider::STAFFHOME);
        }
    }
    return view('auth.login');
});

Route::get('/home', function() {
    if (Auth::check()) {
        if (Auth::user()->type === "admin") {
            return redirect(RouteServiceProvider::ADMINHOME);
        } elseif (Auth::user()->type === "kabid") {
            return redirect(RouteServiceProvider::KABIDHOME);
        } else {
            return redirect(RouteServiceProvider::STAFFHOME);
        }
    }
    // return view('auth.login');
});

Auth::routes();

Route::get('admin/', function () {
    return redirect(RouteServiceProvider::ADMINHOME);
});

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:staff'])->group(function () {

    Route::get('/staff/home', [HomeController::class, 'staffHome'])->name('staff.home');

    /* PROFILE */

    Route::get('/staff/profile', [StaffController::class, 'staffProfile'])->name('staff.profileIndex');

    Route::post('/staff/profile/upload', [StaffController::class, 'staffUploadPicture'])->name('staff.profileUploadPicture');

    Route::match(['put', 'patch'], '/staff/profile/{id}', [StaffController::class, 'staffDataUpdate'])->name('staff.profileDataUpdate');

    Route::post('/staff/profile/change-password', [StaffController::class, 'staffPasswordUpdate'])->name('staff.profilePasswordUpdate');

    /* PROFILE */

    /* INCOMING TRANSACTION LETTER */
    Route::get('/staff/home', [HomeController::class, 'staffHome'])->name('staff.home');

    Route::get('/staff/incoming-letter', [StaffController::class, 'inLetterIndex'])->name('staff.incomingTransactionIndex');

    Route::get('/staff/incoming-letter/add', [StaffController::class, 'inLetterCreate'])->name('staff.incomingTransactionCreate');

    Route::post('/staff/incoming-letter/', [StaffController::class, 'inLetterStore'])->name('staff.incomingTransactionStore');

    Route::get('/staff/incoming-letter/{id}', [StaffController::class, 'inLetterDetail'])->name('staff.incomingTransactionDetail');

    Route::get('/staff/incoming-letter/edit/{id}', [StaffController::class, 'inLetterEdit'])->name('staff.incomingTransactionEdit');

    Route::match(['put', 'patch'], '/staff/incoming-letter/update/{id}', [StaffController::class, 'inLetterUpdate'])->name('staff.incomingTransactionUpdate');

    Route::delete('/staff/incoming-letter/{id}', [StaffController::class, 'inLetterDestroy'])->name('staff.incomingTransactionDestroy');

    /* INCOMING TRANSACTION LETTER */

    /* OUTGOING TRANSACTION LETTER */

    Route::get('/staff/outgoing-letter', [StaffController::class, 'outLetterIndex'])->name('staff.outgoingTransactionIndex');

    Route::get('/staff/outgoing-letter/add', [StaffController::class, 'outLetterCreate'])->name('staff.outgoingTransactionCreate');

    Route::post('/staff/outgoing-letter/', [StaffController::class, 'outLetterStore'])->name('staff.outgoingTransactionStore');

    Route::get('/staff/outgoing-letter/{id}', [StaffController::class, 'outLetterDetail'])->name('staff.outgoingTransactionDetail');

    Route::get('/staff/outgoing-letter/edit/{id}', [StaffController::class, 'outLetterEdit'])->name('staff.outgoingTransactionEdit');

    Route::match(['put', 'patch'], '/staff/outgoing-letter/update/{id}', [StaffController::class, 'outLetterUpdate'])->name('staff.outgoingTransactionUpdate');

    Route::delete('/staff/outgoing-letter/{id}', [StaffController::class, 'outLetterDestroy'])->name('staff.outgoingTransactionDestroy');

    /* OUTGOING TRANSACTION LETTER */

    /* AGENDA LETTER INCOMING */

    Route::get('/staff/agenda-incoming', [StaffController::class, 'inAgendaIndex'])->name('staff.incomingAgendaIndex');

    Route::get('/staff/agenda-incoming/search/', [StaffController::class, 'inAgendaSearchDate'])->name('staff.incomingAgendaSearchDate');

    Route::get('/staff/agenda-incoming/export/', [StaffController::class, 'inAgendaExport'])->name('staff.incomingAgendaExport');

    /* AGENDA LETTER INCOMING */

    /* AGENDA LETTER OUTGOING */

    Route::get('/staff/agenda-outgoing', [StaffController::class, 'outAgendaIndex'])->name('staff.outgoingAgendaIndex');

    Route::get('/staff/agenda-outgoing/search/', [StaffController::class, 'outAgendaSearchDate'])->name('staff.outgoingAgendaSearchDate');

    Route::get('/staff/agenda-outgoing/export/', [StaffController::class, 'outAgendaExport'])->name('staff.outgoingAgendaExport');

    /* AGENDA LETTER OUTGOING */

    /* GALLERY INCOMING LETTER */

    Route::get('/staff/gallery-incoming', [StaffController::class, 'inGalleryIndex'])->name('staff.incomingGalleryIndex');

    /* GALLERY INCOMING LETTER */

    /* GALLERY OUTGOING LETTER */

    Route::get('/staff/gallery-outgoing', [StaffController::class, 'outGalleryIndex'])->name('staff.outgoingGalleryIndex');

    /* GALLERY OUTGOING LETTER */

    /* CLASSIFICATION LETTER */

    Route::get('/staff/classification-letter', [ClassificationController::class, 'staffIndex'])->name('staff.classificationIndex');

    Route::get('/staff/classification-letter/create', [ClassificationController::class, 'StaffCreate'])->name('staff.classificationCreate');

    Route::post('/staff/classification-letter/', [ClassificationController::class, 'staffStore'])->name('staff.classificationStore');

    Route::get('/staff/classification-letter/edit/{id}', [ClassificationController::class, 'staffEdit'])->name('staff.classificationEdit');

    Route::match(['put', 'patch'], '/staff/classification-letter/update/{id}', [ClassificationController::class, 'staffUpdate'])->name('staff.classificationUpdate');

    Route::delete('/staff/classification-letter/{id}', [ClassificationController::class, 'staffDestroy'])->name('staff.classificationDestroy');

    /* CLASSIFICATION LETTER */
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    /* PROFILE */

    Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profileIndex');

    Route::post('/admin/profile/upload', [AdminController::class, 'adminUploadPicture'])->name('admin.profileUploadPicture');

    Route::match(['put', 'patch'], '/admin/profile/{id}', [AdminController::class, 'adminDataUpdate'])->name('admin.profileDataUpdate');

    Route::post('/admin/profile/change-password', [AdminController::class, 'adminPasswordUpdate'])->name('admin.profilePasswordUpdate');

    /* PROFILE */

    /* INCOMING TRANSACTION LETTER */
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');

    Route::get('/admin/incoming-letter', [IncomingController::class, 'inLetterIndex'])->name('admin.incomingTransactionIndex');

    Route::get('/admin/incoming-letter/add', [IncomingController::class, 'inLetterCreate'])->name('admin.incomingTransactionCreate');

    Route::post('/admin/incoming-letter/', [IncomingController::class, 'inLetterStore'])->name('admin.incomingTransactionStore');

    Route::get('/admin/incoming-letter/{id}', [IncomingController::class, 'inLetterDetail'])->name('admin.incomingTransactionDetail');

    Route::get('/admin/incoming-letter/edit/{id}', [IncomingController::class, 'inLetterEdit'])->name('admin.incomingTransactionEdit');

    Route::match(['put', 'patch'], '/admin/incoming-letter/update/{id}', [IncomingController::class, 'inLetterUpdate'])->name('admin.incomingTransactionUpdate');

    Route::delete('/admin/incoming-letter/{id}', [IncomingController::class, 'inLetterDestroy'])->name('admin.incomingTransactionDestroy');

    /* INCOMING TRANSACTION LETTER */

    /* OUTGOING TRANSACTION LETTER */

    Route::get('/admin/outgoing-letter', [OutgoingController::class, 'outLetterIndex'])->name('admin.outgoingTransactionIndex');

    Route::get('/admin/outgoing-letter/add', [OutgoingController::class, 'outLetterCreate'])->name('admin.outgoingTransactionCreate');

    Route::post('/admin/outgoing-letter/', [OutgoingController::class, 'outLetterStore'])->name('admin.outgoingTransactionStore');

    Route::get('/admin/outgoing-letter/{id}', [OutgoingController::class, 'outLetterDetail'])->name('admin.outgoingTransactionDetail');

    Route::get('/admin/outgoing-letter/edit/{id}', [OutgoingController::class, 'outLetterEdit'])->name('admin.outgoingTransactionEdit');

    Route::match(['put', 'patch'], '/admin/outgoing-letter/update/{id}', [OutgoingController::class, 'outLetterUpdate'])->name('admin.outgoingTransactionUpdate');

    Route::delete('/admin/outgoing-letter/{id}', [OutgoingController::class, 'outLetterDestroy'])->name('admin.outgoingTransactionDestroy');

    /* OUTGOING TRANSACTION LETTER */

    /* AGENDA LETTER INCOMING */

    Route::get('/admin/agenda-incoming', [IncomingController::class, 'inAgendaIndex'])->name('admin.incomingAgendaIndex');

    Route::get('/admin/agenda-incoming/search/', [IncomingController::class, 'inAgendaSearchDate'])->name('admin.incomingAgendaSearchDate');

    Route::get('/admin/agenda-incoming/export/', [IncomingController::class, 'inAgendaExport'])->name('admin.incomingAgendaExport');

    /* AGENDA LETTER INCOMING */

    /* AGENDA LETTER OUTGOING */

    Route::get('/admin/agenda-outgoing', [OutgoingController::class, 'outAgendaIndex'])->name('admin.outgoingAgendaIndex');

    Route::get('/admin/agenda-outgoing/search/', [OutgoingController::class, 'outAgendaSearchDate'])->name('admin.outgoingAgendaSearchDate');

    Route::get('/admin/agenda-outgoing/export/', [OutgoingController::class, 'outAgendaExport'])->name('admin.outgoingAgendaExport');


    /* AGENDA LETTER OUTGOING */

    /* CLASSIFICATION LETTER */

    Route::get('/admin/classification-letter', [ClassificationController::class, 'index'])->name('admin.classificationIndex');

    Route::get('/admin/classification-letter/create', [ClassificationController::class, 'create'])->name('admin.classificationCreate');

    Route::post('/admin/classification-letter/', [ClassificationController::class, 'store'])->name('admin.classificationStore');

    Route::get('/admin/classification-letter/edit/{id}', [ClassificationController::class, 'edit'])->name('admin.classificationEdit');

    Route::match(['put', 'patch'], '/admin/classification-letter/update/{id}', [ClassificationController::class, 'update'])->name('admin.classificationUpdate');

    Route::delete('/admin/classification-letter/{id}', [ClassificationController::class, 'destroy'])->name('admin.classificationDestroy');

    /* CLASSIFICATION LETTER */

    /* GALLERY INCOMING LETTER */

    Route::get('/admin/gallery-incoming', [IncomingController::class, 'inGalleryIndex'])->name('admin.incomingGalleryIndex');

    /* GALLERY INCOMING LETTER */

    /* GALLERY OUTGOING LETTER */

    Route::get('/admin/gallery-outgoing', [OutgoingController::class, 'outGalleryIndex'])->name('admin.outgoingGalleryIndex');

    /* GALLERY OUTGOING LETTER */

    /* KELOLA USER */

    Route::get('/admin/manage-users', [AdminController::class, 'index'])->name('admin.userIndex');

    Route::post('/admin/manage-users', [AdminController::class, 'store'])->name('admin.userStore');

    Route::delete('/admin/manage-users/{id}', [AdminController::class, 'destroy'])->name('admin.userDestroy');

    Route::get('/admin/manage-users/edit/{id}', [AdminController::class, 'edit'])->name('admin.userEdit');

    Route::match(['put', 'patch'], '/admin/manage-users/update/{id}', [AdminController::class, 'update'])->name('admin.userUpdate');

    Route::post('/admin/manage-users/reset-password', [AdminController::class, 'resetPassword'])->name('admin.userReset');


    /* KELOLA USER */
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:kabid'])->group(function () {

    Route::get('/kabid/home', [HomeController::class, 'kabidHome'])->name('kabid.home');

    /* PROFILE */

    Route::get('/kabid/profile', [KabidController::class, 'kabidProfile'])->name('kabid.profileIndex');

    Route::post('/kabid/profile/upload', [KabidController::class, 'kabidUploadPicture'])->name('kabid.profileUploadPicture');

    Route::match(['put', 'patch'], '/kabid/profile/{id}', [KabidController::class, 'kabidDataUpdate'])->name('kabid.profileDataUpdate');

    Route::post('/kabid/profile/change-password', [KabidController::class, 'kabidPasswordUpdate'])->name('kabid.profilePasswordUpdate');

    /* PROFILE */

    /* TRANSACTION */

    Route::get('/kabid/incoming-letter/{id}', [KabidController::class, 'inLetterDetail'])->name('kabid.incomingTransactionDetail');

    Route::get('/kabid/outcoming-letter/{id}', [KabidController::class, 'outLetterDetail'])->name('kabid.outgoingTransactionDetail');

    /* TRANSACTION */


    /* AGENDA LETTER INCOMING */

    Route::get('/kabid/agenda-incoming', [KabidController::class, 'inAgendaIndex'])->name('kabid.incomingAgendaIndex');

    Route::get('/kabid/agenda-incoming/search/', [KabidController::class, 'inAgendaSearchDate'])->name('kabid.incomingAgendaSearchDate');

    Route::get('/kabid/agenda-incoming/export/', [KabidController::class, 'inAgendaExport'])->name('kabid.incomingAgendaExport');

    /* AGENDA LETTER INCOMING */

    /* AGENDA LETTER OUTGOING */

    Route::get('/kabid/agenda-outgoing', [KabidController::class, 'outAgendaIndex'])->name('kabid.outgoingAgendaIndex');

    Route::get('/kabid/agenda-outgoing/search/', [KabidController::class, 'outAgendaSearchDate'])->name('kabid.outgoingAgendaSearchDate');

    Route::get('/kabid/agenda-outgoing/export/', [KabidController::class, 'outAgendaExport'])->name('kabid.outgoingAgendaExport');

    /* AGENDA LETTER OUTGOING */

    /* GALLERY INCOMING LETTER */

    Route::get('/kabid/gallery-incoming', [KabidController::class, 'inGalleryIndex'])->name('kabid.incomingGalleryIndex');

    /* GALLERY INCOMING LETTER */

    /* GALLERY OUTGOING LETTER */

    Route::get('/kabid/gallery-outgoing', [KabidController::class, 'outGalleryIndex'])->name('kabid.outgoingGalleryIndex');

    /* GALLERY OUTGOING LETTER */
});
