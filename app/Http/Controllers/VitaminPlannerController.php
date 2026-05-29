<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VitaminSchedule;
use App\Models\ScheduleRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ClientProfile;
use App\Models\ClientProgressLog;

class VitaminPlannerController extends Controller
{
    /**
     * Show the logged-in client dashboard with their interactive calendar and request form.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Cek jika profile belum di-setup
        if (!$user->profile) {
            return view('client.profile_setup');
        }

        $profile = $user->profile;
        $progressLogs = $user->progressLogs;

        $schedules = VitaminSchedule::where('user_id', $user->id)->get();

        // Compile all calendar events
        $events = [];
        foreach ($schedules as $schedule) {
            $events = array_merge($events, $schedule->getEvents());
        }

        // Fetch client requests
        $requests = ScheduleRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch active products for select dropdown
        $products = Product::where('is_active', true)->orderBy('name', 'asc')->get();

        return view('client.dashboard', compact('schedules', 'events', 'requests', 'products', 'profile', 'progressLogs'));
    }

    public function storeRequest(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.vitamin_select' => 'required|string',
            'items.*.vitamin_manual' => 'required_if:items.*.vitamin_select,__manual__|nullable|string|max:255',
            'items.*.dosage' => 'nullable|string|max:255',
            'items.*.notes' => 'nullable|string',
        ]);

        foreach ($request->items as $item) {
            $vitaminName = $item['vitamin_select'];
            if ($vitaminName === '__manual__') {
                $vitaminName = $item['vitamin_manual'];
            }

            ScheduleRequest::create([
                'user_id' => Auth::id(),
                'vitamin_name' => $vitaminName,
                'dosage' => $item['dosage'] ?? null,
                'notes' => $item['notes'] ?? null,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('client.dashboard')->with('success', 'Permintaan suplemen/vitamin berhasil dikirim ke admin.');
    }

    /**
     * Show the interactive calendar for a specific client (public sharing link).
     */
    public function show($code)
    {
        $code = strtoupper($code);
        $schedules = VitaminSchedule::where('client_code', $code)->get();

        if ($schedules->isEmpty()) {
            abort(404, 'Jadwal planner tidak ditemukan untuk kode client ini.');
        }

        $client_name = $schedules->first()->client_name;

        // Compile all events
        $events = [];
        foreach ($schedules as $schedule) {
            $events = array_merge($events, $schedule->getEvents());
        }

        return view('planner.show', compact('schedules', 'events', 'client_name', 'code'));
    }

    /**
     * Export all events for a client as an iCalendar (.ics) file.
     */
    public function exportIcs($code)
    {
        $code = strtoupper($code);
        $schedules = VitaminSchedule::where('client_code', $code)->get();

        if ($schedules->isEmpty()) {
            abort(404);
        }

        $client_name = $schedules->first()->client_name;

        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="jadwal-vitamin-' . strtolower($code) . '.ics"');

        $output = "BEGIN:VCALENDAR\r\n";
        $output .= "VERSION:2.0\r\n";
        $output .= "PRODID:-//Sahabat Alvaro Store//Vitamin Planner//EN\r\n";
        $output .= "CALSCALE:GREGORIAN\r\n";

        foreach ($schedules as $schedule) {
            $events = $schedule->getEvents();
            foreach ($events as $event) {
                $uid = md5($event['id']) . '@sahabatalvaro.store';
                $start_date = str_replace('-', '', $event['start']); // YYYYMMDD
                $end_date = date('Ymd', strtotime($event['start'] . ' +1 day')); // Excluded end date

                $output .= "BEGIN:VEVENT\r\n";
                $output .= "UID:" . $uid . "\r\n";
                $output .= "DTSTAMP:" . gmdate('Ymd\THis\Z') . "\r\n";
                $output .= "DTSTART;VALUE=DATE:" . $start_date . "\r\n";
                $output .= "DTEND;VALUE=DATE:" . $end_date . "\r\n";
                $output .= "SUMMARY:[SA Store] " . $event['title'] . "\r\n";
                $output .= "DESCRIPTION:" . str_replace("\n", "\\n", $event['description']) . "\r\n";
                $output .= "END:VEVENT\r\n";
            }
        }

        $output .= "END:VCALENDAR\r\n";
        echo $output;
        exit;
    }

    /**
     * Store the client's initial physical profile.
     */
    public function storeProfile(Request $request)
    {
        $request->validate([
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'initial_height' => 'required|numeric|min:30|max:300',
            'initial_weight' => 'required|numeric|min:10|max:500',
            'initial_body_fat' => 'nullable|numeric|min:1|max:100',
            'goal' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        // Buat profile
        ClientProfile::create([
            'user_id' => $user->id,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'initial_height' => $request->initial_height,
            'initial_weight' => $request->initial_weight,
            'initial_body_fat' => $request->initial_body_fat,
            'goal' => $request->goal,
        ]);

        // Catat sebagai log pertama
        ClientProgressLog::create([
            'user_id' => $user->id,
            'log_date' => now()->format('Y-m-d'),
            'weight' => $request->initial_weight,
            'height' => $request->initial_height,
            'body_fat' => $request->initial_body_fat,
            'notes' => 'Setup Baseline Profil Awal',
        ]);

        return redirect()->route('client.dashboard')->with('success', 'Profil awal berhasil disimpan! Selamat datang di dashboard progres Anda.');
    }

    /**
     * Store or update weekly progress logs.
     */
    public function storeProgress(Request $request)
    {
        $request->validate([
            'log_date' => 'required|date',
            'weight' => 'required|numeric|min:10|max:500',
            'height' => 'required|numeric|min:30|max:300',
            'body_fat' => 'nullable|numeric|min:1|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        ClientProgressLog::updateOrCreate(
            [
                'user_id' => $user->id,
                'log_date' => $request->log_date,
            ],
            [
                'weight' => $request->weight,
                'height' => $request->height,
                'body_fat' => $request->body_fat,
                'notes' => $request->notes,
            ]
        );

        return redirect()->route('client.dashboard')->with('success', 'Data progres mingguan berhasil dicatat.');
    }
}
