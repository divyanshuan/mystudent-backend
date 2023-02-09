<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Fee;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    public function addStudent(Request $req){
        $student=new Student();
        $student->form_no=$req->form_no;
        $student->added_by= $req->added_by;
        $student->firstname= $req->firstname;
        $student->lastname= $req->lastname;
        $student->fathersname= $req->fathersname;
        $student->mothersname= $req->mothersname;
        $student->mobile= $req->mobile;
        $student->email= $req->email;
        $student->roll=$req->added_by."-".$req->course."-".$req->batch."-".$req->form_no;
        $image=$req->photo;
        $ext = $image->getClientOriginalExtension();
        $name=$req->firstname."-".$req->batch."-".$req->form_no.".".$ext;
        $image->storeAs("Student",$name);
        $student->photopath=$name;

        $student->gender= $req->gender;
        $student->aadhar= $req->aadhar;
        $student->dob= $req->dob;
        $student->category= $req->category;
        $student->timing= $req->timing;
        $student->course= $req->course;
        $student->batch= $req->batch;

        $edu= new Education();
        $edu->address=$req->address;
        $edu->district=$req->district;
        $edu->state=$req->state;
        $edu->pin=$req->pin;
        $edu->matric_m=$req->matric_m;
        $edu->matric_y=$req->matric_y;
        $edu->other_m=$req->other_m;
        $edu->other_y=$req->other_y;

        $var1= $student->save();
        $var2=$student->education()->save($edu);

        if($var1 && $var2){
            return response()->json([
                "message"=>"user added sucessfully ",
                "rollno"=>$student,
            ]);

        }
        else{
            return response()->json([
                'message'=>"oops! something went wrong ",
            ]);

        }
    }
    public function getAllStudents(){
        $stu = Student::with('education')->orderBy('id', 'desc')->get();
        if (count($stu)==0){
            return response()->json([
                "data"=> null,
                "message"=> "No data"
            ]);

        }else{
            return response()->json([
                "data"=> $stu,
                "message"=>"data"
            ]);
        }
    }
    public function getStudent($id){
        $stu = Student::with('education')->where('id',$id)->get()->first();
        if ($stu == null){
            return response()->json([
                "data"=> null,
                "message"=> "No data"
            ]);

        }else{
            return response()->json([
                "data"=> $stu,
                "message"=>"data"
            ]);
        }
    }
    public function addFee(Request $req){
        $student=Student::where("id",$req->id)->first();
        $fee=new Fee();
        $fee->type=$req->type;
        $fee->amount=$req->amount;
        $fee->tid=$req->tid;
        $var2=$student->fees()->save($fee);
        if($var2){
            return response()->json([
                "message"=>"Fee added sucessfully ",
            ]);

        }
        else{
            return response()->json([
                'message'=>"oops! something went wrong ",
            ]);

        }
    }
    public function getFee($id){
        $fee=Fee::where("student_id",$id)->orderByDesc('id')->get();
        // return $student;
        return response()->json([
            "data"=>$fee,
        ]);

    }
    public function guard()
    {
        return Auth::guard();
    }
}
