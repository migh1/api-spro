# Tecnologias: PHP 7.1.4
# Framework: CodeIgniter 3.1.8
# Banco de dados: MySql

# Como Usar:

rotas para a api desenvolvida:

#localhost/api-spro/Api/read - POST
#localhost/api-spro/Api/create - POST
#localhost/api-spro/Api/edit - POST
#localhost/api-spro/Api/delete - POST

#exemplo de requisicao: x-www-form-urlencoded

localhost/api-spro/Api/read - POST
Array(
	[username] => usuario
)
OR
Array(
	[id] => 1
)
////////////
localhost/api-spro/Api/create - POST
Array(
	[email] => email@email.com
	[username] => usuario
	[nome] => Nome Usuario
	[senha] => senha
	[admin] => 1 (0 ou 1, campo opcional sendo 0 => USER e 1 => ADMIN) 
)
////////////
localhost/api-spro/Api/edit - POST
Array(
	[id] => 1
	[email] => email@email.com (campo opcional)
	[username] => usuario (campo opcional)
	[nome] => Nome Usuario (campo opcional)
	[senha] => senha (campo opcional)
)
////////////
localhost/api-spro/Api/delete - POST
Array(
	[id] => 1
)
OU
Array(
	[username] => 1
)


Considerações finais:
Foi especificado no modelo que a tabela de usuario nao possui tipos, no entanto, existe autenticaçao via API para diferenciar os acessos ADMIN/USER (descrito) e outro que seria o sem autenticacao (denominado GUEST no decorrer do trabalho).
Enão optei por adicionar uma coluna 'admin' para diferenciar quem possui determinadas permissoes para listagem/exclusao/edicao

Autenticação da API feito na header, com o parametro Authentication. O Tipo de authentication foi o Basic. A validação do usuario/senha é com email/senha ou username/senha com os registros que foram cadastrados na tabela de usuarios.

O código possui alguns comentários caso precise.


###Para executar corretamente:
1. Extrair o .rar com o conteudo da pasta
2. Colocar a pasta em um apache com MySql
3. Realizar as requisições conforme descrito acima, foi utilizado o POSTMAN para os devidos teste
4. A collection com exemplos está dentro do .rar
5. O Arquivo .SQL está dentro do .rar também
6. Para alterar informações de conexao do banco, deve ser feito no caminho api-spro/application/config/database.php - arquivo de configuração do banco
7. Caso necessário, alterações quanto ao localhost pode ser feito no caminho: api-spro/application/config/config.php - arquivo de configuração geral


repositorio no github: https://github.com/migh1/api-spro
não deu tempo de colocar a aplicação online
Desculpe ser muito breve mas o tempo apurou, estou a disposição para esclarecer qualquer dúvida quanto ao código.