<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VitaminSchedule;
use App\Models\ScheduleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VitaminPlannerController extends Controller
{
    public function index(Request $request)
    {
        $schedules = VitaminSchedule::orderBy('created_at', 'desc')->get();
        $clients = User::orderBy('name', 'asc')->get();
        $pendingRequests = ScheduleRequest::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // Prefill logic dari request client
        $prefill = [
            'request_id' => $request->query('request_id'),
            'user_id' => $request->query('user_id'),
            'client_name' => $request->query('client_name'),
            'vitamin_name' => $request->query('vitamin_name'),
            'notes' => $request->query('notes'),
        ];

        return view('admin.planner.index', compact('schedules', 'clients', 'pendingRequests', 'prefill'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_type' => 'required|string|in:registered,manual',
            'user_id' => 'required_if:client_type,registered|nullable|exists:users,id',
            'client_name' => 'required_if:client_type,manual|nullable|string|max:255',
            'client_code' => 'nullable|string|max:50',
            'vitamin_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required_unless:frequency,once|nullable|date|after_or_equal:start_date',
            'frequency' => 'required|string|in:once,daily,every_other_day,twice_weekly',
            'days_of_week' => 'nullable|array',
            'notes' => 'nullable|string',
            'request_id' => 'nullable|exists:schedule_requests,id', // Untuk update status request
        ]);

        // Tentukan nama client & user_id
        $user_id = null;
        $client_name = '';

        if ($request->client_type === 'registered') {
            $user = User::findOrFail($request->user_id);
            $user_id = $user->id;
            $client_name = $user->name;
        } else {
            $client_name = $request->client_name;
        }

        // Generate client code jika kosong
        $client_code = $request->client_code;
        if (empty($client_code)) {
            // Cek jika client ini sudah punya kode dari jadwal sebelumnya
            $existingQuery = VitaminSchedule::query();
            if ($user_id) {
                $existingQuery->where('user_id', $user_id);
            } else {
                $existingQuery->where('client_name', $client_name);
            }
            $existing = $existingQuery->first();

            if ($existing) {
                $client_code = $existing->client_code;
            } else {
                $client_code = 'SA-' . strtoupper(Str::random(5));
            }
        } else {
            $client_code = strtoupper($client_code);
        }

        $days = $request->days_of_week ? implode(',', $request->days_of_week) : null;
        
        // Jika frekuensi sekali saja (once), set end_date sama dengan start_date
        $end_date = $request->frequency === 'once' ? $request->start_date : $request->end_date;

        VitaminSchedule::create([
            'user_id' => $user_id,
            'client_name' => $client_name,
            'client_code' => $client_code,
            'vitamin_name' => $request->vitamin_name,
            'dosage' => $request->dosage,
            'start_date' => $request->start_date,
            'end_date' => $end_date,
            'frequency' => $request->frequency,
            'days_of_week' => $days,
            'notes' => $request->notes,
        ]);

        // Jika ini approval dari request, ubah status request tersebut
        if ($request->filled('request_id')) {
            $scheduleRequest = ScheduleRequest::find($request->request_id);
            if ($scheduleRequest) {
                $scheduleRequest->update(['status' => 'approved']);
            }
        }

        return redirect()->route('admin.planner.index')->with('success', 'Jadwal vitamin berhasil ditambahkan untuk client: ' . $client_name);
    }

    public function destroy(VitaminSchedule $planner)
    {
        $planner->delete();
        return redirect()->route('admin.planner.index')->with('success', 'Jadwal vitamin berhasil dihapus.');
    }
}
