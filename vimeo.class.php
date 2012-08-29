<?php
/*
Examples of use :
$addr1 = 'http://vimeo.com/api/v2/channel/videoschool/videos.xml';
$addr2 = 'http://vimeo.com/api/v2/channel/wineaftercoffee/videos.xml';

$vimeo = new vimeo;
$vimeo->addFeed($addr1);
$vimeo->addFeed($addr2);

$arr = $vimeo->getFeed();
or
$arr = $vimeo->getFeed('water');
or
$searchArray = Array('glass', 'trix');
$arr = $vimeo->getFeed($searchArray);

foreach($arr as $row)
{
	echo '<iframe src="http://player.vimeo.com/video/'.$row->id.'" width="WIDTH" height="HEIGHT" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe><br />';	
}
*/
class vimeo
{
	public $addr = NULL;
	private $outArr = Array();
	function __construct($addr = NULL)
	{
		$this->addr = $addr != NULL ? $addr : $this->addr;
		if($this->addr)
		{
			return $this->addFeed();	
		}		
	}

	function addFeed($addr = NULL)
	{
		$this->addr = $addr != NULL ? $addr : $this->addr;
		$rss = simplexml_load_file($this->addr);
		$this->outArr = array_merge($this->outArr, $rss->xpath('/videos//video'));
	}	

	function getFeed($input = NULL)
	{
		usort($this->outArr, function ($x, $y)
		{
			if (strtotime($x->pubDate) == strtotime($y->pubDate)) return 0;
    		return (strtotime($x->pubDate) > strtotime($y->pubDate)) ? -1 : 1;		
		});

		if(is_array($input))
		{
			$this->outArr = $this->getArrayFilteredFeed($input);
		}
		elseif(is_string($input))
		{
			$this->outArr = $this->getStringFilteredFeed($input);
		}

		return $this->outArr;
	}

	private function getStringFilteredFeed($s)
	{
		$tempArr = Array();
		foreach($this->outArr as $row)
		{
			if(stristr($row->title,$s) || stristr($row->description,$s))
			{
				array_push($tempArr, $row);
			}
		}
		return $tempArr;
	}

	private function getArrayFilteredFeed($arr)
	{
		$tempArr = Array();
		foreach($this->outArr as $row)
		{
			foreach ($arr as $key) 
			{
				if(stristr($row->title,$key) || stristr($row->description,$key))
				{
					array_push($tempArr, $row);
				}
			}
		}
		return $tempArr;
	}
}
new vimeo;
?>