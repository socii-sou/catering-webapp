<?php

namespace App\Exceptions;

use Exception;

class KapasitasTerlampauiException extends Exception
{
    public function __construct(public int $sisaKapasitas)
    {
        parent::__construct("Kapasitas pada tanggal tersebut sudah terlampaui. Sisa kapasitas: {$sisaKapasitas} pax.");
    }
}

