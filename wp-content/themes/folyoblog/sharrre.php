<?php
  //source http://www.helmutgranda.com/2011/11/01/get-a-url-google-count-via-php/
  
  $json = array('url'=>'','count'=>0);
  
  if(filter_var($_GET['url'], FILTER_VALIDATE_URL)){
    $ch = curl_init();
    
    $json['url'] = $_GET['url'];
    $url = urlencode($_GET['url']);
  
    $encUrl = "https://plusone.google.com/u/0/_/+1/fastbutton?url=".$url."&count=true";
  
    $options = array(
      CURLOPT_RETURNTRANSFER => true, // return web page
      CURLOPT_HEADER => false, // don't return headers
      CURLOPT_FOLLOWLOCATION => true, // follow redirects
      CURLOPT_ENCODING => "", // handle all encodings
      CURLOPT_USERAGENT => 'sharrre', // who am i
      CURLOPT_AUTOREFERER => true, // set referer on redirect
      CURLOPT_CONNECTTIMEOUT => 5, // timeout on connect
      CURLOPT_TIMEOUT => 10, // timeout on response
      CURLOPT_MAXREDIRS => 3, // stop after 10 redirects
      CURLOPT_URL => $encUrl,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => false,
    );
  
    curl_setopt_array($ch, $options);
  
    $content = curl_exec($ch);
    $err = curl_errno($ch);
    $errmsg = curl_error($ch);
  
    curl_close($ch);
  
    if ($errmsg != '' || $err != '') {
      /*print_r($errmsg);
      print_r($errmsg);*/
    }
    else {
      $dom = new DOMDocument;
      $dom->preserveWhiteSpace = false;
      @$dom->loadHTML($content);
      $domxpath = new DOMXPath($dom);
      $newDom = new DOMDocument;
      $newDom->formatOutput = true;
  
      $filtered = $domxpath->query("//div[@id='aggregateCount']");
          
      $json['count'] = str_replace('>', '', $filtered->item(0)->nodeValue);
    }
  }
  echo str_replace('\\/','/',json_encode($json));
?>
