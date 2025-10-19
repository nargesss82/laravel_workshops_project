<?php

namespace App\Http\Controllers;

use App\Constants\StatusCode;
use App\Http\Requests\SubchapterRequest;
use App\Http\Resources\SubchapterResource;
use App\Services\SubchapterService;

class SubchapterController extends Controller
{
    protected $subchapterService;
    public function __construct(SubchapterService $subchapterService)
    {
        $this->subchapterService = $subchapterService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(int $chapterId)
    {
        $subchapters=$this->subchapterService->getAllSubchaptersByChapterId($chapterId);
        return SubchapterResource::collection($subchapters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubchapterRequest $request)
    {
        $chapterId=$request->chapter_id;
        $data=$request->validated();
        $subchapter=$this->subchapterService->createSubchapter($chapterId,$data);
        return (new SubchapterResource($subchapter))->response()->setStatusCode(StatusCode::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subchapter=$this->subchapterService->getSubchapterById($id);
        return new SubchapterResource($subchapter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubchapterRequest $request, string $id)
    {
        $data=$request->validated();
        $subchapter=$this->subchapterService->updateSubchapter($id,$data);
        return (new SubchapterResource($subchapter))->response()->setStatusCode(StatusCode::OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->subchapterService->deleteSubchapter($id);
        return response()->json(['message'=>'Subchapter deleted successfully']);

    }
}
