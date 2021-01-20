<?php

namespace App\Http\Controllers;

use App\Exceptions\BaseMovieServiceUnavailableException;
use App\Services\MovieSelector;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getTitles(Request $request, MovieSelector $movieSelector): JsonResponse
    {
        try {
            $movieList = $movieSelector->getTitles();
        } catch (BaseMovieServiceUnavailableException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'status' => 'failure',
            ]);
        }

        return response()->json($movieList);
    }
}
