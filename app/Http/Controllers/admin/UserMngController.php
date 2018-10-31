<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\physic;
use App\patient;
use App\ptpyrel;
use App\User;
use Auth;

//***********************************************************************
class UserMngController extends AdminController
{
    //----------------------------------------------------------------------
    public function __construct() {
        parent:: __construct();
    }
    //----------------------------------------------------------------------
    public function list(){
        // $users = User::paginate(10);
        $users = User::where('role', 'superAdmin')->orWhere('role', 'subAdmin')->orWhere('role', 'norole')->orderBy('id', 'asc')->paginate(10);
        return view('admin.user_list', compact('users'));
    }
    //----------------------------------------------------------------------
    public function update(Request $request){
        $user = User::where('id', $request->id)->first();
        return view('admin.user_save', compact('user'));
    }
    //----------------------------------------------------------------------
    public function delete(Request $request){
        $user = User::where('id', $request->id)->first();

        $filename = $user->photofile;  
        if ($filename != '' && file_exists($filename)) unlink($filename);
        
        $user->delete();
        
        return back();
    }
    //----------------------------------------------------------------------
     
     public function save(Request $request){
        try{     
            $user = User::findOrFail($request->id);
            
            $user->firstname = $request->first_name;
            $user->lastname = $request->last_name;
            $user->email = $request->email;
            $user->spec = $request->med_spec;
            $user->role = $request->role;
            $user->active = 'yes';
            
            $pwd = preg_replace('/\s+/', '', $request->password);
            $pwd_cfirm = preg_replace('/\s+/', '', $request->password_confirmation);
            
            if(($pwd != '') && ($pwd_cfirm != '') && ($pwd == $pwd_cfirm)){
                $user->password = Hash::make($pwd);     
            }     
            
            $user->save();

            if($user->role == 'physician' && $user->active == 'yes'){
                $py = physic::where('pin', $user->mpid)->first();
                $py->first_name = $user->firstname;
                $py->last_name = $user->lastname;
                $py->email = $user->email;
                $py->med_spec = $user->spec;
                $py->save();
            }
            elseif($user->role == 'patient' && $user->active == 'yes'){
                $pt = patient::where('mrn', $user->mpid)->first();
                $pt->first_name = $user->firstname;
                $pt->last_name = $user->lastname;
                $pt->email = $user->email;
                $pt->save();
            }

            return redirect('admin/user_list');
        }
        catch(ModelNotFoundException $err){
            //Show error page
            return back();
        }
    }
    //----------------------------------------------------------------------
}