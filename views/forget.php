<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/login.css" />

<body>
	<div class="container editContainer">
		<form method="POST">
			<h2><?php $this->lang->get('WHATSURUSERNAME'); ?></h2>

			<input type="email" name=email autofocus required autocomplete="off" placeholder="<?php $this->lang->get('INPUTPHRASE'); ?>" /> <br>
			<br>
			<input type="submit" value="<?php $this->lang->get('SEND'); ?>">
			<br><br>
			<a href="<?php BASE_URL; ?>/"><?php $this->lang->get('BACK'); ?></a>
		</form>