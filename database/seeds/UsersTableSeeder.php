<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new User();
        $user->firstname = "first";
        $user->lastname = "last";
        $user->password = bcrypt('password');
        $user->email = "admin@mail.com";
        $user->role = "superAdmin"; 
        $user->active = 'yes';       
        $user->save();

        // $user = new User();
        // $user->firstname = "fphysician01";
        // $user->lastname = "lphysician01";
        // $user->password = bcrypt('password');
        // $user->email = "physician01@mail.com";
        // $user->role = "physician";      
        // $user->active = 'no';  
        // $user->save();

        // $user = new User();
        // $user->firstname = "fphysician02";
        // $user->lastname = "lphysician02";
        // $user->password = bcrypt('password');
        // $user->email = "physician02@mail.com";
        // $user->role = "physician";  
        // $user->active = 'no';      
        // $user->save();
    }
}
