<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Services\PayUService\Exception;
use App\patient;
use App\physic;
use App\ptpyrel;
use App\User;
use Auth;
use DB;
use Mail;

//***********************************************************************
class patientController extends AdminController
{
    //----------------------------------------------------------------------
    public function __construct() {
        parent:: __construct();
    }
    //----------------------------------------------------------------------
    public function patient_get(){
        $users = User::where('role', 'patient')->where('active', 'no')->paginate(10);
        //$title = 'All Users';
        //return view('admin.user_list_for_add_pt', compact('users','title'));
        return view('admin.user_list_for_add_pt', compact('users'));
        //return view('admin.physic_save');
    }
    //----------------------------------------------------------------------
    public function patient_add(Request $request){
        $user = user::findOrFail($request->id);
   
        $added = explode('-',date('d-m-Y'));
        $mm = $added[1]; $dd = $added[0]; $yy = $added[2];

        $patient = new patient();

        $patient->mrn = $this->genMRN();

        $user->mpid = $patient->mrn;
        $user->password = Hash::make($user->mpid);  
        $user->save();

        $patient->first_name = $user->firstname;
        $patient->last_name = $user->lastname;
        $patient->midd_name = '';

        $patient->bir_mm = $mm;
        $patient->bir_dd = $dd;
        $patient->bir_yy = $yy;

        $patient->gender = '';
            
        $patient->email = $user->email;
        $patient->phone_num1 = '';
        $patient->phone_num2 = '';
        $patient->phone_num3 = '';
        
        $patient->address1 = '';
        $patient->address2 = '';

        $patient->city = '';
        $patient->state = '';
            
        $patient->added_mm = $mm;
        $patient->added_dd = $dd;
        $patient->added_yy = $yy;

        $patient->birthday_msg = '';

        $patient->save();

        $photofile = User::where('mpid', $patient->mrn)->first()->photofile; 

        return view('admin.patient_save', compact('patient', 'photofile'));
    }
    //----------------------------------------------------------------------
    public function patient_new(){
        return view('admin.patient_new');
    }
    //----------------------------------------------------------------------
    public function patient_addnew(Request $request){
        $patient = new patient();

        $patient->mrn = $this->genMRN();
        $patient->first_name = $request->first_name;
        $patient->last_name = $request->last_name;
        $patient->bir_mm = $request->bir_mm;
        $patient->bir_dd = $request->bir_dd;
        $patient->bir_yy = $request->bir_yy;
        $patient->gender = $request->gender;
        $patient->email = $request->email;
        $patient->address1 = $request->address1;
        if (isset($request->address2)){
            $patient->address2 = $request->address2;
        }
        $patient->city = $request->city;
        $patient->state = $request->state;
        $patient->added_mm = $request->added_mm;
        $patient->added_dd = $request->added_dd;
        $patient->added_yy = $request->added_yy;
        $patient->birthday_msg = $request->bir_msg;

        $patient->save();

        return redirect('admin.patient_save', compact('patient'));
    }
    //----------------------------------------------------------------------
    private function upload_photo($mrn, $file){
        $path_dest = "user_photos";
        $filename = sprintf("P_%09d.%s", $mrn, $file->getClientOriginalExtension());

        User::where('mpid', $mrn)->update(['photofile' => $path_dest."/".$filename]);  
        
        if (file_exists($path_dest."/".$filename)) unlink($path_dest."/".$filename);   
        $file->move($path_dest, $filename); 
    }
    //-------------------- send mail to patient -------------------------
    private function send_mail($pt_email, $mrn){
        //$email_admin = User::where('role', 'admin')->first()->email; 
        $email_admin = Auth::user()->email;
        
        $from = $email_admin; 
        $to = $pt_email;   
        $from_name = 'Padic'; 
        $subject = 'From Padic';
        
        $first_name = patient::where('mrn', $mrn)->first()->first_name;
        $last_name = patient::where('mrn', $mrn)->first()->last_name;

        $txt =  "Hello ".$first_name." ".$last_name.", Your access to the Padic Patient registration site has been completed.".
                " Your MRN is ".$mrn.". You will need it to login to the Padic System."; 
        $html = "<div> ".$txt." </div>".
                "<a href='".url('/login')."'>".url('/login')."</a>".
                "<br>".
                "<div> Regards, Padic Team </div>";

        $data = array('name' => $html);

        try {
            Mail::send('admin.email', $data, function ($message) use ($to, $from, $from_name, $subject) {
                $message->from($from, $from_name);
                $message->to($to)->subject($subject);
            });
        } 
        catch (\Exception $e) {
            \Log::info("Email Sending Error : " . $e->getMessage());
            return $e->getMessage();
        }
    }
    //----------------------------------------------------------------------
    public function patient_search(Request $request){
        return view('admin.patient_search');
    }
    //----------------------------------------------------------------------
    public function patient_search_results(Request $request){
        if($request->sitem == '1'){ // MRN
            $patients = DB::table('patient_tb')->where('mrn', $request->keyword)->paginate(10);
        }
        elseif($request->sitem == '2'){ // last name
            $patients = DB::table('patient_tb')->where('last_name', $request->keyword)->paginate(10);
        }

        return view('admin.patient_search', compact('patients'));
    }
    //----------------------------------------------------------------------
    public function patient_all_results(){
        $patients = patient::orderBy('id','desc')->paginate(10);
        return view('admin.patient_all', compact('patients'));
    }
    //----------------------------------------------------------------------
    public function patient_update(Request $request){
        //$patient = DB::table('patient_tb')->where('id', $request->id)->first();
        $patient = patient::where('id', $request->id)->first();
        if (file_exists(public_path().'/user_photos/'.'P_'.$patient->mrn.'.jpg')){
            $photofile = User::where('mpid', $patient->mrn)->first()->photofile;
            return view('admin.patient_save', compact('patient', 'photofile'));
        }
        else {
            return view('admin.patient_save', compact('patient'));
        }
    }
    //----------------------------------------------------------------------
    public function patient_save(Request $request){
        // 'first_name','last_name','midd_name','birthday','email','phone_num1','phone_num2','phone_num3','age','gender','address1','address2','city','state','date_added'
        
        // $validatedData = $request->validate([
        //     'email' => 'required|unique:users|max:255',
        // ]);

        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|unique:users|max:255'
        // ]);       
        
        // if ($validator->fails()) {
        //     return redirect('admin/patient_add')
        //                 ->withErrors($validator)
        //                 ->withInput(); // withInput() is for preserving the input during redirects.
        // }

        // $patient = new patient();
        // $patient['mrn'] = $request->mrn;
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

            $patient->birthday_msg = $request->bir_msg;

            $patient->save();

            $user = User::where('mpid', $request->mrn)->first();
            //if($user != null){
            $user->firstname = $request->first_name;
            $user->lastname = $request->last_name;
            $user->email = $request->email;
            $user->spec = '';  
            $user->active = 'yes';
            //$user->password = Hash::make($request->mrn);                     

            if($request->file('photo_file') != null) $this->upload_photo($patient->mrn, $request->file('photo_file'));

            $user->save();

            $photofile = User::where('mpid', $patient->mrn)->first()->photofile;
            //}
            return view('admin.patient_save', compact('patient', 'photofile'));
        }
        catch(ModelNotFoundException $err){
            //Show error page
            return back();
        }
    }
    //----------------------------------------------------------------------
    public function patient_delete(Request $request){
        $pt =patient::where('id', $request->id)->first();
        $mpid = $pt->mrn;

        $filename = User::where('mpid', $mpid)->first()->photofile;  
        if ($filename != '' && file_exists($filename)) unlink($filename);

        $user = User::where('mpid', $mpid)->delete();

        if($pt != null) {
            $ptpys = ptpyrel::where('ptid', $pt->id)->get();
            foreach($ptpys as $ptpy){
                if($ptpy->pyid == -1) {
                    if($ptpy->att_file != '' ) unlink($ptpy->att_file);
                    $ptpy->delete();
                    continue;
                }
                $py = physic::where('id', $ptpy->pyid)->first();
                if($py == null) {
                    if($ptpy->att_file != '' ) unlink($ptpy->att_file);
                    $ptpy->delete();
                }
            }
            $pt->delete();
        }    

        return back();
    }
    //----------------------------------------------------------------------
    private function genMRN() {
        $number = mt_rand(1000000000, 2147483647); // better than rand() 2
    
        // call the same function if the barcode exists already
        if ($this->bMRN($number)) {
            return $this->genMRN();
        }
    
        // otherwise, it's valid and can be used
        return $number;
    }
    //----------------------------------------------------------------------
    private function bMRN($number) {
        $pt = patient::where('mrn', '=', $number)->first();
        $py = physic::where('pin', '=', $number)->first();

        $ret = true;
        if (($pt === null) && ($py === null)) $ret = false; // user doesn't exist
    
        return $ret;
    }
}
