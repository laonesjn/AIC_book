<?php

namespace App\PDF;

use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;
use setasign\Fpdi\PdfReader\PdfReader;
use setasign\Fpdi\PdfReader\PageBoundaries;

use setasign\Fpdi\PdfParser\StreamReader;

// If Rotate() is missing, use this extended class instead of plain Fpdi:
class FpdiWithRotate extends Fpdi
{
    public function Rotate(float $angle, float $x = -1, float $y = -1): void
    {
        if ($x === -1) $x = $this->x;
        if ($y === -1) $y = $this->y;

        if ($this->angle !== 0) {
            $this->_out('Q');
        }

        $this->angle = $angle;

        if ($angle !== 0) {
            $angle  = $angle * M_PI / 180;
            $c      = cos($angle);
            $s      = sin($angle);
            $cx     = $x  * $this->k;
            $cy     = ($this->h - $y) * $this->k;
            $this->_out(sprintf(
                'q %.5F %.5F %.5F %.5F %.2F %.2F cm',
                $c, $s, -$s, $c, $cx + $s * $cy - $c * $cx, $cy - $c * $cy - $s * $cx
            ));
        }
    }

    public function StartTransform(): void { $this->_out('q'); }
    public function StopTransform(): void  { $this->_out('Q'); }

    protected float $angle = 0;
}