<?php
require_once 'classes/autoload.php';

$addr1 = 'http://vimeo.com/api/v2/channel/videoschool/videos.xml';
$addr2 = 'http://vimeo.com/api/v2/channel/wineaftercoffee/videos.xml';

$vimeo = new vimeo;
$vimeo->addFeed($addr1);
$vimeo->addFeed($addr2);

$arr = $vimeo->getFeed();
// $arr = $vimeo->getFeed('water');

// $searchArray = Array('glass', 'trix');
// $arr = $vimeo->getFeed($searchArray);

foreach($arr as $row)
{
	echo '<iframe src="http://player.vimeo.com/video/'.$row->id.'" width="WIDTH" height="HEIGHT" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe><br />';	
}
?>