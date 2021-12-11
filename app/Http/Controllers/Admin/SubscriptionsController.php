<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\QueryFilters\Sort;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Notifications\User\SubActivated;
use App\QueryFilters\Subscriptions\ShowOnly;
use App\QueryFilters\Subscriptions\SubscriptionsFilter;
use App\Models\Vehicule;

class SubscriptionsController extends Controller
{
    public function index()
    {
        $subscriptions = app(Pipeline::class)
            ->send(Subscription::query())
            ->through([
                \App\QueryFilters\Subscriptions\SubscriptionsFilter::class,
                \App\QueryFilters\Subscriptions\ShowOnly::class,
                \App\QueryFilters\Sort::class,
            ])
            ->thenReturn()
            ->with(['user.agence', 'plan'])
            ->paginate(25);

        return view('admins.premium.subscriptions')->with(['subscriptions' => $subscriptions]);
    }

    public function activate_subscription(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:App\Models\Subscription,id', 'numeric'],
        ]);

        $sub = Subscription::findOrFail($request->id);
        $sub->active = true;
        $sub->activation_date = Carbon::now();
        $sub->save();

        $ids = json_decode($sub->vehicules_ids);
        Vehicule::updateScore($ids, $sub);

        $sub->notify(new SubActivated());

        return redirect()->route('admin.subscriptions.index');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:App\Models\Subscription,id', 'numeric'],
        ]);

        try{

            $sub = Subscription::find($request->id);
            $ids = json_decode($sub->vehicules_ids);
            $sub->delete();

            $sub = Subscription::find($request->id);
            Vehicule::updateScore($ids, $sub);


        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }

        return redirect()->route('admin.subscriptions.index');
        
    }
}
