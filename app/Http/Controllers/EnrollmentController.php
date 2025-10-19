<?php

namespace App\Http\Controllers;

use App\Constants\StatusCode;
use App\Http\Requests\EnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    protected $enrollmentService;
    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments=$this->enrollmentService->getAllEnrollments();
        return EnrollmentResource::collection($enrollments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EnrollmentRequest $request)
    {
        $data=$request->validated();
        $enrollment=$this->enrollmentService->createEnrollment($data['user_id'],$data['workshop_id']);
        return (new EnrollmentResource($enrollment))->response()->setStatusCode(StatusCode::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data=$this->enrollmentService->getEnrollmentById($id);
        return new EnrollmentResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EnrollmentRequest $request, string $id)
    {
        $data=$request->validated();
        $enrollment = $this->enrollmentService->updateEnrollment(
            $data['user_id'] ?? null,
            $data['workshop_id'] ?? null,
            $id
        );
        return (new EnrollmentResource($enrollment))->response()->setStatusCode(StatusCode::OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->enrollmentService->deleteEnrollment($id);
        return response()->json(['message'=>'Enrollment deleted successfully']);
    }
}
