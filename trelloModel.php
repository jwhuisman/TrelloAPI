<?php
	class TrelloModel extends CI_Model  {
		
		// KEY AND TOKEN FOR MIXFINITY LOGIN
		public $key = "## APP KEY ##";  
		public $token = "## APP SECRET / TOKEN";
 
		public function getBoards(){
			$result = $this->makeRequest("/organizations/mixfinity/boards");
			return $result;
		}
		public function getCards($f_id){
			//echo "https://api.trello.com/1/boards/".$f_id."?lists=open&list_fields=name&fields=name,desc";
			$result = $this->makeRequest("/boards/".$f_id."/cards");
			return $result;
		}
		public function getLists($f_id){
			$result = $this->makeRequest("/boards/".$f_id."/lists?cards=open&list_fields=name&fields=name,desc");
			return $result;
		}
		public function getCardsByList($f_id){
			//$object = (object)$object;
			$result = $this->makeRequest("/boards/".$f_id."/lists?cards=open&card_fields=name,shortUrl&fields=name");
			return $result;
			//print_r($first); 
		}
		private function makeRequest($input){
			$url = 'https://api.trello.com/1'.$input;
			if(strpos($input, "?") > 0 ){
				$suffix = '&key='.$this->key.'&token='.$this->token;
			} else {
				$suffix = '?key='.$this->key.'&token='.$this->token;
			}
			$url = $url . $suffix;
	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);		
			$output = curl_exec($ch);
			$request =  curl_getinfo($ch, CURLINFO_HEADER_OUT);
			$error = curl_error($ch);
			//echo $error;
			curl_close($ch);
			//echo $output;
			if(strlen($error) > 0){
				echo "De volgende fout heeft zich voorgedaan: ". $echo;
				die();
			}
			try{
				return json_decode( $output );
			} catch(Exception $e){
				return $output;
			}
			
		}
	} 
?>	 