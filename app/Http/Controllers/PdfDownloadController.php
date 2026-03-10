<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Publication;

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader\PdfReader;
use setasign\Fpdi\PdfReader\PageBoundaries;

class PdfDownloadController extends Controller
{
    // public function download($id)
    // {
    //     $publication = Publication::findOrFail($id); // ✅ OK

    //     $filePath = storage_path('app/public/' . $publication->pdf);

    //     if (!file_exists($filePath)) {
    //         abort(404);
    //     }

    //     $pdf = new Fpdi();
    //     $pageCount = $pdf->setSourceFile($filePath);

    //     for ($i = 1; $i <= $pageCount; $i++) {
    //         $tplId = $pdf->importPage($i);
    //         $size = $pdf->getTemplateSize($tplId);

    //         $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
    //         $pdf->useTemplate($tplId);

    //         // Watermark text
    //         $pdf->SetFont('Helvetica', 'B', 30);
    //         $pdf->SetTextColor(178, 31, 44); // equivalent to #B21F2C
    //         $pdf->SetXY($size['width']/4, $size['height']/2);
    //         $pdf->Write(0, '© MySITE');
    //     }

    //    return response($pdf->Output('S'))
    //      ->header('Content-Type', 'application/pdf')
    //      ->header('Content-Disposition', 'attachment; filename="' . $publication->title . '.pdf"');

    // }

    public function download($id)
    {
        $publication = Publication::findOrFail($id);
        $filePath = storage_path('app/public/' . $publication->pdf);

        if (!file_exists($filePath)) {
            abort(404);
        }

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($filePath);

        for ($i = 1; $i <= $pageCount; $i++) {

            $tplId = $pdf->importPage($i);
            $size  = $pdf->getTemplateSize($tplId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);

            // -------- WATERMARK ----------
            $pdf->SetFont('Helvetica', 'B', 18);
            $pdf->SetTextColor(255, 180, 180);
            $watermark = 'SAMPLE';

            for ($x = -50; $x < $size['width']; $x += 80) {
                for ($y = 20; $y < $size['height']; $y += 60) {

                    // manual rotation workaround
                    $pdf->SetXY($x, $y);
                    $pdf->Text($x, $y, $watermark);
                }
            }
            // -----------------------------
        }

        return response($pdf->Output('S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="sample.pdf"');
    }
}
