<?php

namespace App\Http\Controllers;

// require_once __DIR__ . '/../../../vendor/autoload.php';

use Mpdf\Mpdf;
use App\Models\Budget;
use App\Models\Charge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PDFController extends Controller
{
    public function downloadPDF(Budget $budget)
    {
        $userId = auth()->id();

        // Retrieve budgets for the authenticated user and the selected fiscal year
        $budgets = Budget::where('user_id', $userId)
            ->where('fiscal_year', $budget->fiscal_year)
            ->get();

        if ($budgets->isEmpty()) {
            return redirect()->route('budgets.index')->with('error', 'No budgets found for the selected fiscal year.');
        }

        // Retrieve charges related to the budgets for the selected fiscal year
        $charges = Charge::where('user_id', $userId)
            ->where('fiscal_year', $budget->fiscal_year)
            ->get();

        $fiscal_year = $budget->fiscal_year;

        $html = view('budgets.pdf', compact('budgets', 'charges', 'fiscal_year', 'budget'))->render();

        // $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        // $fontDirs = $defaultConfig['fontDir'];

        // $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        // $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf([
            'mode' => 'UTF-8',
            'autoScriptToLang' => true,
            'autoLangToLang' => true,
            'format' => 'A4',
            'orientation' => 'p',
            'margin_left' => 10,
            'default_font' => 'bangla',
            // 'default_font' => 'solaimanlipi',
            // 'fontDir' => array_merge($fontDirs, [__DIR__ . '/../../../resources/fonts']),
            // 'fontdata' => $fontData + [
            //     'solaimanlipi' => [
            //         'R' => 'SolaimanLipi.ttf',
            //         'useOTL' => 0xFF,
            //         'useKashida' => 75,
            //     ]
            // ],
        ]);

        $mpdf->WriteHTML($html);

        return $mpdf->Output('budget-details.pdf', 'D');
    }
}
