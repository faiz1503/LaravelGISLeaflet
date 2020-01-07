<?php

namespace App\Http\Controllers\Api;

use App\Kebun;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Kebun as KebunResource;

class KebunController extends Controller
{
    /**
     * Get outlet listing on Leaflet JS geoJSON data structure.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $kebuns = Kebun::all();

        $geoJSONdata = $kebuns->map(function ($kebun) {
            return [
                'type'       => 'Feature',
                'properties' => new KebunResource($kebun),
                'geometry'   => [
                    'type'        => 'Point',
                    'coordinates' => [
                        $kebun->longitude,
                        $kebun->latitude,
                    ],
                ],
            ];
        });

        return response()->json([
            'type'     => 'FeatureCollection',
            'features' => $geoJSONdata,
        ]);
    }
}
