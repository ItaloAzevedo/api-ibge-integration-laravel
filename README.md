<h1>API de Pedidos</h1>

<p>Esta é uma API desenvolvida em PHP utilizando o framework Laravel que permite gerenciar pedidos.</p>
<p>A API oferece funcionalidades para consulta, criação, atualização e exclusão de pedidos, bem como integração com a API externa do IBGE para obter dados de municípios do Rio de Janeiro.</p>

<h2>Requisitos</h2>

<ul>
  <li>PHP 8.0.29</li>
  <li>MySQL Server (v8.0.32)</li>
  <li>Composer 2.5.8</li>
  <li>Laravel 9.52.9</li>
</ul>

<h2>Layout dos Dados da API</h2>

<p>Para entender a estrutura e os formatos dos dados retornados pela API de Pedidos com Integração do IBGE, consulte o <a href="https://we.tl/t-zJyY7Mnf0R">Layout dos Dados</a>.</p>

<p>O Layout dos Dados fornece informações detalhadas sobre os campos, tipos de dados e exemplos de uso para cada endpoint da API.</p>

<p>Utilize o Layout dos Dados como referência ao desenvolver e consumir os endpoints da API para garantir a correta manipulação dos dados retornados.</p>

<h2>Instalação</h2>

<ol>
  <li>Faça o clone deste repositório para o seu ambiente local.</li>
  <li>Navegue até a pasta do projeto e execute o comando <code>composer install</code> para instalar as dependências.</li>
  <li>Renomeie o arquivo <code>.env.example</code> para <code>.env</code> e configure as informações do banco de dados conforme a configuração presente na seção <a href="https://github.com/ItaloAzevedo/api-ibge-integration-laravel/edit/master/README.md#configura%C3%A7%C3%A3o-do-banco-de-dados"><b>Configuração do Banco de dados</b></a></li>
  <li>Execute o comando <code>php artisan key:generate</code> para gerar a chave da aplicação.</li>
  
</ol>

<h2>Configuração do Banco de Dados</h2>

<p>Antes de usar a API de Pedidos com Integração do IBGE, você precisa configurar o banco de dados. Siga as etapas abaixo:</p>

<ol>
  <li>Abra o arquivo <code>.env</code> no diretório raiz do projeto.</li>
  <li>Dentro do arquivo <code>.env</code>, encontre as seguintes variáveis de ambiente relacionadas ao banco de dados:</li>
</ol>

<pre>
<code>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nomeBanco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
</code>
</pre>

<p>Certifique-se de definir corretamente o nome do banco de dados (<code>DB_DATABASE</code>), nome de usuário (<code>DB_USERNAME</code>) e senha (<code>DB_PASSWORD</code>).</p>

<ol start="3">
  <li>Salve o arquivo <code>.env</code> após fazer as alterações.</li>
</ol>

<p>Com as configurações do banco de dados definidas no arquivo <code>.env</code>, agora você pode executar as migrações para criar as tabelas necessárias.</p>

<h2>Migrações</h2>

<p>Para gerar a base de dados e as tabelas, execute o seguinte comando no terminal:</p>

<pre>
<code>
php artisan migrate
</code>
</pre>

<p>Isso executará as migrações definidas no diretório <code>database/migrations</code> e criará as tabelas necessárias para a API de Pedidos com Integração do IBGE.</p>

<p>Certifique-se de ter as permissões adequadas para criar e modificar o banco de dados especificado nas configurações do <code>.env</code>.</p>

<h2>Configuração das Migrações</h2>

<p>Siga as etapas abaixo para configurar as migrações das tabelas utilizadas:</p>

<h3>Tabela principal (pedidos)</h3>

<p>Crie a migration para a tabela principal executando o comando:</p>

<pre><code>php artisan make:migration create_table_pedidos --create=pedidos</code></pre>

<p>Na migration gerada, substitua o conteúdo pela seguinte configuração:</p>

<pre><code>public function up()
{
    Schema::create('pedidos', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('category');
        $table->enum('status', array('ACTIVE', 'INACTIVE'))->default('ACTIVE');
        $table->decimal('quantity');
        $table->timestamps();
        $table->softDeletes();
    });
}</code></pre>

