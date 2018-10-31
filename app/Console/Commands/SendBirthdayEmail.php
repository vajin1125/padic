<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendBirthdayEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email users a birthday message and promo code'; 

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $patients = patient::whereMonth('bir_mm', '=', date('m'))->whereDay('bir_dd', '=', date('d'))->get();
 
        foreach($patients as $patient) {
    
            // Create a unique 8 character promo code for user
            $new_promo_code = new PromoCode([
                'promo_code' => str_random(8),
            ]);
    
            $patient->promo_code()->save($new_promo_code);
            
            // Send the email to user
            Mail::queue('emails.birthday', ['user' => $patient], function ($mail) use ($patient) {
                $mail->to($patient['email'])
                    ->from('va.jin1125@gmail.com', 'Company')
                    ->subject($patient['birthday_msg']);
            });
    
        }
    
        $this->info('Birthday messages sent successfully!');
    }
}
