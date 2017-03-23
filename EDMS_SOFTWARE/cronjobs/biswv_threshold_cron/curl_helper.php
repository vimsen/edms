<?php
/**
 * Description of curl_helper
 *
 * @author intelen
 */
class curl_helper {
    /**
     * Send a POST requst using cURL 
     * @param string $url to request 
     * @param array $post values to send 
     * @param array $options for cURL 
     * @return string 
     */
    static function curl_post($url, array $post = NULL, array $options = array(), $put = false, $debug = false) {
        $curlCommand = '';
        $defaults = array(
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 50,
            CURLOPT_POSTFIELDS => http_build_query($post, '&')
        );
        if($put){
            $defaults[CURLOPT_CUSTOMREQUEST] = "PUT"; 
            $defaults[CURLOPT_POST]= 1;
        } else {
            $defaults[CURLOPT_POST]= 1;
        }
        if (isset($defaults[CURLOPT_POST]) && $debug) {
            $curlCommand = 'curl --data "'.$defaults[CURLOPT_POSTFIELDS].'" --url "'.$url.'" --header "Content-type:application/x-www-form-urlencoded"';
        }
        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        return Curl_helper::curl_execute($ch, $debug, $curlCommand);
    }
    
    /**
     * 
     * @param type $url
     * @return type
     */
    static function curl_get($url, $debug = false){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        return Curl_helper::curl_execute($ch, $debug);
    }

    //Curl_helper::curl_put($this->write_api_url . "thresholds_log", $threshold_log->toArray(), array(), $this->debug);
    static function curl_put($url, array $post = NULL, array $options = array(), $debug = false){
        //return Curl_helper::curl_post($url, $post, $options, true, $debug);
        return Curl_helper::curl_post($url, $post, $options, true, $debug);
    }
    
    static function curl_execute($ch, $debug = false, $curlCommand = ''){
        
        if (!$result = curl_exec($ch)) {
            trigger_error(curl_error($ch));
        }
        if($debug){
            $curlVersion = curl_version();
            extract(curl_getinfo($ch));
            $curlCommand = $curlCommand == '' ? "curl $url" : $curlCommand;
            $metrics = 
<<<EOD
            <h1>Curl Debug</h1>
            URL....: $url <br/>
            Code...: $http_code ($redirect_count redirect(s) in $redirect_time secs) <br/>
            Content: $content_type Size: $download_content_length (Own: $size_download) Filetime: $filetime <br/>
            Time...: $total_time Start @ $starttransfer_time (DNS: $namelookup_time Connect: $connect_time Request: $pretransfer_time) <br/>
            Speed..: Down: $speed_download (avg.) Up: $speed_upload (avg.) <br/>
            Curl...: v{$curlVersion['version']} <br/>
            cURL Console Command...: $curlCommand <br/>
EOD;
            echo $metrics;
            echo "\n\nResult.: ".substr($result, 0, 100)."\n";
        }
        curl_close($ch);
        $array = json_decode($result, true);
        if(!$array && $debug){
            echo "Result not valid JSON";
            echo "$result";
        }
        return $array;
    }
    
}

?>
