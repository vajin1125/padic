<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\patient;
use App\physic;
use App\User;

//***********************************************************************
class AdminController extends Controller
{
    //----------------------------------------------------------------------
    public function __construct() {
        $this->middleware("auth");

        $this->middleware(function ($request, $next) {
            $user= Auth::user();
            if($user->role != 'superAdmin'){
                return redirect('/logout');
            }
            return $next($request);
        });
    }
    //----------------------------------------------------------------------
    public function bEmail_patient(Request $request){
        $email = $request->param;
        $msg = "true";
        if(User::where('email', $email)->first() != null)  $msg = "false";
        // elseif(physic::where('email', $email)->first() != null)  $msg .= "physic";
        // elseif(patient::where('email', $email)->first() != null)  $msg .= "patient";
        return response()->json(array('msg'=> $msg));
    }
    //----------------------------------------------------------------------
    public function bEmail_user(Request $request){
        $uid = $request->uid;
        $email = $request->email;
        
        $msg = 'true';
        $user = User::where('email', $request->email)->first();
        if($user != null && $user->id != $uid) $msg = 'false';
        
        return response()->json(array('msg'=> $msg));
    }
    //----------------------------------------------------------------------
    public function profile(){
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }
    //----------------------------------------------------------------------
    public function profile_update(Request $request){
        try{     
            $user = Auth::user();

            $old_photo = $user->photofile;
            if (file_exists($old_photo)) unlink($old_photo);   

            $user->firstname = $request->first_name;
            $user->lastname = $request->last_name;
            $user->email = $request->email;
            $user->spec = $request->med_spec; 
            
            $pwd = preg_replace('/\s+/', '', $request->password);
            $pwd_cfirm = preg_replace('/\s+/', '', $request->password_confirmation);
            
            if(($pwd != '') && ($pwd_cfirm != '') && ($pwd == $pwd_cfirm)){
                $user->password = Hash::make($pwd);     
            }     
            
            if($request->file('photo_file') != null) $this->upload_photo($user->id, $request->file('photo_file'));
            $user->save();
                        
            return view('admin.profile', compact('user'));
        }
        catch(ModelNotFoundException $err){
            //Show error page
            return back();
        }
    }
    //----------------------------------------------------------------------
    private function upload_photo($id, $file){
        $path_dest = "user_photos";
        $filename = sprintf("P_ad%07d.%s", $id, $file->getClientOriginalExtension());
        Auth::user()->photofile = $path_dest."/".$filename;
        $file->move($path_dest, $filename); 
    }
}
