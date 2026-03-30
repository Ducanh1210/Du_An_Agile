<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(){
        return view("client.trangChu");    
    }

    public function contact(){
        return view("client.lienHe");
    }

    public function news(){
        return view("client.tinTuc");
    }

    public function newsDetail($id){
        return view("client.tinTucChiTiet");
    }
}
