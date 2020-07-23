<?php
    
    namespace App\Http\Services;
    
    
    class API
    {
        private $base_url = 'http://localhost:4000/api/';
        //private $media_wiki_api_url = 'https://en.wikipedia.org/w/rest.php/v1/search/page?q='; // Black Sabbath&limit=5
        private $media_wiki_api_url_start = 'https://en.wikipedia.org/w/api.php?action=opensearch&search="'; // Black Sabbath&limit=5
        private $media_wiki_api_url_end = '"&format=json&callback=?'; // Black Sabbath&limit=5
        // https://en.wikipedia.org/w/api.php?action=opensearch&search="+ searchTerm +"&format=json&callback=?
        
        
        
        private $google_search_api_key = 'AIzaSyDbCeIJKSceQ1dtqbLZGVpgwyBUEBNMdko';
        
        
        public function apiGetSearchMediaWiki($search)
        {
            if (!empty($search)) {
                
                $url_request = $this->media_wiki_api_url_start . $search;
                $url_request .= $this->media_wiki_api_url_end;
                $result = $this->curlRequestGet($url_request);
                //$map = new \App\Http\Services\MappingResults();
                $map = new MappingResults();
                return $map->convertMass_MediaWiki($result);
            } else {
                return [];
            }
        }
        
        
        public function apiGetAllArticles()
        {
            $url_request = $this->base_url . 'articles';
            $result = $this->curlRequestGet($url_request);
            $data = Helper::convertJsonToArray($result);
            return Helper::truncateArrayTexts($data, 300);
        }
    
    
        public function apiSearchArticleInModified($tag)
        {
            $url_request = $this->base_url . 'articletaginmodified/' . $tag;
            $result = $this->curlRequestGet($url_request);
            return Helper::convertJsonToArray($result);
        }
        
        
        public function apiGetArticleByTag($tag)
        {
            if (!empty($tag)) {
                $tag = strtolower(implode('_', explode(' ', $tag)));
                $url_request = $this->base_url . 'articletag/' . $tag;
                $result = $this->curlRequestGet($url_request);
                return Helper::convertJsonToArray($result);
            } else {
                return [];
            }
        }
        
        public function apiGetArticleBy_Id($id)
        {
            $url_request = $this->base_url . 'articles/' . $id;
            $result = $this->curlRequestGet($url_request);
            return Helper::convertJsonToArray($result);
        }
        
        public function apiPostModified($data)
        {
            $url_request = $this->base_url . 'modified';
            return $this->curlRequestPost($url_request, $data);
        }
        
        public function apiPostSaveKeys($data)
        {
            $url_request = $this->base_url . 'tags';
            return $this->curlRequestPost($url_request, $data);
        }
        
        public function apiGetKeysByArticle_id($article_id)
        {
            $url_request = $this->base_url . 'tags/' . $article_id;
            return $this->curlRequestGet($url_request);
        }
        
        private static function getRandomAgent(){
            $agents = [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
                'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.9) Gecko/20100508 SeaMonkey/2.0.4',
                'Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)',
                'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; da-dk) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1',
                'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0'
            ];
            
            return $agents[array_rand($agents)];
        }
        
        private function curlRequestGet($url, $data = null)
        {
            
            $curl = curl_init();
            
            $headers = [
                'Access-Control-Allow-Origin:*',
                'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
                'Cache-Control: max-age=0',
                //'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Connection: keep-alive',
                'Keep-Alive: 300',
                'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                //'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
                'Content-Type: application/json;',
                'Accept-Language: en-us,en;q=0.5',
                'Pragma',
                'User-Agent: '.self::getRandomAgent(),
                'X-MicrosoftAjax: Delta=true'
            ];
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => $headers,
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            return $response;
        }
        
        private function curlRequestPost($url, $data = null)
        {
            
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            return $response;
        }

    }





