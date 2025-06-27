# Avaliacao-PHP-MYSQL

## O projeto consiste em análisar o conhecimento nas seguintes técnologias:

* PHP Orientado a Objetos
* Arquiteura MVC
* PDO com MySql
* Javascript ou JQuery

*Obs.: Favor enviar junto com o projeto o script da criação das tabelas.*

## Pontos a se considerar:
Código legível, comentado e manutenível.
Separe cada responsabilidade no seu arquivo correto.
Não poderá ser utilizado nenhuma forma de framework (backend e frontend)  

# NÃO UTILIZAR COMPOSER PARA GERENCIAMENTO DE DEPENDÊNCIAS, O CANDIDATO QUE UTILIZAR SERÁ AUTOMATICAMENTE DESCLASSIFICADO.

O gestor da empresa JM Informática decide criar um sistema de ordem de serviços para controlar os serviços prestados pelos seus funcionários. O sistema deve permitir autenticar-se para acesso a tela inicial (dashboard). Na tela inicial deverá mostrar os dados do usuário logado, a data atual e os serviços prestados.

## Tela de Login com email ou senha inválidos
Dado que o usuário acesse tela de login
Quando quando não informar email e senha corretos
Então deve mostrar mensagem ‘Ops, Email ou Senha inválido’

## Tela de Login com email e senha válidos
Dado que o usuário acesse tela de login
Quando informar email e senha correto
Então deve ser redirecionado a tela inicial do sistema (Dashboard)

## Tela de Dashboard
Dado que o usuário acesse a tela de dashboard com usuário correto
Então devo ver uma tabela com os serviços prestados pelos funcionários apresentando as seguintes informações (id, descrição, status, valor, nome usuário) com botões de excluir, alterar o registro e um botão para finalizar serviço


## Tela de Dashboard (Valor Total dos Serviços Prestados pelo Usuário)
Dado que o usuário acesse a tela de dashboard com usuário correto
Então deve mostrar de forma destacada o valor total dos serviços prestados por este usuário.

## Tela de Dashboard (Serviços com status Pendentes Prestados pelo Usuário)
Dado que o usuário acesse a tela de dashboard com usuário correto
Então deve mostrar de forma destacada uma pequena lista com os últimos serviços prestados com status “Pendentes”.

## Tela de Dashboard (Marcar status como finalizado)
Dado que o usuário acesse a tela de dashboard com usuário correto
Então devo clicar no botão do registro a ser finalizado, gravar a data de finalização do serviço e enviar um email para o usuário do serviço, e calcular o valor da comissão. Os serviços que possuem data de finalização serão considerados como finalizados e os que não possuem serão considerados como pendentes.
	Para valores até R$ 250, 00 será dado 5% de comissão
	Para valores acima de R$ 1.000,00 será dado 10% de comissão
	Para valores acima de R$ 10.000,00 será dado 20% de comissão.



## Tela de Dashboard (Filtro por período)
Dado que o usuário acesse a tela de dashboard com usuário correto
Quando informar filtro por período inicial e final
Então deve mostrar na tabela os serviços prestados dentro do período

## Tela de Dashboard (Filtro por nome do serviço)
Dado que o usuário acesse a tela de dashboard com usuário correto
Quando informar o nome do serviço
Então deve mostrar os serviços prestados com este nome

## Tela de Dashboard (Filtro por status do serviço)
Dado que o usuário acesse a tela de dashboard com usuário correto
Quando informar o status do serviço
Então deve mostrar os serviços prestados com este status.

## Tela de Dashboard (Filtro por usuário do serviço)
Dado que o usuário acesse a tela de dashboard com usuário correto
Quando informar o nome do usuário do serviço
Então deve mostrar os serviços prestados por este usuário.

## Tela de Dashboard (Adicionar Novo Serviço)
Dado que o usuário acesse a tela de dashboard com usuário correto
Quando clicar no botão de adicionar novo serviço
Então deve mostrar nova tela com formulário para cadastrar novo serviço.


## Tela de Cadastro de Serviço (Adicionar novo serviço com sucesso)
Dado que o usuário acesse a tela de cadastrar novo serviço
Quando informar as informações obrigatórias(descrição do serviço, valor)
Então deve cadastrar o novo serviço com status de “Pendente” para o usuário logado, mostrando mensagem de sucesso redirecionando para tela inicial.

## Tela de Cadastro de Serviço (Falha ao adicionar novo serviço)
Dado que o usuário acesse a tela de cadastrar novo serviço
Quando não informar as informações obrigatórias (descrição e valor) ou ocorrer algum erro
Então não deve cadastrar o novo serviço mostrando mensagem de falha redirecionando para tela inicial.

- [Wireframe](TesteTitanWireFrame.pdf)

- [Modelagem do Banco](model_teste_titan.pdf)


Boa sorte!!



