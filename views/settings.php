<!DOCTYPE html>
<html>

<head>
	<title>Chat - <?php $this->lang->get('SETTINGS'); ?></title>
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/login.css" />
</head>

<body>
	<div class="container">
		<h4>Dados</h4>

		<?php if (!empty($msg)) : ?>
			<div class="warning">
				<?php echo $msg; ?>
			</div>
		<?php endif; ?>

		<form method="POST">
			<?php $this->lang->get('NAME'); ?>: <br>
			<input type="text" name="name" value="<?php echo ucfirst($user['name']); ?>" class="settings" />
			<small><a href="<?php BASE_URL; ?>/settings/updatename"><?php $this->lang->get('EDIT'); ?></a></small>

			<br /><br />

			<?php $this->lang->get('EMAIL'); ?>: <br>
			<input type="email" name="email" value="<?php echo ($user['email']); ?>" class="settings" />
			<small><a href="<?php BASE_URL; ?>/settings/updateemail"><?php $this->lang->get('EDIT'); ?></a></small>
			<br /><br />

			<?php $this->lang->get('USERNAME'); ?>:<br />
			<input type="text" name="username" value="<?php echo ($user['username']); ?>" class="settings" />
			<small><a href="<?php BASE_URL; ?>/settings/updateusername"><?php $this->lang->get('EDIT'); ?></a></small>
			<br /><br />

			<?php $this->lang->get('PASSWORD'); ?>:<br />
			<input type="password" name="pass" id="pass" value="password" readonly="true" maxlength="8" class="settings" />
			<small><a href="<?php BASE_URL; ?>/settings/resetpass"><?php $this->lang->get('EDIT'); ?></a></small>
			<br /> <br>


			<a href="<?php BASE_URL; ?>/" class="btn"><?php $this->lang->get('BACK'); ?></a> <br><br>
			<a href="<?php BASE_URL; ?>/settings/deleteuser"><?php $this->lang->get('DELETE'); ?></a>
		</form>
	</div>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/signup.js"></script>
</body>

</html>