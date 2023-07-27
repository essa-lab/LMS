<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPassword;
use App\Http\Requests\VerifyEmailRequest;
use App\Http\Requests\VerifyPinRequest;
use Illuminate\Support\Facades\Password;
use App\Service\UserServiceInterface;
use ArgumentCountError;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends ApiController
{
    //
    public function __construct(public readonly UserServiceInterface $service)
    {}
    public function login(LoginRequest $request){
         $success = [];
         $user = $this->service->login($request->only('email','password'));
         if (!$user){
            return $this->sendError("Please make sure you entered correct email and password",['Invaild Credintial'],Response::HTTP_UNAUTHORIZED);
         }
         try{
            $success['token']=$user->createToken('API Token')->plainTextToken;
            $success['name']=$user['name'];
            return $this->sendResponse($success,'Hello '.$user['name'],Response::HTTP_CREATED);
         }
         catch(Exception $e){
            return $this->sendError("Error Login User",$e->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

    public function register(RegisterRequest $request){
        $success = [];
        $user = $this->service->register($request->all());
        try{
            $success['email']=$user['email'];
            
            return $this->sendResponse($success,'User Created Successfuly',Response::HTTP_CREATED);
        }catch(ArgumentCountError $e){
            return $this->sendError("Error creating User",$e->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(){
        try{
            $this->service->logout();
            return $this->sendResponse([],'Log Out Successfuly',Response::HTTP_ACCEPTED);
        }catch(Exception $e){
            return $this->sendError("error",['errors'=>$e],404);
        }
    }
    
    public function verifyEmail(VerifyEmailRequest $request){
        try{
            $this->service->verifyEmail($request->all());
            return $this->sendResponse([],'Email Verified Successfuly',Response::HTTP_ACCEPTED);
         }catch (Exception $e){
            return $this->sendError("Error verifed User email",$e->getMessage(),Response::HTTP_BAD_REQUEST);
        }

    }

    public function resetPassword(ResetPassword $request){
       $user =  $this->service->resetPassword($request->all());
       if ($user){
        return $this->sendResponse([],"Password Updated Successfuly!",Response::HTTP_OK);
       }
       return $this->sendError("Error Occure while updating password",[$user],Response::HTTP_BAD_REQUEST);
    }

    public function forgetPassword(ForgetPasswordRequest $request){
        try{
            $done = $this->service->forgetPassword($request->all()['email']);
            if($done){
                return $this->sendResponse([],"PIN was sent to your email address",Response::HTTP_OK);
            }
            return $this->sendError("Email Address not found",[],Response::HTTP_NOT_FOUND);

        }catch(Exception $e){
            return $this->sendError("Error.",$e->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

    public function verifyPin(VerifyPinRequest $request){
        try{
            $done = $this->service->verifyPin($request->all());
            if($done){
                return $this->sendResponse([],"PIN verified",Response::HTTP_OK);
            }
            return $this->sendError("Wrong please check your inputs",[],Response::HTTP_NOT_FOUND);

        }catch(Exception $e){
            return $this->sendError("Error.",$e->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }
    
}
