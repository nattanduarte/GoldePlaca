<!doctype html>
<html>
<head>
	<title>Gerenciador de Campeonatos</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./css/estiloadctime.css">
</head>
<body>
	<script type="text/javascript">
		
		alert("Olá, se você não for Nattan Duarte ou José Vitor Heringer, clique na setinha para a esquerda no canto superior esquerdo do seu navegador. Se você for José ou Nattan, primeiro, você é lindo, cara, agora vamos consertar essa porra, beijos");

	</script>

	<video width="100%" height="100%" autoplay loop muted>
		<source src="esquiloladrao.mp4" type="video/mp4"/>
	</video>

	<div class="tudao">
	<form method="post">
		<h1>Adicione seu time!</h1>
		<br/>
		Nome do time:<input type="text" name="ntime" value=""/>
		<br/>
		<input type="submit"/>
	</form>
		<?php


			$ntime=$_POST['ntime'];


			$ntime = mb_strtoupper($ntime);

			$handle=fopen("./documentos/times.txt", "r+");

			while (!feof($handle)) {
					
							
				if ($ntime!=fgets($handle)) {
					
					fwrite($handle, $ntime.'\n \t'.PHP_EOL);
					echo "Time inscrito com sucesso!";
					break;
				}
				else{
				
					?>
					<p>Aparentemente o time que você inseriu já está disponível. Corra e acompanhe os resultados <a href="">na tabela</a></p>
					<?php
					break;
				}
			}	
			fclose($handle);
	?>
	</div>

</body>

</html>