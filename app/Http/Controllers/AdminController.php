<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use App\Models\PLanguage;
use App\Models\Course;
use App\Models\RegisteredCourse;
use Facade\Ignition\QueryRecorder\Query;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Office;
use App\Models\User;
use Mockery\Matcher\Not;
use Illuminate\Support\Collection;
use Mockery\Matcher\Any;
use PhpParser\Node\Expr\New_;
use PHPUnit\Framework\Constraint\Count;

class AdminController extends Controller
{

    public function Dashboard(){
     
        $users = User::get();
        $cars = Course::get();
        $rentals = RegisteredCourse::get();
        $brands = PLanguage::get();
        $offices  = Office::get();
         return view('Admin.Layouts.Dashboard',[
            'users' => $users ,
            'cars' => $cars,
            'rentals' => $rentals,
            'offices'  => $offices,
            'brands'=> $brands ,
        ]);
     }

     public function Users(){
        $Users = User::orderBy('id')->get();
        return view('Admin.Users.Users', [
            'users' => $Users ,
        ]);
     }

     public function Cars(){
        $Courses = Course::orderBy('id')->get();
        return view('Admin.Cars.Cars', [
            'Courses' => $Courses ,
        ]);
     }

     public function  Brands(){
        $PLanguages = PLanguage::orderBy('id')->get();
        return view('Admin.Brands.Brands', [
            'PLanguages' => $PLanguages ,
        ]);
     }

     public function  Offices(){
        $Offices = Office::orderBy('id')->get();
        return view('Admin.Offices.Offices', [
            'Offices' => $Offices ,
        ]);
     }

     public function  Rentals(){
        $RegisteredCourses = RegisteredCourse::orderBy('id')->get();
        return view('Admin.Rentals.Rentals', [
            'RegisteredCourses' => $RegisteredCourses ,
        ]);
     }
     public function makeAdmin($id){
        $user = User::where('id',$id)->first();
        $user->role='Admin';
        $user->save();

        
        return redirect()->back()->with('status','Admin Added Successfully');

    }

    public function Edit($id){

        $user = User::find($id);
        return view('admin.Users.editUser',[
            'user'=>$user
        ]);
    }

    public function Add(){

        
        return view('admin.Users.AddUser');
    }

    
    public function AddUser(Request $request){

        

        // $this->validate($request,[
        //     'name'=>'required|regex:/^[\pL\s\-]+$/u',
        //     'password'=>'nullable|min:6|max:25',
        //     'email'=>'required|unique:users,email,',
        //     'phoneNumber'=>'required|numeric',
        //     'age'=>'required|numeric',
        //     'skillLevel'=>'required'


        // ]);

        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->phoneNumber = $request->input('phoneNumber');
        $user->age = $request->input('age');


        if($request->hasFile('profile_image')){
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time().'.'.$extension;
            $file->move('uploads/users/',$fileName);
            $user->profile_image = $fileName;
            
        }

        if($request->input('password')){
            $user->password=bcrypt($request->input('password'));
        }

        $user->save();
        return redirect('/AUsers')->with('status','User Added Successfully');
    }

    public function EditUser(Request $request,$id){

        // $this->validate($request,[
        //     'name'=>'required|regex:/^[\pL\s\-]+$/u',
        //     'password'=>'nullable|min:6|max:25',
        //     'email'=>'required|unique:users,email,',
        //     'phoneNumber'=>'required|numeric',
        //     'age'=>'required|numeric',
        // ]);

        $user = User::where('id',$id)->first();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->phoneNumber = $request->input('phoneNumber');
        $user->age = $request->input('age');


        if($request->hasFile('profile_image')){
        
            $file = $request->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time().'.'.$extension;
            $file->move('uploads/users/',$fileName);
            $user->profile_image = $fileName;
            
        }

        if($request->input('password')){
            $user->password=bcrypt($request->input('password'));
        }

        $user->save();
        return redirect('/AUsers')->with('status','User Edited Successfully');
    }


    public function DeleteUser($id){

        $user = User::where('id',$id)->first();    
        $user->delete();
        return redirect()->back()->with('status','User Deleted Successfully');

    }
    
    
    public function UserSearch(Request $request){

        $Users = User::get();     

        $id = $request->input('id');
        $PhoneNumber = $request->input('PhoneNumber');
      
        $MinAge  = $request->input('MinAge');
        $MaxAge  = $request->input('MaxAge');

    
        $Result = $Users;

        if($id != "")
        {
            $Result = $Result->where('id' , '=' ,$id );
        }
        if($PhoneNumber != "")
        {
            $Result = $Result->where('phoneNumber' , '=' ,$PhoneNumber );
        }
        if($MinAge != "")
        {
            $Result = $Result->where('age' , '>=' ,$MinAge );
        }
        if($MaxAge != "")
        {
            $Result = $Result->where('age' , '<=' ,$MaxAge );
        }
      
        return view('Admin.Users.Users', [
            'users' => $Result ,
        ]);
    }


/// Car



    public function AddCar(){

        
        $PLanguages = PLanguage::get();
        $Offices = Office::get();
        return view('Admin.Cars.AddCar',[
            'PLanguages'=> $PLanguages,
            'Offices'=>$Offices,

        ]);
    }

