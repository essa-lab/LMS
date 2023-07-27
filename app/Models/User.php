<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;
    // private string $name;
    // private string $email;
    // private string $password;
    // public function __construct($name,$email,$password)
    // {
    //     $this->setPassword($password);
    //     $this->setName($name);
    //     $this->setEmail($email);
    // }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function setPassword($value){
         $this->attributes['password']=Hash::make($value);
    }
    public function setName ($name){
         $this->attributes['name']=$name;
    }
    public function setEmail($email){
          $this->attributes['email']=$email;
    }
    public function getName(){
        return $this->attributes['name'];
    }
    public function getEmail(){
        return $this->attributes['email'];
    }
    public function getPassword(){
        return $this->attributes['password'];
    }
    public function toArray()
    {
        return [
            'name'=>$this->getName(),
            'email'=>$this->getEmail(),
            'password'=>$this->getPassword()
        ];
    }
}