<h3>Tabela de integração (ibge)</h3>

<p>Crie a migration para a tabela de integração executando o comando:</p>

<pre><code>php artisan make:migration create_table_ibge --create=ibge</code></pre>

<p>Na migration gerada, substitua o conteúdo pela seguinte configuração:</p>

<pre><code>public function up()
{
    Schema::create('ibge', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('ibge_id');
        $table->string('ibge_name');
    });
}</code></pre>

<p>Execute o comando <code>php artisan migrate</code> para migrar as tabelas do banco de dados.</p>

<h2>Configuração Adicional para Integração com a API do IBGE</h2>

<p>Para realizar a integração com a API externa do IBGE, é necessário configurar o arquivo <code>cacert.pem</code> para permitir a comunicação SSL. Siga as instruções abaixo:</p>

<ol>
  <li>Baixe o arquivo <code>cacert.pem</code> a partir do link <a href="https://curl.se/ca/cacert.pem">https://curl.se/ca/cacert.pem</a>.</li>
  <li>No diretório raiz onde o PHP está instalado, procure o diretório <code>extras</code>.</li>
  <li>Acesse o diretório <code>ssl</code> e mova o arquivo <code>cacert.pem</code> para este diretório.</li>
  <li>No mesmo diretório raiz do PHP, busque e edite o arquivo <code>php.ini</code>.</li>
  <li>Procure a linha comentada <code>;curl.cainfo =</code> e altere-a para <code>curl.cainfo = "C:\php\extras\ssl\cacert.pem"</code></li>
</ol>

<h2>Rotas Principais</h2>

<p>A API possui as seguintes rotas principais disponíveis:</p>

<ul>
  <li>Consultar todos os pedidos: <code>GET /api/pedidos</code></li>
  <li>Consultar um pedido específico: <code>GET /api/pedidos/{id}</code></li>
  <li>Consultar pedidos reciclados (soft_delete): <code>GET /api/pedidos/deletados</code></li>
  <li>Cadastrar um novo pedido: <code>POST /api/pedidos</code></li>
  <li>Atualizar o registro de um pedido: <code>PUT /api/pedidos</code></li>
  <li>Reciclar um pedido: <code>DELETE /api/pedidos/{id}</code></li>
  <li>Restaurar um pedido reciclado: <code>GET /api/pedidos/restaurar/{id}</code></li>
  <li>Forçar a exclusão de um pedido reciclado: <code>DELETE /api/pedidos/force_delete/{id}</code></li>
</ul>

<h2>Rotas de Consulta e Integração a API Externa </h2>

<p>A API possui as seguintes rotas para consulta a API do IBGE e integração ao banco de dados da API principal:</p>

<ul>
  <li>Consulta diretamente a API do IBGE: <code>GET: /api/ibge/externo</code></li>
  <li>Consulta e integração dos dados do IBGE: <code>GET: /api/ibge/interno</code></li>
</ul>

<h2>Demonstração de Requisição da Integração com a API externa</h2>

<p>Aqui está um demonstração de como fazer uma requisição para integrar os dados do IBGE à base de dados principal da API:</p>

<img src="/resources/media/demonstration-request.gif" alt="Exemplo de Requisição do IBGE">

<p>Nessa demonstração, é realizada uma requisição utilizando o metodo <code>GET</code> para o endpoint <code>/api/interno</code> que consulta a API do IBGE e integra os dados à base de dados principal da API.<br></p>
<p>O gif ilustra o processo de integração em ação.</p>


<p>Consulte o <a href="https://github.com/ItaloAzevedo/api-ibge-integration-laravel">repositório</a> para obter mais detalhes sobre a implementação e utilização da API.</p>

<h2>Considerações finais</h2>

<p>Esta API oferece recursos para gerenciar pedidos e integração com a API do IBGE para obter dados de municípios do Rio de Janeiro.<br>
Certifique-se de fornecer os parâmetros corretos ao fazer as chamadas para as rotas e seguir as convenções estabelecidas.</p>
<p>Em caso de dúvidas, entre em contato comigo pelo <a href="https://www.linkedin.com/in/italo-azevedo-7a13971a1/">Linkedin</a> ou <a href="https://github.com/ItaloAzevedo">GitHub</a>.</p>
