<?php

$result="";
$message = preg_replace_callback('#(?:https?://\S+)|(?:www.\S+)|(?:\S+\.\S+)#', function($arr)
{
    global $result;
    if(strpos($arr[0], 'http') !== 0)
    {
        $arr[0] = 'http://' . $arr[0];
    }
    $url = parse_url($arr[0]);

    if(preg_match('#\.(png|jpg|gif)$#', $url['path']))
    {
        $linkPrev = '<img class="img" src="'. $arr[0] . '" />';
    }
    if(in_array($url['host'], array('www.youtube.com', 'youtube.com'))
      && $url['path'] == '/watch'
      && isset($url['query']))
    {
        parse_str($url['query'], $query);
        $linkPrev = sprintf('<iframe class="embedded-video" src="http://www.youtube.com/embed/%s" allowfullscreen></iframe>', $query['v']);
    }
    $link = sprintf('<a href="%1$s">%1$s</a>', $arr[0]);
    $result = $linkPrev."<br>".$link."<br>";
}, $message);
$message = $result . $message;

?>