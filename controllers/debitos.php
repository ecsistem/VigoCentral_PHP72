<?php

class Debitos extends Controller {

    function __construct() {

        parent::__construct();

        @session_start();

        if (!isset($_SESSION['LOGIN'])) {

            // For�a um logout caso n�o exista a sess�o
            echo "<script>window.location='login';</script>";
            exit;
        } else {

            // Recupera o login informado na sess�o
            @$login_informado = $_SESSION['LOGIN'];

            // For�a um logout caso o LOGIN esteja em branco
            if (($login_informado == '') || ($login_informado == null)) {

                echo "<script>window.location='/index';</script>";
                exit;
            }

            // Instancia a classe de MODEL relacionado

            require 'models/sessao_model.php'; // O MODEL n�o � "auto-carregado" como as libs
            $financeiro_model = new Sessao_Model();

            // Consulta as credenciais de login
            $existe = $financeiro_model->Pesquisa_Credenciais($login_informado); // Executa a query no BD e armazena o resultado numa array

            if ($existe[0] == '0') {

                // Avisa que n�o existe e for�a um logout
                echo "<script>alert('Nenhum cliente encontrado com este login/senha !');window.location='logout';</script>";
                exit;
            } else {

                // Captura as informa��es do cliente autenticado corretamente

                $dados = $financeiro_model->Dados_Cliente($login_informado); // Executa a query no BD e armazena o resultado numa array

                $this->view->id_cliente = $dados[0]['id'];
                $this->view->id_empresa = $dados[0]['idempresa'];
                $this->view->nome = $dados[0]['nome'];
                $this->view->sexo = $dados[0]['sexo'];
                $this->view->endereco = $dados[0]['endereco'];
                $this->view->bairro = $dados[0]['bairro'];
                $this->view->cpfcgc = $dados[0]['cpfcgc'];
                $this->view->cidade = $dados[0]['cidade'];
                $this->view->uf = $dados[0]['uf'];
                $this->view->dt_entrada = $this->funcoes->dataToBR($dados[0]['dt_entrada']);
                $this->view->login = $dados[0]['login'];

                // Instancia a classe de MODEL relacionado
                require 'models/boletos_model.php'; // O MODEL n�o � "auto-carregado" como as libs
                $boletos_model = new Boletos_Model();

                // Cria a se��o
                $_SESSION['ID_CLIENTE'] = $dados[0]['id'];
                $_SESSION['CPFCNPJ'] = $dados[0]['cpfcgc'];
                $_SESSION['LOGIN'] = $dados[0]['login'];

                $this->view->lista_debitos = $boletos_model->Lista_Debitos($_SESSION['ID_CLIENTE']);

                // Renderiza a view relacionada
                $this->view->renderJQ('debitos/index');
            }
        }
    }
}
?>
