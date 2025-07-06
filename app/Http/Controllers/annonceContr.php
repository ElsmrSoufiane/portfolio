<?php

namespace App\Http\Controllers;
use App\Models\Annonce;
use Illuminate\Http\Request;

class annonceContr extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $annonces=Annonce::all();
        return view("index",Compact("annonces"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
     
        return view("create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        Annonce::create($request->All());
        return redirect("/index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
        $annonce=Annonce::find($id);
        return view("edit",Compact("annonce"));
    }
    public function update(Request $request,$id){
        $annonce=Annonce::find($id);
        $annonce->titre=$request->input("titre");
        $annonce->titre=$request->input("description");
        $annonce->titre=$request->input("type");
        $annonce->titre=$request->input("ville");
        $annonce->titre=$request->input("superficie");
        $annonce->titre=$request->input("etat");
        $annonce->titre=$request->input("prix");
        $annonce->sav();
        return redirect("/index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { $annonce=Annonce::find($id);
        $annonce->delete();
        return redirect("/index");
    }
}
