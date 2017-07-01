<!DOCTYPE html>
<html>
<head>
	<title>Tabela</title>
</head>
<body>
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

	<table border="1">
		<tr>
			<th>Nome</th>
			<th>J</th>
			<th>P</th>
			<th>V</th>
			<th>E</th>
			<th>D</th>
			<th>GP</th>
			<th>GC</th>
			<th>SG</th>
			<th>Aprov.</th>
		</tr>
		<?php
			foreach ($tabelaOrganizada as $key => $value) {
		?>
		<tr>
			<td> <?php echo $value[ 'TIME' ] ?></td>
			<td> <?php echo $value[ 'JOGOS' ] ; ?></td>
			<td> <?php echo $value[ 'PONTOS' ] ; ?></td>
			<td> <?php echo $value[ 'VITORIAS' ] ; ?></td>
			<td> <?php echo $value[ 'EMPATES' ] ; ?></td>
			<td> <?php echo $value[ 'DERROTAS' ] ; ?></td>
			<td> <?php echo $value[ 'GOLSPRO' ] ; ?></td>
			<td> <?php echo $value[ 'GOLSCONTRA' ] ; ?></td>
			<td> <?php echo $value[ 'SALDOGOLS' ] ; ?></td>
			<td> <?php echo round($value[ 'APROVEITAMENTO' ], 1) ; ?>%</td>
		</tr>
		<?php } ?>
	</table>

<?php
fclose($arquivoTimes);
fclose($arquivoResultado); 
?>
</body>
</html>

