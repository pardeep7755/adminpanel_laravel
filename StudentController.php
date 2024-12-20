<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;


class StudentController extends Controller
{
    protected $students;
    public function __construct(){
        $this->students = new Student();
    }

    function index()
    {
        $users = DB::table('employee')->get();
        return view('student.index', ['users' => $users]);

    }
    function student_delete($id='')
    {
        Student::where('id', $id)->delete(); // Deletes the record where ID matches
        return redirect()->back()->with('success', 'Deleted successfully!');
    }

    function student_edit($id='')
    {

       
        $data ="";
        $url = url('/');

       
        if(!empty($id))
        {
            $data = DB::table('employee')->find($id);
        }
        return view("student.edit",compact("data","url")); 

        // $datas['emp'] = $emp_info;
        // return view("student.edit",$datas); 
        

    }
    
    function save_stud(Request $request)
    {
        
        $id = $request->post('id');
        $name = $request->post('name');
        $rollno = $request->post('rollno');
        $class = $request->post('class');
        $create_date = date("Y-m-d h:i:s");
        $created_by = "3";


        if(!empty($id))
        {
            DB::table('employee')->where('id', $id)->update(array('name' => $name,'rollno' => $rollno,'class' => $class,'updated_date' => date("Y-m-d h:i:s"),'updated_by' => "5"));  

        }
        else{
            DB::insert('insert into employee (name,rollno,class,created_date,created_by) values (?,?,?,?,?)', [$name,$rollno,$class,$create_date,$created_by]);
        }
        return redirect()->to(url('/'));  
    }

    function valid_rollno(Request $request)
    {
 
        if(!empty($id))
        {
            $data = DB::table('employee')->find($id);
        }
        // $datas['emp'] = $emp_info;
        // return view("student.edit",$datas); 
         return view("student.edit",compact("data")); 

    }

    function man_edit_stud(Request $request)
    {
 
        $id = $request->post('id');
        if(!empty($id))
        {
            $data = DB::table('employee')->find($id);

            $view = view('student.editModel', compact("data"));

            $sections = $view->render();

            $data = array("content" => $sections);
            echo json_encode($data);
            die;
           

        }
     

    }
}
