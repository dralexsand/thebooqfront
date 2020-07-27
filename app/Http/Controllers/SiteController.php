<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Services\API;
    use App\Http\Services\Helper;
    
    class SiteController extends Controller
    {
        private $count_tags = 5;
        
        /**
         * Show the application dashboard.
         *
         * @return \Illuminate\Contracts\Support\Renderable
         */
        public function index($search = null)
        {
            $search = str_replace('/', '_', $search);
            
            // AC//DC
            
            $api = new API();
            $tag = Helper::convertToTag($search);
            $exact_match_searchresults = $api->apiGetArticleByTag($tag);
            
            $keysPanel = [];
            
            if (!empty($exact_match_searchresults)) {
                
                $article_id = $exact_match_searchresults['article_id'];
                
                $keys = $api->apiGetKeysByArticle_id($article_id);
                
                if (!empty($keys)) {
                    
                    $keysPanel = Helper::extractTagsAndConvertSingleJsonToArray($keys);
                    
                    if (sizeof($keysPanel) > $this->count_tags) {
                        array_splice($keysPanel, $this->count_tags);
                    }
                    
                    $keys_new = [];
                    foreach ($keysPanel as $key) {
                        $key_new = implode(' ', explode('_', $key));
                        $keys_new[] = $key_new;
                    }
                    $keysPanel = $keys_new;
                }
            } else {
                $articleIsNew = $api->apiSearchArticleByTagInModified($tag);
                
            }
            
            //$searchresults = $api->apiGetSearchMediaWiki($search);
            $searchresults = $api->apiGetAllArticles();
            
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
        
        
        public function edit($title)
        {
            
            $api = new API();
            $tag = Helper::convertToTag($title);
            $article = $api->apiGetArticleByTag($tag);
            
            if (empty($article)) {
                $redirect = 'search/' . $title;
                return redirect($redirect);
            } else {
                $keysJson = $api->apiGetKeysByArticle_id($article['article_id']);
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
            $post['type'] = 'article';
            $post['created'] = date('Y-m-d H:i:s');
            $post['user_id'] = 7;
            $post['indb'] = 0;
            $post['isnew'] = 0;
            
            $data = \GuzzleHttp\json_encode($post);
            
            $api = new API();
            $result = $api->apiPostModified($data);
            
            $tags = [];
            
            if (!empty($post['tags'])) {
                $tags = explode(',', $post['tags']);
            };
            
            $tags[] = Helper::convertToTag($post['title']);
            
            $tags_array = [];

            foreach ($tags as $tag_trash) {
                $tag = Helper::convertToTag($tag_trash);
                $isDuplicate = $api->apiGetCheckTagsDublicate($tag);
                
                if ($isDuplicate == 0) {
                    $tags_item = [];
                    $tags_item['article_id'] = $post['article_id'];
                    $tags_item['user_id'] = $post['user_id'];
                    
                    $tag = strtolower(trim($tag));
                    $tag = strtolower(implode('_', explode(' ', $tag)));
                    $tags_item['tag'] = $tag;
                    
                    $tags_item['created'] = date('Y-m-d H-i-s');
                    $tags_item['modified'] = date('Y-m-d H-i-s');
                    $tags_item['indb'] = 0;
                    
                    $tags_array[] = $tags_item;
                    
                    $data = \GuzzleHttp\json_encode($tags_array, JSON_UNESCAPED_UNICODE);
                    //$result = $api->apiPostSaveMTags($data);
                    $result = $api->apiPostSaveKeys($data);
                }
            }
            
            $keysJson = $api->apiGetKeysByArticle_id($post['article_id']);
            $keys = Helper::extractTagsAndConvertSingleJsonToArray($keysJson);
            
            if (!empty($keys) && sizeof($keys) > $this->count_tags) {
                array_splice($keys, $this->count_tags);
            }
            
            if (!empty($keys)) {
                $keys_new = [];
                foreach ($keys as $key) {
                    $key_new = str_replace('_', ' ', $key);
                    $keys_new[] = $key_new;
                }
                $keys = $keys_new;
            }
    
            $redirect = 'search/' . $post['title'];
    
            return redirect($redirect);
            
            /*return view('edit',
                [
                    'article' => $post,
                    'keys' => $keys
                ]);*/
        }
        
        public function store()
        {
            $post = $_POST;
            $post['tag'] = Helper::convertToTag($post['title']);
            
            $api = new API();
            
            $article_id = $api->apiGetLastId();
            
            $post['article_id'] = $article_id;
            $post['type'] = 'article';
            $post['original_article_id'] = 0;
            $post['created'] = date('Y-m-d H:i:s');
            $post['user_id'] = 7;
            $post['indb'] = 0;
            $post['isnew'] = 1;
            
            $data = \GuzzleHttp\json_encode($post);
            
            $result = $api->apiPostModified($data);
            
            $tags = [];
            
            if (!empty($post['tags'])) {
                $tags = explode(',', $post['tags']);
            };
            
            $tags[] = Helper::convertToTag($post['title']);
            
            $tags_array = [];
            
            foreach ($tags as $tag_trash) {
                
                $tag = Helper::convertToTag($tag_trash);
                $isDuplicate = $api->apiGetCheckTagsDublicate($tag);
                
                if ($isDuplicate == 0) {
                    $tags_item = [];
                    $tags_item['article_id'] = $article_id;
                    $tags_item['user_id'] = $post['user_id'];
                    
                    $tag = strtolower(trim($tag));
                    $tag = strtolower(implode('_', explode(' ', $tag)));
                    $tags_item['tag'] = $tag;
                    
                    $tags_item['created'] = date('Y-m-d H-i-s');
                    $tags_item['modified'] = date('Y-m-d H-i-s');
                    $tags_item['indb'] = 0;
                    
                    $tags_array[] = $tags_item;
                }
            }
            
            $data = \GuzzleHttp\json_encode($tags_array, JSON_UNESCAPED_UNICODE);
            //$result = $api->apiPostSaveMTags($data);
            $result = $api->apiPostSaveKeys($data);
            
            
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
