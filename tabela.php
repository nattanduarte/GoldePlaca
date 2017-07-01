<!DOCTYPE html>
<html>
<head>
	<title>Tabela</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="./css/estilotabela.css"/>
	<link rel="icon" href="./img/logo.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="./img/logo.ico" type="image/x-icon" />
</head>
<body>
	
	<figure class="background">
		
			<img src="./img/presentationfundo.jpg">
	</figure>
	<h1><span>Tabela</span> Gol de <span>Placa</span></h1>
	<?php

		$jogos=array();

		$tabelaCampeonato=array();
		$caminhoResultado = "./documentos/resultados.txt";
		$arquivoResultado = fopen($caminhoResultado, 'r');
		$caminhoTimes = "./documentos/times.txt";
		$arquivoTimes = fopen($caminhoTimes, 'r');

		$t=0;

		while (!feof($arquivoResultado)){

			$linha=fgets($arquivoResultado);
			if (empty($linha)) {
				continue;
			}
			$resultado=explode(";", $linha);
			array_push($jogos, $resultado);
		}

		$valoresTabela = [
			'JOGOS'  => 0,
			'PONTOS' => 0,
			'VITORIAS' => 0,
			'EMPATES' => 0,
			'DERROTAS' => 0,
			'GOLSPRO' => 0,
			'GOLSCONTRA' => 0,
			'SALDOGOLS' => 0,
			'APROVEITAMENTO'=> 0

		];
		 $i=0;
		while (!feof($arquivoTimes)) {

			$time=fgets($arquivoTimes);
			$time=str_replace(PHP_EOL, '', $time);
			if (empty($time)) {
				continue;
			}
			$tabelaCampeonato[$time]=array();
		}




		foreach( $tabelaCampeonato as $key => $valor ) {
			$tabelaCampeonato[ $key ] = $valoresTabela;
		}


		for( $i = 0; $i < count( $jogos ); $i++ ) {
			
			$time1 = $jogos[ $i ][ 0 ];
			$time2 = $jogos[ $i ][ 1 ];
			$golMandante = $jogos[ $i ][ 2 ];
			$golVisitante = $jogos[ $i ][ 3 ];
			$saldoGolMandante = $jogos[ $i ][ 2 ] - $jogos[ $i ][ 3 ];
			$saldoGolVisitante = $jogos[ $i ][ 3 ] - $jogos[ $i ][ 2 ];
				
			
			$tabelaCampeonato[ $time1 ][ 'JOGOS' ] += 1;
			$tabelaCampeonato[ $time2 ][ 'JOGOS' ] += 1;
			$tabelaCampeonato[ $time1 ][ 'GOLSPRO' ] += $golMandante;
			$tabelaCampeonato[ $time2 ][ 'GOLSPRO' ] += $golVisitante;
			$tabelaCampeonato[ $time2 ][ 'GOLSCONTRA' ] += $golMandante;
			$tabelaCampeonato[ $time1 ][ 'GOLSCONTRA' ] += $golVisitante;
			$tabelaCampeonato[ $time1 ][ 'SALDOGOLS' ] += $saldoGolMandante;
			$tabelaCampeonato[ $time2 ][ 'SALDOGOLS' ] += $saldoGolVisitante;

			
			if( $golMandante > $golVisitante ) { //VITÓRIA DO MANDANTE
				$tabelaCampeonato[ $time1 ][ 'VITORIAS' ] += 1;
				$tabelaCampeonato[ $time2 ][ 'DERROTAS' ] += 1;
				$tabelaCampeonato[ $time1 ][ 'PONTOS' ] += 3;
			} else if( $golMandante == $golVisitante ) {//EMPATE
				$tabelaCampeonato[ $time1 ][ 'EMPATES' ] += 1;
				$tabelaCampeonato[ $time2 ][ 'EMPATES' ] += 1;
				$tabelaCampeonato[ $time1 ][ 'PONTOS' ] += 1;
				$tabelaCampeonato[ $time2 ][ 'PONTOS' ] += 1;
			} else {//VITÓRIA DO VISITANTE
				$tabelaCampeonato[ $time2 ][ 'VITORIAS' ] += 1;
				$tabelaCampeonato[ $time1 ][ 'DERROTAS' ] += 1;
				$tabelaCampeonato[ $time2 ][ 'PONTOS' ] += 3;
			}

		}

		foreach ($tabelaCampeonato as $key => $value) {
			$qtddjogos = $tabelaCampeonato[ $key ][ 'JOGOS' ] * 3;
			if ($qtddjogos==0) {
				continue;
			}
			$tabelaCampeonato[ $key ][ 'APROVEITAMENTO' ] = ($tabelaCampeonato[ $key ][ 'PONTOS' ]/ $qtddjogos ) * 100;
		}

		$tabelaOrganizada = [];

		foreach ($tabelaCampeonato as $key => $value) {
			$value[ 'TIME' ] = $key;
			array_push($tabelaOrganizada, $value);
		}

		for ( $i=0; $i < count( $tabelaOrganizada) ; $i++) { 
			for ( $j=$i + 1; $j < count( $tabelaOrganizada) ; $j++) {

				if ( $tabelaOrganizada[ $i ][  'VITORIAS' ] == $tabelaOrganizada[ $j ][  'VITORIAS' ] ) {
				 	if ( $tabelaOrganizada[ $i ][  'SALDOGOLS' ] == $tabelaOrganizada[ $j ][  'SALDOGOLS' ] ) {
				 		if ($tabelaOrganizada[ $i ][  'GOLSPRO' ] == $tabelaOrganizada[ $j ][  'GOLSPRO' ]) {
				 			continue;			 		
				 		}
				 		else if( $tabelaOrganizada[ $i ][  'GOLSPRO' ] < $tabelaOrganizada[ $j ][  'GOLSPRO' ]  ) {
								$temp =  $tabelaOrganizada[ $j ];
								$tabelaOrganizada[ $j ] = $tabelaOrganizada[ $i ];
								$tabelaOrganizada[ $i ] = $temp;
							 }
					}
				 	else if( $tabelaOrganizada[ $i ][  'SALDOGOLS' ] < $tabelaOrganizada[ $j ][  'SALDOGOLS' ]  ) {
						$temp =  $tabelaOrganizada[ $j ];
						$tabelaOrganizada[ $j ] = $tabelaOrganizada[ $i ];
						$tabelaOrganizada[ $i ] = $temp;
					}
				 } 

				else if( $tabelaOrganizada[ $i ][  'VITORIAS' ] < $tabelaOrganizada[ $j ][  'VITORIAS' ]  ) {
					$temp =  $tabelaOrganizada[ $j ];
					$tabelaOrganizada[ $j ] = $tabelaOrganizada[ $i ];
					$tabelaOrganizada[ $i ] = $temp;
				}
			}		
		}
	?>

		<table class="table">
			<tr>
				<th class="line">Nome</th>
				<th class="line">J</th>
				<th class="line">P</th>
				<th class="line">V</th>
				<th class="line">E</th>
				<th class="line">D</th>
				<th class="line">GP</th>
				<th class="line">GC</th>
				<th class="line">SG</th>
				<th class="line">Aprov.</th>
			</tr>
			<?php
				foreach ($tabelaOrganizada as $key => $value) {
			?>
			<tr>
				<td class="line"> <?php echo $value[ 'TIME' ] ?></td>
				<td class="line"> <?php echo $value[ 'JOGOS' ] ; ?></td>
				<td class="line"> <?php echo $value[ 'PONTOS' ] ; ?></td>
				<td class="line"> <?php echo $value[ 'VITORIAS' ] ; ?></td>
				<td class="line"> <?php echo $value[ 'EMPATES' ] ; ?></td>
				<td class="line"> <?php echo $value[ 'DERROTAS' ] ; ?></td>
				<td class="line"> <?php echo $value[ 'GOLSPRO' ] ; ?></td>
				<td class="line"> <?php echo $value[ 'GOLSCONTRA' ] ; ?></td>
				<td class="line"> <?php echo $value[ 'SALDOGOLS' ] ; ?></td>
				<td class="line"> <?php echo round($value[ 'APROVEITAMENTO' ], 1) ; ?>%</td>
			</tr>
			<?php } ?>
		</table>

	<?php
	fclose($arquivoTimes);
	fclose($arquivoResultado); 
	?>
</body>
</html>

