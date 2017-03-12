<?php  if ( ! defined('INDEX')) exit('No direct script access allowed');
class data extends Controller {
	function getRandomImage(){
		$images = load_recursive('application/images', 2, array('jpg'));
		$rand_image = rand(0,count($images)-1);

		$path = base_url.'application/images/'.$images[$rand_image];
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$content = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($content);

		$data['image'] = $base64;
		$this->render->json($data);
	}
}

?>