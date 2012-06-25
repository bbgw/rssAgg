<?php

include('XML2Array.php');

function getFeed($feed_url) {

    $content = file_get_contents($feed_url);
    $x = new SimpleXMLElement($content);

    $dom = new DOMDocument();
    $dom->loadXML($x->asXML());

    $xml_array = XML2Array::createArray($dom);

    foreach ($xml_array['feed']['entry'] as $item) {
        $title = $item['title']['@cdata'];
        $link = $item['link']['0']['@attributes']['href'];
        $content = $item['summary']['@cdata'];
        $content = strip_tags($content);
        echo $title . "\n" . $link . "\n" . $content . "\n\n";
    }
//print_r($xml_array); 
    // echo "<ul>";  
//    foreach($x->channel->item as $entry) {  
    //       echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";  
    //  }  
    //echo "</ul>";  
}

$url = 'http://rss1.smashingmagazine.com/feed/';
getFeed($url);
/*
  $ch = curl_init("http://rss1.smashingmagazine.com/feed/");
  //$fp = fopen("example_homepage.txt", "w");

  //curl_setopt($ch, CURLOPT_FILE, $fp);
  //curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $return = curl_exec($ch);
  print $result;
  curl_close($ch);
  //fclose($fp);
 */
?>
