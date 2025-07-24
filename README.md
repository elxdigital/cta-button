# Botão CTA (Call to Action)
Esta dependência foi criada para otimizar a alta frequência de uso em projetos próprios da Ellox, onde sites institucionais tendem a recorrer deste recurso com alta demanda, se tratando de seu objetivo principal.

## Requisitos:
* Tabela criada no banco de dados nomeada de: cta_button;
* Model referente a tabela mencionada no tópico anterior;
* É indiscutível que a tabela tenha, pelo menos, os seguintes campos:
1. id - identificador do registro
2. tipo_cta - lead, whatsapp ou externo
3. btn_titulo - título a ser visualizado no botão
4. form_lead - formulário que abrirá para preencher leads
5. contato_wpp - contato do WhatsApp a ser chamado
6. link_redir - link a ser redirecionado (interno ou externo)
7. cliques - número de cliques no botão

## Recurosos disponíveis:
Campo de formulário HTML do tipo 'select' com as seguintes opções:
* Formulário para Captura de Leads
* Redirecionamento Direto para WhatsApp
* Redirecionamento para Link Externo

## Qual é o objetivo de cada um deles?
### ✔️ Formulário para Captura de Leads
Vista abrir uma modal com um formulário de lead, onde o usuário do site preenche seus dados, sendo
posteriormente redirecionado para uma conversa do WhatsApp.

* **Campos preenchidos**: formulário a ser preenchido e contato do WhatsApp.

### ✔️ Redirecionamento Direto para WhatsApp
Vista redirecionar o usuário, sem nenhum tipo de intermediação, para uma conversa do WhatsApp.

* **Campos preenchidos**: contato do WhatsApp.

### ✔️ Redirecionamento para Link Externo
Vista redirecionar o usuário para um link de página interna (do próprio site) ou externa.

* **Campos preenchidos**: link de redirecionamento.

    Obs.: Para redirecionar para um link externo, preencha-o de forma completa (protocolo, domínio e caminho, se tiver). Para links internos, preencha somente o caminho para a página.
Exemplo: 


    Link externo: https://google.com.br
    Link interno: /sobre, /produtos, etc...

## Como usar?
* `Button` - Instanciar a classe principal.
* `connectDataBase` - Inicia uma conexão com o banco de dados, que aceita os parâmetros: (bool) criar tabela básica para botão, (string) host, (string) nome do banco de dados, (string) usuário, (string) senha e a (string) porta.
* `setConversao` - recebe como parâmetro um identificador da conversão do tipo int, caso exista e esteja salva na tabela que deseja.
* `setFormulariosLead` - recebe como parâmetro um array de formulários disponíveis para a opção de lead.
* `addFormularioLead` - recebe como parâmetro um array para adicionar uma opção às opções já existentes de formulário para a opção lead. Cada nova opção deve ser um item do array passado no parâmetro, contendo os indexes `key` e `value`.
* `renderPublic` - renderiza o botão no site, ou seja, na parte que o usuário final vê.
* `renderPrivate` - renderiza o select no painel administrativo do site, ou seja, na parte de quem está gerenciando o conteúdo do site vê.

## Tabela de exemplo para cta_button:
```php
    CREATE TABLE cta_button (
      id INT AUTO_INCREMENT PRIMARY KEY,
      tipo_cta ENUM('lead', 'whatsapp', 'externo') NOT NULL,
      btn_titulo VARCHAR(255) NOT NULL,
      form_lead TEXT DEFAULT NULL,
      contato_wpp VARCHAR(20) DEFAULT NULL,
      link_redir TEXT DEFAULT NULL,
      cliques INT UNSIGNED NOT NULL DEFAULT 0,
      data_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      data_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );
```
