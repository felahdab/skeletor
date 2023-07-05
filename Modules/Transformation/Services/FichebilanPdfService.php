<?php
namespace Modules\Transformation\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class FichebilanPdfService
{
    public static function fichebilanpdf(User $user)
    {
        $html = view('transformation::transformation.fichebilanpdf', ['user' => $user])->render();

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 
                            'format' => 'A4',
                            'margin_left' => 10,
                            'margin_right' => 10,
                            'margin_top' => 10,
                            'margin_bottom' => 10
                            ]);
        $mpdf->SetTitle('Fiche bilan');
        $mpdf->setFooter('{PAGENO}/{nb}');
        $mpdf->WriteHTML($html);
        $nomfic=date('Ymd')."_Fiche bilan ".$user->name."_".$user->prenom.".pdf";
        //echo $html;
        $mpdf->Output($nomfic,'I');
    }
}