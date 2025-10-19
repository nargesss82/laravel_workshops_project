<?php

namespace App\Http\Controllers;

use App\Constants\StatusCode;
use App\Http\Requests\AddTeacherRequest;
use App\Http\Requests\EnrollmentRequest;
use App\Http\Requests\WorkshopRequest;
use App\Http\Resources\WorkshopResource;
use App\Services\WorkshopService;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    protected $workshopService;
    public function __construct(WorkshopService $workshopService)
    {
        $this->workshopService = $workshopService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workshops=$this->workshopService->getAllWorkshops(true);
        return WorkshopResource::collection($workshops);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkshopRequest $request)
    {
        $data=$request->validated();
        $workshop=$this->workshopService->createWorkshop($data);
        return (new WorkshopResource($workshop))->response()->setStatusCode(StatusCode::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $workshop=$this->workshopService->getWorkshopById($id,true);
        return new WorkshopResource($workshop);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkshopRequest $request, string $id)
    {
        $data=$request->validated();
        $workshop=$this->workshopService->updateWorkshop($data,$id);
        return (new WorkshopResource($workshop))->response()->setStatusCode(StatusCode::OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->workshopService->deleteWorkshop($id);
        return response()->json(['message'=>'Workshop deleted successfully']);
    }

    public function addTeacher(AddTeacherRequest $request, string $id)
    {
        $data=$request->validated();
        $addition=$this->workshopService->addTeacher($id,$data['phone'],$data['name']);
        return (new WorkshopResource($addition))->response()->setStatusCode(StatusCode::OK);
    }
}
