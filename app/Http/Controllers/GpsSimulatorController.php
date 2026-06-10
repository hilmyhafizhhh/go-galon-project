<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Task;
use App\Models\TrackingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * GPS Simulator — HANYA untuk demo/testing (TA, presentasi, dll)
 * Hapus atau disable di production nyata.
 */
class GpsSimulatorController extends Controller
{
    /**
     * Halaman simulator — pilih task lalu jalankan simulasi.
     */
    public function index()
    {
        $tasks = Task::with(['order.user', 'order.address'])
            ->where('status', 'picked_up')
            ->latest()
            ->get();

        return view('simulator.index', compact('tasks'));
    }

    /**
     * Ambil rute OSRM dari depot → tujuan order.
     * Dipanggil JS saat halaman simulator load.
     */
    public function getRoute(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);

        $task    = Task::with('order.address')->findOrFail($request->task_id);
        $address = $task->order->address;

        if (!$address?->latitude || !$address?->longitude) {
            return response()->json(['success' => false, 'message' => 'Alamat tidak punya koordinat.'], 422);
        }

        $depotLat = -6.1413375;
        $depotLng = 106.7869347;
        $destLat  = (float) $address->latitude;
        $destLng  = (float) $address->longitude;

        // Minta rute dari OSRM (server-side)
        $url = "https://router.project-osrm.org/route/v1/driving/{$depotLng},{$depotLat};{$destLng},{$destLat}?overview=full&geometries=geojson&steps=true";

        try {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 8,
                CURLOPT_USERAGENT      => 'DeliveryApp-Simulator/1.0',
            ]);
            $body   = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($status !== 200 || !$body) {
                throw new \Exception('OSRM tidak merespons');
            }

            $data = json_decode($body, true);

            if (empty($data['routes'])) {
                throw new \Exception('Rute tidak ditemukan');
            }

            $route    = $data['routes'][0];
            $coords   = array_map(fn($c) => [$c[1], $c[0]], $route['geometry']['coordinates']);
            $distKm   = round($route['distance'] / 1000, 1);
            $etaMins  = ceil($route['duration'] / 60);

            return response()->json([
                'success'   => true,
                'task_id'   => $task->id,
                'order_id'  => $task->order_id,
                'coords'    => $coords,      // array of [lat, lng]
                'dist_km'   => $distKm,
                'eta_mins'  => $etaMins,
                'dest_lat'  => $destLat,
                'dest_lng'  => $destLng,
                'depot_lat' => $depotLat,
                'depot_lng' => $depotLng,
            ]);

        } catch (\Exception $e) {
            // Fallback: garis lurus depot → tujuan
            return response()->json([
                'success'   => true,
                'task_id'   => $task->id,
                'order_id'  => $task->order_id,
                'coords'    => [[$depotLat, $depotLng], [$destLat, $destLng]],
                'dist_km'   => null,
                'eta_mins'  => null,
                'dest_lat'  => $destLat,
                'dest_lng'  => $destLng,
                'depot_lat' => $depotLat,
                'depot_lng' => $depotLng,
                'fallback'  => true,
                'error'     => $e->getMessage(),
            ]);
        }
    }

    /**
     * Inject satu titik koordinat ke tracking_logs —
     * seolah-olah GPS kurir mengirim data real.
     * Dipanggil JS setiap langkah simulasi.
     */
    public function injectPoint(Request $request)
    {
        $request->validate([
            'task_id'   => 'required|exists:tasks,id',
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'speed'     => 'nullable|numeric|min:0',
        ]);

        $task  = Task::with('order')->findOrFail($request->task_id);
        $kurir = Courier::where('user_id', $task->courier_id)->first();

        if (!$kurir) {
            // Coba cari kurir berdasarkan courier_id langsung (jika courier_id = couriers.id)
            $kurir = Courier::find($task->courier_id);
        }

        // Simpan tracking log
        TrackingLog::create([
            'courier_id'  => $kurir?->id ?? $task->courier_id,
            'order_id'    => $task->order_id,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'speed'       => $request->speed ?? rand(20, 45),
            'recorded_at' => now(),
        ]);

        // Update posisi terakhir kurir
        if ($kurir) {
            $kurir->update([
                'last_known_lat' => $request->latitude,
                'last_known_lng' => $request->longitude,
            ]);
        }

        return response()->json(['success' => true]);
    }
}