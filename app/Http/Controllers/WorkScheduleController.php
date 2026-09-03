<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WorkScheduleController extends Controller
{
    /**
     * ============================================================
     * HALAMAN JADWAL KERJA
     * ============================================================
     */

    /**
     * ============================================================
     * AMBIL EVENT UNTUK FULLCALENDAR
     * ============================================================
     */
    public function events(Request $request)
    {
        $query = WorkSchedule::with([
            'user:id,name,schedule_color'
        ]);

        /*
         * FullCalendar mengirim:
         * start = tanggal awal
         * end   = tanggal akhir
         *
         * end FullCalendar biasanya exclusive,
         * sehingga kita kurangi 1 hari.
         */

        if ($request->filled('start')) {
            $query->whereDate(
                'date',
                '>=',
                Carbon::parse($request->start)->format('Y-m-d')
            );
        }

        if ($request->filled('end')) {
            $end = Carbon::parse($request->end)
                ->subDay()
                ->format('Y-m-d');

            $query->whereDate('date', '<=', $end);
        }

        $schedules = $query
            ->orderBy('date')
            ->orderBy('user_id')
            ->get();

        $events = [];

        foreach ($schedules as $schedule) {

            /*
             * Jika user terhapus tetapi schedule masih ada,
             * jangan sampai menyebabkan error.
             */
            if (!$schedule->user) {
                continue;
            }

            $color = $schedule->user->schedule_color ?: '#6c757d';

            $events[] = [
                'id' => $schedule->id,

                'title' => $schedule->user->name,

                'start' => Carbon::parse($schedule->date)
                    ->format('Y-m-d'),

                'allDay' => true,

                'backgroundColor' => $color,

                'borderColor' => $color,

                'textColor' => '#ffffff',

                'extendedProps' => [
                    'date' => Carbon::parse($schedule->date)
                        ->format('Y-m-d'),

                    'user_id' => $schedule->user_id,

                    'user_name' => $schedule->user->name,

                    'schedule_color' => $color,
                ],
            ];
        }

        return response()->json($events);
    }


    /**
     * ============================================================
     * AMBIL JADWAL BERDASARKAN TANGGAL
     * ============================================================
     */
    public function byDate(Request $request)
    {
        $validated = $request->validate([
            'date' => [
                'required',
                'date',
            ],
        ]);

        $schedules = WorkSchedule::with([
            'user:id,name,schedule_color'
        ])
            ->whereDate('date', $validated['date'])
            ->orderBy('user_id')
            ->get();

        return response()->json([
            'success' => true,

            'date' => Carbon::parse($validated['date'])
                ->format('Y-m-d'),

            'users' => $schedules
                ->filter(function ($schedule) {
                    return $schedule->user !== null;
                })
                ->map(function ($schedule) {

                    return [
                        'id' => $schedule->id,

                        'user_id' => $schedule->user_id,

                        'user_name' => $schedule->user->name,

                        'schedule_color' =>
                            $schedule->user->schedule_color
                                ?: '#6c757d',
                    ];
                })
                ->values(),
        ]);
    }


    /**
     * ============================================================
     * SIMPAN JADWAL BARU
     * ============================================================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => [
                'required',
                'date',
            ],

            'user_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'user_ids.*' => [
                'required',
                'integer',
                'exists:users,id',
            ],
        ]);

        DB::transaction(function () use ($validated) {

            $date = Carbon::parse($validated['date'])
                ->format('Y-m-d');

            foreach (array_unique($validated['user_ids']) as $userId) {

                WorkSchedule::firstOrCreate([
                    'user_id' => $userId,
                    'date' => $date,
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil disimpan.',
        ]);
    }


    /**
     * ============================================================
     * UPDATE JADWAL
     *
     * Semua user pada tanggal tersebut akan disesuaikan
     * dengan pilihan terbaru.
     * ============================================================
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'date' => [
                'required',
                'date',
            ],

            'user_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'user_ids.*' => [
                'required',
                'integer',
                'exists:users,id',
            ],
        ]);

        DB::transaction(function () use ($validated) {

            $date = Carbon::parse($validated['date'])
                ->format('Y-m-d');

            /*
             * Hapus semua jadwal pada tanggal tersebut.
             */
            WorkSchedule::whereDate('date', $date)
                ->delete();

            /*
             * Buat ulang sesuai pilihan user.
             */
            foreach (array_unique($validated['user_ids']) as $userId) {

                WorkSchedule::create([
                    'user_id' => $userId,
                    'date' => $date,
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diperbarui.',
        ]);
    }


    /**
     * ============================================================
     * HAPUS SEMUA JADWAL PADA TANGGAL
     * ============================================================
     */
    public function destroyByDate(Request $request)
    {
        $validated = $request->validate([
            'date' => [
                'required',
                'date',
            ],
        ]);

        $date = Carbon::parse($validated['date'])
            ->format('Y-m-d');

        $deleted = WorkSchedule::whereDate('date', $date)
            ->delete();

        return response()->json([
            'success' => true,

            'message' => $deleted > 0
                ? 'Jadwal berhasil dihapus.'
                : 'Tidak ada jadwal pada tanggal tersebut.',
        ]);
    }


    /**
     * ============================================================
     * HAPUS SATU JADWAL
     * ============================================================
     */
    public function destroy($id)
    {
        $schedule = WorkSchedule::find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan.',
            ], 404);
        }

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus.',
        ]);
    }


    /**
     * ============================================================
     * UPDATE WARNA USER
     * ============================================================
     */
    public function updateUserColor(Request $request)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'schedule_color' => [
                'required',
                'string',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
        ]);

        $user = User::findOrFail($validated['user_id']);

        $user->schedule_color = $validated['schedule_color'];
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Warna jadwal user berhasil diperbarui.',

            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'schedule_color' => $user->schedule_color,
            ],
        ]);
    }
}
