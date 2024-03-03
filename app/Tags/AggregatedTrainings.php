<?php

namespace App\Tags;

use Statamic\Tags\Tags;
use Statamic\Facades\GlobalSet;
use Carbon\Carbon;

class AggregatedTrainings extends Tags
{
    /**
     * The {{ aggregated_trainings }} tag.
     *
     * @return string|array
     */
    public function index()
    {
        $trainingsData = GlobalSet::findByHandle('activity')->inDefaultSite()->get('trainings', []);

        $dates = array_keys($trainingsData);
        sort($dates);

        $aggregatedDates = [];
        $lastDate = null;

        foreach ($dates as $date) {
            $currentDate = Carbon::parse($date);

            if (is_null($lastDate) || $currentDate->diffInHours($lastDate) >= 4) {
                // If there's a 4-hour difference, add just the day to the new array
                $aggregatedDates[] = $currentDate->toDateString();
                $lastDate = $currentDate;
            }
        }

        $aggregatedDates = implode(',', $aggregatedDates);

        return $aggregatedDates;
    }
}
