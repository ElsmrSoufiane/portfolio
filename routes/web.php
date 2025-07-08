<?php

use Illuminate\Support\Facades\Route;
use App\Models\Project;
use App\Models\Tutorial;
use App\Models\User;
use App\Models\Contact;
use App\Models\Image_projet;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::post('/contact', function (Request $request) {
    $request->validate([
        'nom' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string',
    ]);

    Contact::create([
        'nom' => $request->nom,
        'email' => $request->email,
        'message' => $request->message,
    ]);

   return redirect('/')->with('success', 'Votre message a bien été reçu. Je vous contacterai par e-mail dès que possible.');
})->name('contact.store');
Route::get('/projet/{id}', function ($id) {
    $projet = Project::find($id); // Get the project with the specified ID
   $images = $projet->images; 
   return view('projet', compact('projet', 'images')); 
});
Route::get('/messages', function () {
    $contacts = Contact::all(); // Get all contacts
    return view('messages', compact('contacts'));
})->middleware('auth')->name('messages');
Route::get("/logout", function () {
    auth()->logout();
    return redirect('/')->with('success', 'Vous êtes déconnecté avec succès.');
})->name('logout');
Route::get('/', function () {
    $projects = Project::all(); // Get all projects
    $tutorials = Tutorial::all(); // Get all tutorials
    
    return view('index', compact('projects', 'tutorials'));
});

Route::middleware("auth")->group(function() {
    // Afficher le formulaire de création d'image pour un projet
    Route::get('/createimage/{id}', function ($id) {
        $projet = Project::find($id);
        return view('createimage', compact('projet'));
    });

    // Enregistrer une nouvelle image pour un projet
    Route::post("/storeimage/{id}", function (Request $request, $id) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'titre' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Image_projet::create([
            'titre' => $request->titre,
            'image' => $imagePath,
            'description' => $request->description,
            'project_id' => $id,
        ]);

        return redirect("/images/{$id}")->with('success', 'Image uploaded successfully.');
    })->name('image.store');

    // Supprimer une image d'un projet (avec suppression du fichier)
    Route::get('/delete/image/{id}', function($id) {
        $image = Image_projet::findOrFail($id);
        $projet = $image->project;

        // Supprimer le fichier image du stockage
        if (Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return redirect("/images/{$projet->id}")->with('success', 'Image deleted successfully.');
    });

    // Afficher le formulaire de création de projet
    Route::get('/createprojet', function () {
        return view('createprojet');
    });

    // Lister tous les projets
    Route::get('/projets', function () {
        $projects = Project::all();
        return view('projets', compact('projects'));
    });

    // Lister tous les tutoriels
    Route::get('/tutos', function () {
        $tutorials = Tutorial::all();
        return view('tutos', compact('tutorials'));
    });

    // Afficher le formulaire d'édition d'un tutoriel
    Route::get('edittutoriel/{id}', function ($id) {
        $tutorial = Tutorial::findOrFail($id);
        return view('edittuto', compact('tutorial'));
    });

    // Supprimer un projet (avec toutes ses images)
    Route::get('/delete/projet/{id}', function ($id) {
        $projet = Project::findOrFail($id);

        // Supprimer l'image principale du projet
        if (Storage::disk('public')->exists($projet->image)) {
            Storage::disk('public')->delete($projet->image);
        }

        // Supprimer toutes les images associées au projet
        foreach ($projet->images as $image) {
            if (Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
            $image->delete();
        }

        $projet->delete();

        return redirect('/')->with('success', 'Projet supprimé avec succès');
    });

    // Afficher les images d'un projet
    Route::get('images/{id}', function ($id) {
        $projet = Project::findOrFail($id);
        $images = $projet->images;
        return view('images', compact('projet', 'images'));
    });

    // Afficher le formulaire d'édition d'un projet
    Route::get('editprojet/{id}', function ($id) {
        $projet = Project::findOrFail($id);
        return view('editprojet', compact('projet'));
    });

    Route::get('/delete/contact/{id}', function ($id) {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect('/messages')->with('success', 'Message supprimé avec succès');
    });

    // Supprimer un tutoriel (avec son icône)
    Route::get('/delete/tutoriel/{id}', function ($id) {
        $tutorial = Tutorial::findOrFail($id);

        // Supprimer l'icône du tutoriel
        if (Storage::disk('public')->exists($tutorial->icon)) {
            Storage::disk('public')->delete($tutorial->icon);
        }

        $tutorial->delete();

        return redirect('/')->with('success', 'Tutoriel supprimé avec succès');
    });

    // Mettre à jour un tutoriel
    Route::post('/update.tutoriel/{id}', function (Request $request, $id) {
        $request->validate([
            'titre' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        $tutorial = Tutorial::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('icon')) {
            // Supprimer l'ancienne icône
            if (Storage::disk('public')->exists($tutorial->icon)) {
                Storage::disk('public')->delete($tutorial->icon);
            }

            // Enregistrer la nouvelle icône
            $data['icon'] = $request->file('icon')->store('icons', 'public');
        }

        $tutorial->update($data);

        return redirect('/')->with('success', 'Tutorial modifié avec succès');
    })->name('tutorials.update');

    // Mettre à jour un projet
    Route::post('/update.projet/{id}', function (Request $request, $id) {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'code_source' => 'required|url',
            'deploiement' => 'nullable|url',
        ]);

        $projet = Project::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if (Storage::disk('public')->exists($projet->image)) {
                Storage::disk('public')->delete($projet->image);
            }

            // Enregistrer la nouvelle image
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $projet->update($data);

        return redirect('/')->with('success', 'Projet modifié avec succès');
    })->name('projet.update');

    // Créer un nouveau projet
    Route::post('/create_project', function (Request $request) {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'code_source' => 'required|url',
            'deploiement' => 'nullable|url',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        Project::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'image' => $imagePath,
            'code_source' => $request->code_source,
            'deploiement' => $request->deploiement,
        ]);

        return redirect('/')->with('success', 'Projet créé avec succès!');
    })->name('projet.store');

    // Afficher le formulaire de création de tutoriel
    Route::get('/create_tutorial', function () {
        return view('createtuto');
    });

    // Créer un nouveau tutoriel
    Route::post('/create_tutorial', function (Request $request) {
        $request->validate([
            'titre' => 'required|string|max:255',
            'url' => 'required|url',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $iconPath = $request->file('icon')->store('icons', 'public');

        Tutorial::create([
            'titre' => $request->titre,
            'url' => $request->url,
            'icon' => $iconPath,
        ]);

        return redirect('/')->with('success', 'Tutoriel créé avec succès!');
    })->name('tutorials.store');
});

Route::get('/login', function () {
    return view('login');
});
Route::post('/login', function (Illuminate\Http\Request $request) {
   Auth::attempt(
    ["email"=>$request->email,
        "password"=>$request->password ,
    ]);
      return redirect('/')->with('success', 'vous etes conecté avec success');

})->name('login');

