<?php
namespace App\Service;

use App\Http\Requests\ForgetPasswordRequest;
use App\Mail\ForgetPassword;
use App\Mail\VerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class UserService implements UserServiceInterface{
    
    public function login(array $credentials){
        try{
            Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']]);
            $user = Auth::user();
            return $user;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
    public function register(array $data)
    {
        DB::beginTransaction();
        try{
        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>bcrypt($data['password'])
        ]);
        $pin = rand(100000,999999);
        Mail::to($data['email'])->send(new VerifyEmail($pin));
        DB::table('password_reset_tokens')->insert([
            'email'=>$data['email'],
            'token'=>$pin
        ]);
        $user->assignRole('student');
        DB::commit();
        return $user;
    }catch (ValidationException $e){
        DB::rollBack();
        throw new ValidationException($e->getMessage());
    }
    catch(Exception $e){
        DB::rollBack();
        throw new Exception($e->getMessage());
    }
    }
    public function logout(){  
        Auth::user()->logout;
    }
    
    public function resetPassword(array $credentials){ 
        try{
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        if(Hash::check($credentials['password'],$user->password)){
        $user->update([
            'password'=>$credentials['new_password']
        ]);
        return $user;
    }
        return false;
        }catch (ModelNotFoundException $e){
            return $e->getMessage();
        }

    }
    public function verifyEmail($pin)
    {
        $select = DB::table('password_reset_tokens')->where('email',Auth::user()->email)->where('token',$pin);
        if ($select->get()->isEmpty()){
            throw new Exception('Invaild PIN');
        }
        $select->delete();
        $user = User::find(Auth::user()->id);
        $user->email_verified_at = Carbon::now()->getTimestamp();
        $user->save();
        return $user;
    }
    
    public function forgetPassword($email){
        try{
        $user = User::where('email',$email)->exists();
        if(!$user){
            return false;
        }
        $verify = DB::table('password_reset_tokens')->where('email',$email);
        $verify->exists() ? $verify->delete() : '';
        $pin = rand(100000,999999);
        DB::table('password_reset_tokens')->insert([
            'email'=>$email,
            'token'=>$pin,
            
            'created_at'=>Carbon::now()
        ]);
        Mail::to($email)->send(new ForgetPassword($pin));
        return true;
        }catch(Exception $e){
        throw new Exception($e->getMessage());
        }
    }

    public function verifyPin(array $credentials){
        $user = DB::table('password_reset_tokens')->where([
            'email'=>$credentials['email'],
            'token'=>$credentials['pin']
        ]);
        
        if($user->get()->isEmpty()){
            return false;
        }
        if(Carbon::now()->diffInSeconds($user->get()[0]->created_at)>3600){
            return false;
        }
        $user->delete();
        return true;
    }
    
}