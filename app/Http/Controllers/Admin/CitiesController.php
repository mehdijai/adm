<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
    public function index()
    {
        $cities = app(Pipeline::class)
            ->send(City::query())
            ->through([
                \App\QueryFilters\Cities\CitiesFilter::class,
                \App\QueryFilters\Sort::class,
            ])
            ->thenReturn()
            ->with('agences')
            ->latest()
            ->paginate(25);

        return view('admins.cities.index', compact('cities'));
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request)
    {
        
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:App\Models\City,id', 'numeric'],
        ]);

        try{
            
            $city = City::with('agences')->findOrFail($request->id);
            
            if(count($city->agences) == 0){
                $city->delete();
            }else{
                return redirect()->back()->withErrors(['message' => 'This city has agencies!']);
            }

        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }

        return redirect()->route('admin.cities.index');
    }

    public function clean(Request $request)
    {
        try{
            
            $cities = City::withCount('agences')->having('agences_count', 0)->get();

            foreach ($cities as $city) {
                $city->delete();
            }

        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }

        return redirect()->route('admin.cities.index');
    }
}
