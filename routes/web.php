<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
/*vBookController
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
    return view('welcome');
});

Auth::routes();


Route::get('/AddBrand', function () {
    return view('Brands.create');
})->middleware('auth');

Route::get('/AddBrand', function () {
    return view('Brands.create');
})->middleware('auth');

Route::post('/AddBrand',[PostsController::class, 'AddBrand'])->middleware('auth');

Route::get('/OfferCourse', [HomeController::class, 'Cars'])->middleware('auth');
Route::post('/OfferCourse',[PostsController::class, 'AddCar'])->middleware('auth');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/SearchCourses', [BookController::class, 'DatePick'])->middleware('auth');

Route::get('/Models/{Brand}',[App\Http\Controllers\HomeController::class, 'Models'])->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'Choice'])->name('home')->middleware('auth');

Route::get('/Date', [App\Http\Controllers\BookController::class, 'DatePick'])->middleware('auth');
Route::get('/Courses', [App\Http\Controllers\BookController::class, 'Courses'])->middleware('auth');

Route::get('/Showcourses/{PLanguage}/{StartDate}/{City}', [App\Http\Controllers\BookController::class, 'Showcourses'])->middleware('auth');
Route::post('/register/{Car_id}/{StartDate}/{City}',[App\Http\Controllers\BookController::class, 'Register'])->middleware('auth');

Route::post('/Search/{PickupDate}/{ReturnDate}/{City}',[App\Http\Controllers\BookController::class, 'Search'])->middleware('auth');

// Aly
Route::get('/Profile', [App\Http\Controllers\HomeController::class, 'Profile'])->middleware('auth');
Route::post('/Profile', [App\Http\Controllers\HomeController::class, 'Edit'])->middleware('auth');

Route::get('/MyCourses', [App\Http\Controllers\HomeController::class, 'MyCourses'])->middleware('auth');
Route::post('/Pay/{id}', [HomeController::class, 'Pay'])->middleware('auth');
Route::post('/Cancel/{id}', [HomeController::class, 'Cancel'])->middleware('auth');


Route::get('/MyCars', [App\Http\Controllers\BookController::class, 'MyCars'])->middleware('auth');
Route::post('/Disable/{Car_id}',[App\Http\Controllers\BookController::class, 'Service'])->middleware('auth');
Route::post('/Enable/{Car_id}',[App\Http\Controllers\BookController::class, 'ServiceEnable'])->middleware('auth');

//*** Admin ***//




//Dahsboard
Route::get('/ADashboard', [AdminController::class,'Dashboard'])->middleware('auth');

//**Users**
Route::get('/AUsers', [AdminController::class,'Users'])->middleware('auth');
//Make Admin
Route::post("makeAdmin/{id}",[AdminController::class,'makeAdmin']);
//Add
Route::get("AdminAdd",[AdminController::class,'Add']);
Route::post("AdminAddUser",[AdminController::class,'AddUser']);
//Search
Route::post("AdminUserSearch",[AdminController::class,'UserSearch']);
//Edit
Route::get("Edit/{id}",[AdminController::class,'Edit']);
Route::post("EditUser/{id}",[AdminController::class,'EditUser']);
//Delete
Route::get("AdminUserDelete/{id}",[AdminController::class,'DeleteUser']);
//**Users**



//cars
Route::get('/ACars', [AdminController::class,'Cars'])->middleware('auth');

Route::post("AdminCarSearch",[AdminController::class,'CarSearch']);

Route::get("AdminCar",[AdminController::class,'AddCar']);
Route::post("AdminAddCar",[AdminController::class,'AAddCar']);
Route::get("AdminCarDelete/{id}",[AdminController::class,'DeleteCar']);
//brands

Route::get('/ABrands', [AdminController::class,'Brands'])->middleware('auth');

Route::get("AdminBrand",[AdminController::class,'AddBrand']);
Route::post("AdminAddBrand",[AdminController::class,'AAddBrand']);
Route::get("AdminBrandDelete/{id}",[AdminController::class,'DeleteBrand']);
//offices
Route::get('/AOffices', [AdminController::class,'Offices'])->middleware('auth');

Route::get("AdminOffice",[AdminController::class,'AddOffice']);
Route::post("AdminAddOffice",[AdminController::class,'AAddOffice']);
Route::get("AdminOfficeDelete/{id}",[AdminController::class,'DeleteOffice']);

//rentals

Route::get('/ARentals', [AdminController::class,'Rentals'])->middleware('auth');


Route::post("AdminRentalSearch",[AdminController::class,'RentalSearch']);

Route::get("AdminRentalDelete/{id}",[AdminController::class,'DeleteRental']);

//*** Admin ***//