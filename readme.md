## O PROJETO
O projeto utiliza as linguagens HTML, CSS, JavaScript e PHP para desenvolver uma aplicação WEB de uma livraria, que faz manutenção nos cadastros de acervos e de editoras.

Enquanto o backend foi construído em PHP, o frontend foi desenvolvido utilizando HTML, CSS e Javascript. Como critério de avaliação, não foi utilizado nenhum framework durante o processo de desenvolvimento, de modo a explorar vários conceitos das linguagens propostas.

### Passo a passo para configurar a aplicação
1.	Instalar o servidor XAMPP ou qualquer outro ambiente APACHE compatível;
2.	Colocar todos os arquivos do projeto dentro da pasta htdocs, disponível na pasta de instalação do XAMP;
3.	Iniciar o servidor APACHE e o banco de dados MYSQL;
4.	No banco de dados, execute o script disponível no arquivo assets/populate-database.sql;
5.	No arquivo config.php, altere o valor das variáveis de conexão de acordo com as configurações do banco de dados criado;
6.	Caso a porta que o APACHE esteja rodando não seja a padrão (80), altere o valor da variável API_HOST no arquivo assets/api.js, colocando a porta que a aplicação está sendo executada;

OBS: outras configurações no arquivo .htacces podem ser necessárias, dependendo de qual servidor apache está sendo utilizado.

### Demos e captura de telas
**Tela inicial do sistema**  
![Tela inicial do sistema](/assets/imgs/home.png)

**Tela de listagem de editoras**  
![Tela de listagem de editoras](/assets/imgs/publishers.png)

**Tela de listagem de acervos**  
![Tela de listagem de acervos](/assets/imgs/books.png)

**Tela de cadastro de editoras**  
![Tela de cadastro de editoras](/assets/imgs/publisher-form.png)

**Tela de cadastro de acervos**  
![Tela de cadastro de acervos](/assets/imgs/book-form.png)

**Designe mobile**  
![Designe mobile](/assets/imgs/mobile.png)