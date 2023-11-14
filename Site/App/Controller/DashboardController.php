<?php

namespace App\Controller;

use App\Model\MovimentacaoModel;
use App\Model\ParcelaModel;

class DashboardController extends Controller
{
	public static function index()
	{
		parent::checkParcelas();		
		parent::isAuthenticated();

		$movimentacao = new MovimentacaoModel();
		$parcela = new ParcelaModel();
		$saldo = $movimentacao->getSaldo();
		$saida = $movimentacao->getTotalSaida();
		$entrada = $movimentacao->getTotalEntrada();
		$pendente = $parcela->getTotalPendenteOfCurrentMonth();

		include VIEWS . 'Home/Dashboard.php';
	}
}
