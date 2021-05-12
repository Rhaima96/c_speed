<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    public function index(Request $request)
    {
        $users = User::where('c_id',Auth::user()->id)->where('role' , '!=' , 2)->get();

        if ($users->count() === null ) {
            return $this->sendError("no results found");
        }

        return $this->sendResponse(UserResource::collection($users), "users get successfully");
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => ['required' , 'regex:/(.+)@(.+)\.(.+)/i', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'required|string|confirmed|min:8',
            'offre' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError("verify fields");
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'c_id' => Auth::user()->id ,
            'offre'=> $request->offre,
            'role'=> $request->role,
            'phone'=> $request->phone,
            'adress'=> $request->adress,
        ]);
        $user->sendEmailVerificationNotification();

        return $this->sendResponse(new UserResource($user) ,'user added successfully' );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::where('c_id', Auth::user()->id)->find($id);

        if (empty($user) ) {

            return $this->sendError("user not found");
        }


        return $this->sendResponse(new UserResource($user) ,'user exist' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::where('c_id', Auth::user()->id)->find($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => ['required' , 'regex:/(.+)@(.+)\.(.+)/i', 'string', 'email', 'max:255'],
            'offre' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError("verify fields");
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->offre = $request->offre;
        $user->role = $request->role;
        $user->adress = $request->adress;
        $user->phone = $request->phone;
        $user->save();



        if (Hash::check($request->ac_password, $user->password)) {

            $request->validate([
                'password' => 'string|confirmed|min:8',
            ]);

                $user->password =  Hash::make($request->password);

                $user->save();
      }


        return $this->sendResponse(new UserResource($user) ,'user updated successfully' );
    }


}
