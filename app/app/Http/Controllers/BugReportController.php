<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBugReportRequest;
use App\Http\Requests\UpdateBugReportRequest;
use App\Models\BugReport;

use Illuminate\Support\Facades\Http;

class BugReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBugReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBugReportRequest $request)
    {
        $user = auth()->user();
        
        $response = Http::withoutVerifying()
            ->withHeaders(["X-Auth-AccessKey" => env("TULEAP_TOKEN")])
            ->post(env("TULEAP_URL") . "api/artifacts", [
                "tracker" =>  ["id" => env('TULEAP_TRACKER_BUGREPORT') ],
                "values_by_field" => [
                    "commentaire"    => [ "value" => $request->message ],
                    "url"=>  ["value"  => $request->url ],
                    "user"=> ["value" => $user->display_name]
                ]
            ]);
        
        return redirect($request->url)->withSuccess("Message bien enregistré. Merci beaucoup.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BugReport  $bugReport
     * @return \Illuminate\Http\Response
     */
    public function show(BugReport $bugReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BugReport  $bugReport
     * @return \Illuminate\Http\Response
     */
    public function edit(BugReport $bugReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBugReportRequest  $request
     * @param  \App\Models\BugReport  $bugReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBugReportRequest $request, BugReport $bugReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BugReport  $bugReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(BugReport $bugReport)
    {
        //
    }
}
