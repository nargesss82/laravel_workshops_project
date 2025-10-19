<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\WorkshopResource;
use App\Services\UserService;
use App\Services\WorkshopService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $workshopService;


    public function __construct(UserService $userService, WorkshopService $workshopService)
    {
        $this->userService = $userService;
        $this->workshopService = $workshopService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return UserResource::collection($users);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userService->getUserById($id);
        return new UserResource($user);
    }

    public function sendVerificationCode(UserRequest $request)
    {
        $data = $request->validated();
        if(count($data)==1 && $data['phone'] ){
            $data['name'] = 'user name';
            $data['role'] = 'student';
        }

        $user = $this->userService->sendVerificationCode($data['phone'],$data['name'],$data['role']);

        return new UserResource($user);
    }

    public function verifyCode(LoginRequest $request)
    {
        $data = $request->validated();
        $data = $this->userService->verifyCodeAndLogin($data['phone'],$data['code']);
        return response()->json([
            'user' => new UserResource($data['user']),
            'token' => $data['token'] ?? null
        ]);
    }

    public function getTeacherWorkshops(int $id)
    {
        $workshops=$this->workshopService->getWorkshopsByTeacher($id);
        return WorkshopResource::collection($workshops);
    }

    public function getStudentWorkshops(int $id)
    {
        $workshops=$this->workshopService->getWorkshopsByStudent($id);
        return WorkshopResource::collection($workshops);
    }
}





