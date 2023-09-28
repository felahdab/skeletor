@php
$libunite='';
if ($row->unite_id){
    $unite = $row->unite()->first();
    $libunite= $unite->unite_libcourt;
}
echo $libunite;
@endphp
