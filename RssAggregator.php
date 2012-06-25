<?php

//include('XML2Array.php');

function getFeed($feed_url, $urlid) {

    $content = file_get_contents($feed_url);
    $x = new SimpleXMLElement($content);
    print_r($x);
    //$title = $x->attributes('entry');
    //print_r($title);
    /*
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
     * 
     */
//print_r($xml_array); 
    switch ($urlid) {
        case 2:
        case 3:
        case 4:
        case 6:
        case 7:
        case 8:
            foreach ($x->channel->item as $entry) {
                $title = $entry->title;
                $article = strip_tags($entry->description);
                $pattern = '/[\s|\n|\r]+/';
                $article = preg_replace($pattern, " ", $article);
                $article = str_replace('&nbsp;', "", $article);
            }
            break;
        case 1:
        case 5:
            break;
        default:
            break;
    }
}

$host = 'localhost';
$user = 'sync_manager';
$pwd = '8EtHAcH2';
$db = 'ocv_application';
$tbl_src = "ocv_news_sources";
$tbl_article = "ocv_news_articles";
$con = mysql_connect($host, $user, $pwd) or die('connection failed: ' . mysql_error());
mysql_select_db($db, $con);

$sql = "SELECT * FROM " . $tbl_src . " WHERE is_active='1'";
$srcs = mysql_fetch_assoc($sql);
foreach ($srcs as $key => $val) {
    //$urlid = $src->urlid;
    //$departmentid = $src->departmentid;
    //$url = $src->url;
    $src[$key] = $val;
    print_r($src);
}
////$url = 'http://rss1.smashingmagazine.com/feed/';//urlid=1
//$url = 'http://feeds.feedburner.com/net/topstories?format=xml';//urlid=2
//$url = 'http://images.apple.com/main/rss/hotnews/hotnews.rss';//urlid=3
//$url = 'http://feeds.feedburner.com/CssTricks?format=xml';//urlid=4
////$url = 'http://feeds.feedburner.com/webdesignerdepot?format=xml';//urlid=5
//$url = 'http://feeds.feedburner.com/WebDesignerMag?format=xml';//urlid=6
//$url = 'http://rss.macworld.com/macworld/feeds/main';//urlid=7
//$url = 'http://www.maclife.com/articles/all/feed'; //urlid=8
//getFeed($url);
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
$con->close();
?>