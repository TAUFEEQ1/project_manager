<?php

namespace App\Http\Controllers;

use App\Tasks;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Assignments;
use Guzzle\Http\Client;

class TasksController extends Controller
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

     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //Extract all Tasks
        if(!(session('username') && session("type")=='Admin')){
            return response()->json();
        }
        $reqcols = array('TaskId','ProjectId','Progress','Duration','earlyStart','earlyFinish','lateStart','lateFinish');
        $tasks = Tasks::where('Archived',0)->get($reqcols);
        $data = array();
        foreach ($tasks as $task) {
            $assignments = Tasks::find($task->TaskId)->assignments->toArray();
            if($assignments){
                foreach ($assignments as &$assignment) {
                    $names = Assignments::find($assignment["AssId"])->workers;
                    $assignment["WorkerName"] = $names["Name"];
                }
            }
            $task->workers = $assignments;
        }
        foreach($tasks as $task){
            $resources = Tasks::find($task->TaskId)->resources->toArray();
            $task->resources = $resources;
        }

        return response()->json($tasks);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function edit(Tasks $tasks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tasks $tasks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tasks $tasks)
    {
        //
    }
    /**
        * Compute
    */
    public function compute(Request $request)
    {
        $client = new Client();
        $projectid = $request->post('projid');
        $response =  $client->get('http://compute.glassociates.engineering',['projid'=>$projectid]);
        $response = $response->getBody();
        return response()->json($response);        
    }

}
