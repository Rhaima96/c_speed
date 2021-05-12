<?php

namespace App\Http\Controllers\API;

use App\Models\Bilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Bilan as BilanResource;

class BilanController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
            'code' => 'required',
            'nom' => 'required',
            'actif' => 'required',
            'passif' => 'required',
            'm_actif' => 'required',
            'm_passif' => 'required',
            'mv_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError("verify fields");
        }

        $bilan = Bilan::create([
            'code' => $request->code,
            'mv_id'=>$request->mv_id,
            'nom' => $request->nom,
            'actif'=> $request->actif,
            'passif'=> $request->passif,
            'm_actif'=> $request->m_actif,
            'm_passif'=> $request->m_passif,

        ]);

        return $this->sendResponse(new BilanResource($bilan) ,'bilan added successfully' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bilan  $bilan
     * @return \Illuminate\Http\Response
     */
    public function show(Bilan $bilan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bilan  $bilan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bilan = Bilan::find($id);

        if (is_null($bilan)) {
            return $this->sendError("bilan not exist");
        }

        return $this->sendResponse(new BilanResource($bilan) ,'bilan exist' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bilan  $bilan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bilan = Bilan::find($id);

        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'nom' => 'required',
            'actif' => 'required',
            'passif' => 'required',
            'm_actif' => 'required',
            'm_passif' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError("verify fields");
        }

           $bilan ->update($request->all());


           return $this->sendResponse(new BilanResource ($bilan), "bilan updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bilan  $bilan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bilan = Bilan::find($id)->delete();
        return $this->sendResponse("delete", "bilan deleted successfully");
    }
}
