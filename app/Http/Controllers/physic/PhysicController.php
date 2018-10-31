<?php

namespace App\Http\Controllers\physic;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\patient;
use App\physic;
use App\ptpyrel;
use App\User;
use Auth;

//***********************************************************************
class PhysicController extends Controller
{
    //-----------------------------------------------------------------------
    public function __construct() {
        $this->middleware("auth");
        
        $this->middleware(function ($request, $next) {
            $user= Auth::user();
            if($user->role != 'physician'){
                return redirect('/logout');
            }
            else{
                if($user->active == 'no'){
                    return redirect('/logout');
                    // return redirect('/message');
                }
            }
            return $next($request);
        });
    }
    //-----------------------------------------------------------------------
    public function list(){

        $user = Auth::user();

        //$physic = physic::where('email', $user->email)->first();
        $physic = physic::where('pin', $user->mpid)->first();
        $pyid = $physic->id;
        // $ptpys = ptpyrel::where('pyid', $pyid)->groupBy('ptid')->orderBy('created_at','desc')->paginate(10);
        $ptpys = ptpyrel::where('pyid', $pyid)->orderBy('created_at','desc')->paginate(10);

        $ptrecords = array();
        foreach($ptpys as $ptpy){
            $ptrecord = array();
            $pt = patient::where('id', $ptpy->ptid)->first();
            $ptrecord['time'] = $ptpy->created_at;
            $ptrecord['att_file'] = $ptpy->att_file;
            array_push($ptrecords, $ptrecord);
        }

        return view('physic.list', compact('ptpys', 'ptrecords'));
    }
    //-----------------------------------------------------------------------'
    public function edit(){
        $user = Auth::user();
        //$physic = physic::where('email', $user->email)->first();
        $physic = physic::where('pin', $user->mpid)->first();
        return view('physic.edit', compact('physic'));
    }
    //-----------------------------------------------------------------------'
    public function view(Request $request){
        $ptpy = ptpyrel::where('id', $request->id)->first();
        $patient = patient::where('id', $ptpy->ptid)->first();
        $photofile = User::where('mpid', $patient->mrn)->first()->photofile;
        return view('physic.view', compact('patient', 'ptpy', 'photofile'));
    }
    //----------------------------------------------------------------------
    public function save(Request $request){
        try{     
            $physic = physic::findOrFail($request->id);
            
            $physic->pin = $request->pin;

            $physic->first_name = $request->first_name;
            $physic->last_name = $request->last_name;
            $physic->midd_name = $request->midd_name;

            $physic->bir_mm = $request->bir_mm;
            $physic->bir_dd = $request->bir_dd;
            $physic->bir_yy = $request->bir_yy;

            $physic->gender = $request->gender;
            
            $physic->email = $request->email;
            $physic->phone_num1 = $request->phone_num1;
            $physic->phone_num2 = $request->phone_num2;
            $physic->phone_num3 = $request->phone_num3;
            
            $physic->address1 = $request->address1;
            $physic->address2 = $request->address2;

            $physic->city = $request->city;
            $physic->state = $request->state;

            $physic->med_spec = $request->med_spec;
            
            $physic->added_mm = $request->added_mm;
            $physic->added_dd = $request->added_dd;
            $physic->added_yy = $request->added_yy;

            $physic->save();

            //$user = User::where('mpid', $request->pin)->first();
            $user = Auth::user();

            $old_photo = $user->photofile;
            if ($request->file('photo_file') != null && file_exists($old_photo)) unlink($old_photo);

            $user->firstname = $request->first_name;
            $user->lastname = $request->last_name;
            $user->email = $request->email;
            $user->spec = $request->med_spec;
            $user->active = 'yes';
            
            if($request->file('photo_file') != null) $this->upload_photo($physic->pin, $request->file('photo_file'));

            $user->save();

            return view('physic.edit', compact('physic'));
        }
        catch(ModelNotFoundException $err){
            //Show error page
            return back();
        }
    }
    //----------------------------------------------------------------------
    private function upload_photo($pin, $file){
        $path_dest = "user_photos";
        $filename = sprintf("P_%09d.%s", $pin, $file->getClientOriginalExtension());

        //User::where('mpid', $pin)->update(['photofile' => $path_dest."/".$filename]);  
        Auth::user()->photofile = $path_dest."/".$filename;

        if (file_exists($path_dest."/".$filename)) unlink($path_dest."/".$filename);   
        $file->move($path_dest, $filename); 
    }
    //----------------------------------------------------------------------
    public function profile(){
        $user = Auth::user();
        //$physic = physic::where('email', $user->email)->first();
        $physic = physic::where('pin', $user->mpid)->first();
        return view('physic.profile', compact('physic'));
    }
}