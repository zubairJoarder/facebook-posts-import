<?php

//class that reads facebook JSON data and post to wordpress
class WordpressPoster{

	//attribute
	private $facebookJsonFileSource = null;
	
	//class constructor
	public function __construct(){
		if(DATA_MODE == "FILE_READ"){
			$this->facebookJsonFileSource = DATA_SOURCE;
		}else{
			echo "Get data from Facebook";
		}
	}
	
	//public function that imports facebook news post
	public function importFacebookPost(){
		if($this->facebookJsonFileSource!=null){
			$this->readFacebookJsonFile();
		}else{
			$this->getJsonDataFromFacebook();
		}
	}
	
	//to implement if sample data was not given
	public function getJsonDataFromFacebook(){
		echo "to implement if sample data was not given";
	}
	
	//read JSON file and post to wordpress
	private function readFacebookJsonFile(){
		$facebookJson = json_decode(file_get_contents($this->facebookJsonFileSource), true);
		if($facebookJson){
			foreach($facebookJson as $type => $data){
				if($type == 'data'){
					foreach($data as $itemNumber => $info){
						$currentData = $data[$itemNumber];
						$message = $currentData['message'];
						$pictureLink = $currentData['picture'];
						$storyLink = $currentData['link'];
						$articleName = $currentData['name'];
						$caption = strtoupper($currentData['caption']);
						$postMsg = "<div><p>{$message}</p><b>{$articleName}</b><br/><a href='{$storyLink}'>{$caption}</a></div>";
						
						if($articleName == '')continue;
						$post = array(
							'post_title'    => $articleName,
							'post_content'  => $postMsg,
							'post_status'   => 'publish',
							'post_author'   => get_current_user_id(),
							'post_type'     => 'post',
							'post_category' => array(0)
						);
						
						global $wpdb;
						$articleName = str_replace("'", "\\'", $articleName );
						$return = $wpdb->get_row( "SELECT ID FROM wp_posts WHERE post_title = '" . $articleName . "' && post_status = 'publish' && post_type = 'post' ", 'ARRAY_N' );
						if( empty( $return ) ) {
							$post_id = wp_insert_post($post);
						} else {
						}
					}
				}	
			}
		}else{
			throw new Exception("Error: file format error, expecting JSON file");
		}
	}
}

?>


