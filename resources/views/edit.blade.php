@extends('layouts.edit_layout')

@section('content')
    <div class="container">
        
        <div class="flex mb-4">
            <div class="w-full bg-gray-200 h-12">
                
                @if(!empty($keys))
                    
                    @foreach($keys as $keyphrase)
                        <div class="flex-1
                        bg-gray-600 h-12 inline-block
                        p-3 rounded-lg text-white text-bold text-sm">
                            <i class="fas fa-check"></i> {{ $keyphrase }}
                        </div>
                    @endforeach
                
                @endif
            
            </div>
        </div>
        
        @if(!empty($article))
            
            
            <div class="flex mb-4">
                <div class="w-full bg-gray-200 p-5">
                    <span>
                        <a href="/search/{{ $article['title'] }}"
                           class="links_searchresults bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        Article
                    </a>
                    </span>
                    {{--<span>
                        <a href="/edit/{{ $article['article_id'] }}"
                           class="links_searchresults bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        Edit
                    </a>
                    </span>--}}
                    <span>
                        <a href="/discuss/{{ $article['article_id'] }}"
                           class="links_searchresults bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        Discuss
                    </a>
                    </span>
                    <span>
                        <a href="/history/{{ $article['article_id'] }}"
                           class="links_searchresults bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        History
                    </a>
                    </span>
                </div>
            </div>
            
            <form action="/update" method="post">
                @csrf
                
                <input name="article_id" type="hidden" value="{{ $article['article_id'] }}">
                <input name="tag" type="hidden" value="{{ $article['tag'] }}">
                
                <div class="flex mb-4 text-lg bg-gray-100">
                    Title:
                </div>
                
                <div class="flex mb-4">
                    <div class="w-full">
                        <input name="title" id="editor_title" class="p-2 "
                               value="{{ $article['title'] }}"
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
                            {{ $article['content'] }}
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
        
        @endif
    
    </div>

@endsection


