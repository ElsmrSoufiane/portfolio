<?php

namespace App\Http\Controllers;
use App\Models\Annonce;
use Illuminate\Http\Request;

class annonceController extends Controller
{
    public function index(){
        $annonces=Annonce::All();
        return view("index",Compact("annonces"));
    }
    public function create(){
     
        return view("create");
    }
    public function store(Request $request){
        Annonce::create($request->All());
        return redirect("/index");
    }
    public function edit($id){
        $annonce=Annonce::find($id);
        return view("edit",Compact("annonce"));
    }
    public function update(Request $request){
        $annonce=Annonce::find($request->input);
        return redirect("/index");
    }
    
}
