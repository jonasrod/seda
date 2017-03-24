<?php
class correioslog {
	public $tipo_arquivo   = 'Postagem';
	public $versao_arquivo = '2.3';
	public $plp;
	public $remetente;
	public $forma_pagamento;
	public $objeto_postal;
	
	private $parametros;
	
	public function __construct($parametros, $objetoPostal)
	{
		$this->parametros = $parametros;
		
		$this->createPlpNode();
		$this->createRemetenteNode();
		$this->createObjetoPostal($objetoPostal);
	}
	
	private function createPlpNode()
	{
		$this->plp = array(
			'id_plp' => '',
			'valor_global' => '',
			'mcu_unidade_postagem' => '',
			'nome_unidade_postagem' => '',
			'cartao_postagem' => $this->parametros['cartao']
		);
	}
	
	private function createRemetenteNode()
	{
		$this->remetente = array(
				'numero_contrato'  => $this->parametros['contrato'],
				'numero_diretoria' => $this->parametros['cod_diretoria'],
				'codigo_administrativo' => $this->parametros['cod_adm'],
				'nome_remetente'   => '<![CDATA[DIRCE DA SILVA CARDOSO - ME]]>',
				'logradouro_remetente' => '<![CDATA[ESTRADA DO BARUEL]]>',
				'numero_remetente' => '2840',
				'complemento_remetente' => '',
				'bairro_remetente' => '<![CDATA[BARUEL]]>',
				'cep_remetente' => '<![CDATA[08653300]]>',
				'cidade_remetente' => '<![CDATA[SUZANO]]>',
				'uf_remetente' => 'SP',
				'telefone_remetente' => '1147511852',
				'fax_remetente' => '<![CDATA[]]>',
				'email_remetente' => '<![CDATA[SEDA@SEDAEROTICA.COM.BR]]>'
		);
	}
	
	public function createObjetoPostal($objetoPostal) {
		$this->objeto_postal = array(
				'numero_etiqueta' => $objetoPostal['etiqueta'],
				'codigo_objeto_cliente' => '',
				'codigo_servico_postagem' => $objetoPostal['cd_serv_post'],
				'cubagem' => '',
				'peso' => $objetoPostal['peso'],
				'rt1' => '',
				'rt2' => '',
				'destinatario' => array(
					'nome_destinatario' => '<![CDATA['.$objetoPostal['cliente']['nome'].']]>',
					'telefone_destinatario' => $objetoPostal['cliente']['telFixo'],
					'celular_destinatario' => $objetoPostal['cliente']['telCelular'],
					'email_destinatario' => '<![CDATA['.$objetoPostal['cliente']['email'].']]>',
					'logradouro_destinatario' => '<![CDATA['.$objetoPostal['cliente']['endereco'].']]>',
					'complemento_destinatario' => '<![CDATA['.$objetoPostal['cliente']['complemento'].']]>',
					'numero_end_destinatario' => $objetoPostal['cliente']['numero']
				),
				'nacional' => array(
					'bairro_destinatario' => '<![CDATA['.$objetoPostal['cliente']['bairro'].']]>',
					'cidade_destinatario' => '<![CDATA['.$objetoPostal['cliente']['cidade'].']]>',
					'uf_destinatario' => $objetoPostal['cliente']['uf'],
					'cep_destinatario' => '<![CDATA['.$objetoPostal['cliente']['cep'].']]>',
					'codigo_usuario_postal' => '',
					'centro_custo_cliente' => '',
					'numero_nota_fiscal' => $objetoPostal['nf'],
					'serie_nota_fiscal' => '',
					'valor_nota_fiscal' => '',
					'natureza_nota_fiscal' => '',
					'descricao_objeto' => '<![CDATA[]]>',
					'valor_a_cobrar' => ''
				),
				'servico_adicional' => array(
					'codigo_servico_adicional' => '025',
					'valor_declarado' => ''
				),
				'dimensao_objeto' => array(
					'tipo_objeto' => '001',
					'dimensao_altura' => '2',
					'dimensao_largura' => '11',
					'dimensao_comprimento' => '16',
					'dimensao_diametro' => '0'
				),
				'data_postagem_sara' => '',
				'status_processamento' => 0,
				'numero_comprovante_postagem' => '',
				'valor_cobrado' => ''
		);
	}
}
?>