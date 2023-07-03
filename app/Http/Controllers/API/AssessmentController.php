<?php

namespace App\Http\Controllers\API;

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

    public function dailyIndex()
    {
        $dailyAssessmentData = $this->assessmentService->getDailyAssessmentData();

        return $this->successResponse('Daily assessment questions retrieved successfully', $dailyAssessmentData);
    }
}
