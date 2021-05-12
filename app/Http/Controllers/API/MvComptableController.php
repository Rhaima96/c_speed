<?php

namespace App\Http\Controllers\API;

use App\Models\MvComptable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Resources\MvComptable as MvComptableResource;
use App\Models\Bilan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MvComptableController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $mvs = MvComptable::where('user_id',Auth::user()->id)->get();
        // if ($mvs->count() === null ) {
        //     return $this->sendError("no results found");
        // }
        // return $this->sendResponse(MvComptableResource::collection($mvs), "mvs get successfully");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'num_piece' => 'required',
            'ref' => 'required',
            'code' => 'required',
            'libelle' => 'required',
            'm_debit' => 'required',
            'm_credit' => 'required',
            // 'tva' => 'required',
           ]);


           $mvs =  MvComptable::create([
            'user_id'=> Auth::user()->c_id,
            'num_piece' => $request->num_piece ,
            'ref' => $request->ref ,
            'f_id'=>$request->folder,
            'code' => $request->code ,
            'libelle' => $request->libelle ,
            'm_debit' => $request->m_debit ,
            'm_credit' => $request->m_credit ,
            'tva' => $request->tva ,
        ]);

        return $this->sendResponse(new MvComptableResource($mvs) ,'mv added successfully' );


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MvComptable  $mvComptable
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mv = MvComptable::where('user_id',Auth::user()->c_id)->find($id);

        if (is_null($mv)) {
            return $this->sendError("mv not exist");
        }

        $bilans = Bilan::where('mv_id',$id)->get();
        if ($bilans->count() === null ) {
            return $this->sendError("no results found");
        }
        return response(['mv'=> $mv,'bilans'=>$bilans, 'message'=>'get data successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MvComptable  $mvComptable
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mv = MvComptable::where('user_id', Auth::user()->c_id)->find($id);

        if (is_null($mv)) {
            return $this->sendError("mv not exist");
        }

        return $this->sendResponse(new MvComptableResource($mv) ,'mv exist' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MvComptable  $mvComptable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mv = MvComptable::where('user_id', Auth::user()->c_id)->find($id);

        $this->validate($request , [
            'num_piece' => 'required',
            'ref' => 'required',
            'code' => 'required',
            'libelle' => 'required',
            'm_debit' => 'required',
            'm_credit' => 'required',
            // 'tva' => 'required',
           ]);

           $mv ->update($request->all());


           return $this->sendResponse(new MvComptableResource ($mv), "mv updated successfully");

    }

    public function rec(Request $request,$id)
    {
        $rec = MvComptable::find($id);
       if ($rec->rec == false) {
        $rec->rec = true;
       }else{
        $rec->rec = false;
       }
        $rec->save();
        return $this->sendResponse(new MvComptableResource ($rec), "rec updated successfully");

    }

    public function filter(Request $request)
    {
        $date = Carbon::parse($request->date);

        $filter = MvComptable::where('user_id' , Auth::user()->c_id)->whereDate('created_at', $date)->get();

        return $this->sendResponse(MvComptableResource::collection($filter), "mv filtred successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MvComptable  $mvComptable
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mv = MvComptable::where('user_id', Auth::user()->c_id)->find($id)->delete();
        return $this->sendResponse("delete", "mv deleted successfully");
    }
}
