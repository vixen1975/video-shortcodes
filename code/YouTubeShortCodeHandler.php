<?php 
class YouTubeShortCodeHandler {
	
	public static function parse_youtube($arguments, $caption = null, $parser = null, $tagName) {
		// first things first, if we dont have a video ID, then we don't need to
		// go any further
		if (empty($arguments['id'])) {
			return;
		}

		$customise = array();

		// YouTube video id
		$customise['YouTubeID'] = $arguments['id'];
		
		$id = $arguments['id'];
		$do = Video::get()->filter(array('VideoType' => 'YouTube', 'ExternalID' => $id))->First();
		if($do){
			if(isset($arguments['popup']) && $arguments['popup'] == true){
				//need to render a popup link instead of embed
				if($do->ImageID > 0){
					$customise['Image'] = $do->Image();
				}
				$customise['ViewURL'] = 'https://www.youtube.com/watch?v='.$id;
				$customise['Title'] = $do->Title;
				$customise['Type'] = 'Upload';
				$template = new SSViewer('VideoPopup');
			} else {
				//play the video on page load
				$set = isset($arguments['autoplay']);
				$customise['AutoPlay'] = $set ? true : false;
		
				
				//set dimensions
				$widthSet = isset($arguments['width']);
				$heightSet = isset($arguments['height']);
				$customise['Width'] = $widthSet ? $arguments['width'] : 640;
				$customise['Height'] = $heightSet ? $arguments['height'] : 360;
		
				//get our Vimeo template
				$template = new SSViewer('YouTube');
			}
	
			//return the customised template
			return $template->process(new ArrayData($customise));
		} else {
			return;
		}

	}
}

class VimeoShortCodeHandler {
	
	public static function parse_vimeo($arguments, $caption = null, $parser = null, $tagName) {
		// first things first, if we dont have a video ID, then we don't need to
		// go any further
		if (empty($arguments['id'])) {
			return;
		}

		$customise = array();

		// Vimeo video id
		$customise['VimeoID'] = $arguments['id'];

		$id = $arguments['id'];
		$do = Video::get()->filter(array('VideoType' => 'Vimeo', 'ExternalID' => $id))->First();
		if($do){
			if(isset($arguments['popup']) && $arguments['popup'] == true){
				//need to render a popup link instead of embed
				if($do->ImageID > 0){
					$customise['Image'] = $do->Image();
				}
				$customise['ViewURL'] = 'https://vimeo.com/'.$id;
				$customise['Title'] = $do->Title;
				$customise['Type'] = 'Upload';
				$template = new SSViewer('VideoPopup');
			} else {
				//play the video on page load
				$set = isset($arguments['autoplay']);
				$customise['AutoPlay'] = $set ? true : false;
		
				
				//set dimensions
				$widthSet = isset($arguments['width']);
				$heightSet = isset($arguments['height']);
				$customise['Width'] = $widthSet ? $arguments['width'] : 640;
				$customise['Height'] = $heightSet ? $arguments['height'] : 360;
		
				//get our Vimeo template
				$template = new SSViewer('Vimeo');
			}
	
			//return the customised template
			return $template->process(new ArrayData($customise));
		} else {
			return;
		}
	}
}

class UploadShortCodeHandler {
	
	public static function parse_upload($arguments, $caption = null, $parser = null, $tagName) {
		// first things first, if we dont have a video ID, then we don't need to
		// go any further
		if (empty($arguments['id'])) {
			return;
		}

		$customise = array();

		// video id
		$id = $arguments['id'];
		$do = Video::get()->byID($id);
		if($do){
			$customise['MP4'] = $do->VideoMP4()->URL;
			if($do->VideoOgg()->URL){
				$customise['Ogg'] = $do->VideoOgg()->URL;
			}
			if(isset($arguments['popup']) && $arguments['popup'] == true){
				//need to render a popup link instead of embed
				$customise['Image'] = $do->Image();
				$customise['ViewURL'] = '/video/'.$id;
				$customise['Title'] = $do->Title;
				$customise['Type'] = 'Upload';
				$template = new SSViewer('VideoPopup');
			} else {
				//play the video on page load
				$set = isset($arguments['autoplay']);
				$customise['AutoPlay'] = $set ? true : false;
		
				
				//set dimensions
				$widthSet = isset($arguments['width']);
				$heightSet = isset($arguments['height']);
				$customise['Width'] = $widthSet ? $arguments['width'] : 640;
				$customise['Height'] = $heightSet ? $arguments['height'] : 360;
		
				//get our Vimeo template
				$template = new SSViewer('Upload');
			}
	
			//return the customised template
			return $template->process(new ArrayData($customise));
		} else {
			return;
		}

		
	}
}