<?php

namespace App\Repositories\Eloquent;



use App\Repositories\BaseRepository;
use App\Models\User;
use Carbon\Carbon;

/**
 * Class UserRepository.
 *
 * @package namespace App\Repositories;
 */
class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
         parent::__construct($model);
    }

    public function findByPhone(string $phone)
    {
        $user=$this->model::where('phone',$phone)->first();
        return $user;
    }


    public function getStudentWorkshops(int $userId,bool $onlyActive=false)
    {
        $query=$this->model->where('id',$userId)->with('workshopsEnrolled');
        if($onlyActive){
            $query=$query->whereHas('workshopsEnrolled',fn($q)=>$q->where('status','active'));
        }
        return $query->firstOrFail()->workshopsEnrolled;
    }

    public function getTeacherWorkshops(int $userId,bool $onlyActive=false)
    {
        $query=$this->model->where('id',$userId)->with('workshopsTaught');
        if($onlyActive){
            $query=$query->whereHas('workshopsTaught',fn($q)=>$q->where('status','active'));
        }
        return $query->firstOrFail()->workshopsTaught;
    }

    public function createUserWithCode(string $phone,string $code,string $name,string $role)
    {
        return $this->create([
            'name'=>$name,
            'phone'=>$phone,
            'verification_code'=>$code,
            'code_expires_at'=>Carbon::now()->addMinutes(2),
            'role'=>$role
        ]);
    }

    public function updateVerificationCode(User $user,string $code)
    {
        $user->verification_code=$code;
        $user->code_expires_at=Carbon::now()->addMinutes(2);
        $user->save();
        return $user;
    }

    public function clearVerificationCode(User $user)
    {
        $user->verification_code=null;
        $user->code_expires_at=null;
        $user->save();
    }

}
