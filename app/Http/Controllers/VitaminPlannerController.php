<?php

namespace App\Http\Controllers;

use App\Models\VitaminSchedule;
use App\Models\ScheduleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;

class VitaminPlannerController extends Controller
{
    /**
     * Show the logged-in client dashboard with their interactive calendar and request form.
     */
    public function dashboard()
    {
        $user = Auth::user();
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

        return view('client.dashboard', compact('schedules', 'events', 'requests', 'products'));
    }

    public function storeRequest(Request $request)
    {
        $request->validate([
            'vitamin_select' => 'required|string',
            'vitamin_manual' => 'required_if:vitamin_select,__manual__|nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $vitaminName = $request->vitamin_select;
        if ($vitaminName === '__manual__') {
            $vitaminName = $request->vitamin_manual;
        }

        ScheduleRequest::create([
            'user_id' => Auth::id(),
            'vitamin_name' => $vitaminName,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

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
}
