<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ConsolidateConfig;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    //

    public function index()
    {
        return view('superadmin.configuration');
    }

    // Update Consolidate Day Configuration
    public function store(Request $request)
    {
        $item = ConsolidateConfig::updateOrCreate(
            ['day' => $request->prevDay],
            ['day' => $request->day]
        );
        return response()->json(['success' => 'Consolidate Configured']);
    }

    // fetch consolidate date   
    public function fetch()
    {
        return response()->json(ConsolidateConfig::all());
    }

}
