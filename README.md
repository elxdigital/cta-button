# Botão CTA (Call to Action)
Esta dependência foi criada para otimizar a alta frequência de uso em projetos próprios da Ellox, onde sites institucionais tendem a recorrer deste recurso com alta demanda, se tratando de seu objetivo principal.

## Requisitos:
* php >=8.0
* ext-pdo
* league/plates 3.*
* ext-mbstring
* phpmailer/phpmailer
* vlucas/phpdotenv
* jQuery e jQuery Mask
* Bootstrap 4
* Se já criada a tabela `cta_button`, é indiscutível que tenha, pelo menos, os seguintes campos:

```
id - identificador do registro
btn_identificador - um identificador único para o botão
tipo_cta - lead e whatsapp, somente lead, somente whatsapp ou externo
btn_titulo - título a ser visualizado no botão
form_lead - formulário que abrirá para preencher leads
contato_wpp - contato do WhatsApp a ser chamado
message_wpp - mensagem enviada quando abrir o WhatsApp
link_redir - link a ser redirecionado (interno ou externo)
cliques - número de cliques no botão
```

* Ter as seguintes constantes previamente declaradas:
  * url:
    * CONF_URL_BASE - url utilizada
    * CONF_URL_TEST - url utilizada
  * data base:
    * CONF_DB_HOST - database host
    * CONF_DB_NAME - database name
    * CONF_DB_USER - database user
    * CONF_DB_PASS - database password
    * CONF_DB_PORT - database port
  * email:
    * CONF_MAIL_HOST - mail host
    * CONF_MAIL_PORT - mail port
    * CONF_MAIL_USER - mail user
    * CONF_MAIL_PASS - mail password
    * CONF_MAIL_SENDER_NAME - nome para endereço de e-mail
    * CONF_MAIL_SENDER_ADDRESS - endereço de e-mail 
    * CONF_MAIL_TEST_NAME - nome para endereço de e-mail de testes
    * CONF_MAIL_TEST_ADDRESS - endereço de e-mail de testes

## Recurosos disponíveis:
Campo de formulário HTML do tipo 'select' com as seguintes opções:
* Formulário para Captura de Leads
* Redirecionamento Direto para WhatsApp
* Redirecionamento para Link Externo

## Qual é o objetivo de cada um deles?
### ✔️ Formulário para Captura de Leads + Redirecionamento para WhatsApp
Vista abrir uma modal com um formulário de lead, onde o usuário do site preenche seus dados e, após preencher o
formulário e enviar, redirecionar o usuário para uma conversa do WhatsApp.

* **Campos preenchidos**: número do contato do WhatsApp e (opcional) mensagem a ser enviada na conversa.

### ✔️ Formulário para Captura de Leads
Vista abrir uma modal com um formulário de lead, onde o usuário do site preenche seus dados, ficando
a responsabilidade do destino ou manipulação dos dados a cargo do sistema.

* **Campos preenchidos**: formulário a ser preenchido.

### ✔️ Redirecionamento Direto para WhatsApp
Vista redirecionar o usuário, sem nenhum tipo de intermediação, para uma conversa do WhatsApp.

* **Campos preenchidos**: contato do WhatsApp e (opcional) mensagem a ser enviada na conversa.

### ✔️ Redirecionamento para Link Externo
Vista redirecionar o usuário para um link de página interna (do próprio site) ou externa.

* **Campos preenchidos**: link de redirecionamento.

    Obs.: Para redirecionar para um link externo, preencha-o de forma completa (protocolo, domínio e caminho, se tiver). Para links internos, preencha somente o caminho para a página.
Exemplo: 


    Link externo: https://google.com.br
    Link interno: /sobre, /produtos, etc...

## Como usar?
Adicionar dependência ao projeto: <br>
`composer require elxdigital/cta-button`

Copiar arquivos de estilo/script para acesso público: <br>
`cp -r vendor/elxdigital/cta-button/src/template/assets src/template/assets`

Copiar formulário de lead padrão para acesso público: <br>
`cp -r vendor/elxdigital/cta-button/src/template/forms src/template/forms`

Copiar template de e-mail para acesso público: <br>
`cp -r vendor/elxdigital/cta-button/src/template/shared src/template/shared`

Copiar arquivo de rotas para acesso público: <br>
`cp -r vendor/elxdigital/cta-button/src/routes src/routes`

### Parte do Painel Administrativo (admin):
* `Button` - Instanciar a classe principal.
  * Ex.: `new \Elxdigital\CtaButton\Button();`

#### Métodos
* `renderPrivate` - renderiza o select no painel administrativo do site, ou seja, na parte de quem está gerenciando o conteúdo do site vê.
  * Parâmetros (já na ordem devidamente passada ao método):
    * `field_name` - atributo name do input no formulário principal, ou seja, nome da coluna na tabela que você deseja salvar essa FK. 
    * `identificador` - identificador utilizado para diferenciar botões, mesmo que estes tenham o mesmo nome na FK.
    * `formularios` - formulários disponíveis no seu site, aparecerão no select caso o objetivo do botão seja conversão de leads.
    * `btn_cta_id` (opcional) - caso já tenha um botão cadastrado na tabela, esse id da FK é passado neste parâmetro.

### Parte no Site (público):
* `Button` - Instanciar a classe principal.
  * Ex.: `new \Elxdigital\CtaButton\Button("caminho_para_views");`
  * Parâmetro:
    * `template_path` - caminho/path para os templates do seu site.

#### Métodos
* `renderPublic` - renderiza o botão no site, ou seja, na parte que o usuário final vê.
  * Parâmetro:
    * `btn_cta_id` - id do botão que deseja ser renderizado na tela e acessado pelos usuários do site.
    * `estilos` (opcional) - array de estilos, com flexibilidade para passar qualquer atributo possível em uma tag \<a> do HTML.
    * `span` (opcional) - boolean, se quiser que o conteúdo da tag \<a> seja envolto em uma tag \<span>, por padrão: false.

## Tabela de exemplo para cta_button:
```php
    CREATE TABLE cta_button (
      id INT AUTO_INCREMENT PRIMARY KEY,
      tipo_cta ENUM('lead_whatsapp', 'lead', 'whatsapp', 'externo') NOT NULL,
      btn_identificador VARCHAR(255) NOT NULL,
      btn_titulo VARCHAR(255) NOT NULL,
      form_lead TEXT DEFAULT NULL,
      contato_wpp VARCHAR(20) DEFAULT NULL,
      message_wpp VARCHAR(255) DEFAULT NULL,
      link_redir TEXT DEFAULT NULL,
      cliques INT UNSIGNED NOT NULL DEFAULT 0,
      data_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      data_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );
```

## Mais Dúvidas?
Dentro do projeto temos alguns exemplos, tanto para uso no painel administrativo quanto no site,
para que assim você possa se guiar e utilizar em seu sistema :)

Os exemplos se encontram na pasta `examples` na raíz da dependência.