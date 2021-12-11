<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plan::paginate(25);
        return view('admins.premium.plans')->with(['plans' => $plans]);
    }

    public function edit($id)
    {
        if(!filter_var($id, FILTER_VALIDATE_INT)){
            abort(404);
            // return redirect()->route('admin.admins.index');
        }

        try{

            $plan = Plan::findOrFail($id);

        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }

        return view('admins.premium.edit')->with(['plan' => $plan]);
        
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:App\Models\Plan,id', 'numeric'],
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'max_vehs' => ['required', 'numeric'],
            'features' => ['required', 'string'],
        ]);

        // dd($request->all());
        Plan::where('id', $request->id)->update($request->except(['_token', 'new-offer']));

        return redirect()->route('admin.plans.index');
    }
}
