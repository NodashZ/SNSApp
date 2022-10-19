<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->sort;
        $userId = $request->user()->id;
        $users = User::where('id', '!=', $userId);

        if (isset($sort)) {
            $users = $users->orderBy($sort, 'asc');
        }
        $users = $users->paginate(3);

        return new UserCollection($users);
 //       return UserResource::collection($users);
    }
}
