<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/login.css" />

<body>
	<div class="container editContainer">
		<form method="POST">
			<h2>Atualize seu e-mail </h2>
			<?php if (!empty($msg)) : ?>
				<div class="warning">
					<?php echo $msg; ?>
				</div>
			<?php endif; ?>
			<br />
			<input type="email" name="data" autofocus required placeholder="Atualize seu e-mail" autocomplete="off" />
			<br /><br>
			<input type="submit" value="Atualizar e-mail" />
			<br><br>
			<a href="<?php BASE_URL; ?>/settings">Voltar</a>
		</form>
</body>