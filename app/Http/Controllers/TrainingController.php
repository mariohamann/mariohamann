<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Facades\GlobalSet;
use DateTime;
use App\Jobs\RefreshCacheJob;

class TrainingController extends Controller
{
    public function update(Request $request)
    {
        // Check if API_TOKEN is set in config
        if (!config('services.api.token')) {
            return response()->json(['error' => 'API token not set'], 500);
        }

        // Check if the request has the correct token
        $token = $request->header('Authorization');
        if ($token !== 'Bearer ' . config('services.api.token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validate the request body
        $validated = $request->validate([
            'data' => 'required|array',
        ]);

        $activityGlobal = GlobalSet::findByHandle('activity');

        if (!$activityGlobal) {
            return response()->json(['error' => 'Global set not found'], 404);
        }

        $originalTrainingsData = $activityGlobal->inDefaultSite()->get('trainings', []);
        $trainingsData = $originalTrainingsData;

        foreach ($validated['data'] as $date => $uuid) {
            $dateTime = new DateTime($date);

            // Adjust for late-night trainings
            if ((int)$dateTime->format('G') < 4) {
                $dateTime->modify('-1 day');
                $dateTime->setTime(23, 59, 59);
            }

            $trainingsData[$dateTime->format('Y-m-d\TH:i:sP')] = $uuid;
        }

        ksort($trainingsData);
        $dataHasChanged = $originalTrainingsData !== $trainingsData;

        if ($dataHasChanged) {
            $activityGlobal->inDefaultSite()->set('trainings', $trainingsData)->save();
            RefreshCacheJob::dispatch(['/islands/activity-graph-trainings']);
        }

        return response()->json(['success' => 'Trainings updated successfully.']);
    }
}
