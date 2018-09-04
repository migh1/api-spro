<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function create(){
		http_response_code(200);
		
		//Verifica se a requisição é do tipo POST
		if ($this->input->post()) {
			//Recebe os campos do POST
			$post 				= $this->input->post();

			//Declaração das variáveis de retorno
			$retorno 			= array();
			$erro 				= false;
			$mensagem 			= '';
			$array_parametros	= array(
				'email',
				'username',
				'senha',
				'nome'
			);

			//Verifica se é um array
			if (is_array($post)) {
				//Verifica se as chaves principais para create de usuario estão no array da requisicao
				if (
					!(
						array_key_exists('email', $post) 	&& 
						array_key_exists('username', $post) &&
						array_key_exists('senha', $post) 	&&
						array_key_exists('nome', $post)
					)
				) {
					http_response_code(400);
					$erro 		= true;
					$mensagem 	= 'Formato de requisicao invalido.';
				} else {
					/* //Validacao da autenticaçao da api
					//Declaração das variaveis de authorização
					$username = '';
					$password = '';
					$hasAuth = 0;

					//Verifica nas headers se o parametro Authorization foi preenchido e se é do tipo Basic
					if (!empty(getallheaders()['Authorization'])) {
						if (preg_match('/^basic/i', getallheaders()['Authorization'])) {
							list($username, $password) = explode(':', base64_decode( substr( getallheaders()['Authorization'], 6)));
							//Validacao do usuario e senha para nivel de permissao
							if (strtolower($username) == 'admin' && strtolower($password) == 'admin') {
								$hasAuth = 1;
							} else if(strtolower($username) == 'user' && strtolower($password) == 'user') {
								$hasAuth = 2;
							}
						}
					}
					*/

					//Percorre pelos campos
					foreach ($post as $key => $value) {
						//A variavel $key é o parametro/campo do array
						$key = strtolower($key);
						//Verifica se é um campo válido permitido
						if (in_array($key, $array_parametros)) {
							//Validação para campo nao vazio
							if (!empty($value)) {
								//Verifica se o campo é 'email' para validar o mesmo
								if ($key == 'email') {
									if($this->validaEmail($value)) {
										$this->load->model('model_api', 'api');
										//Verifica se o email em questão já não está cadastrado no banco
										if(!$this->api->get_usuario_by_parametro($key, $value)){
											$erro 				= true;
											$mensagem 			.= "'" . $key . "' ja cadastrado.";
											$http_status 		= http_response_code(400);
										}
									} else {
										$erro 				= true;
										$mensagem 			.= "Parametro '" . $key . "' nao e um email valido.";
										$http_status 		= http_response_code(400);
									}
								} else if ($key == 'username') { //Verifica se o campo é 'username' para validar o mesmo
									$this->load->model('model_api', 'api');
									//Verifica se o username em questão já não está cadastrado no banco
									if(!$this->api->get_usuario_by_parametro($key, $value)){
										$erro 				= true;
										$mensagem 			.= "'" . $key . "' ja cadastrado.";
										$http_status 		= http_response_code(400);
									}
								}
							} else {
								$erro 				= true;
								$mensagem 			.= "Parametro '" . $key . "' nao pode ser vazio.";
								$http_status 		= http_response_code(400);
							}
						} else {
							$erro 				= true;
							$mensagem 			.= "Parametro '" . $key . "' nao reconhecido.";
							$http_status 		= http_response_code(400);
						}
					}
				}
			} else {
				http_response_code(400);
				$erro 		= true;
				$mensagem 	= 'Formato de requisicao invalido.';
			}
			
			if ($erro) {
				$retorno = array(
					"erro" => array(
						'mensagem' 		=> utf8_encode($mensagem),
						'http_status' 	=> http_response_code()
					)
				);
			} else {
				//Prepara os dados para inserção
				$post_insert = array(
					'email' 	=> trim($post['email']),
					'username' 	=> trim($post['username']),
					'senha' 	=> sha1(trim($post['senha'])),
					'nome' 		=> trim($post['nome'])
				);

				//Cadastra o usuario
				$dados_insert = $this->api->create($post_insert);

				//Verifica retorno do banco
				if($dados_insert){
					//Prepara array de retorno da requisicao
					$retorno = array(
						'id' 			=> $dados_insert['id'],
						'email' 		=> $post_insert['email'],
						'username' 		=> $post_insert['username'],
						'nome' 			=> $post_insert['nome'],
						'data_criacao' 	=> $dados_insert['data_criacao']
					);
				} else {
					http_response_code(400);
					$retorno = array(
						"erro" => array(
							'mensagem' 		=> utf8_encode('Falha ao inserir registro.'),
							'http_status' 	=> http_response_code()
						)
					);
				}
			}

		} else {
			http_response_code(400);
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($retorno));
	}

	public function validaEmail($email) {
		$conta 		= '/^[a-zA-Z0-9\._-]+?@';
		$domino 	= '[a-zA-Z0-9_-]+?\.';	
		$gTLD 		= '[a-zA-Z]{2,6}'; //.com; .coop; .gov; .museum; etc.	
		$ccTLD 		= '((\.[a-zA-Z]{2,4}){0,1})$/'; //.br; .us; .scot; etc.
		$pattern 	= $conta.$domino.$gTLD.$ccTLD;
		
		return preg_match($pattern, $email);
	}
}
