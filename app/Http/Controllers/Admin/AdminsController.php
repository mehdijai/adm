<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\QueryFilters\Admins\IsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Actions\Jetstream\DeleteUser;
use App\QueryFilters\Admins\AdminsFilter;

class AdminsController extends Controller
{
    public function index()
    {

        $admins = app(Pipeline::class)
            ->send(User::query())
            ->through([
                \App\QueryFilters\Admins\IsAdmin::class,
                \App\QueryFilters\Admins\AdminsFilter::class,
                \App\QueryFilters\Sort::class,
            ])
            ->thenReturn()
            ->latest()
            ->paginate(25);

        return view('admins.admins.index')->with(['admins' => $admins]);
    }

    public function create()
    {
        return view('admins.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'cin' => ['required', 'string', 'unique:users'],
        ]);

        try{

            $user = User::create(array_merge($request->except(['_token']), ['role_id' => 2, 'password' => Hash::make($request->cin . '_')]));

        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }

        return redirect()->route('admin.admins.index');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:App\Models\User,id', 'numeric'],
        ]);

        try{
            
            $user = User::findOrFail($request->id);
            $deleteUser = new DeleteUser();
            $deleteUser->delete($user);

        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }

        return redirect()->route('admin.admins.index');
        
    }
}
