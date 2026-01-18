<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LatihanController extends Controller
{
    public function index(){
        return "ini dicetak dari Controller";
    }

    public function blog($id){
        return "Ini function blog dengan id ".$id;
    }

    public function komentar($idblog,$idkomentar){
        echo 'ID Blog:' .$idblog;
        echo '<br>';
        echo 'ID Komentar:' .$idkomentar;
    }

    public function beranda(){
        $data = array('nama' => 'Albert Chandra');
        return view('beranda',$data);
    }
}
