<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBugReportRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class BugReportController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(StoreBugReportRequest $request)
    {
        $user = auth()->user();

        $TULEAP_TOKEN = config('skeletor.services.tuleap.token');
        $TULEAP_URL = config('skeletor.services.tuleap.url');
        $TULEAP_TRACKER_BUGREPORT = config('skeletor.services.tuleap.tracker_bugreport');

        $response = Http::withoutVerifying()
            ->withHeaders(['X-Auth-AccessKey' => $TULEAP_TOKEN])
            ->post($TULEAP_URL.'api/artifacts', [
                'tracker' => ['id' => $TULEAP_TRACKER_BUGREPORT],
                'values_by_field' => [
                    'commentaire' => ['value' => $request->message],
                    'url' => ['value' => $request->url],
                    'user' => ['value' => $user->display_name],
                ],
            ])
        ;

        return redirect($request->url)->withSuccess('Message bien enregistré. Merci beaucoup.');
    }
}
