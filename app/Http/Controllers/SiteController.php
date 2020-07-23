<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Services\API;
    use App\Http\Services\Helper;
    
    class SiteController extends Controller
    {
        private $count_tags = 5;
        
        
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            //$this->middleware('auth');
        }
        
        /**
         * Show the application dashboard.
         *
         * @return \Illuminate\Contracts\Support\Renderable
         */
        public function index($search = null)
        {
            
            $api = new API();
            
            $exact_match_searchresults = $api->apiGetArticleByTag($search);
            
            $keysPanel = [];
            
            if (!empty($exact_match_searchresults)) {
                
                $article_id = $exact_match_searchresults['_id'];
                
                $keys = $api->apiGetKeysByArticle_id($article_id);
                $keysPanel = Helper::extractTagsAndConvertSingleJsonToArray($keys);
                
                if (!empty($keysPanel) && sizeof($keysPanel) > $this->count_tags) {
                    array_splice($keysPanel, $this->count_tags);
                }
                
                if (!empty($keysPanel)) {
                    $keys_new = [];
                    foreach ($keysPanel as $key) {
                        $key_new = implode(' ', explode('_', $key));
                        $keys_new[] = $key_new;
                    }
                    $keysPanel = $keys_new;
                }
            }
            
            $searchresults = $api->apiGetSearchMediaWiki($search);
            //$searchresults = $api->apiGetAllArticles();
            
            
            if (!empty($search) && empty($exact_match_searchresults)) {
                
                $search_tag = str_replace(' ', '_', strtolower($search));
                $articleIsNew = $api->apiSearchArticleInModified($search_tag);
            }
            
            $isNew = !empty($articleIsNew) ? 1 : 0;
            
            return view('search',
                [
                    'searchkey' => $search,
                    'searchresults' => $searchresults,
                    'keysPanel' => $keysPanel,
                    'exact_match_searchresults' => $exact_match_searchresults,
                    'is_new' => $isNew
                ]
            );
        }
        
        public function edit($id)
        {
            $api = new API();
            $article = $api->apiGetArticleBy_Id($id);
            
            $keysJson = $api->apiGetKeysByArticle_id($id);
            $keys = Helper::extractTagsAndConvertSingleJsonToArray($keysJson);
            
            if (!empty($keys) && sizeof($keys) > $this->count_tags) {
                array_splice($keys, $this->count_tags);
            }
            
            if (!empty($keys)) {
                $keys_new = [];
                foreach ($keys as $key) {
                    $key_new = implode(' ', explode('_', $key));
                    $keys_new[] = $key_new;
                }
                $keys = $keys_new;
            }
            
            return view('edit',
                [
                    'article' => $article,
                    'keys' => $keys
                ]
            );
        }
        
        public function discuss($id)
        {
            return view('discuss');
        }
        
        public function history($id)
        {
            return view('history');
        }
        
        public function about()
        {
            return view('about');
        }
        
        public function contacts()
        {
            return view('contacts');
        }
        
        public function update()
        {
            $post = $_POST;
            $post['article_id'] = 0;
            $post['type'] = 'article';
            //$post['original_article_id'] = $post['id'];
            $post['created'] = date('Y-m-d H:i:s');
            $post['user_id'] = 7;
            
            $data = \GuzzleHttp\json_encode($post);
            
            $post['_id'] = $post['original_article_id'];
            $api = new API();
            $result = $api->apiPostModified($data);
            
            if (!empty($post['tags'])) {
                
                $tags = explode(',', $post['tags']);
                
                $tags_array = [];
                
                foreach ($tags as $tag) {
                    $tags_item = [];
                    $tags_item['article_id'] = $post['original_article_id'];
                    $tags_item['user_id'] = $post['user_id'];
                    
                    $tag = strtolower(trim($tag));
                    $tag = strtolower(implode('_', explode(' ', $tag)));
                    $tags_item['tag'] = $tag;
                    
                    $tags_item['created'] = date('Y-m-d H-i-s');
                    $tags_item['modified'] = date('Y-m-d H-i-s');
                    $tags_array[] = $tags_item;
                }
                
                $data = \GuzzleHttp\json_encode($tags_array, JSON_UNESCAPED_UNICODE);
                
                /*[
                {"name":"Michael", "email":"michael@mail.com", "age":25 },
                 {"name":"Andy", "email":"andy@mail.com", "age":27 },
                {"name":"Paul", "email":"paul@mail.com", "isAdmin":true }
                ]/*/
                
                $result = $api->apiPostSaveKeys($data);
            }
            
            // apiPostSaveKeys
            
            $keysJson = $api->apiGetKeysByArticle_id($post['original_article_id']);
            $keys = Helper::extractTagsAndConvertSingleJsonToArray($keysJson);
            
            if (!empty($keys) && sizeof($keys) > $this->count_tags) {
                array_splice($keys, $this->count_tags);
            }
            
            if (!empty($keys)) {
                $keys_new = [];
                foreach ($keys as $key) {
                    $key_new = implode(' ', explode('_', $key));
                    $keys_new[] = $key_new;
                }
                $keys = $keys_new;
            }
            
            $tag = strtolower(implode('_', explode(' ', $tag)));
            
            return view('edit',
                [
                    'article' => $post,
                    'keys' => $keys
                ]);
        }
        
        public function store()
        {
            $post = $_POST;
            $post['tag'] = str_replace(' ', '_', strtolower($post['title']));
            $post['article_id'] = random_int(111111111, 999999999);
            $post['type'] = 'article';
            $post['original_article_id'] = 0;
            $post['created'] = date('Y-m-d H:i:s');
            $post['user_id'] = 7;
            
            $data = \GuzzleHttp\json_encode($post);
            $api = new API();
            $result = $api->apiPostModified($data);
            
            $redirect = 'search/' . $post['title'];
            
            return redirect($redirect);
        }
        
        public function create($data)
        {
            return view('create',
                [
                    'title' => $data
                ]
            );
        }
        
        
        public function post($id)
        {
            $post = $_POST;
        }
        
        public function upload($data)
        {
            $post = $_POST;
            $fileUload = $data;
            $file = $_FILES;
            
            $api = new API();
            $article = $api->apiGetArticleBy_Id(1);
            
            $keysJson = $api->apiGetKeysByArticle_id($post['original_article_id']);
            $keys = Helper::extractTagsAndConvertSingleJsonToArray($keysJson);
            
            if (!empty($keys) && sizeof($keys) > $this->count_tags) {
                array_splice($keys, $this->count_tags);
            }
            
            return view('edit',
                [
                    'article' => $article,
                    'keys' => $keys
                ]
            );
        }
        
        public function ajaxFileUpload($data)
        {
            $fileUload = $data;
            $file = $_FILES;
            
            $api = new API();
            $article = $api->apiGetArticleBy_Id(1);
            
            $keys = Helper::getDemoKeys();
            
            return view('edit',
                [
                    'article' => $article,
                    'keys' => $keys
                ]
            );
        }
        
        
    }
