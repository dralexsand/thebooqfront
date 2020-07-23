@extends('layouts.edit_layout')

@section('content')
    <div class="container">
        

            <div class="flex mb-4">
                <div class="w-full bg-gray-200 p-5">
                    <span>
                        <a href="/search/{{ $title }}"
                           class="links_searchresults bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        Cancel
                    </a>
                    </span>
                    
                </div>
            </div>
            
            <form action="/store" method="post">
                @csrf
                
                <div class="flex mb-4 text-lg bg-gray-100">
                    Title:
                </div>
                
                <div class="flex mb-4">
                    <div class="w-full">
                        <input name="title" id="editor_title" class="p-2 "
                               value="{{ $title }}"
                        />
                    </div>
                </div>
                
                <br>
                <hr>
                <br>
                
                <div class="flex mb-4 text-lg bg-gray-100">
                    Content:
                </div>
                
                <div class="flex mb-4">
                    <div class="w-full">
                        <textarea name="content" id="editor_content" class="p-2 ">
                        
                        </textarea>
                    </div>
                </div>
                
                <div class="flex mb-4 text-lg bg-gray-100">
                    You can add key phrases to this article. List them separated by commas.
                    For example: <span class="italic"> Dog food, dog breeds</span>
                </div>
                
                <div class="flex mb-4">
                    <div class="w-full">
                        <textarea name="tags" id="editor_keys" class="p-2 ">
                        
                        </textarea>
                    </div>
                </div>
                
                <hr>
                
                <button
                    type="submit"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Save
                </button>
            
            </form>

    
    </div>

@endsection


