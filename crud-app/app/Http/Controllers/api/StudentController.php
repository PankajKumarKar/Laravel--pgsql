<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
     //Get All Student Data

     public function getAllStudents(){
        $students= Student::all();

        if($students->count()>0){
            return response()->json([
                'status'=>200,
                'student'=>$students
            ],200);

        }else{
            return response()->json([
                'status'=>404,
                'message'=> 'No Records Found !'
            ],404);
        }
       
    }

    //Add Student Data

    public function addStudent(Request $request){

           $validator=Validator::make($request->all(),[
            'name'=>'required|string|max:191',
            'email'=>'required|email|max:191',
            'mobile'=>'required|digits:10',
           ]);

           if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()
            ],422);
           }else{
            $student= Student::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'mobile'=>$request->mobile,
            ]);


            if($student){
            return response()->json([
                'status'=>200,
                'message'=>"Student Created Successfully !"
            ],200);
            }else{
             return response()->json([
                'status'=>500,
                'message'=>"Student Creating failed !"
             ],500);
            }
           }
          }

          //Get Student Data By Id
    public function getStudentById($id){
         $student=Student::find($id);

         if($student){
            return response()->json([
                'status'=>200,
                'student'=>$student
            ],200);
         }else{
            return response()->json([
                'status'=>404,
                'message'=>"No Such Student Found !!"
            ],404);
         }
    }


    //Update Student Data

    public function updateStudent(Request $request,int $id){

       
        $validator=Validator::make($request->all(),[
            'name'=>'required|string|max:191',
            'email'=>'required|email|max:191',
            'mobile'=>'required|digits:10',
           ]);
        
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()
            ],422);

        }else
        {
            $student=Student::find($id);

            if($student){
              
            $student->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'mobile'=>$request->mobile
            ]);

            return response()->json([
                'status'=>200,
                'message'=>"Student Updated Successfully !"
            ],200);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>"No Such Student Found ! "
                ],404);
            }
        }
    }


    //Delete Student Data

    public function deleteUser($id){
        $student =Student::find($id);

        if($student){
        $student->delete();

        return response()->json([
            'status'=>200,
            'message'=>"Student Deleted !"
        ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>"No Such Student Found !"
            ],404);
        }
    }
}
