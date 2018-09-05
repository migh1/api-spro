<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct() {
    	parent::__construct();
		//Declaração das variaveis de authorização
		$this->login 		= '';
		$this->password 	= '';
		$this->parametro 	= '';
		$this->id 			= '';
		$this->username 	= '';
		$this->email 		= '';
		//Inicializa um global com permissao de visitante
		$this->permissao = 2;
	}

	//Realiza a inserção do registro na base
	public function create(){
		//Verifica se a requisição é do tipo POST
		if ($this->input->post()) {
			http_response_code(200);

			//Recebe os campos do POST
			$post 		= $this->input->post();
			$retorno 	= $this->validaRequisicao($post, 'create');
			
			if ($retorno['erro']) {
				$retorno = array(
					"erro" => array(
						'mensagem' 		=> utf8_encode($retorno['mensagem']),
						'http_status' 	=> $retorno['http_status']
					)
				);
			} else {
				$admin 	= (isset($post['admin']) ? (is_numeric($post['admin']) ? ($post['admin'] == 1 ? $post['admin'] : 0) : 0) : 0);
				
				//Prepara os dados para inserção
				$post_insert = array(
					'email' 	=> trim($post['email']),
					'username' 	=> trim($post['username']),
					'senha' 	=> sha1(trim($post['senha'])),
					'nome' 		=> trim($post['nome']),
					'admin' 	=> $admin
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
					http_response_code(500);
					$retorno = array(
						"erro" => array(
							'mensagem' 		=> utf8_encode('Falha ao inserir registro.'),
							'http_status' 	=> http_response_code()
						)
					);
				}
			}
		} else {
			$retorno = array();
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($retorno));
	}

	//Realiza a edição do registro na base
	public function edit(){
		//Verifica se a requisição é do tipo POST
		if ($this->input->post()) {
			http_response_code(200);

			//Recebe os campos do POST
			$post 		= $this->input->post();

			//Verifica se o parametro Authorization foi preenchido
			if (!empty(getallheaders()['Authorization'])) {
				//Validacao do usuario e senha com base na header Authentication
				$this->_autenticaUsuario();
				//Verifica se a permissao é de USER ou ADMIN
				if (in_array($this->permissao, array(0,1))) {
					if (!empty($post['id']) && ($post['id'] != $this->id) && $this->permissao != 1) {
						http_response_code(401);
						$retorno = array(
							'erro'			=> true,
							'mensagem'		=> 'Nao e possivel alterar os dados de outro usuario.',
							'http_status'	=> http_response_code()
						);
					} else {
						$retorno 	= $this->validaRequisicao($post, 'edit');
					}
				} else {
					http_response_code(401);
					$retorno = array(
						'erro'			=> true,
						'mensagem'		=> 'Autenticacao falhou, verifique usuario e senha e tente novamente.',
						'http_status'	=> http_response_code()
					);
				}
				
				if ($retorno['erro']) {
					$retorno = array(
						"erro" => array(
							'mensagem' 		=> utf8_encode($retorno['mensagem']),
							'http_status' 	=> $retorno['http_status']
						)
					);
				} else {
					$update = array();
					//Prepara os dados para a atualização
					if(!empty($post['email']) 		&& !empty(trim($post['email']))){ 		$update['email'] 	= trim($post['email']); 		}
					if(!empty($post['username']) 	&& !empty(trim($post['username']))){ 	$update['username'] = trim($post['username']); 		}
					if(!empty($post['nome']) 		&& !empty(trim($post['nome']))){ 		$update['nome'] 	= trim($post['nome']); 			}
					if(!empty($post['senha']) 		&& !empty(trim($post['senha']))){ 		$update['senha'] 	= sha1(trim($post['senha'])); 	}
					
					if (!empty($update)) {
						//Atualiza o usuario
						$dados_update = $this->api->edit($post['id'], $update);

						//Verifica retorno do banco
						if($dados_update){
							//Prepara array de retorno da requisicao
							$retorno = array(
								'id' 			=> $dados_update['id'],
								'email' 		=> $dados_update['email'],
								'username' 		=> $dados_update['username'],
								'nome' 			=> $dados_update['nome'],
								'data_criacao' 	=> $dados_update['data_criacao']
							);
						} else {
							http_response_code(500);
							$retorno = array(
								"erro" => array(
									'mensagem' 		=> utf8_encode('Falha ao atualizar registro.'),
									'http_status' 	=> http_response_code()
								)
							);
						}
					}
				}
			} else {
				http_response_code(400);
				$retorno = array(
					"erro" => array(
						'mensagem' 		=> utf8_encode('E preciso se autenticar na API para continuar com a edicao'),
						'http_status' 	=> http_response_code()
					)
				);
			}
		} else {
			$retorno = array();
			http_response_code(400);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($retorno));
	}

	//Realiza a leitura/pesquisa do registro na base
	public function read(){
		//Verifica se a requisição é do tipo POST
		if ($this->input->post()) {
			//Recebe os campos do POST
			$post 		= $this->input->post();
			//Verifica se o parametro Authorization foi preenchido
			if (!empty(getallheaders()['Authorization'])) {
				//Validacao do usuario e senha com base na header Authentication
				$this->_autenticaUsuario();

				if (is_array($post)) {
					if(count($post) == 1){
						if (array_key_exists('id', $post) || array_key_exists('username', $post)) {
							if (!empty($post['id'])) {
								if (is_numeric($post['id'])) {
									if ($this->permissao == 1) { //ADMIN
										$this->load->model('model_api', 'api');
										$consulta = $this->api->consulta_por_id($post['id']);

										if (!empty($consulta)) {
											$retorno = $consulta;
										} else {
											http_response_code(400);
											$erro = true;
											$mensagem = "Nao ha registros para o id informado.";
										}
									} else if($this->permissao == 0) { //USER
										if ($this->id == $post['id']) {
											$consulta = $this->api->consulta_por_id($post['id']);
											if (!empty($consulta)) {
												$retorno = $consulta;
											} else {
												http_response_code(400);
												$erro = true;
												$mensagem = "Nao ha registros para o id informado.";
											}
										} else {
											http_response_code(401);
											$erro = true;
											$mensagem = "Permissao insuficiente.";
										}
									} else { //GUEST
										$id 		= '';
										$email 		= '';
										$username 	= '';
										$nome 		= '';
										$data_criacao = '';

										$consulta 	= $this->api->consulta_por_id(trim($post['id']));
										
										if (!empty($consulta['id'])) {
											$id 			= $consulta['id'];
										}
										if (!empty($consulta['email'])) {
											$array_email = explode('@', $consulta['email']);
											
											$parte1 = substr($array_email[0], 0, 3) . str_repeat('*', strlen($array_email[0]) - 3) . $array_email[0][strlen($array_email[0])-1] . '@';
											$array_email2 = explode('.', $array_email[1]);
											$parte2 = '';
											foreach ($array_email2 as $key => $value) {
												if ($key != 0) {
													$parte2 .= '.';
												}
												$parte2 .= substr($value, 0, 1) . str_repeat('*', strlen($value) - 2) . $value[strlen($value)-1]; 
											}
											$email 			= $parte1 . $parte2;
										}

										if (!empty($consulta['username'])) {
											$username 		= substr($consulta['username'], 0, 4-strlen($consulta['username'])) . str_repeat('*', strlen($consulta['username']) - 4) . $consulta['username'][strlen($consulta['username'])];
										}

										if (!empty($consulta['nome'])) {
											$nome 			= substr($consulta['nome'], 0, 4-strlen($consulta['nome'])) . str_repeat('*', strlen($consulta['nome']) - 2) . $consulta['username'][strlen($consulta['username'])];
										}

										if (!empty($consulta['data_criacao'])) {
											$data_criacao 	= substr($consulta['data_criacao'], 0, 4-strlen($consulta['data_criacao'])) . str_repeat('*', strlen($consulta['data_criacao']) - 4) . $consulta['username'][strlen($consulta['username'])];
										}

										$retorno = array(
											'id' 			=> $id,
											'email' 		=> $email,
											'username' 		=> $username,
											'nome' 			=> $nome,
											'data_criacao' 	=> $data_criacao
										);
									}
								} else {
									http_response_code(400);
									$erro = true;
									$mensagem = "Formato de requisicao invalido. Campo 'id' deve ser numerico.";
								}
							} else if(!empty($post['username'])) {
								if ($this->permissao == 1) { //ADMIN
									$this->load->model('model_api', 'api');
									$consulta = $this->api->consulta_por_username($post['username']);

									if (!empty($consulta)) {
										$retorno = $consulta;
									} else {
										http_response_code(400);
										$erro = true;
										$mensagem = "Nao ha registros para o username informado.";
									}
								} else if($this->permissao == 0) { //USER
									if ($this->username == $post['username']) {
										$consulta = $this->api->consulta_por_username($post['username']);
										if (!empty($consulta)) {
											$retorno = $consulta;
										} else {
											http_response_code(400);
											$erro = true;
											$mensagem = "Nao ha registros para o username informado.";
										}
									} else {
										http_response_code(401);
										$erro = true;
										$mensagem = "Permissao insuficiente.";
									}
								} else { //GUEST
									$id 		= '';
									$email 		= '';
									$username 	= '';
									$nome 		= '';
									$data_criacao = '';

									$consulta 	= $this->api->consulta_por_username(trim($post['username']));
									if (!empty($consulta['id'])) {
										$id 			= $consulta['id'];
									}
									if (!empty($consulta['email'])) {
										$array_email = explode('@', $consulta['email']);
										
										$parte1 = substr($array_email[0], 0, 3) . str_repeat('*', strlen($array_email[0]) - 3) . $array_email[0][strlen($array_email[0])-1] . '@';
										$array_email2 = explode('.', $array_email[1]);
										$parte2 = '';
										foreach ($array_email2 as $key => $value) {
											if ($key != 0) {
												$parte2 .= '.';
											}
											$parte2 .= substr($value, 0, 1) . str_repeat('*', strlen($value) - 2) . $value[strlen($value)-1]; 
										}
										$email 			= $parte1 . $parte2;
									}

									if (!empty($consulta['username'])) {
										$username 		= substr($consulta['username'], 0, 4-strlen($consulta['username'])) . str_repeat('*', strlen($consulta['username']) - 4) . $consulta['username'][strlen($consulta['username'])];
									}

									if (!empty($consulta['nome'])) {
										$nome 			= substr($consulta['nome'], 0, 4-strlen($consulta['nome'])) . str_repeat('*', strlen($consulta['nome']) - 2) . $consulta['username'][strlen($consulta['username'])];
									}

									if (!empty($consulta['data_criacao'])) {
										$data_criacao 	= substr($consulta['data_criacao'], 0, 4-strlen($consulta['data_criacao'])) . str_repeat('*', strlen($consulta['data_criacao']) - 4) . $consulta['username'][strlen($consulta['username'])];
									}

									$retorno = array(
										'id' 			=> $id,
										'email' 		=> $email,
										'username' 		=> $username,
										'nome' 			=> $nome,
										'data_criacao' 	=> $data_criacao
									);
								}
							} else {
								http_response_code(400);
								$erro = true;
								$mensagem = "Formato de requisicao invalido. Campo nao pode ser vazio.";
							}
						} else {
							http_response_code(400);
							$erro = true;
							$mensagem = "Formato de requisicao invalido. Deve possuir um campo 'id' ou 'username' para a busca.";
						}
					} else {
						http_response_code(400);
						$erro = true;
						$mensagem = 'Formato de requisicao invalido. Verifique o nome do parametro enviado.';
					}
				} else {
					http_response_code(400);
					$erro = true;
					$mensagem = 'Formato de requisicao invalido.';
				}
				
				if ($erro) {
					$retorno = array(
						'erro' => array(
							'mensagem' => $mensagem,
							'http_status' => http_response_code()
						)
					);
				}
			}
		} else {
			$retorno = array();
			http_response_code(400);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($retorno));
	}

	public function delete(){
		//Verifica se a requisição é do tipo POST
		if ($this->input->post()) {
			//Recebe os campos do POST
			$post 		= $this->input->post();
			//Verifica se o parametro Authorization foi preenchido
			if (!empty(getallheaders()['Authorization'])) {
				//Validacao do usuario e senha com base na header Authentication
				$this->_autenticaUsuario();
				if (!in_array($this->permissao, array(0,1))) {
					http_response_code(401);
					$erro = true;
					$mensagem = 'E preciso se autenticar para realizar a exclusao';
				} else {
					if (is_array($post)) {
						if(count($post) == 1){
							if (array_key_exists('id', $post) || array_key_exists('username', $post)) {
								if (!empty($post['id'])) {
									if (is_numeric($post['id'])) {
										if ($this->permissao == 1) { //ADMIN
											$this->load->model('model_api', 'api');
											$consulta = $this->api->consulta_por_id($post['id']);
											if ($this->api->delete_por_id($post['id'])) {
												$retorno['mensagem'] = 'Usuario ' . $consulta['nome'] . ' deletado com sucesso.';
											} else {
												http_response_code(500);
												$erro = true;
												$mensagem = "Ocorreu uma falha ao excluir registro.";
											}
										} else if($this->permissao == 0) { //USER
											if ($this->id == $post['id']) {
												$consulta = $this->api->consulta_por_id($post['id']);
												if ($this->api->delete_por_id($post['id'])) {
													$retorno['mensagem'] = 'Usuario ' . $consulta['nome'] . ' deletado com sucesso.';
												} else {
													http_response_code(500);
													$erro = true;
													$mensagem = "Ocorreu uma falha ao excluir registro.";
												}
											} else {
												http_response_code(401);
												$erro = true;
												$mensagem = "Permissao insuficiente.";
											}
										}
									} else {
										http_response_code(400);
										$erro = true;
										$mensagem = "Formato de requisicao invalido. Campo 'id' deve ser numerico.";
									}
								} else if(!empty($post['username'])) {
									if ($this->permissao == 1) { //ADMIN
										$this->load->model('model_api', 'api');
										$consulta = $this->api->consulta_por_username($post['username']);

										if ($this->api->delete_por_username($post['username'])) {
											http_response_code(200);
											$erro = false;
											$retorno['mensagem'] = 'Usuario "' . $consulta['nome'] . '" deletado com sucesso.';
										} else {
											http_response_code(500);
											$erro = true;
											$mensagem = "Ocorreu uma falha ao excluir registro.";
										}
									} else if($this->permissao == 0) { //USER
										if ($this->username == $post['username']) {
											$consulta = $this->api->consulta_por_username($post['username']);
											if ($this->api->delete_por_username($post['username'])) {
												http_response_code(200);
												$erro = false;
												$retorno['mensagem'] = 'Usuario "' . $consulta['nome'] . '" deletado com sucesso.';
											} else {
												http_response_code(500);
												$erro = true;
												$mensagem = "Ocorreu uma falha ao excluir registro.";
											}
										} else {
											http_response_code(401);
											$erro = true;
											$mensagem = "Permissao insuficiente.";
										}
									}
								} else {
									http_response_code(400);
									$erro = true;
									$mensagem = "Formato de requisicao invalido. Campo nao pode ser vazio.";
								}
							} else {
								http_response_code(400);
								$erro = true;
								$mensagem = "Formato de requisicao invalido. Deve possuir um campo 'id' ou 'username' para a busca.";
							}
						} else {
							http_response_code(400);
							$erro = true;
							$mensagem = 'Formato de requisicao invalido. Verifique o nome do parametro enviado.';
						}
					} else {
						http_response_code(400);
						$erro = true;
						$mensagem = 'Formato de requisicao invalido.';
					}
				}
				
				if ($erro) {
					$retorno = array(
						'erro' => array(
							'mensagem' => $mensagem,
							'http_status' => http_response_code()
						)
					);
				}
			}
		} else {
			$retorno = array();
			http_response_code(400);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($retorno));
	}

	//Verifica se o email é um email válido
	public function validaEmail($email) {
		$conta 		= '/^[a-zA-Z0-9\._-]+?@';
		$domino 	= '[a-zA-Z0-9_-]+?\.';	
		$gTLD 		= '[a-zA-Z]{2,6}'; //.com; .coop; .gov; .museum; etc.	
		$ccTLD 		= '((\.[a-zA-Z]{2,4}){0,1})$/'; //.br; .us; .scot; etc.
		$pattern 	= $conta.$domino.$gTLD.$ccTLD;
		
		return preg_match($pattern, $email);
	}

	//Realiza a validacao da requisicao
	public function validaRequisicao($post, $tipo = null){
		//Declaração das variáveis de retorno
		$erro 				= false;
		$mensagem 			= '';
		$http_status 		= 200;

		//Verifica se é um array
		if (is_array($post)) {
			if($tipo == 'edit' && !array_key_exists('id', $post)){
				$erro 			= true;
				$mensagem 		= "E necessario informar o parametro 'id'.";
			}

			if (!$erro) {
				if(!$this->validaLayoutArray($post, $tipo)){
					$erro 				= true;
					if ($tipo == 'edit') {
						$mensagem 		= 'Formato de requisicao invalido. E necessario informar ao menos 1 campo para atualizacao.';
					} else {
						$mensagem 		= 'Formato de requisicao invalido. Verifique o nome dos parametros enviados.';
					}
				} 
			}
			
			if(!$erro) {
				$validaCampoVazio = $this->validaCampoVazio($post, $tipo);
				
				if($validaCampoVazio['erro']){
					$erro 			= $validaCampoVazio['erro'];
					$mensagem 		= $validaCampoVazio['mensagem'];
				}
			}
		} else {
			$erro 			= true;
			$mensagem 		= 'Formato de requisicao invalido.';
		}

		if ($erro) {
			http_response_code(400);
		}

		return array(
			'erro' 			=> $erro,
			'mensagem' 		=> $mensagem,
			'http_status' 	=> http_response_code()
		);
	}

	//Verifica se as chaves principais para create/edit de usuario estão no array da requisicao
	public function validaLayoutArray($post, $tipo){
		$array_parametros = array('email', 'username', 'nome', 'senha');

		//Validacao específica para o edit, necessário validar a chave id e ao menos mais algum campo para atualização
		if ($tipo == 'edit') {
			$isValid = false;
			foreach ($post as $key => $value) {
				if (in_array(strtolower(trim($key)), $array_parametros)) {
					$isValid = true;
				}
			}
		} else { //Validacao para o create
			$isValid = true;
			foreach ($array_parametros as $key => $value) {
				if (!array_key_exists($value, $post)) {
					$isValid = false;
				}
			}
		}
		return $isValid;
	}

	//Verifica se os campos necessarios nao estao vazios
	public function validaCampoVazio($post, $tipo){
		$erro 			= false;
		$mensagem 		= '';
		$http_status 	= 200;
		$status 		= 400;
		
		foreach ($post as $key => $value) {
			//Validação para campo nao vazio
			if (!empty($value)) {
				//Verifica se o campo é 'email' para validar o mesmo
				if (strtolower(trim($key)) == 'email') {
					if($this->validaEmail($value)) {
						
						$this->load->model('model_api', 'api');

						//Verifica se o email em questão já não está cadastrado no banco
						if ($tipo == 'edit' && !empty($post['id'])) {
							if($this->api->valida_edit(strtolower(trim($key)), $value, $post['id'])){
								$erro 		= true;
								$mensagem 	.= "'" . $key . "' ja cadastrado.";
							}
						} else {
							if(!$this->api->get_usuario_by_parametro(strtolower(trim($key)), $value)){
								$erro 		= true;
								$mensagem 	.= "'" . $key . "' ja cadastrado.";
							}
						}
					} else {
						$erro 		= true;
						$mensagem 	.= "Parametro '" . $key . "' nao e um email valido.";
					}
				} else if (strtolower(trim($key)) == 'username') { //Verifica se o campo é 'username' para validar o mesmo
					$this->load->model('model_api', 'api');
					//Verifica se o username em questão já não está cadastrado no banco
					if ($tipo == 'edit' && !empty($post['id'])) {
						if($this->api->valida_edit(strtolower(trim($key)), $value, $post['id'])){
							$erro 		= true;
							$mensagem 	.= "'" . $key . "' ja cadastrado.";
						}
					} else {
						if(!$this->api->get_usuario_by_parametro(strtolower(trim($key)), $value, $this->id)){
							$erro 		= true;
							$mensagem 	.= "'" . $key . "' ja cadastrado.";
						}
					}
				} else if($tipo == 'edit' && strtolower(trim($key)) == 'id'){
					$this->load->model('model_api', 'api');
					if ($this->permissao == 1) { //ADMIN pode alterar demais usuarios
						//Verifica se o id em questão é referente a um usuario valido
						if($this->api->get_usuario_by_parametro(strtolower(trim($key)), $value)){
							$erro 		= true;
							$mensagem 	.= "'" . $key . "' nao cadastrado.";
						}
					} else if($this->permissao == 0){ //USER só pode alterar o seu proprio usuario
						//Busca o ID do usuario da requisicao
						$id = $this->api->valida_usuario_edit($this->login, $this->parametro);
						if(!empty($id)){
							if ($id != $value) { //Nao pode editar registros de outro usuario
								$erro 		= true;
								$mensagem 	.= "Sem permissao suficiente.";
								$status 	= 401;
							}
						} else {
							$erro 		= true;
							$mensagem 	.= "'usuario' nao cadastrado.";
						}
					}
				}
			} else if(empty($value) && $value != '0' && $tipo != 'edit') {
				$erro 		= true;
				$mensagem 	.= "Parametro '" . $key . "' nao pode ser vazio.";
			}
		}

		if ($erro) {
			http_response_code($status);
			$http_status = $status;
		}

		return array(
			'erro'			=> $erro,
			'mensagem'		=> $mensagem,
			'http_status'	=> $http_status
		);
	}

	//Funcao que autentica o usuario com base no parametro Authorization passado pela header
	private function _autenticaUsuario(){
		//Validacao da autenticaçao da api
		//Verifica nas headers se o parametro Authorization foi preenchido e se é do tipo Basic
		if (!empty(getallheaders()['Authorization'])) {
			if (preg_match('/^basic/i', getallheaders()['Authorization'])) {
				list($this->login, $this->password) = explode(':', base64_decode( substr( getallheaders()['Authorization'], 6)));

				$this->load->model('model_api', 'api');
				$this->parametro 	= $this->validaEmail($this->login) ? 'email' : 'username';
				$dados_usuario 		= $this->api->autenticaUsuario($this->login, $this->password, $this->parametro);
				//Autenticado
				if(!empty($dados_usuario)){
					$this->id 			= $dados_usuario['id'];
					$this->username 	= $dados_usuario['username'];
					$this->email 		= $dados_usuario['email'];
					$this->permissao 	= $dados_usuario['admin'];
				}
			}
		}
	}
}
