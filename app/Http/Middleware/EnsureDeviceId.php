<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EnsureDeviceId
{
    /**
     * Memastikan setiap request memiliki 'sigap_device_id' unik.
     * Jika request belum memiliki cookie sigap_device_id, generate UUID/ID baru
     * dan pasang ke request attributes serta attach cookie ke response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $deviceId = $request->cookie('sigap_device_id')
            ?? $request->input('device_id')
            ?? $request->header('X-Device-Id');

        $isNew = false;
        if (empty($deviceId) || ! is_string($deviceId)) {
            $deviceId = 'dev_' . Str::random(24);
            $isNew = true;
        }

        // Simpan ke atribut request agar controller mudah membaca
        $request->attributes->set('sigap_device_id', $deviceId);

        /** @var Response $response */
        $response = $next($request);

        // Jika cookie baru atau belum ada di browser, kirim cookie berumur 1 tahun
        if ($isNew || ! $request->hasCookie('sigap_device_id')) {
            $response->headers->setCookie(
                cookie(
                    name: 'sigap_device_id',
                    value: $deviceId,
                    minutes: 60 * 24 * 365,
                    path: '/',
                    domain: null,
                    secure: null,
                    httpOnly: false, // Boleh diakses JS agar sinkron
                    raw: false,
                    sameSite: 'lax'
                )
            );
        }

        return $response;
    }
}
