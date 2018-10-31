<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Auth;
use App\User;
use Mail;

//***********************************************************************
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //--------------------------------------------------------------------
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    //--------------------------------------------------------------------
     public function index()
    {
        $user = Auth::user();

        if($user->role == 'superAdmin'){ // role : superAdmin
            return redirect("admin/index");
        }
        elseif($user->role == 'subAdmin'){ // role : subAdmin
            return redirect("subadmin/index");
        }
        elseif($user->role == 'physician'){ // role : physician
            return redirect('physic/index');
        }
        elseif($user->role == 'patient'){ // role : patient
            return redirect('patient/index');
        }
    }
    //--------------------------------------------------------------------
    public function afterReg() // pop up message 
    {
        $user = Auth::user();
        $role = $user->role;
        
        $this->send_mail_from($user->email, $user->firstname, $user->lastname, $role);

        Auth::logout();

        return view('admin.message', compact('role'));
    }
    //-------------------- send mail to admins -------------------------
    private function send_mail_from($from_email, $first_name, $last_name, $role){
        $admins = User::where('role', 'superAdmin')->orWhere('role', 'subAdmin')->orderBy('id', 'asc')->get();
        $to_emails = array();
        foreach($admins as $admin){
            if($admin->email != 'admin@mail.com') array_push($to_emails, $admin->email);
        }
        if(sizeof($to_emails) == 0) return;

        $from = $from_email; 
        $to = $to_emails;
        $from_name = $first_name." ".$last_name; 
        $subject = 'To Padic';

        $txt_py = "Thank you for registering. Once we approve your registration, we will send you your PIN (Personal Identification number). Your personal PIN will be emailed to the email you provided at signup. This PIN is your new password to login to Padic.";

        $txt_pt = "Thank you for registering. Once we approve your registration, we will send you your MRN (Medical Record Number). Your personal MRN will be emailed to the email you provided at signup. This MRN is your new password to login to Padic.";

        $txt_st = "Thank you for registering. Please login to your account using your username and password. Padic Admin.";

        //$txt = "My name is ".$first_name." ".$last_name.". I registered with Padic."; 
        if($role == 'physician') $txt = $txt_py;
        elseif($role == 'patient') $txt = $txt_pt;
        else $txt = $txt_st;

        $html = "<div> ".$txt." </div>".
                "<a href='".url('/login')."'>".url('/login')."</a>".
                "<br>".
                "<div> Regards, From Padic Team </dic>";

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
}
