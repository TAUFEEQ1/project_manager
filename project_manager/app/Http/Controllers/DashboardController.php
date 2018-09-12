<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Projects;
use App\Tasks;
use App\Resources;
use App\Reports;

class DashboardController extends Controller{

	private function Validator(){
		try{
			if(session('username') && session('type') == 'Admin'){
				return true;
			}
			else{
				return redirect('https://pm.glassociates.engineering/');
			}
		}
		catch(Exception $e){
			report($e);
		}
	}
	public function index(Request $request){
		$check = $this->Validator();
		if($check){
			$query = $request->post('query');
			if($query== "projects"){
				$results = Projects::all();
				return response()->json(["message"=>200,"info"=>$results]);
			}
		}
		else{
			return response()->json(["message"=>403]);
		}
	}


}
