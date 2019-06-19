## Previateri - Challenge Bolton

### Funcionalidades:
- Integração com o Endpoint: https://apiuat.arquivei.com.br/v1/nfe/received
- Armazenamento dos resultados obtidos em banco de dados Mysql
- Armazenamento das informações de cada request em banco de dados Mysql
- Armazenamento do resultado de cada request no servidor local
- Fornecimento de um Endpoint através de rota personalizada que recupera informações no banco de dados Mysql e retorna em formato JSON

#### Construção:
O desafio foi desenvolvido utilizando a  linguagem PHP em sua versão 7.3, utiliza o Mysql na versão 5.7 e o servidor Nginx. Toda a estrutura do projeto esta dividia em três containers que rodam cada um dos serviços mencionados.

As duas principais funcionalidades do sistema atuam de forma independente, no entanto compartilham de classes e métodos que foram construídos utilizando-se de alguns Design Patterns como o Singleton e Builder.

Para as requisições ao endpoint que carrega as notas fiscais o sistema utiliza a Biblioteca Guzzle, sendo essa a única depenência declarada no composer.json. Para o fornecimento do endpoind para consulta das notas fiscais o sistema possui o próprio motor de execução de rotas e envio de respostas.

#### Utilização:

Para a utilização e demonstração do funcionamento do sistema siga os seguintes passos:

1. Realize o clone do projeto utilizando o git:

		git clone https://github.com/previateri/challengeBolton-Previateri.git

2. Suba o ambiente com o comando:

		docker-compose up -d

3. Instale as dependências do projeto:

		docker-compose exec php-fpm composer install

4. Faça a importação do banco do dump do banco de dados para o seu container Mysql:

		docker-compose exec mysql mysql -u root -prootpass < initSql.sql

5. Utilize o comando abaixo para executar a request que realiza a carga inicial no banco de dados:

		docker-compose exec php-fpm composer init-charge

6. Realize uma requisição GET para o endpoint informando uma chave de Nota Fiscal válida: 

        http://localhost:8081/v0/nfs/minhasnotasficais/35180109647481000104550010000005781000005788

Se todos os passos forem realizados com sucesso você receberá o retorno de um JSON contento informações da nota fiscal referente a chave fornecida.