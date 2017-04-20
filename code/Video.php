<?php 
class Video extends DataObject {
	
	private static $db = array(
	  'Title' => 'Text',
	  'VideoType' => 'Enum("Upload, YouTube, Vimeo")',
	  'ExternalID' => 'Text'
	);
	
	private static $has_one = array(
		'Image' => 'Image',
		'VideoMP4' => 'File',
		'VideoOgg' => 'File'
	);
	
	private static $summary_fields = array(
		'Thumbnail' => 'Thumbnail',
	 	'Title' => 'Title'
	);
	
	public function getThumbnail() { 
		   return $this->Image()->CMSThumbnail();
	}
	
	public function getCMSFields(){
		$fields = new FieldList();
		$literal_u = DisplayLogicWrapper::create(new LiteralField('', '<div class="field"><p>Use this shortcode to embed the video in a page/post:<strong> [Video id='.$this->ID.'/]</strong></p><p>Use this shortcode to add the video as a popup in a page/post:<strong> [Video id="'.$this->ID.'" popup="true"]</strong></p></div>'));
		$literal_u->displayIf('VideoType')->isEqualTo('Upload');
		$literal_y = DisplayLogicWrapper::create(new LiteralField('', '<div class="field"><p>Use this shortcode to embed the YouTube video in a page/post:<strong> [YouTube id='.$this->ID.'/]</strong></p><p>Use this shortcode to add the video as a popup in a page/post:<strong> [YouTube id="'.$this->ExternalID.'" popup="true"]</strong></p></div>'));
		$literal_y->displayIf('VideoType')->isEqualTo('YouTube');
		$literal_v = DisplayLogicWrapper::create(new LiteralField('', '<div class="field"><p>Use this shortcode to embed the Vimeo video in a page/post:<strong> [Vimeo id='.$this->ID.'/]</strong></p><p>Use this shortcode to add the video as a popup in a page/post:<strong> [Vimeo id="'.$this->ExternalID.'" popup="true"]</strong></p></div>'));
		$literal_v->displayIf('VideoType')->isEqualTo('Vimeo');
		$fields->push($literal_u);
		$fields->push($literal_y);
		$fields->push($literal_v);
		$fields->push(new TextField('Title', 'Title'));
		$fields->push(new DropdownField('VideoType', 'Type of video', $this->dbObject('VideoType')->enumValues()));
		$fields->push(new UploadField("Image", "Video thumbnail"));
		$vid = DisplayLogicWrapper::create(new UploadField("VideoMP4", "Video MP4 File"), new UploadField("VideoOgg", "Video OGG File"));
		$vid->displayIf('VideoType')->isEqualTo('Upload');
		$ex = DisplayLogicWrapper::create(new LiteralField("", "<div class='field'><p>The YouTube ID is found in the url after the 'watch?v=' eg https://www.youtube.com/watch?v=<strong>f-j3RZmyRpM</strong></p><p>The Vimeo ID is found in the url after the '/' eg https://vimeo.com/<strong>178783368</strong></p></div>"), new TextField("ExternalID", "YouTube or Vimeo video ID"));
		$ex->displayIf('VideoType')->isEqualTo('YouTube')->orIf('VideoType')->isEqualTo('Vimeo');
		$fields->push($vid);
		$fields->push($ex);
		return $fields;
	}
	
	public function VideoURL(){
		if($this->VideoType == 'YouTube'){
			$url = 'https://www.youtube.com/watch?v='.$this->ExternalID;
		} else if($this->VideoType == 'Vimeo'){
			$url = 'https://vimeo.com/'.$this->ExternalID;
		} else {
			$url = '/video/'.$this->ID;
		}
		return $url;
	}
	
	
	
}

class Video_Controller extends Page_Controller {
	
	public function index(SS_HTTPRequest $request) {
		if($this->request->param('ID')){
			$video = Video::get()->byID($this->request->param('ID'));
			if($video){
				return $this->customise($video)->renderWith('VideoPlayer');
			}
		}
	}
}