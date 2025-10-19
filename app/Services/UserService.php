<?php

namespace App\Services;


use App\Repositories\Eloquent\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->all();
    }

    public function getUserById(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function getUserByPhone(string $phone)
    {
        $user = $this->userRepository->findByPhone($phone);
        return $user;
    }

    public function sendVerificationCode(string $phone,string $name=null,string $role=null)
    {
        $code=rand(1000,9999);
        $user = $this->userRepository->findByPhone($phone);
        if($user){
            $this->userRepository->updateVerificationCode($user,$code);
        }
        else{
            $user=$this->userRepository->createUserWithCode($phone,$code,$name,$role);
        }
        return $user;
    }

    public function verifyCodeAndLogin(string $phone,string $code)
    {
        $user=$this->userRepository->findByPhone($phone);
        if(!$user || !$user->verification_code)
        {
            throw new \Exception("Invalid phone number or code");
        }
        if($user->verification_code != $code)
        {
            throw new \Exception("Incorrect verification code");
        }
        if(Carbon::now()->greaterThan(Carbon::parse($user->code_expires_at)))
        {
            throw new \Exception("Code expired");
        }

        $token=$user->createToken('api-token')->accessToken;
        return [
            'token'=>$token,
            'user'=>$user
        ];
    }
}
