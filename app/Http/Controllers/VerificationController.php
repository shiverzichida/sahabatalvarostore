<?php

namespace App\Http\Controllers;

use App\Models\Verification;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        return view('verification.index');
    }

    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $verification = Verification::where('code', $request->code)->first();

        if ($verification) {
            if (!$verification->is_used) {
                $verification->update([
                    'is_used' => true,
                    'verified_at' => now(),
                ]);
                return back()->with('success', 'Produk ASLI! Ini adalah verifikasi pertama untuk kode ini.');
            } else {
                return back()->with('warning', 'Kode ini sudah pernah diverifikasi pada ' . $verification->verified_at->format('d M Y H:i') . '. Pastikan Anda membeli dari sumber resmi.');
            }
        }

        return back()->with('error', 'Maaf, kode verifikasi TIDAK DITEMUKAN. Produk mungkin palsu.');
    }
}
