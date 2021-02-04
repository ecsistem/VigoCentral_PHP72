<?php

class Aceitar extends Controller {

    function __construct() {

        parent::__construct();

        @session_start();

        // Verifica se existe uma se��o criada
        $this->funcoes->verificaSessao();

        /* DEFINE O CALLBACK E RECUPERA O POST */
        $CallBack = 'Agree';
        $PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        /* VALIDA A A��O */
        if ($PostData && $PostData['callback_action'] && $PostData['callback'] == $CallBack):

            /* PREPARA OS DADOS DO POST */
            $Case = $PostData['callback_action'];
            unset($PostData['callback'], $PostData['callback_action']);

            /* ELIMINA C�DIGOS */
            $PostData = array_map('strip_tags', $PostData);

            /* SELECIONA A��O */
            switch ($Case):

                /* MANAGER */
                case 'manager':

                    /* VERIFICA SE O USU�RIO ACEITOU O TERMO */
                    if(isset($PostData['term_action']) && isset($PostData['term_check'])
                        && ($PostData['term_action'] == "Aceito") && ($PostData['term_check'] == "on")):

                        // Instancia a classe de MODEL relacionado
                        require 'models/sessao_model.php'; // O MODEL n�o � "auto-carregado" como as libs
                        $core_model = new Sessao_Model();

                        require 'models/aceite_model.php'; // O MODEL n�o � "auto-carregado" como as libs
                        $aceite_model = new Aceite_Model();

                        // Captura as informa��es do cliente autenticado corretamente
                        $dados = $core_model->Dados_Cliente($_SESSION['LOGIN']);

                        $cliente_id = (int) $dados[0]['id'];
                        $contrato_aceito = 'S';
                        $contrato_data = date('Y-m-d');
                        $contrato_hora = date('H:i:s');

                        // Processa e registra o aceite do termo
                        $aceite_model->Aceitar_Termo($cliente_id, $contrato_aceito, $contrato_data, $contrato_hora);

                        // Redireciona para o controller relacionado
                        @@header("Location: core");
                    else:

                        // SE N�O ACEITOU O TERMO, POR SEGURAN�A FAZ O LOGOUT
                        @header("Location: logout");
                        exit;
                    endif;
                break;
            endswitch;
        else:
            // SE N�O ACEITOU O TERMO, POR SEGURAN�A FAZ O LOGOUT
            @header("Location: logout");
            exit;
        endif;
    }
}
?>