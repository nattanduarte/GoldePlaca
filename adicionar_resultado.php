<!doctype html>
<html>
<head>
	<title>Gerenciador de Campeonatos</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./css/estiloadcresult.css"/>
	<link rel="icon" href="./img/logo.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="./img/logo.ico" type="image/x-icon" />
</head>
<body>

	<figure class="background">
		
			<img src="./img/presentationfundo.jpg">


		</figure>

		<figure class="cinturaotimes">
				<img src="./img/cinturaotimes.png">
		</figure>

	<div class="form">
	<form action="adicionar_resultado.php" method="get">
		<h1>Adicione o resultado!</h1>
		<br/>
		Nome do time mandante:<input type="text" name="timem" />
		<br/>
		Placar do time mandante:<input type="number" name="resultado_timem" />
		<br/>
		Nome do time visitante:<input type="text" name="timev" />
		<br/>
		Placar do time visitante:<input type="number" name="resultado_timev" />
		<br/>
		<input type="submit"/>
	</form>
</div>

<?php

	
	if( !array_key_exists( 'timem', $_GET ) ) return;
	if( !array_key_exists( 'timev', $_GET ) ) return;
	if( !array_key_exists( 'resultado_timem', $_GET ) ) return;
	if( !array_key_exists( 'resultado_timev', $_GET ) ) return;
	

	$caminhoArquivo = "./documentos/resultados.txt";
	$caminhoArquivoTimes = "./documentos/times.txt";

	$timem=$_GET['timem'];
	$resultado_timem=$_GET['resultado_timem'];
	$timev=$_GET['timev'];
	$resultado_timev=$_GET['resultado_timev'];
	
	$arquivo = '';

	$timem =  mb_strtoupper($timem);
	$timev =  mb_strtoupper($timev);
	
	$handle_times=fopen($caminhoArquivoTimes, "r");
	$handle_resultado=fopen($caminhoArquivo, "r+");
	
	$b = trim( $timem . PHP_EOL );
	$c = trim( $timev . PHP_EOL );

	while(!feof($handle_times)){

		$linha = trim( fgets($handle_times) );
		

		if( $timem == $linha ){
			rewind ( $handle_times );
			
			while(!feof($handle_times)){
				
				$linha = trim( fgets($handle_times) );
				if($c == $linha){
					
						while(!feof($handle_resultado)){
							$linha = trim( fgets($handle_resultado) );
							$arquivo .= PHP_EOL . $linha ;	
							$resultado=$timem .';'. $timev.';'.$resultado_timem.';'.$resultado_timev;

							$a=explode(";", $linha);

							if($a[0]==$timem and $a[1]==$timev){
								
								echo "O resultado deste jogo já foi adicionado";	
								die;
							}
						
						}			
					
					$a = $timem .';'. $timev.';'.$resultado_timem.';'.$resultado_timev . $arquivo;
			
					file_put_contents($caminhoArquivo, $a );
					
					die("Resultado adicionado com sucesso!");
				}
			}
			
		}
		
	}
	fclose($handle_times);
	fclose($handle_resultado);
	echo "Um dos times não está cadastrado";
?>

</body>

</html>