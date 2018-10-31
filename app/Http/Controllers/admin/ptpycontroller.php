<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\patient;
use App\physic;
use App\ptpyrel;
use App\User;
use DB;
use Auth;

use Mail;

//--------------------------------
//   setting mail
//--------------------------------
// MAIL_DRIVER=smtp 
// MAIL_HOST=smtp.gmail.com 
// MAIL_PORT=587 
// MAIL_USERNAME=zahnifinder2018@gmail.com 
// MAIL_PASSWORD=jilmixoxsmkzcniv 
// MAIL_ENCRYPTION=TLS 
// pretend=false

class ptpycontroller extends AdminController
{
    //----------------------------------------------------------------------
    public function __construct() {
        parent:: __construct();
    }
    //----------------------------------------------------------------------
    public function index(Request $request){
        try{     
            $patient = patient::where('id', $request->id)->first();
            $ptpy = ptpyrel::where('ptid', $request->id)->orderBy('id','desc')->first();
            $pt_file = ptpyrel::where('ptid', $request->id)->where('att_file', '<>', '')->orderBy('id', 'desc')->limit(10)->get();
            // dd($pt_file[0]['att_file']);

            if($ptpy != null) $physic = physic::where('id', $ptpy->pyid)->first();
            else $physic = null;

            $physics = physic::all();

            return view('admin.ptpy_set', compact('patient', 'physic', 'physics', 'ptpy', 'pt_file'));
        }
        catch(ModelNotFoundException $err){
            //Show error page
            return back();
        }
    }
    //----------------------------------------------------------------------
    public function vali_py(Request $request){

        $tmp = explode('(', $request->param)[1];
        $py_pin = explode(')', $tmp)[0];

        $py = physic::where('pin', $py_pin)->first();

        if($py === null) $msg = "false";
        else $msg = "true";
            
        //echo json_encode(['msg'=>$msg]);
        return response()->json(array('msg'=> $msg));
    }
    //----------------------------------------------------------------------
    public function ptpy_del(Request $request){
        $ptpy = ptpyrel::where('id', $request->ptpy_id)->first();
        if($ptpy->att_file != '' ) unlink($ptpy->att_file);
        $ptpy ->delete();

        $patient = patient::where('id', $request->pt_id)->first();
        $physics = physic::all();
        return view('admin.ptpy_set', compact('patient', 'physics'));
    }
    //----------------------------------------------------------------------
    public function send_msg(Request $request){
        $pt_id = $request->id;
        $bSend = $request->bSend;
        $mrn = $request->mrn;

        $pt = patient::where('id', $pt_id)->first();

        if($bSend == 'send'){ // Add Records to physician.
            $tmp = explode('(', $request->select_physican)[1];
            $py_pin = explode(')', $tmp)[0];
            $py = physic::where('pin', $py_pin)->first();
            if($py === null) return back();
            $py_id = $py->id;
        }
        else{
            $py = null;
            $py_id = -1;
        }

        //$this->send_mail($request->bSend, $pt, $py); 
        
        $ptpy = new ptpyrel();
        
        $ptpy['ptid'] = $pt_id;
        $ptpy['pyid'] = $py_id;
        $ptpy->save();

        $filename = $this->file_upload_save($request->file('att_file'), $ptpy->id, $mrn);

        $ptpy['att_file'] = $filename;
        $ptpy->save();

        //return redirect('admin/patient_all');  
        return redirect('admin/patient_send_msg?id='.$pt->id);
    }
    // ---------------------- file upload ----------------------------
    private function file_upload_save($file, $id, $mrn){
        $allowedFileTypes = config('app.allowedFileTypes');
        $maxFileSize = config('app.maxFileSize');
        // $rules = ['att_file.*' => 'required|mimes:'.$allowedFileTypes.'|max:'.$maxFileSize];
        // $this->validate($request, $rules);
              
        $filename = '';
        if($file != ''){
            $path_dest = "uploads"."/".$mrn;
            //$filename = sprintf("pt_%09d.%s", $id, $file->getClientOriginalExtension());
            $originFileName = $file->getClientOriginalName();
            $filename = sprintf("%s.%s", $originFileName, $file->getClientOriginalExtension());
            $file->move($path_dest, $filename);
            $filename = $path_dest.'/'.$filename;
        }
        return $filename;
    }
    // ------------------- send mail from padic to physician and patient  ----------------------
    private function send_mail($bSend, $pt, $py){
        //$tmp = explode(' ', $meet_time);   $meet_date = $tmp[0]; $meet_time = $tmp[1];

        $txt_for_pt =   "Hello ".$pt->first_name." ".$pt->last_name.
                        ", you have a medical record in your Padic inbox. Please login now to review.";
        $html_for_pt = "<div> ".$txt_for_pt." </div>".
                        "<a href='".url('/login')."'>".url('/login')."</a>".
                        "<br>".
                        "<div> Regards, Padic Team </div>";
      
        $email_admin = Auth::user()->email;
        
        // send mail to patient.
        $data = array('name'=>$html_for_pt);
        $from = $email_admin; 
        $to = $pt->email; 
        $from_name = 'Padic'; 
        $subject = 'From Padic';
        
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
 
        if($bSend == 'send'){ // send mail to physician.
            $txt_for_py =   "Hello ".$py->first_name." ".$py->last_name.
                            ", you have a medical record in your Padic inbox. Please login now to review.";
            $html_for_py =  "<div> ".$txt_for_py." </div>".
                            "<a href='".url('/login')."'>".url('/login')."</a>".
                            "<br>".
                            "<div> Regards, Padic Team </div>";

            $data = array('name'=>$html_for_py);
            $from = $email_admin;
            $to = $py->email;  
            $from_name = 'Padic'; 
            $subject = 'From Padic';

            try{
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
    }
}
