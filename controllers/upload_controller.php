<?php
include_once "../config.php";

class UploadController{

        protected int $size;

        function __construct($size = 16){
                $this->size = $size;
        }

        public function get_hashed_key(){
                $bytes = random_bytes( $this->size );
                $result = bin2hex($bytes);
                // $formated = substr($result,0,4) . "-" . substr($result,4,4) . "-" . substr($result,8,4). "-" . substr($result,12,4);  
				$formated =$result;
                return strtoupper( $formated );
        }

		public function create_secure_path(){
			$path = "";

			$path .=  $this->get_hashed_key() . "/" .  $this->get_hashed_key() . "/" .  $this->get_hashed_key() . "/";

			if (!mkdir(UPLOAD_PATH . $path, 0755, true)) {
				return "";
			}			

			return $path;
		}

		public function create_secure_filname(){
			$filename = $this->get_hashed_key();
			return $filename;
		}		
}