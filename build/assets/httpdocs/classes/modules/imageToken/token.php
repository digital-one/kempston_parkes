<?php 

class token
{
	private $img;
	
	public $alpha="123456789qwertyuiopasdfghjklzxcvbnm";
	
	public $length=5;
	public $code;
	public $fonts= array('arialbd.ttf','comic.ttf');
	
	public $x=250;
	public $y=100;
	
	public $background=array(250,250,250);
	public $foreground=array(220,220,220);
	public $shadow=array(169,169,169);
	
	function __construct()
	{
		global $CONF;
		$this->fontPath=realpath('.')."/classes/modules/imageToken/";
		$this->background=array($CONF->get("/configuration/imageToken/background/r"),$CONF->get("/configuration/imageToken/background/g"),$CONF->get("/configuration/imageToken/background/b"));
		$this->foreground=array($CONF->get("/configuration/imageToken/foreground/r"),$CONF->get("/configuration/imageToken/foreground/g"),$CONF->get("/configuration/imageToken/foreground/b"));
		$this->shadow=array($CONF->get("/configuration/imageToken/shadow/r"),$CONF->get("/configuration/imageToken/shadow/g"),$CONF->get("/configuration/imageToken/shadow/b"));

		$this->generate();
	}
	
	function generate()
	{
		$size=strlen($this->alpha)-1;
		for($i=0;$i<$this->length;$i++)
		{
			$x=mt_rand(0,$size);
			$tmp.=$this->alpha[$x];
		}
		$this->code=$tmp;
		
		$this->img = ImageCreateTrueColor($this->x,$this->y) or die("Cannot Initialize new GD image stream");
		
		$bg = ImageColorAllocate($this->img, $this->background[0], $this->background[1], $this->background[2]); 
		$fg = ImageColorAllocate($this->img, $this->foreground[0], $this->foreground[1], $this->foreground[2]); 
		$sh = ImageColorAllocate($this->img, $this->shadow[0], $this->shadow[1], $this->shadow[2]); 
		
		ImageFilledRectangle($this->img, 0, 0, $this->x, $this->y, $bg);  
		
		for($i = 0; $i < 25; $i++) //w pêtli
		{       
			$x=mt_rand(0, $this->x+200);
			$y=mt_rand(0, $this->y+200);
			$w=mt_rand(50, 200);
			$h=mt_rand(50, 200);
	
			for($j = 0; $j < 100; $j+=10) 
			ImageEllipse($this->img, ($x+$j), ($y+$j), ($w+$j), ($h+$j), $fg); //tworzymy losowo rozmieszczone elipsy o kolorze darkgray 
		} 
		
		$a=40;//mt_rand(35,50);
		$b=mt_rand(-7,7);
		if($b<0) $y=mt_rand(40,65);
		else $y=mt_rand(65,90);
		$x=mt_rand(10,45);
		$e=$this->fontPath.$this->fonts[rand(0, count($this->fonts) - 1)];
		
		ImageTTFText($this->img, $a, $b, $x, $y, $sh, $e, $this->code); //dodajemy do rysunku tekst o losowym po³o¿eniu, kolorze darkgray, losowej czcionce (losowanej z tablicy) oraz tekœcie, który przeka¿emy za pomoc¹ sesji   
		ImageTTFText($this->img, $a+5, $b, $x+1, $y-1, $fg, $e, $this->code);
		

	}
	
	function __destruct()
	{
		ImageDestroy($this->img);
	}
	
	function showImage()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header("Content-type: image/jpeg");

		ImagePNG($this->img);
	}
}

?>
