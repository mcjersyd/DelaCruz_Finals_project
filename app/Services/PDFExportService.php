<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;

class PDFExportService
{
    /**
     * Export brands to PDF
     */
    public function exportBrands($brands, $filename = null)
    {
        $filename = $filename ?? 'brands_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        
        $pdf = Pdf::loadView('exports.brands-pdf', ['brands' => $brands]);
        return $pdf->download($filename);
    }

    /**
     * Export vehicles to PDF
     */
    public function exportVehicles($vehicles, $filename = null)
    {
        $filename = $filename ?? 'vehicles_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        
        $pdf = Pdf::loadView('exports.vehicles-pdf', ['vehicles' => $vehicles]);
        return $pdf->download($filename);
    }
}
