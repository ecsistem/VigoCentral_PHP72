<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS

if (!isset($this->config->tema)) {
   $this->config = new stdClass();
   $this->config->tema = "verde";
}
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
    <head>
        <meta name="robots" content="noindex, nofollow">
        <meta http-equiv="Content-Language" content="pt-br" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta content="Vigo Tecnologia" name="Title" />
        <meta content="Jorge Valdez" name="Author" />
        <title>Central do Cliente</title>
        <link rel="shortcut icon" href="<?php echo $funcoes->baseProjeto(); ?>/public/images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo $funcoes->baseProjeto(); ?>/public/images/favicon_32.png" sizes="32x32">
        <link rel="stylesheet" type="text/css" href="<?php echo $funcoes->baseProjeto(); ?>/public/css/default.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $funcoes->baseProjeto(); ?>/public/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $funcoes->baseProjeto(); ?>/public/css/style_<?php echo $this->config->tema; ?>.css" />
        <link href="<?php echo $funcoes->baseProjeto(); ?>/public/css/fonts.css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?php echo $funcoes->baseProjeto(); ?>/public/js/jquery.js"></script>
        <script>document.addEventListener("touchstart", function () {}, true);</script>
        <script type="text/javascript">
            $(document).ready(function () {
                // Não permite voltar a página
                history.forward();

                // Valida o clique no checkbox
                $("#term_check").on("click", function (){
                    validateCheckbox(this);
                });
            });

            function validateCheckbox(id){
                var isChecked = $(id).is(':checked');
                if (isChecked) {
                    // Desativa o botão "Discordo"
                    $('#btnDisagree').prop("disabled", true);
                    $('#btnDisagree').addClass("btnDisabled");

                    // Ativa o botão "Aceito"
                    $('#btnAgree').prop("disabled", false);
                    $('#btnAgree').removeClass("btnDisabled");
                } else {
                    // Desativa o botão "Aceito"
                    $('#btnAgree').prop("disabled", true);
                    $('#btnAgree').addClass("btnDisabled");

                    // Ativa o botão "Discordo"
                    $('#btnDisagree').prop("disabled", false);
                    $('#btnDisagree').removeClass("btnDisabled");
                }
            }
        </script>
    </head>
    <body>