<?php

class galleryFullView extends templateEngine
{
	var $title;
	var $shortDescription;
	var $newsDate;
	var $image;
	var $imageMini;
	var $back;
	
	function galleryFullView($id)
	{
		global $LINK;
		global $DB;
		
		$rs=$DB->query("SELECT * FROM gallery WHERE active=1 AND id=".$id);
		$tab=$DB->fetch_array($rs);
				
		$this->back=$LINK->getLink("","galleryId");
		$this->name=stripslashes($tab["name"]);
		$this->title=stripslashes($tab["title"]);
		$this->keywords=stripslashes($tab["keywords"]);
		$this->description=stripslashes($tab["description"]);
		$this->fullDescription=stripslashes($tab["fullDescription"]);

	
		$query="SELECT * FROM gallery_photo WHERE active=1 AND galleryId=".$tab["id"]." ORDER BY position ASC, id ASC";
		
		$rs=$DB->query($query);
		while($tab=$DB->fetch_array($rs)) 
		{
			$tab["imgBig"]='data/gallery_photo/image/'.$tab["photo"];
			$tab["imgMini"]='data/gallery_photo/image/100x75/'.$tab["photo"];
			$tab["title"]=stripslashes($tab["title"]);
			$this->items[]=$tab;
		}

		
		
		
		$this->parseTemplate("templates/modules/gallery/galleryFullView.html");
	}
}

?>