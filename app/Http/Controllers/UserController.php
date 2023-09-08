<?php

namespace App\Http\Controllers;
use App\User;
use App\Company;
use App\Department;
use Illuminate\Http\Request;

use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::with('department', 'company')->get();
        $companies = Company::get();
        $departments = Department::get();
        $roles = $this->roles();
        return view('users', array(
            'users' => $users,
            'companies' => $companies,
            'departments' => $departments,
            'roles' => $roles,
        ));

    }
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);


        $new_account = new User;
        $new_account->name = $request->name;
        $new_account->email = $request->email;
        $new_account->company_id = $request->company;
        $new_account->department_id = $request->department;
        $new_account->position = $request->position;
        $new_account->tel_number = $request->tel_number;
        $new_account->role = $request->role;
        $new_account->password = bcrypt($request->password);
        $new_account->save();
        Alert::success('Successfully Store')->persistent('Dismiss');
        return back();
    }
    public function changepassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|confirmed',
        ]);

        $user = User::where('id', $id)->first();
        $user->password = bcrypt($request->password);
        $user->save();
        Alert::success('Successfully Change Password')->persistent('Dismiss');
        return back();
    }
    public function deactivate_user(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->status = 1;
        $user->password = "";
        $user->save();

        return "success";
    }
    public function activate_user(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->status = null;
        $user->save();

        return "success";
    }
    public function edit_user(Request $request, $id)
    {

        $this->validate($request, [
            'email' => 'unique:users,email,' . $id,
        ]);

        $account = User::where('id', $id)->first();
        $account->name = $request->name;
        $account->email = $request->email;
        $account->company_id = $request->company;
        $account->position = $request->position;
        $account->tel_number = $request->tel_number;
        $account->department_id = $request->department;
        $account->role = $request->role;
        $account->save();

        Alert::success('Successfully Updated')->persistent('Dismiss');
        return back();
    }
    public function roles()
    {
        $roles = [
            'Auditee' => 'Auditee',
            'Auditor' => 'Auditor',
            'IAD Approver' => 'IAD Approver',
            'Department Head' => 'Department Head',
            'Administrator' => 'Administrator',
        ];

        return $roles;
    }
}
