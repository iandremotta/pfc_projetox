<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/login.css" />

<body>
	<div class="container editContainer">
		<form method="POST">
			<h2>Digite a nova senha</h2>
			<?php if (!empty($msg)) : ?>
				<div class="warning">
					<?php echo $msg; ?>
				</div>
			<?php endif; ?>
			<br />
			<input type="password" name="password" autofocus placeholder="Digite a nova senha" />
			<br>

			<input type="password" name="confirmPass" autofocus placeholder="Repita sua  senha" />
			<br /> <br>
			<input type="submit" value="Mudar senha" />
			<br><br>
			<a href="<?php BASE_URL; ?>/settings">Voltar</a>
		</form>