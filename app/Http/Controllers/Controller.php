<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Catering Webapp API',
    description: 'Dokumentasi API untuk sistem pemesanan paket katering (role Penjual & Pelanggan).'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'Sanctum Token',
    description: 'Login dulu lewat /login, lalu isi token yang didapat di sini (tanpa kata "Bearer").'
)]
abstract class Controller
{
    use AuthorizesRequests;
}