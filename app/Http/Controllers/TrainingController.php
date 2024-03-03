<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Facades\GlobalSet;

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
            $trainingsData[$date] = $uuid;
        }

        $activityGlobal->inDefaultSite()->set('trainings', $trainingsData)->save();

        return response()->json(['success' => 'Trainings updated successfully.']);
    }
}
