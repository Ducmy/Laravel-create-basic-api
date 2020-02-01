<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class ApiController extends Controller
{
    public function getAllStudents()
    {
        // Lấy toàn bộ danh sách về thông tin của học sinh tại đây
        $student = Student::get()->toJson(JSON_PRETTY_PRINT);
        return response($student, 200);
    }

    public function createStudent(Request $request)
    {
        // Tạo thông tin học sinh tại đây
        $student = new Student;
        $student->name = $request->name;
        $student->course = $request->course;
        $student->save();

        return response()->json([
            "message" => "student record created"
        ], 201);
    }

    public function getStudent($id)
    {
        // Lấy thông tin học sinh có mã ID tại đây 
        if (Student::where('id', $id)->exists()) {
            $student = Student::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($student, 200);
        } else {
            return response()->json(["message" => "Student not found"], 400);
        };
    }

    public function updateStudent(Request $request, $id)
    {
        // Update thông tin của một học sinh tại đây
        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->name = is_null($request->name) ? $student->name : $request->name;
            $student->course = is_null($request->course) ? $student->course : $request->course;
            $student->save();
            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        } else {
            return response()->json(["message" => "Student not found"], 400);
        }
    }

    public function deleteStudent($id)
    {
        // Xoá thông tin của một học sinh tại đây

        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->delete();
            return response()->json([
                "message" => "records deleted."
            ], 200);
        } else {
            return response()->json(["message" => "Student not found"], 400);
        }
    }
}
