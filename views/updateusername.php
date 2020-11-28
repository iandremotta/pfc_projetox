<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/login.css" />

<body>
	<div class="container editContainer">
		<form method="POST">
			<h2>Atualize o seu username</h2>
			<?php if (!empty($msg)) : ?>
				<div class="warning">
					<?php echo $msg; ?>
				</div>
			<?php endif; ?>
			<br />
			<input type="text" name="data" autofocus required placeholder="Atualize seu username" autocomplete="off" />
			<br /> <br>
			<input type="submit" value="Mudar username" />
			<br> <br>
			<a href="<?php BASE_URL; ?>/settings">Voltar</a>

		</form>