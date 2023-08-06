<?php

use App\Services\AssessmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssessmentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_assessment_data()
    {
        $serviceMock = Mockery::mock(AssessmentService::class);
        $serviceMock->shouldReceive('getAssessmentData')->once()->andReturn(['question1', 'question2']);

        $this->app->instance(AssessmentService::class, $serviceMock);

        $response = $this->getJson('/api/v1/assessment-questions');

        $response->assertStatus(200);
    }

    public function test_get_daily_assessment_data()
    {

        $serviceMock = Mockery::mock(AssessmentService::class);

        $serviceMock->shouldReceive('getDailyAssessmentData')->once()->andReturn(['questionA', 'questionB']);

        $this->app->instance(AssessmentService::class, $serviceMock);

        $response = $this->getJson('/api/v1/daily-assessment-questions');

        $response->assertStatus(200);
    }
}
