<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\AssessmentService;
use App\Http\Controllers\Controller;

class AssessmentController extends Controller
{
    protected $assessmentService;

    public function __construct(AssessmentService $assessmentService)
    {
        $this->assessmentService = $assessmentService;
    }

    public function index()
    {
        $assessmentData = $this->assessmentService->getAssessmentData();

        return $this->successResponse('Assessment questions retrieved successfully', $assessmentData);
    }
}