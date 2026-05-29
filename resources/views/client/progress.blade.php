@extends('layouts.client')

@section('title', 'Progres & Statistik Fisik')

@section('content')
@php
    $latestProgress = $progressLogs->last();
@endphp
<div style="animation: fadeIn 0.8s ease-out;">
    <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 20px; background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Progres & Statistik Fisik</h2>
    
    <div class="progress-grid-layout" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px;">
        
        <!-- Chart.js Trend Line -->
        <div class="glass-card" style="padding: 24px; display: flex; flex-direction: column; min-height: 400px; justify-content: space-between;">
            <div>
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">Grafik Trend Perkembangan</h3>
                <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 16px;">Visualisasi perubahan berat badan dan kadar lemak tubuh (body fat) Anda dari waktu ke waktu.</p>
            </div>
            <div style="flex-grow: 1; min-height: 280px; position: relative;">
                <canvas id="progressChart" style="width: 100%; height: 100%;"></canvas>
            </div>
        </div>

        <!-- Log Form & History -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Input Progres Baru -->
            <div class="glass-card" style="padding: 24px;">
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px;">Catat Progres Baru</h3>
                <form action="{{ route('client.progress.store') }}" method="POST">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                        <div class="form-group mb-0">
                            <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Tanggal Log</label>
                            <input type="date" name="log_date" class="input-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Tinggi (cm)</label>
                            <input type="number" step="0.1" name="height" class="input-control" value="{{ $latestProgress ? number_format($latestProgress->height, 1, '.', '') : number_format($profile->initial_height, 1, '.', '') }}" required>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                        <div class="form-group mb-0">
                            <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Berat (kg)</label>
                            <input type="number" step="0.1" name="weight" class="input-control" value="{{ $latestProgress ? number_format($latestProgress->weight, 1, '.', '') : number_format($profile->initial_weight, 1, '.', '') }}" required>
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Body Fat % (Optional)</label>
                            <input type="number" step="0.1" name="body_fat" class="input-control" value="{{ $latestProgress && $latestProgress->body_fat ? number_format($latestProgress->body_fat, 1, '.', '') : ($profile->initial_body_fat ? number_format($profile->initial_body_fat, 1, '.', '') : '') }}">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Catatan (Optional)</label>
                        <input type="text" name="notes" class="input-control" placeholder="Contoh: Perut terasa lebih ramping" style="font-size: 14px;">
                    </div>
                    <button type="submit" class="submit-btn" style="background: linear-gradient(135deg, var(--accent-blue) 0%, #1e40af 100%); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2); width:100%; border:none; padding:12px; border-radius:10px; color:#fff; font-weight:700; cursor:pointer; font-size: 14px; transition: all 0.3s;">Simpan Progres</button>
                </form>
            </div>

            <!-- Riwayat Catatan -->
            <div class="glass-card" style="padding: 20px;">
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 12px;">Riwayat Log Progres</h3>
                <div style="max-height: 200px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.08); color: var(--text-muted);">
                                <th style="padding: 8px 4px;">Tanggal</th>
                                <th style="padding: 8px 4px;">BB (kg)</th>
                                <th style="padding: 8px 4px;">TB (cm)</th>
                                <th style="padding: 8px 4px;">Fat %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($progressLogs->reverse() as $log)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                                    <td style="padding: 8px 4px; color: #cbd5e1;">{{ date('d/m/Y', strtotime($log->log_date)) }}</td>
                                    <td style="padding: 8px 4px; font-weight:700; color: #fff;">{{ number_format($log->weight, 1) }}</td>
                                    <td style="padding: 8px 4px; color: #cbd5e1;">{{ number_format($log->height, 1) }}</td>
                                    <td style="padding: 8px 4px; color: #cbd5e1;">{{ $log->body_fat ? number_format($log->body_fat, 1) . '%' : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup Chart.js untuk Progres Fisik
        const progressData = @json($progressLogs);
        const chartLabels = progressData.map(log => {
            const date = new Date(log.log_date);
            return date.getDate().toString().padStart(2, '0') + '/' + (date.getMonth() + 1).toString().padStart(2, '0');
        });
        const weightData = progressData.map(log => parseFloat(log.weight));
        const bodyFatData = progressData.map(log => log.body_fat ? parseFloat(log.body_fat) : null);

        const ctx = document.getElementById('progressChart').getContext('2d');
        const progressChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Berat Badan (kg)',
                        data: weightData,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.3,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Body Fat (%)',
                        data: bodyFatData,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.05)',
                        borderWidth: 2,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.3,
                        yAxisID: 'y1',
                        spanGaps: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#cbd5e1',
                            font: {
                                family: "'Outfit', sans-serif",
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#fff',
                        bodyColor: '#cbd5e1',
                        borderColor: 'rgba(255,255,255,0.08)',
                        borderWidth: 1,
                        padding: 10,
                        titleFont: { family: "'Outfit', sans-serif" },
                        bodyFont: { family: "'Outfit', sans-serif" }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.03)'
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: { family: "'Outfit', sans-serif" }
                        }
                    },
                    y: {
                        position: 'left',
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        },
                        ticks: {
                            color: '#3b82f6',
                            font: { family: "'Outfit', sans-serif" }
                        },
                        title: {
                            display: true,
                            text: 'Berat (kg)',
                            color: '#3b82f6',
                            font: { family: "'Outfit', sans-serif", weight: 'bold' }
                        }
                    },
                    y1: {
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            color: '#10b981',
                            font: { family: "'Outfit', sans-serif" }
                        },
                        title: {
                            display: true,
                            text: 'Body Fat (%)',
                            color: '#10b981',
                            font: { family: "'Outfit', sans-serif", weight: 'bold' }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
