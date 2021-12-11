<?php

namespace App\Http\Controllers\Admin;

use App\Models\Marque;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MarquesController extends Controller
{
    public function index()
    {
        $marques = app(Pipeline::class)
            ->send(Marque::query())
            ->through([
                \App\QueryFilters\Marques\MarquesFilter::class,
                \App\QueryFilters\Sort::class,
            ])
            ->thenReturn()
            ->with('vehicules')
            ->latest()
            ->paginate(25);

        return view('admins.marques.index', compact('marques'));
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
            'id' => ['required', 'exists:App\Models\Marque,id', 'numeric'],
        ]);

        try{
            
            $marque = Marque::with('vehicules')->findOrFail($request->id);
            
            if(count($marque->vehicules) == 0){
                $marque->delete();
            }else{
                return redirect()->back()->withErrors(['message' => 'This marque has vehicules!']);
            }

        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }

        return redirect()->route('admin.marques.index');
    }

    public function clean(Request $request)
    {
        try{
            
            $marques = Marque::withCount('vehicules')->having('vehicules_count', 0)->get();

            foreach ($marques as $marque) {
                $marque->delete();
            }

        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }

        return redirect()->route('admin.marques.index');
    }
}
