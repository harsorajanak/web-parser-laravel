<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPHtmlParser\Dom;

class WebscrapController extends HelperController
{
    //home page with get all categories from provided url
    function index(){
        $data['category'] = $this->getCategories('http://www.mycorporateinfo.com/');
        return view('home',$data);
    }
    // get all companies details
    function getAllCompanies(Request $request){
        $data['result'] = [];
        $data['pagination'] = [];
        if($request->url){
            $data = $this->getCompanies($request->url);
        }
        return view('companies',$data);
    }
    //Store company details to database
    function storeCompanyDetails(Request $request){
        $data = $this->getCompanyDetails($request->url);
        $company = new Companies();
        foreach ($data as $key => $value){
            $company->$key = $value;
        }
        $company->save();
        $data['status'] = 1;
        $data['message'] = 'Record stored successfully';
        return Response::json($data);
    }

}
