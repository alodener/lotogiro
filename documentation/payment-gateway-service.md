### Payment Gateway Service

Para atender as necessidades desta aplicação, foi criada uma biblioteca simples porém robusta. A uma das principais caracterista desta biblioteca é, a chamada de uma única classe, que fica responsável em criar clientes, fazer transações e capturar webhooks, sendo possível alterar o provedor durante a execução da aplicação e também reduz a necessidade alterar o código  quando um novo provedor for adicionado ou removido.



##### Estrutura

Foi criado dentro de `app/Services/GatewayPayment/Contracts` uma lista de interfaces ou contratos, responsáveis em padronizar os comportamentos das classes que candidatas à gateway de pagamento.

- CredentialInterface 

- GatewayServiceInterface

- TransactionInterface

- CustomerInterface

- StatusTransactionInterface

- WebhookInterface



Para criar um novo provedor de pagamento crie um novo diretório dentro de `app\Services\GatewayPayment\Gateways` e crie suas classes implementados os contratos citados acima.



##### Classe GatewayPaymentService

Esta classe é considara o core desta biblioteca pois, a partir dela podemos saber quais os gateways estão "instalados" e fazer todas as ações referentes ao gateway.



##### Configurações

dentro do arquivo .`env` foram criadas algumas variavéis afim de controlar parcialmente os comportamentos da biblioteca.

```
PAYMENT_GATEWAY_MODE=dev
PAYMENT_GATEWAY_DOMAIN=https://www.example.com
PAYMENT_GATEWAY_VERSION=v2
```

`PAYMENT_GATEWAY_MODE`: define se o será usado o ambiente de teste do provedor de pagamento e também nomeclatura do identificador da transação, caso não esteja defino o padrão sempre será `dev`, sendo assim em **produção** deve ficar explicito o modo de **production**.

PS: Devida a complexidade da documentação do mercado pago este até mesmo em ambiente de desenvolvimento foi usado o ambiente de produção.



`PAYMENT_GATEWAY_DOMAIN`: define qual será o endereço os webhooks iram ser comunicar para informar seus eventos. Para testar localmente é recomendado usar o [ngrok](https://ngrok.com) para expor a aplicação.



`PAYMENT_GATEWAY_VERSION`: juntamente com a `PAYMENT_GATEWAY_DOMAIN` define qual a versão da rota a ser utilizada pelo webook. Para isto é necessário que crie um novo endpoint em `api.php` seguindo o padrão da versão 2, que é o endpoint padrão. Exemplo de saída `POST` `https://www.example.com/api/v2/webhook`




