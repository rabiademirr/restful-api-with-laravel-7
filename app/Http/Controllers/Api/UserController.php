<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = $request->offset ? $request->offset : 0;
        $limit = $request->limit ? $request->limit :25;
        $qb = User::query();
        $users = $qb->offset($offset)->limit($limit)->get();

      /*  return response([
            'users'=>UserResource::collection($users)
        ],200);*/
        return response([
            'users'=>new UserCollection($users)
        ],200);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at =  now();
        $user->password = bcrypt($request->password);
        $user->save();

        if(!empty($user)){
            return response([
                'userInfos'=>$user,
                'message'=>'User inserted'
            ],201);

        }else{
            response(['message'=>'User can not inserted!!!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = User::find($user->id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->save();

        return response(['message'=>'User updated!'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response(['message' => 'User deleted!'], 200);
    }
}
