<?php
    
    namespace App\Http\Services;
    
    
    class Helper
    {
        
        public static function extractTagsAndConvertSingleJsonToArray($tags_json)
        {
            $key_array = \GuzzleHttp\json_decode($tags_json, true);
            $tags = [];
            foreach ($key_array as $key) {
                $tags[] = $key['tag'];
            }
            return $tags;
        }
        
        
        public static function convertJsonToArray($json)
        {
            return json_decode($json, true);
        }
        
        public static function truncateArrayTexts($data, $max)
        {
            $converted_data = [];
            
            foreach ($data as $item) {
                $converted_item = [];
                foreach ($item as $field => $value) {
                    
                    if (in_array($field, self::dateFieldsList())) {
                        $converted_item[$field] = self::convertData($value);
                    } else {
                        
                        if (strlen($value) > $max) {
                            $converted_item[$field] = self::truncate_text_nicely($value, $max, 'Подробнее...');
                        } else {
                            $converted_item[$field] = $value;
                        }
                    }
                    
                }
                $converted_data[] = $converted_item;
            }
            return $converted_data;
        }
        
        public static function convertData($date_string)
        {
            $date_time = strtotime($date_string);
            $dt = date('Y-m-d H:i:s', $date_time);
            return $dt;
        }
        
        private static function dateFieldsList()
        {
            return [
                'created',
                'modified'
            ];
        }
        
        
        // A function to truncate text to a length and indicate more is available.
        public static function truncate_text_nicely($string, $max, $moretext)
        {
            // Only begin to manipulate if the string is longer than max
            if (strlen($string) > $max) {
                // Modify $max by removing the length of moretext to allow room
                $max -= strlen($moretext);
                
                // Snag only the appropriate part of the string.
                $string = strrev(strstr(strrev(substr($string, 0, $max)), ' '));
                
                // Add the moretext onto it:
                $string .= $moretext;
            }
            
            // Return the string, whether it was modified or not.
            return $string;
        }
        
        
        public static function getBadge($text)
        {
            $form = '<div
                      class="flex items-center bg-grey-600 text-white text-sm font-bold px-4 py-3"
                      role="alert">
                      <i class="fas fa-bookmark"></i>
                      <p>' . $text . '</p>
                      </div>';
            
            return $form;
        }
        
        
        public static function getGridKeysPanel($target_key = null)
        {
            
            $keys = self::getDemoKeys($target_key);
            
            $panel = [];
            
            foreach ($keys as $key) {
                $badge = '<div class="flex-1 bg-gray-600 h-12">';
                $badge .= self::getBadge($key);
                $badge .= '</div>>';
                $panel[] = $badge;
            }
            
            return implode('', $panel);
        }
        
        public static function getDemoKeys($target_key = null)
        {
            return [
                'Dogs foods',
                'Dogs breeds',
                'Treating dogs',
                'Dog training',
                'Dog shows',
                'Diseases of dogs',
                'Dog walking areas',
            ];
        }
        
        
    }

?>



