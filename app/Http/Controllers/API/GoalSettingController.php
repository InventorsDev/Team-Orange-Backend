<?php

namespace App\Http\Controllers\API;

use App\Enums\GoalSettingDurationEnum;
use App\Models\GoalSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGoalSettingRequest;
use App\Http\Requests\UpdateGoalSettingRequest;

class GoalSettingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $goalSettings = $user->goalSettings()->paginate(10);

        return $this->successResponse('Goal settings retreived successfully', $goalSettings);
    }


    public function store(CreateGoalSettingRequest $request)
    {
        $goalSetting = $this->processGoalSetting($request);

        return $this->createdResponse('Goal setting created successfully ', $goalSetting);
    }


    public function show(GoalSetting $goalSetting)
    {
        return $this->successResponse('Goal setting retreived successfullly', $goalSetting);
    }


    public function update(UpdateGoalSettingRequest $request, GoalSetting $goalSetting)
    {

        $goalSetting = $this->processGoalSetting($request, $goalSetting);

        return $this->successResponse('Goal setting updated successfully', $goalSetting);
    }


    public function destroy(GoalSetting $goalSetting)
    {
        $goalSetting->delete();

        return $this->successResponse('Goal setting deleted successfully');
    }


    private function processGoalSetting($request, GoalSetting $goalSetting = null)
    {
        $data = [
            'user_id' => $request->user()->id,
            'goal_plan' => $request->goal_plan,
            'goal_information' => $request->goal_information,
            'duration' => GoalSettingDurationEnum::fromValue($request->duration),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        if ($goalSetting) {
            $goalSetting->update($data);
        } else {
            $goalSetting = GoalSetting::create($data);
        }

        return $goalSetting;
    }
}