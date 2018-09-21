<?php

namespace App\Http\Controllers;

use App\Resources;
use Illuminate\Http\Request;

class ResourceController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Resources  $resources
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $taskid = $request->post('query');
        if($taskid){
            $reqcols = array('id','OriginalQuantity','Quantity','Name','Grouping');
            $resources = Resources::where('TaskId',$taskid)->get($reqcols);
            return response()->json($resources);
        }else{
            $data = array("taskid"=>$taskid,"checked"=>$checked);
            return response()->json($data);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resources  $resources
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
    }

    public function cqty(Request $request){
        $quantity = $request->post('rsrcQty');
        $resourceId = $request->post('rsrcId');
        $resource = Resources::find($resourceId);
        $resource->Quantity = $resource->Quantity + $quantity;
        if($quantity>0){
            $resource->OriginalQuantity = $resource->OriginalQuantity + $quantity;    
        }
        $resource->save();
        $data = array('Quantity'=>$resource->Quantity, 'OriginalQuantity'=>$resource->OriginalQuantity);  
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resources  $resources
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resources $resources)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resources  $resources
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resources $resources)
    {
        //
    }
}