    public function AAddCar(Request $request){

        $user = auth()->user();
        $Course = new Course();
        $Course->PLanguage = $request->input('PLanguage');
        $Course->Teacher_id = $user->id;
        $Course->Information = $request->input('Details');
        $Course->Price = $request->input('Cost');
        $Course->City =  $request->input('City');
        
    
        if($request->hasFile('Image')){
            $file = $request->file('Image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time().'.'.$extension;
            $file->move('uploads/Courses/',$fileName);
            $Course->Image = $fileName;
        }else{
            $Course->Image = 'carlogo.svg';
        }
        
        $Course->save();
    
        return redirect('/ACars')->with('status','Course Added Successfully');
    }


    public function CarSearch(Request $request){

        $NewCars = Course::get();
        $Result =  $NewCars;


        $Brand = $request->input('Brand');
        $OwnerID = $request->input('Owner');
        $AirConditioner =$request->input('AirConditioner');
        $Transmisson=$request->input('Transmisson');
        $MinPrice = $request->input('MinPrice');
        $MaxPrice  = $request->input('MaxPrice');
        $Type = $request->input('Type');
        $Status = $request->input('Status');
             if($Brand != 'Any')
                {
                    $Result = $Result->where('Brand', $Brand);
                }
                if($OwnerID != "")
                {
                    $Result = $Result->where('Owner_id'  , '=' , $OwnerID );
                }
                if($MinPrice != "")
                {
                    $Result = $Result->where('Price' , '>=' ,$MinPrice );
                }
                if($MaxPrice != "")
                {
                    $Result = $Result->where('Price' , '<=' ,$MaxPrice );
                }
                if($AirConditioner != 'Any')
                {
                    $Result = $Result->where('AC' ,  $AirConditioner );
                }
                if($Transmisson != 'Any')
                {
                    $Result = $Result->where('Trans' ,  $Transmisson );
                }
                if($Type != 'Any')
                {
                    $Result = $Result->where('Type' ,  $Type );
                }
                if($Status != 'Any')
                {
                    $Result = $Result->where('Status' ,  $Status );
                }

                return view('Admin.Cars.Cars', [
                    'Cars' => $Result ,
                ]);
     }


    public function DeleteCar($id){

        $Course = Course::where('id',$id)->first();    
        $Course->delete();
        return redirect()->back()->with('status','Course Removed Successfully');

    }
    

    /// Brand


    public function AddBrand(){

        
        return view('Admin.Brands.AddBrand');
    }

    
    public function AAddBrand(Request $request){

        $user = auth()->user();
        $PLanguage = new PLanguage() ;
        $PLanguage->PLanguage = $request->input('Language');
        $PLanguage->user_id = $user->id;
        if($request->hasFile('Logo')){
            $file = $request->file('Logo');
            $extension = $file->getClientOriginalExtension();
            $fileName = time().'.'.$extension;
            $file->move('uploads/PLanguage/',$fileName);
            $PLanguage->PLanguage_image = $fileName;
        }else{
            $PLanguage->PLanguage_image = 'carlogo.svg';
        }
        
        $PLanguage->save();

        return redirect('/ABrands')->with('status','Brand Added Successfully');
       
    }

    public function DeleteBrand($id){

        $PLanguage = PLanguage::where('id',$id)->first();    
        $PLanguage->delete();
        return redirect()->back()->with('status','Brand Deleted Successfully');

    }
    ///// Offices

    public function AddOffice(){

        
        return view('Admin.Offices.AddOffice');
    }

    
    public function AAddOffice(Request $request){

        
        $Offices = new Office ;
        $Offices->Country = $request->input('Country');
        $Offices->City = $request->input('City');
        
      
        $Offices->save();

        return redirect('/AOffices')->with('status','Office Added Successfully');
       
    }

    public function DeleteOffice($id){

        $Office = Office::where('id',$id)->first();    
        $Office->delete();
        return redirect()->back()->with('status','Office Deleted Successfully');

    }



    //// Rentals


    public function RentalSearch(Request $request){

        $Rentals = RegisteredCourse::get();
        $Result =  $Rentals;


        $RenterID = $request->input('RenterID');
        $OwnerID = $request->input('OwnerID');
        $MinDate = $request->input('MinDate');
        $MaxDate  = $request->input('MaxDate');




             if($RenterID != "")
                {
                    $Result = $Result->where('Renter_id', $RenterID);
                }
                if($OwnerID != "")
                {
                    $Result = $Result->where('Owner_id'  , '=' , $OwnerID );
                }
                if($MinDate != "")
                {
    
                    $Result = $Result->where('Start_date' , '>=' ,$MinDate );
                }
                if($MaxDate != "")
                {
           
                    $Result = $Result->where('End_Date' , '<=' ,$MaxDate );
                }
           
                return view('Admin.Rentals.Rentals', [
                    'Rentals' => $Result ,
                ]);
            
                // return $MinDate;

     }

     public function DeleteRental($id){

        $RegisteredCourse = RegisteredCourse::where('id',$id)->first();    
        $RegisteredCourse->delete();
        return redirect()->back()->with('status','RegisteredCourse Deleted Successfully');

    }
}