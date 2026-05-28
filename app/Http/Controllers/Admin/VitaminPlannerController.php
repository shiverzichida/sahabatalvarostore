<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VitaminSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VitaminPlannerController extends Controller
{
    public function index()
    {
        $schedules = VitaminSchedule::orderBy('created_at', 'desc')->get();
        return view('admin.planner.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_code' => 'nullable|string|max:50',
            'vitamin_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'frequency' => 'required|string|in:daily,every_other_day,twice_weekly',
            'days_of_week' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        // Generate client code jika kosong
        $client_code = $request->client_code;
        if (empty($client_code)) {
            // Check if there is an existing code for the same client name
            $existing = VitaminSchedule::where('client_name', $request->client_name)->first();
            if ($existing) {
                $client_code = $existing->client_code;
            } else {
                $client_code = 'SA-' . strtoupper(Str::random(5));
            }
        } else {
            $client_code = strtoupper($client_code);
        }

        $days = $request->days_of_week ? implode(',', $request->days_of_week) : null;

        VitaminSchedule::create([
            'client_name' => $request->client_name,
            'client_code' => $client_code,
            'vitamin_name' => $request->vitamin_name,
            'dosage' => $request->dosage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'frequency' => $request->frequency,
            'days_of_week' => $days,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.planner.index')->with('success', 'Jadwal vitamin berhasil ditambahkan untuk client dengan kode: ' . $client_code);
    }

    public function destroy(VitaminSchedule $planner)
    {
        $planner->delete();
        return redirect()->route('admin.planner.index')->with('success', 'Jadwal vitamin berhasil dihapus.');
    }
}
