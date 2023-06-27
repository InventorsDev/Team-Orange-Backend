<?php

namespace App\Services;

class AssessmentService
{
    private function loadJsonData(string $filePath)
    {
        $jsonContents = file_get_contents(storage_path($filePath));
        return json_decode($jsonContents, true);
    }

    public function getAssessmentData()
    {
        return $this->loadJsonData('json/assessment_data.json');
    }
}