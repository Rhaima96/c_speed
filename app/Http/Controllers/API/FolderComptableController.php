<?php

namespace App\Http\Controllers\API;

use App\Models\FolderComptable;
use App\Models\MvComptable;
use App\Http\Resources\MvComptable as MvComptableResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FolderResource;
use Illuminate\Support\Facades\Validator;


class FolderComptableController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = FolderComptable::where('user_id', Auth::user()->c_id)->get();

        if ($folders->count() === null ) {
            return $this->sendError("no results found");
        }
        return $this->sendResponse(FolderResource::collection($folders), "folders get successfully");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'num_f' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError("verify fields");
        }


        $folder = FolderComptable::create([
            'name' => $request->name,
            'num_f' => $request->num_f,
            'user_id' => Auth::user()->c_id ,
        ]);

        return $this->sendResponse(new FolderResource($folder) ,'Folder added successfully' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FolderComptable  $folderComptable
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $folder = FolderComptable::where('user_id',Auth::user()->c_id)->find($id);

        if (is_null($folder)) {
            return $this->sendError("folder not exist");
        }

        $mvs = MvComptable::where('user_id',Auth::user()->c_id)->where('f_id', $folder->id)->get();
        if ($mvs->count() === null ) {
            return $this->sendError("no results found");
        }
        return response(['folder'=> $folder,'mvs'=>$mvs, 'message'=>'get data successfully']);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FolderComptable  $folderComptable
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $folder = FolderComptable::where('user_id',Auth::user()->c_id)->find($id);

        if (is_null($folder)) {
            return $this->sendError("folder not exist");
        }

        return $this->sendResponse(new FolderResource($folder) ,'folder exist' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FolderComptable  $folderComptable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $folder = FolderComptable::where('user_id', Auth::user()->id)->find($id);

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'num_f' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError("verify fields");
        }

           $folder ->update($request->all());


           return $this->sendResponse(new FolderResource ($folder), "folder updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FolderComptable  $folderComptable
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $folder = FolderComptable::where('user_id', Auth::user()->c_id)->find($id)->delete();
        return $this->sendResponse("delete", "folder deleted successfully");
    }
}
