<?php

namespace App\Http\Controllers;
use App\Models\PLanguage;
use App\Models\Course;
use App\Models\RegisteredCourse;
use Facade\Ignition\QueryRecorder\Query;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Office;
use DateTime;
use Mockery\Matcher\Not;
use Illuminate\Support\Collection;
use Mockery\Matcher\Any;
use PhpParser\Node\Expr\New_;

class BookController extends Controller
{
    public function DatePick(){
        $Offices = Office::orderBy('id')->get();
        $PLanguages = PLanguage::orderBy('id')->get();
        return view('DatePick', [
            'PLanguages' => $PLanguages ,
            'Offices' => $Offices  

        ]);
     }


     public function Courses(Request $request){

        $PLanguages = PLanguage::orderBy('id')->get();
        $StartDate = $request->input('StartDate');
        $City = $request->input('City');
        return view('BrandChoose', [
            'PLanguages'       =>  $PLanguages,
            'StartDate'   =>  $StartDate,
            'City'         =>  $City

        ]);
    }
    public function Showcourses($PLanguage,$StartDate,$City){


        $NewCourses = DB::table('courses')->get();
            $Result = $NewCourses->where('PLanguage', $PLanguage);
            $Result = $Result->where('City',$City);

            return redirect()->back()->with(['Courses' => $Result]);
        }

        
        public function  Register($Course_id,$PickupDate,$City){
           
            $Teacher = Course::where('id','=',$Course_id)->first();

            $user = auth()->user();
            $Register = new RegisteredCourse();
            $Register->Course_id = $Course_id;
            $Register->Teacher_id = $Teacher->Teacher_id;
            $Register->Student_id = $user->id;
            $Register->Start_date = $PickupDate;
            $Register->End_date = "2023-05-18";
            $Register->City = $City;  
            $Register->Paid = "No";  
            $Register->TMoney  = 0; 

        
            
            $Register->save();
        
      
            return redirect('/home')->with('status','Course Registered Successfully');

           
        }
        public function Rents(){
            return view('home');
         }
        
        public function Search(Request $request,$PickupDate,$ReturnDate,$City){


            $NewCars = DB::table('cars')
                ->whereNotIn('id', function ($query) use ($PickupDate, $ReturnDate) {
                    $query->select('car_id')->from('rentals')
                        ->wherein('car_id', function ($query) use ($PickupDate, $ReturnDate) {
                            $query->select('car_id')->from('rentals')
                                ->where('Start_date', '>', $PickupDate)
                                ->where('Start_date', '<', $ReturnDate);
                        })
                        ->orwherein('car_id', function ($query) use ($PickupDate, $ReturnDate) {
                            $query->select('car_id')->from('rentals')
                                ->where('End_date', '>', $PickupDate)
                                ->where('End_date', '<', $ReturnDate);
                        })
                        ->orwherein('car_id', function ($query) use ($PickupDate, $ReturnDate) {
                            $query->select('car_id')->from('rentals')
                                ->where('Start_date', '<', $PickupDate)
                                ->where('End_date', '>', $ReturnDate);
                        })
    
                        ->orwherein('car_id', function ($query) use ($PickupDate, $ReturnDate) {
                            $query->select('car_id')->from('rentals')
                                ->where('Start_date', '=', $PickupDate)
                                ->where('End_date', '=', $ReturnDate);
                        });
                })
                ->get();
    


                $Result  =  $NewCars->where('City',$City); ;   

                $Brand = $request->input('Brand');
                $Model = $request->input('Model');
                $AirConditioner =$request->input('AirConditioner');
                $Transmisson=$request->input('Transmisson');
                $MinPrice = $request->input('MinPrice');
                $MaxPrice  = $request->input('MaxPrice');
                $Type = $request->input('Type');
                
                if($Brand != 'Any')
                {
                    $Result = $Result->where('Brand', $Brand);
                }
                if($Model != "")
                {
                    $Result = $Result->where('Model'  , 'LIKE' , '%'.$Model.'%' );
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

                
                $Result = $Result->where('Status', "Available");
                
    
                return redirect()->back()->with(['Cars' => $Result]);
            }

            public function MyCars(){
                $user = auth()->user();
                $MyCars = Course::where('Owner_id',$user->id)->orderBy('id')->get();
                return view('Customer.MyCars', [
                    'MyCars' => $MyCars , 
        
                ]);
            }

            public function Service($Car_id){
                $MyCar = Course::where('id','=',$Car_id)->first();
                $MyCar->Status = "Disabled";
        

                $MyCar->save();
            
                return redirect('/MyCars')->with('status','Car Status Disabled Successfully');
    
               
            }

            public function ServiceEnable($Car_id){
                $MyCar = Course::where('id','=',$Car_id)->first();
                $MyCar->Status = "Available";
        

                $MyCar->save();
            
                return redirect('/MyCars')->with('status','Car Status Available Successfully');
    
               
            }


        
    
            

        
       
}