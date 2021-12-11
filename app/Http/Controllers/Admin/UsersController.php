<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\QueryFilters\Users\IsUser;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Actions\Jetstream\DeleteUser;
use App\QueryFilters\Users\UsersFilter;

class UsersController extends Controller
{
    public function index()
    {

        $users = app(Pipeline::class)
            ->send(User::query())
            ->through([
                \App\QueryFilters\Users\IsUser::class,
                \App\QueryFilters\Users\UsersFilter::class,
                \App\QueryFilters\Sort::class,
            ])
            ->thenReturn()
            ->latest()
            ->with('agence.vehicules')
            ->paginate(25);

        return view('admins.users.index')->with(['users' => $users]);
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

        return redirect()->route('admin.users.index');
        
    }
}
