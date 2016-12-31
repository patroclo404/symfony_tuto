<?php 
	namespace AppBundle\Services;

	use Firebase\JWT\JWT;
	/**
	* 
	*/
	class JwtAuth{
		public $manager;
		public $key;

		public function __construct($manager){
			$this->manager = $manager;
			$this->key = "clave-secreta";
		}

		public function signup($email, $password, $getHash = NULL){
			$key = $this->key;

			$user = $this->manager->getRepository('BackendBundle:User')->findOneBy(
				array(
						"email" => $email,
						"password" => $password
					)
				);

			if (is_object($user)) {

				$token = array(
					"sub" => $user->getId(),
					"email"=>$user->getEmail(),
					"name"=>$user->getName(),
					"surname"=>$user->getSurname(),
					"password"=>$user->getPassword(),
					"image"=>$user->getImage(),
					"iat"=>time(),
					"exp"=>time() + (7 * 24 * 60 * 60)
					);

				$jwt = JWT::encode($token, $key, 'HS256');
				$decoded = JWT::decode($jwt,$key,array('HS256'));
				if ($getHash != null) {
					return $jwt;
				}
				return $decoded;
				
				

				//return array("status"=>"success","data"=>"login success!!");
			}
			return array("status"=>"fail","data"=>"Login failed!!");
		}

		public function checkToken($jwt, $getIdentity = false){
			$key = $this->key;
			$auth = false;

			try {
				$decoded = JWT::decode($jwt,$key,array('HS256'));
			} catch (\UnexpectedValueException $e) {
				
			}catch(\DomainException $e) {

			}

			$auth = (isset($decoded->sub)) ? true : false;

			if($getIdentity && $auth)
				return $decoded;
			return $auth;
			
		}
	}
	