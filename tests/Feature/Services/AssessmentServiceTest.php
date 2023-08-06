<?php

namespace Tests\Feature\Services;

use App\Services\AssessmentService;
use Tests\TestCase;

class AssessmentServiceTest extends TestCase
{

    public function test_get_assessment_data()
    {
        $service = new AssessmentService();

        $assessmentData = $service->getAssessmentData();

        $this->assertIsArray($assessmentData);
    }

    public function test_get_daily_assessment_data()
    {
        $service = new AssessmentService();

        $dailyAssessmentData = $service->getDailyAssessmentData();

        $this->assertIsArray($dailyAssessmentData);
    }
}
