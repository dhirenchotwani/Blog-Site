<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
	public function index(){
		$title="LARAVEL!";
		//loading views with parameters
		//return view('pages.index',compact('title'));
		
		return view('pages.index')->with('title',$title); 
	}
	
	public function about(){
		$title="About!";
		return view('pages.about')->with('title',$title);   
	}
	public function services(){
		//$title="Services!";
		$data=array(
		'title' => 'Services', 
			'services' => ['web','tool']
		);
		return view('pages.services')->with($data);  
	}
}
