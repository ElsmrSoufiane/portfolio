@extends('master')
@section('content')

                <form  action="{{ route('projet.update', $projet->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    

                   
                        
                      
                                        <input type="text" name="titre" id="titre" 
                                               value="{{ old('titre', $projet->titre) }}" 
                                               placeholder="Titre" required>
                                 
                                        <input type="file" name="image" id="image">
                                        @if($projet->image)
                                            <img src="{{ asset($projet->image) }}" 
                                                 style="max-width: 100px; margin-top: 10px;">
                                            <small>Image actuelle</small>
                                        @endif
                                    
                                        <textarea name="description" id="description" 
                                                  placeholder="Description" required>{{ old('description', $projet->description) }}</textarea>
                                   
                                        <input type="url" name="code_source" id="code_source" 
                                               value="{{ old('code_source', $projet->code_source) }}" 
                                               placeholder="Code Source URL" required>
                                    
                                
                                
                                        <input type="url" name="deploiement" id="deploiement" 
                                               value="{{ old('deploiement', $projet->deploiement) }}" 
                                               placeholder="URL de Déploiement">
                                   
                                
                              
                                        <button type="submit" >Modifier</button>
                                   
                </form>
           
@endsection