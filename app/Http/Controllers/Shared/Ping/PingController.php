<?php

namespace App\Http\Controllers\Ping;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PingController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json('Service is online');
    }
}
