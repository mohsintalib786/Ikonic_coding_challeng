<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $last_id = $request->last_id;
        if(is_null($last_id) || $last_id == 'null'){
            $sentRequests = Connection::with('sender', 'receiver')->where("sender", Auth::id())->where('status', 0)->latest()->take(10)->get();
        }else{
            $sentRequests = Connection::with('sender', 'receiver')->where("sender", Auth::id())->where('status', 0)->where('id', '>', $last_id)->get();
        }
        $lastSentRequestId  = null;
        if(count($sentRequests) > 10 ){
            $array = $sentRequests->toArray();
            $lastSentRequestId  = $sentRequests[count($array) -1]['id'];
        }
        return response()->json(['success'=>true, 'sentRequests'=>$sentRequests, 'lastSentRequestId'=>$lastSentRequestId]);
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
    public function store($id)
    {
        $request = Connection::find($id);
        $request->status = 1;
        $request->update();
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $receivedRequests = Connection::with('sender', 'receiver')->where("receiver", Auth::id())->where('status', 0)->get();
        return response()->json(['success'=>true, 'receivedRequests'=>$receivedRequests]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $request = Connection::find($id);
        $request->status = 2;
        $request->update();
        return response()->json(['success'=>true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
