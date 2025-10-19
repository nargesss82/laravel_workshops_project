<?php

namespace App\Http\Controllers;

use App\Constants\StatusCode;
use App\Http\Requests\ChapterRequest;
use App\Http\Resources\ChapterResource;
use App\Services\ChapterService;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    protected $chapterService;
    public function __construct(ChapterService $chapterService)
    {
        $this->chapterService = $chapterService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chapters=$this->chapterService->getAllChapters(true);
        return  ChapterResource::collection($chapters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChapterRequest $request)
    {
        $data=$request->validated();
        $chapter=$this->chapterService->createChapter($request->workshop_id,$data);
        return (new ChapterResource($chapter))->response()->setStatusCode(StatusCode::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chapter=$this->chapterService->getChapterById($id,true);
        return new ChapterResource($chapter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChapterRequest $request, string $id)
    {
        $data=$request->validated();
        $chapter=$this->chapterService->updateChapter($id,$data);
        return (new ChapterResource($chapter))->response()->setStatusCode(StatusCode::OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->chapterService->deleteChapter($id);
        return response()->json(['message'=>'Chapter deleted successfully']);
    }
}
