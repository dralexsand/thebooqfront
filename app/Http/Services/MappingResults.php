<?php
    
    namespace App\Http\Services;
    
    class MappingResults
    {
        
        public function convertMass_MediaWiki($results)
        {
            
            $resultsArray = \App\Http\Services\Helper::convertJsonToArray($results);
            
            $converted_results = [];
            
            if(!empty($resultsArray)){
                $pages = $resultsArray['pages'];
    
                foreach ($pages as $resultItem) {
                    $converted_results[] = $this->convertSingle_MediaWiki($resultItem);
                }
            }

            return $converted_results;
        }
        
        public function convertSingle_MediaWiki($results)
        {
            $converted_results = [];
            foreach ($results as $field => $value) {
                
                $map = self::map_MediaWiki();
                
                if (array_key_exists($field, $map)) {
                    
                    switch ($field) {
                        case 'key':
                            $value = strtolower($value);
                            break;
                        case 'id':
                            $value = strtolower($value) . random_int(1111111, 9999999);
                            break;
                    }
                    
                    $result_value = strip_tags($value);
                    
                    $excepted_tags = self::exceptedStrings();
                    
                    $result_value = str_replace($excepted_tags, '', $result_value);
                    
                    $converted_results[$map[$field]] = $result_value;
                }
            }
            
            $converted_results['created'] = date('Y-m-d H:i:s');
            $converted_results['modified'] = date('Y-m-d H:i:s');
            
            return $converted_results;
        }
        
        private static function exceptedStrings()
        {
            return [
                '&quot;'
            ];
        }
        
        private static function map_MediaWiki()
        {
            return [
                'title' => 'title',
                'excerpt' => 'content',
                'key' => 'tag',
                'id' => 'article_id'
            ];
        }
        
        /*"id": 54210241,
        "key": "Latvians_in_Russia",
        "title": "Latvians in Russia",
        "excerpt": "Juris Lorencs. Baškīrijā, latviešos",
        "description": null,
        "thumbnail": null*/
        
        
        /*"_id": "5f1602c9de0047524d188abb",
        "article_id": 1,
        "title": "Rammstein",
        "tag": "rammstein",
        "content": "Rammstein
         "created": "Tue Jul 21 2020 02:47:05 GMT+0600 (GMT+06:00)",
            "modified": "Tue Jul 21 2020 02:47:05 GMT+0600 (GMT+06:00)"*/
        
    }
