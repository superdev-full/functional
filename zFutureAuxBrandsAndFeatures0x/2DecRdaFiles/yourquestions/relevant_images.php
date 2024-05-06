<?php
/**
 *  "<topic_keywork>" => "<image_filename.jpg>",
 * 
 *  - The topic_keywork must be lowercase
 * 	- The image files are saved under assets/images
 *  - Do not erase the first element of the array "default"
 * 
 * 	The code will choose the first match between user's topics and these relevant images
 * 
 *  Example:
 *  "python" => "logo_of_python.jpg",
 * 
 */
	// 
	// 
$relevant_images = array(
	"default" => "default_logo.png",
	// -------------- ADD HERE-----
	"python" => "python_logo.jpg",
	"php" => "php_logo.png",
	"ios" => "ios_logo.png",
	"linux" => "linux.png",
	"bitcoin" => "bitcoin.png",
	"swift" => "swift.png",

	// -------------- ADD HERE-----
);
