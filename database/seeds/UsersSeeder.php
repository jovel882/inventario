<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {                
        $user=User::create([
            'name' => "John Fredy Velasco Bareño",
            'email' => "jovel882@gmail.com",
            'password' => bcrypt('123456789'),
        ]);
        $user->assignRole("Super Administrator");                
        factory(User::class,9)->create();
        $users=User::whereNotIn("id",[1])->get();        
        foreach ($users as $user) {
            if($user->id==3 || $user->id==4){
                $user->assignRole("Provider");                
            }
            else{
                $user->assignRole("Client");                
            }
        }
    }
}
