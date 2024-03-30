<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Facades\GlobalSet;
use DateTime;

class TrainingController extends Controller
{
    public function update(Request $request)
    {
        // Check if API_TOKEN is set in env
        if (!env('API_TOKEN')) {
            return response()->json(['error' => 'API token not set'], 500);
        }

        // Check if the request has the correct token
        $token = $request->header('Authorization');
        if ($token !== 'Bearer ' . env('API_TOKEN')) {
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

        $trainingsData = $activityGlobal->inDefaultSite()->get('trainings', []);

        // Update the 'trainings' data with new values
        foreach ($validated['data'] as $date => $uuid) {
            // Convert the date string to a DateTime object
            $dateTime = new DateTime($date);


            // Sometimes I'm getting to bed after midnight
            // I want to count those trainings as the previous day
            // Check if the time is between 00:00 and 04:00
            if ((int)$dateTime->format('G') < 4) {
                // Subtract one day
                $dateTime->modify('-1 day');
                // Set time to 23:59:59
                $dateTime->setTime(23, 59, 59);
            }

            // Format the DateTime object back to the original format and store it
            $trainingsData[$dateTime->format('Y-m-d\TH:i:sP')] = $uuid;
        }

        $activityGlobal->inDefaultSite()->set('trainings', $trainingsData)->save();

        // get complete data, sort it and save it
        $trainingsData = $activityGlobal->inDefaultSite()->get('trainings', []);
        ksort($trainingsData);
        $activityGlobal->inDefaultSite()->set('trainings', $trainingsData)->save();

        return response()->json(['success' => 'Trainings updated successfully.']);
    }
}
