<!doctype html>
<html>
<head>
	<title>Gerenciador de Campeonatos</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./css/estiloadctime.css">
	<link rel="icon" href="./img/logo.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="./img/logo.ico" type="image/x-icon" />
</head>
<body>

	<div class="inscricao">
		
		<figure class="background">
		
			<img src="./img/presentationfundo.jpg">


		</figure>

		<figure class="cinturaotimes">
				<img src="./img/cinturaotimes.png">
		</figure>

		<form class="inscricao_form" action="adicionar_time.php" method="get">
			<h1>Adicione seu time!</h1>
			<br/>
			<p>Nome do time:</p><input type="text" name="ntime" value=""/>
			<br/>
			<input type="submit" class="submit" />
		</form>
	

		<div class="inscricao_confirmacao">

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

					$arquivo .= PHP_EOL . $linha;
				}

				fclose($handle);

				$a = $ntime . $arquivo;
				file_put_contents($caminhoArquivo, $a );
				
				echo "<p class='sucesso-adicao'>Time $ntime inscrito com sucesso!</p>";
			?>

		</div>	
			
	</div>
</body>

</html>