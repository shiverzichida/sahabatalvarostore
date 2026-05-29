<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitaminSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_name',
        'client_code',
        'vitamin_name',
        'dosage',
        'start_date',
        'end_date',
        'frequency',
        'days_of_week',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to check if a specific date falls on this schedule.
     */
    public function getEvents()
    {
        $events = [];
        
        // Jika frekuensi sekali saja (once)
        if ($this->frequency === 'once') {
            $events[] = [
                'id' => $this->id . '_' . $this->start_date,
                'title' => $this->vitamin_name . ' (' . $this->dosage . ')',
                'start' => $this->start_date,
                'description' => $this->notes ?? '',
                'className' => 'event-vitamin',
                'allDay' => true
            ];
            return $events;
        }

        $start = new \DateTime($this->start_date);
        $end = new \DateTime($this->end_date);
        $end->modify('+1 day'); // Include the end date

        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($start, $interval, $end);

        $days = $this->days_of_week ? explode(',', $this->days_of_week) : [];

        $counter = 0;
        foreach ($period as $date) {
            $current_date_str = $date->format('Y-m-d');
            $day_name = $date->format('l'); // e.g., "Monday"
            $should_add = false;

            if ($this->frequency === 'daily') {
                $should_add = true;
            } elseif ($this->frequency === 'every_other_day') {
                if ($counter % 2 === 0) {
                    $should_add = true;
                }
            } elseif ($this->frequency === 'twice_weekly') {
                if (in_array($day_name, $days)) {
                    $should_add = true;
                }
            }

            if ($should_add) {
                $events[] = [
                    'id' => $this->id . '_' . $current_date_str,
                    'title' => $this->vitamin_name . ' (' . $this->dosage . ')',
                    'start' => $current_date_str,
                    'description' => $this->notes ?? '',
                    'className' => 'event-vitamin',
                    'allDay' => true
                ];
            }
            $counter++;
        }

        return $events;
    }
}
