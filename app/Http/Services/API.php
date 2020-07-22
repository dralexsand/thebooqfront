<?php
    
    namespace App\Http\Services;
    
    
    class API
    {
        private $base_url = 'http://localhost:4000/api/';
        
        public function apiGetAllArticles()
        {
            $url_request = $this->base_url . 'articles';
            $result = $this->curlRequestGet($url_request);
            $data = Helper::convertJsonToArray($result);
            return Helper::truncateArrayTexts($data, 300);
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
        
        private function curlRequestGet($url, $data = null)
        {
            /*$ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $result = curl_exec($ch);
            curl_close($ch);
            
            return $result;*/
            
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
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





