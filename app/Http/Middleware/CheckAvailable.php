<?php

namespace App\Http\Middleware;

use App\Models\NotAvailable;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CheckAvailable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $validator = Validator::make($request->all(), [
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->first(),
                ], 400);
            }

            $validated = $validator->validated();
            $startTime = $validated['start_time'];
            $endTime = $validated['end_time'];

            $isConflict = NotAvailable::where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })->exists();

            if ($isConflict) {
                $response = [
                    'success' => false,
                    'message' => 'Rentang waktu tidak tersedia, Silahkan pilih rentang waktu lain!',
                    'data'    => null,
                ];
                return response()->json($response, 400);
            }

            return $next($request);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'data'    => null,
            ];
            return response()->json($response, 500);
        }
    }
}
