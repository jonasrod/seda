<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Vers�o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est� dispon�vel sob a Licen�a GPL dispon�vel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voc� deve ter recebido uma c�pia da GNU Public License junto com     |
// | esse pacote; se n�o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colabora��es de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Jo�o Prado Maia e Pablo Martins F. Costa			       	  |
// | 																	                                    |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordena��o Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Bradesco: Ramon Soares						            |
// +----------------------------------------------------------------------+


require_once '../wcm/config.php';
require_once '../wcm/model/bancodedados.class.php';
require_once '../wcm/model/produto.class.php';
require_once '../wcm/model/fatura.class.php';
require_once '../wcm/model/venda.class.php';
require_once '../wcm/model/cliente.class.php';
require_once '../wcm/model/endereco.class.php';
require_once '../wcm/model/data.class.php';

$objBd = new BancodeDados();
$objVenda = new Venda();
$objFatura = new Fatura();
$objCliente = new Cliente();
$objEndereco = new Endereco();

$objVenda->obterVendaPorNumPedido($_GET['numPedido']);
$objFatura->obterFaturaPorVendaId($objVenda->getVendaId());
$objCliente->obterCliente($objVenda->getMClienteId());
$objEndereco->obterEnderecoPorCliente($objCliente->getClienteId());


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERA��O DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formul�rio c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 4;
$taxa_boleto = 0.0;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $objFatura->getValorBoleto(); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = $objFatura->getNossoNumero();  // Nosso numero sem o DV - REGRA: Máximo de 11 caracteres!
$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou do documento = Nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $objCliente->getNome() . ' ' . $objCliente->getSobrenome();
$dadosboleto["endereco1"] = $objEndereco->getEndereco() . ', ' . $objEndereco->getNumero() . ' ' . $objEndereco->getComplemento();
$dadosboleto["endereco2"] = $objEndereco->getCidade() . ' - ' . $objEndereco->getEstado() . ' - CEP: ' . $objEndereco->getCep();

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja DIRCE DA SILVA CARDOSO - ME";
$dadosboleto["demonstrativo2"] = "";
$dadosboleto["demonstrativo3"] = "";
$dadosboleto["instrucoes1"] = "- Pagamento em qualquer ag&ecirc;ncia banc&aacute;ria at&eacute; o vencimento.";
$dadosboleto["instrucoes2"] = "- O n&atilde;o pagamento at&eacute; a data de vencimento, o pedido ser&aacute; cancelado automaticamente.";
$dadosboleto["instrucoes3"] = "";
$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = $valor_boleto;
$dadosboleto["aceite"] = "N";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "OUT";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - Bradesco
$dadosboleto["agencia"] = "3188"; // Num da agencia, sem digito
$dadosboleto["agencia_dv"] = "7"; // Digito do Num da agencia
$dadosboleto["conta"] = "18955"; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "3"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - Bradesco
$dadosboleto["conta_cedente"] = "18955"; // ContaCedente do Cliente, sem digito (Somente Números)
$dadosboleto["conta_cedente_dv"] = "3"; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = "25";  // Código da Carteira: pode ser 06 ou 03

// SEUS DADOS
$dadosboleto["identificacao"] = 'DIRCE DA SILVA CARDOSO - ME';
$dadosboleto["cpf_cnpj"] = "019.380.699/0001-90";
$dadosboleto["endereco"] = "Estrada do Baruel, 123";
$dadosboleto["cidade_uf"] = "Suzano / SP";
$dadosboleto["cedente"] = "DIRCE DA SILVA CARDOSO - ME";

// N�O ALTERAR!
include("include/funcoes_bradesco.php");
include("include/layout_bradesco.php");
?>
