<!doctype html>
<html>
<head>
	<title>Gerenciador de Campeonatos</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./css/estiloadctime.css">
</head>
<body>



	<div class="">
	<form action="adicionar_time.php" method="get">
		<h1>Adicione seu time!</h1>
		<br/>
		Nome do time:<input type="text" name="ntime" value=""/>
		<br/>
		<input type="submit"/>
	</form>
</div>

<?php

	
	if( !array_key_exists( 'ntime', $_GET ) ) return;

	$caminhoArquivo = "./documentos/times.txt";

	$ntime=$_GET['ntime'];
	$arquivo = '';

	$ntime =  mb_strtoupper($ntime);
	$handle=fopen($caminhoArquivo, "r+");

	while(!feof($handle)){

		$linha= trim( fgets($handle) );
		$b = trim( $ntime . PHP_EOL );

		if( $b ==$linha){
			die("<p class='erro-adicao'>O time $ntime já está cadastrado, confira a nossa <a href='./documentos/times.txt'>tabela</a></p>");
		}

		$arquivo .= $linha . PHP_EOL;
	}

	fclose($handle);

	$a = $ntime . PHP_EOL . $arquivo;
	file_put_contents($caminhoArquivo, $a );
	
	echo "<p class='sucesso-adicao'>Time $ntime inscrito com sucesso!</p>";
?>

</body>

</html>