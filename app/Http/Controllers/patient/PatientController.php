<?php

namespace App\Http\Controllers\patient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\patient;
use App\physic;
use App\ptpyrel;
use App\User;
use Auth;

//***********************************************************************
class PatientController extends Controller
{
    //-----------------------------------------------------------------------
    public function __construct() {
        $this->middleware("auth");
        
        $this->middleware(function ($request, $next) {
            $user= Auth::user();
            if($user->role != 'patient'){
                return redirect('/logout');
            }
            else{
                if($user->active == 'no'){
                    return redirect('/logout');
                    //return redirect('/message');
                }
            }
            return $next($request);
        });
    }
    //-----------------------------------------------------------------------
    public function list(){

        $user = Auth::user();
        //$patient = patient::where('email', $user->email)->first();
        $patient = patient::where('mrn', $user->mpid)->first();
        $ptid = $patient->id;
        // $ptpys = ptpyrel::where('pyid', $pyid)->groupBy('ptid')->orderBy('created_at','desc')->paginate(10);
        $ptpys = ptpyrel::where('ptid', $ptid)->orderBy('created_at','desc')->paginate(10);

        $ptrecords = array();

        foreach($ptpys as $ptpy){
            $ptrecord = array();
            $py = physic::where('id', $ptpy->pyid)->first();
            $ptrecord['time'] = $ptpy->created_at;
            $ptrecord['att_file'] = $ptpy->att_file;
            array_push($ptrecords, $ptrecord);
        }

        return view('patient.list', compact('ptpys', 'ptrecords'));
    }
    //-----------------------------------------------------------------------'
    public function edit(){
        $user = Auth::user();
        //$patient = patient::where('email', $user->email)->first();
        $patient = patient::where('mrn', $user->mpid)->first();
        return view('patient.edit', compact('patient'));
    }
    //-----------------------------------------------------------------------'
    public function view(Request $request){

        // $user = Auth::user();
        // $physic = physic::where('email', $user->email)->first();
        // dump(physic);
        // $pyid = $physic->id;
        // $ptpys = ptpyrel::where('pyid', $pyid)->groupBy('ptid')->orderBy('created_at','desc')->paginate(10);
        
        $ptpy = ptpyrel::where('id', $request->id)->first();
        $physic = physic::where('id', $ptpy->pyid)->first();
        $photofile = User::where('mpid', $physic->pin)->first()->photofile; 
        return view('patient.view', compact('physic', 'ptpy', 'photofile'));
    }
    //----------------------------------------------------------------------
    public function save(Request $request){
        try{     
            $patient = patient::findOrFail($request->id);
            
            $patient->mrn = $request->mrn;

            $patient->first_name = $request->first_name;
            $patient->last_name = $request->last_name;
            $patient->midd_name = $request->midd_name;

            $patient->bir_mm = $request->bir_mm;
            $patient->bir_dd = $request->bir_dd;
            $patient->bir_yy = $request->bir_yy;

            $patient->gender = $request->gender;
            
            $patient->email = $request->email;
            $patient->phone_num1 = $request->phone_num1;
            $patient->phone_num2 = $request->phone_num2;
            $patient->phone_num3 = $request->phone_num3;
            
            $patient->address1 = $request->address1;
            $patient->address2 = $request->address2;

            $patient->city = $request->city;
            $patient->state = $request->state;
            
            $patient->added_mm = $request->added_mm;
            $patient->added_dd = $request->added_dd;
            $patient->added_yy = $request->added_yy;

            $patient->save();

            //$user = User::where('mpid', $request->mrn)->first();
            $user = Auth::user();
            if($user != null){
                $old_photo = $user->photofile;
                if ($request->file('photo_file') != null && file_exists($old_photo)) unlink($old_photo);

                $user->firstname = $request->first_name;
                $user->lastname = $request->last_name;
                $user->email = $request->email;
                $user->role = 'patient';
                $user->active = 'yes';
                //$user->password = Hash::make($request->mrn);     
                //$user->spec = '';      
                if($request->file('photo_file') != null) $this->upload_photo($patient->mrn, $request->file('photo_file'));
                $user->save();
            }
            return view('patient.edit', compact('patient'));
        }
        catch(ModelNotFoundException $err){
            //Show error page
            return back();
        }
    }
    //----------------------------------------------------------------------
    private function upload_photo($mrn, $file){
        $path_dest = "user_photos";
        $filename = sprintf("P_%09d.%s", $mrn, $file->getClientOriginalExtension());

        //User::where('mpid', $mrn)->update(['photofile' => $path_dest."/".$filename]);  
        Auth::user()->photofile = $path_dest."/".$filename;

        if (file_exists($path_dest."/".$filename)) unlink($path_dest."/".$filename);   
        $file->move($path_dest, $filename); 
    }
    //----------------------------------------------------------------------
    public function profile(){
        $user = Auth::user();
        //$patient = patient::where('email', $user->email)->first();
        $patient = patient::where('mrn', $user->mpid)->first();
        return view('patient.profile', compact('patient'));
    }
}