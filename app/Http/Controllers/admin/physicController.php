<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\physic;
use App\patient;
use App\ptpyrel;
use App\User;
use Auth;
use DB;
use Mail;

class physicController extends AdminController
{
    //----------------------------------------------------------------------
    public function __construct() {
        parent:: __construct();
    }
    //----------------------------------------------------------------------
    public function physic_get(){
        $users = User::where('role', 'physician')->where('active', 'no')->paginate(10);
        //$title = 'All Users';
        //return view('admin.user_list_for_add_py', compact('users','title'));
        return view('admin.user_list_for_add_py', compact('users'));
        //return view('admin.physic_save');
    }
    //----------------------------------------------------------------------
    public function physic_add(Request $request){ 
        $user = user::findOrFail($request->id);
   
        $added = explode('-',date('d-m-Y'));
        $mm = $added[1]; $dd = $added[0]; $yy = $added[2];

        $physic = new physic();

        $physic->pin = $this->genPIN();
        
        $user->mpid = $physic->pin;
        $user->password = Hash::make($user->mpid);  
        $user->save();

        $physic->first_name = $user->firstname;
        $physic->last_name = $user->lastname;
        $physic->midd_name = '';

        $physic->bir_mm = $mm;
        $physic->bir_dd = $dd;
        $physic->bir_yy = $yy;

        $physic->gender = '';
        
        $physic->email = $user->email;
        $physic->phone_num1 = '';
        $physic->phone_num2 = '';
        $physic->phone_num3 = '';
        
        $physic->address1 = '';
        $physic->address2 = '';

        $physic->city = '';
        $physic->state = '';

        $physic->med_spec = $user->spec;
        
        $physic->added_mm = $mm;
        $physic->added_dd = $dd;
        $physic->added_yy = $yy;

        $physic->save();

        $photofile = User::where('mpid', $physic->pin)->first()->photofile; 

        return view('admin.physic_save', compact('physic', 'photofile'));
    }
    //----------------------------------------------------------------------
    private function upload_photo($pin, $file){
        $path_dest = "user_photos";
        $filename = sprintf("P_%09d.%s", $pin, $file->getClientOriginalExtension());

        User::where('mpid', $pin)->update(['photofile' => $path_dest."/".$filename]);  
        
        if (file_exists($path_dest."/".$filename)) unlink($path_dest."/".$filename);   
        $file->move($path_dest, $filename); 
    }
   //-------------------- send mail to physician -------------------------
    private function send_mail($py_email, $pin){
        //$email_admin = User::where('role', 'admin')->first()->email;
        $email_admin = Auth::user()->email;

        $from = $email_admin; 
        $to = $py_email;    
        $from_name = 'Padic'; 
        $subject = 'From Padic';
        
        $first_name = physic::where('pin', $pin)->first()->first_name;
        $last_name = physic::where('pin', $pin)->first()->last_name;
        
        $txt =  "Hello ".$first_name." ".$last_name.", Your access to the Padic Physician registration site is complete.".
                " Your PIN is ".$pin.". You will need it to login to the padic System."; 
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

        //User::where('email', $request->email)->update(['active' => 'yes']);   
        User::where('mpid', $pin)->update(['active' => 'yes']); 
    }
    //----------------------------------------------------------------------
    public function physic_search(Request $request){
        return view('admin.physic_search');
    }
    //----------------------------------------------------------------------
    public function physic_search_results(Request $request){
        if($request->sitem == '1'){ // PIN
            $physics = DB::table('physic_tb')->where('pin', $request->keyword)->paginate(10);
        }
        elseif($request->sitem == '2'){ // last name
            $physics = DB::table('physic_tb')->where('last_name', $request->keyword)->paginate(10);
        }
        
        return view('admin.physic_search', compact('physics'));
    }
    //----------------------------------------------------------------------
    public function physic_all_results(){
        $physics = physic::orderBy('id','desc')->paginate(10);
        return view('admin.physic_all', compact('physics'));
    }
    //----------------------------------------------------------------------
    public function physic_update(Request $request){
        $physic = DB::table('physic_tb')->where('id', $request->id)->first();
        $photofile = User::where('mpid', $physic->pin)->first()->photofile; 
        return view('admin.physic_save', compact('physic', 'photofile'));
    }
    //----------------------------------------------------------------------
    public function physic_save(Request $request){
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

            $user = User::where('mpid', $request->pin)->first();
            $user->firstname = $request->first_name;
            $user->lastname = $request->last_name;
            $user->email = $request->email;
            $user->spec = $request->med_spec;
            $user->active = 'yes';

            if($request->file('photo_file') != null) $this->upload_photo($physic->pin, $request->file('photo_file'));
            
            $user->save();
            
            $photofile = User::where('mpid', $physic->pin)->first()->photofile; 
            
            return view('admin.physic_save', compact('physic', 'photofile'));
        }
        catch(ModelNotFoundException $err){
            //Show error page
            return back();
        }
    }
    //----------------------------------------------------------------------
    public function physic_delete(Request $request){
        $py = physic::where('id', $request->id)->first();
        $mpid = $py->pin;

        $filename = User::where('mpid', $mpid)->first()->photofile;  
        if ($filename != '' && file_exists($filename)) unlink($filename);

        $user = User::where('mpid', $mpid)->delete();
                
        if($py != null)  {
            $ptpys = ptpyrel::where('pyid', $py->id)->get();
            foreach($ptpys as $ptpy){
                $pt = patient::where('id', $ptpy->ptid)->first();
                if($pt == null) {
                    if($ptpy->att_file != '' ) unlink($ptpy->att_file);
                    $ptpy->delete();
                }
            }
            $py->delete();
        }

        return back();
    }
    //----------------------------------------------------------------------
    private function genPIN() {
        $number = mt_rand(1000000000, 2147483647); // better than rand() 2
    
        // call the same function if the barcode exists already
        if ($this->bPIN($number)) {
            return $this->genPIN();
        }
    
        // otherwise, it's valid and can be used
        return $number;
    }
    //----------------------------------------------------------------------
    private function bPIN($number) {
        $pt = patient::where('mrn', '=', $number)->first();
        $py = physic::where('pin', '=', $number)->first();

        $ret = true;
        if (($pt === null) && ($py === null)) $ret = false; // user doesn't exist
    
        return $ret;
    }
    //----------------------------------------------------------------------
    // private function generateBarcodeNumber() {
    //     $number = mt_rand(1000000000, 9999999999); // better than rand()
    
    //     // call the same function if the barcode exists already
    //     if (barcodeNumberExists($number)) {
    //         return generateBarcodeNumber();
    //     }
    
    //     // otherwise, it's valid and can be used
    //     return $number;
    // }
    
    // private function barcodeNumberExists($number) {
    //     // query the database and return a boolean
    //     // for instance, it might look like this in Laravel
    //     return User::whereBarcodeNumber($number)->exists();
    // }
}
