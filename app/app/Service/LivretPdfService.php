<?php
namespace App\Service;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class LivretPdfService
{
    public static function livretpdf(User $user, $mode)
    {
        $pathbrest = Storage::path('public/livret-gtr-brest.jpg');
        $pathtln = Storage::path('public/livret-gtr-toulon.jpg');

        $html = view('transformation.livretpdf', ['user' => $user,
            'pathbrest' => $pathbrest,
            'pathtln'   => $pathtln])->render();

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 
                            'format' => 'A4',
                            'margin_left' => 10,
                            'margin_right' => 10,
                            'margin_top' => 15,
                            'margin_bottom' => 15
                            ]);
        $mpdf->SetTitle('Livret de transformation');
        $mpdf->setFooter('{PAGENO}/{nb}');
        $mpdf->WriteHTML($html);
        $nomfic=date('Ymd')."_Livret de transformation de ".$user->name."_".$user->prenom.".pdf";
        
        if($mode=='archiv'){
            //sauvegarde sur serveur
            $filename=Storage::disk('local')->path('livrets/' . $nomfic);
            $mpdf->Output($filename,'F');
        }
        else {
            $mpdf->Output($nomfic,'D');
        }
    }
}