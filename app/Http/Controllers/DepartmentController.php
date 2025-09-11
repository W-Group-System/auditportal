<?php

namespace App\Http\Controllers;
use App\Department;
use App\DepartmentHead;
use App\User;
use Illuminate\Http\Request;
use Alert;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $departments = Department::with('dep_head','group')->get();
        $employees = User::where('status', null)->get();
        return view('departments', array(
            'departments' => $departments,
            'employees' => $employees,
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'code' => 'required|min:2|max:50|unique:departments',
            'name' => 'required',
            'user_id' => 'required',
        ]);

        
        $department = new Department;
        $department->code = $request->code;
        $department->name = $request->name;
        $department->company = $request->company;
        $department->save();

        $department_head = new DepartmentHead;
        $department_head->user_id = $request->user_id;
        $department_head->department_id = $department->id;
        $department_head->save();

        Alert::success('Successfully Store')->persistent('Dismiss');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $department = Department::findOrfail($id);
        $department->name = $request->name;
        $department->company = $request->company;
        $department->save();

        $department_head = DepartmentHead::where('department_id',$id)->delete();

        $department_head = new DepartmentHead;
        $department_head->user_id = $request->user_id;
        $department_head->department_id = $department->id;
        $department_head->save();

        Alert::success('Successfully Updated')->persistent('Dismiss');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deactivate(Request $request)
    {
        // dd($request->all());
        $department = Department::where('id', $request->id)->first();
        $department->status = "deactivated";
        $department->save();

        return "success";
    }

    public function activate(Request $request)
    {
        // dd($request->all());
        $department = Department::where('id', $request->id)->first();
        $department->status = null;
        $department->save();

        return "success";
    }
}
