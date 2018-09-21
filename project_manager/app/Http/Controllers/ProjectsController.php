<?php

namespace App\Http\Controllers;

use App\Projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    private $username;
    private $account_type;
    private function Validator(){
        try{
            if(session('username') && session('type') == 'Admin'){
                // $this->$username = session('username');
                // $this->$account_type = session('type');
                return true;
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            report($e);
        }
    }
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
    public function create(Request $request)
    {
        $checked = $this->Validator();
        if($checked){
            $this->store($request);
        }
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
        $project = new Projects;
        $data = $request->post('data');
        $project->Name = $data["pName"];
        $project->TasksNumber = $data["taskNo"];
        $project->Duration = $data["Duration"];
        $project->StartDate = $data["StartDate"];
        $project->EndDate = $data["EndDate"];
        $project->Location = $data["location"];
        $project->save();
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function show(Projects $projects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function edit(Projects $projects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projects $projects)
    {
        //
    }
    public function archive(Request $request){
        $pid = $request->post('projectId');
        $project = Projects::find($pid);
        $project->Archived = true;
        $project->save();
    }
    public function unarchive(Request $request){
        $pid = $request->post('projectId');
        $project = Projects::find($pid);
        $project->Archived = false;
        $project->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projects $projects)
    {
        //
    }
}
