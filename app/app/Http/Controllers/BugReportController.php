<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBugReportRequest;
use App\Http\Requests\UpdateBugReportRequest;
use App\Models\BugReport;

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
        $report = BugReport::create([
            "url" => $request->url,
            "message" => $request->message,
            "user_id" => $user->id,
            "username" => $user->displayString()
            ]);
        $report->save();
        return redirect($request->url);
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
