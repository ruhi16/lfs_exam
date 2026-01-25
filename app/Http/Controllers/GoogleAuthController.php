<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class GoogleAuthController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle(){
        try{
            $google_user = Socialite::driver('google')->user();
            // dd($google_user);

            $user = User::where('google_id', $google_user->getId())->first();

            if(!$user){
                $new_user = User::UpdateOrCreate([
                   'name'  => $google_user->getName(),
                   'email' => $google_user->getEmail(), 
                   'google_id' => $google_user->getId(),
                   'email_verified_at' => Carbon::now()->format('d-m-Y'),
                   'password' => Hash::make($google_user->getName().'@'.$google_user->getId()),
                   'role_id' => 1
                ]);
                

                $new_user->save();
                Auth::login($new_user);
                return redirect()->intended('/dashboard');
            }else{

                // $save_user = User::where('email', $google_user->getEmail())->first()->update([
                //     'google_id' => $google_user->getId(),
                // ]);
                
                $user->google_id = $google_user->getId();
                $user->save();

                Auth::login($user);
                return redirect()->intended('/dashboard');
            }



        }catch(\Exception $e){
            dd($e);
        }

    }
}
