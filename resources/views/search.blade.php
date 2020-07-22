@extends('layouts.search_layout')

@section('content')
    <div class="container">
        
        <!-- Full width column -->
        <div class="flex mb-4">
            <div class="w-full h-12">
                
                <form class="w-full">
                    <div class="flex items-center border-b border-b-2 border-teal-500 py-2">
                        
                        <input autocomplete="off" id="s" style="width: 100%!important;"
                               class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                               type="text"
                               placeholder="Search"
                               aria-label="Full name">
                        
                        <button id="s_button"
                                class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
                                type="button">
                            
                            <i class="fas fa-search"></i>
                        
                        </button>
                    </div>
                </form>
            
            </div>
        </div>
        
        <div class="flex mb-4">
            <div class="w-full bg-gray-200">
                
                @if(!empty($keysPanel))
                    
                    @foreach($keysPanel as $keyphrase)
                        <div class="flex-1
                        bg-gray-600 h-12 inline-block
                        p-3 rounded-lg text-white text-bold text-sm">
                            <i class="fas fa-check"></i> {{ $keyphrase }}
                        </div>
                    @endforeach
                
                @endif
            
            </div>
        </div>
        
        <div class="flex mb-4">
            <div class="w-full h-12">
                <h2 id="target_keyword">{{ $searchkey }}</h2>
            </div>
        </div>
        
        @if(!empty($exact_match_searchresults))
            <div class="flex mb-4">
                <div class="w-ful">
                    <span>
                        <a href="/search/{{ $exact_match_searchresults['title'] }}"
                           class="links_searchresults bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        Article
                    </a>
                    </span>
                    
                    <span>
                        <a href="/edit/{{ $exact_match_searchresults['_id'] }}"
                           class="links_searchresults bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        Edit
                    </a>
                    </span>
                    
                    <span>
                        <a href="/discuss/{{ $exact_match_searchresults['article_id'] }}"
                           class="links_searchresults bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        Discuss
                    </a>
                    </span>
                    
                    <span>
                        <a href="/history/{{ $exact_match_searchresults['article_id'] }}"
                           class="links_searchresults bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        History
                    </a>
                    </span>
                
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-full bg-gray-200">
                    <span class="text-left text-3xl">
                        <span class="p-1">
                            {{ $exact_match_searchresults['title'] }}
                        </span>
                    </span>
                    <span class="text-right italic">
                        User: <span class="font-bold p-1">
                            John Doe
                        </span>
                         <span class="font-medium p-1">
                             {{ $exact_match_searchresults['modified'] }}
                         </span>
                    </span>
                </div>
            </div>
            
            <div class="flex">
                <div class="w-1/6 bg-gray-200 h-12"></div>
                <div class="w-5/6 bg-gray-100 p-2">
                    {{ $exact_match_searchresults['content'] }}
                </div>
            </div>
        
        @endif
        
        <hr>
        <div class="flex mb-4">
            <div class="w-full h-12">
                <h2 id="related_searches">Related searches:</h2>
            </div>
        </div>
        <hr>
        
        @if(!empty($searchresults))
            
            @foreach($searchresults as $searchresult)
                <div class="flex mb-4">
                    <div class="w-full bg-gray-200 ">
                        <div class="max-w-sm w-full lg:max-w-full lg:flex">
                            <div
                                class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden"
                                style="background-image: url('http://placeimg.com/192/312/any')"
                                title="Woman holding a mug">
                            </div>
                            
                            <a class="links_searchresults" href="/search/{{ $searchresult['title'] }}">
                                
                                <div
                                    class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                                    <div class="mb-8">
                                        <p class="text-sm text-gray-600 flex items-center">
                                            {{ $searchresult['tag'] }}
                                        </p>
                                        <div class="title text-gray-900 font-bold text-xl mb-2">
                                            {{ $searchresult['title'] }}
                                        </div>
                                        <p class="text-gray-700 text-base">
                                            {{ $searchresult['content'] }}
                                        </p>
                                    </div>
                                    <div class="flex items-center">
                                        
                                        <div class="text-sm">
                                            <p class="text-gray-900 leading-none">
                                                <i class="far fa-user"></i> UserLastName Firstname
                                            </p>
                                            <p class="text-gray-600 italic">
                                                Updated at {{ $searchresult['modified'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            
                            </a>
                        
                        </div>
                    </div>
                </div>
        @endforeach
    
    @endif
    
    <!-- Two columns -->
        <div class="flex mb-4">
            <div class="w-1/2 bg-gray-400 h-12"></div>
            <div class="w-1/2 bg-gray-500 h-12"></div>
        </div>
        
        <!-- Three columns -->
        <div class="flex mb-4">
            <div class="w-1/3 bg-gray-400 h-12"></div>
            <div class="w-1/3 bg-gray-500 h-12"></div>
            <div class="w-1/3 bg-gray-400 h-12"></div>
        </div>
        
        <!-- Four columns -->
        <div class="flex mb-4">
            <div class="w-1/4 bg-gray-500 h-12"></div>
            <div class="w-1/4 bg-gray-400 h-12"></div>
            <div class="w-1/4 bg-gray-500 h-12"></div>
            <div class="w-1/4 bg-gray-400 h-12"></div>
        </div>
        
        <!-- Five columns -->
        <div class="flex mb-4">
            <div class="w-1/5 bg-gray-500 h-12"></div>
            <div class="w-1/5 bg-gray-400 h-12"></div>
            <div class="w-1/5 bg-gray-500 h-12"></div>
            <div class="w-1/5 bg-gray-400 h-12"></div>
            <div class="w-1/5 bg-gray-500 h-12"></div>
        </div>
        
        <!-- Six columns -->
        <div class="flex">
            <div class="w-1/6 bg-gray-400 h-12"></div>
            <div class="w-1/6 bg-gray-500 h-12"></div>
            <div class="w-1/6 bg-gray-400 h-12"></div>
            <div class="w-1/6 bg-gray-500 h-12"></div>
            <div class="w-1/6 bg-gray-400 h-12"></div>
            <div class="w-1/6 bg-gray-500 h-12"></div>
        </div>
    
    </div>
@endsection
