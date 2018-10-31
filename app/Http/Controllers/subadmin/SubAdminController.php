<?php

namespace App\Http\Controllers\subadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\patient;
use App\physic;
use App\ptpyrel;
use App\User;
use Auth;
use DB;

//***********************************************************************
class subadminController extends Controller
{
    //-----------------------------------------------------------------------
    public function __construct() {
        $this->middleware("auth");
        
        $this->middleware(function ($request, $next) {
            $user= Auth::user();
            if($user->role != 'subAdmin'){
                return redirect('/logout');
            }
            else{
                if($user->active == 'no'){
                    return redirect('/logout');
                }
            }
            return $next($request);
        });
    }
    //-----------------------------------------------------------------------
    public function admin_list(){
        $users = User::where('role', 'superAdmin')->orWhere('role', 'subAdmin')->orderBy('id', 'asc')->paginate(10);
        return view('subadmin.admin_list', compact('users'));
    }
    //-----------------------------------------------------------------------'
    public function admin_view(Request $request){
        $admin = User::where('id', $request->id)->first();
        $photofile = $admin->photofile;
        return view('subadmin.admin_view', compact('admin', 'photofile'));
    }
    //----------------------------------------------------------------------
    public function physic_search(Request $request){
        return view('subadmin.physic_search');
    }
    //----------------------------------------------------------------------
    public function physic_search_results(Request $request){
        if($request->sitem == '1'){ // PIN
            $physics = DB::table('physic_tb')->where('pin', $request->keyword)->paginate(10);
        }
        elseif($request->sitem == '2'){ // last name
            $physics = DB::table('physic_tb')->where('last_name', $request->keyword)->paginate(10);
        }
        
        return view('subadmin.physic_search', compact('physics'));
    }
    //----------------------------------------------------------------------
    public function physic_all_results(){
        $physics = physic::orderBy('id','desc')->paginate(10);
        return view('subadmin.physic_all', compact('physics'));
    }
    //----------------------------------------------------------------------
    public function physic_view(Request $request){
        $physic = DB::table('physic_tb')->where('id', $request->id)->first();
        $photofile = User::where('mpid', $physic->pin)->first()->photofile; 
        return view('subadmin.physic_view', compact('physic', 'photofile'));
    }
    //----------------------------------------------------------------------
    public function patient_search(Request $request){
        return view('subadmin.patient_search');
    }
    //----------------------------------------------------------------------
    public function patient_search_results(Request $request){
        if($request->sitem == '1'){ // PIN
            $patients = DB::table('patient_tb')->where('mrn', $request->keyword)->paginate(10);
        }
        elseif($request->sitem == '2'){ // last name
            $patients = DB::table('patient_tb')->where('last_name', $request->keyword)->paginate(10);
        }
        
        return view('subadmin.patient_search', compact('patients'));
    }
    //----------------------------------------------------------------------
    public function patient_all_results(){
        $patients = patient::orderBy('id','desc')->paginate(10);
        return view('subadmin.patient_all', compact('patients'));
    }
    //----------------------------------------------------------------------
    public function patient_view(Request $request){
        $patient = DB::table('patient_tb')->where('id', $request->id)->first();
        $photofile = User::where('mpid', $patient->mrn)->first()->photofile; 
        return view('subadmin.patient_view', compact('patient', 'photofile'));
    }
    //----------------------------------------------------------------------
    public function patient_physic(Request $request){
        try{     
            $patient = patient::where('id', $request->id)->first();
            $ptpy = ptpyrel::where('ptid', $request->id)->orderBy('id','desc')->first();

            if($ptpy != null)  $physic = physic::where('id', $ptpy->pyid)->first();
            else $physic = null;
            
            $physics = physic::all();

            return view('subadmin.ptpy', compact('patient', 'physic', 'physics', 'ptpy'));
        }
        catch(ModelNotFoundException $err){
            //Show error page
            return back();
        }
    }
    //----------------------------------------------------------------------
    public function profile(){
        $user = Auth::user();
        return view('subadmin.profile', compact('user'));
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
                        
            return view('subadmin.profile', compact('user'));
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
    //----------------------------------------------------------------------
    public function bEmail_user(Request $request){
        $uid = $request->uid;
        $email = $request->email;
        
        $msg = 'true';
        $user = User::where('email', $request->email)->first();
        if($user != null && $user->id != $uid) $msg = 'false';
        
        return response()->json(array('msg'=> $msg));
    }
}

