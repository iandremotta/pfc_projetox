<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/login.css" />

<body>
	<div class="container editContainer">
		<form method="POST">
			<h2>Atualize seu nome</h2>
			<br />
			<input type="text" name="data" autofocus placeholder="Digite seu novo nome" autocomplete="off" required />
			<br /><br>
			<input type="submit" value="Mudar nome" />
			<br><br>
			<a href="<?php BASE_URL; ?>/settings">Voltar</a>
		</form>
</body>