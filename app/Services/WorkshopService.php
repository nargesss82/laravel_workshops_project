<?php

namespace App\Services;

use App\Repositories\Eloquent\UserRepository;
use App\Models\User;
use App\Models\Workshop;
use App\Repositories\Eloquent\WorkshopRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class WorkshopService
{
    protected $workshopRepository;
    protected $userRepository;
    public function __construct(WorkshopRepository $workshopRepository,UserRepository $userRepository)
    {
        $this->workshopRepository = $workshopRepository;
        $this->userRepository = $userRepository;
    }

    public function getAllWorkshops(bool $withChapters = false)
    {
        if($withChapters){
            return $this->workshopRepository->allWithChapters();
        }
        return $this->workshopRepository->all();
    }
    public function getWorkshopById(int $id, bool $withChapters = false)
    {
        if($withChapters){
            return $this->workshopRepository->findWithChapters($id);
        }
        return $this->workshopRepository->find($id);
    }

    public function getWorkshopsByTeacher(int $userId, bool $onlyActive = false)
    {
        $user=$this->userRepository->find($userId);
        if(!$user->isTeacher())
        {
            throw new \Exception("User id must be a teacher");
        }
        return $this->userRepository->getTeacherWorkshops($userId, $onlyActive);
    }

    public function getWorkshopsByStudent(int $userId, bool $onlyActive = false)
    {
        $user=$this->userRepository->find($userId);
        if(!$user->isStudent())
        {
            throw new \Exception("User id must be a student");
        }
        return $this->userRepository->getStudentWorkshops($userId, $onlyActive);
    }

    public function createWorkshop(array $data)
    {
        if(!$data){
            throw new \Exception("Workshop data not set");
        }
        if($this->workshopRepository->existsTitle($data)){
            throw new \Exception("Title already exists");
        }
        $teacher=$this->userRepository->find($data['teacher_id']);
        if(!$teacher->isTeacher()){
            throw new \Exception("User id must be a teacher");
        }
        return $this->workshopRepository->create($data);
    }
    public function updateWorkshop(array $data, int $id){
        if(!$data){
            throw new \Exception("Workshop data not set");
        }
        if($this->workshopRepository->existsTitle($data)){
            throw new \Exception("Title already exists");
        }
        return $this->workshopRepository->update($id, $data);
    }
    public function deleteWorkshop(int $id){
        if(!$id){
            throw new \Exception("Workshop id not set");
        }
        return $this->workshopRepository->delete($id);
    }

    public function addTeacher(int $workshopId,string $phone,string $name=null)
    {
        $teacher=$this->userRepository->findByPhone($phone);
        if(!$teacher){
            $teacher=$this->userRepository->create(['phone'=>$phone,'name'=>$name,'role'=>'teacher']);
        }
        if (!$teacher->isTeacher()){
            throw new \Exception("The selected user is not a teacher");
        }
        return $this->workshopRepository->assignTeacherToWorkshop($workshopId,$teacher->id);
    }



}
