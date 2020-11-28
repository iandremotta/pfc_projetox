<!DOCTYPE html>
<html>

<head>
	<title>Chat - Login</title>
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/login.css" />
</head>

<body>
	<div class="container">
		<div class="language">
			<?php $this->lang->get('LANGUAGE'); ?>
			<ul class="language-list">
				<li><a href="lang/set/en"> <?php $this->lang->get('ENGLISH'); ?></a></li>
				<li><a href="lang/set/pt-br"><?php $this->lang->get('PORTUGUESE'); ?></a></li>
			</ul>
		</div>
		<h2><?php $this->lang->get('LOGIN'); ?></h2>
		<?php if (!empty($msg)) : ?>
			<div class="warning">
				<?php echo $msg; ?>
			</div>
		<?php endif; ?>

		<form method="POST" action="<?php echo BASE_URL; ?>login/signin">
			<?php $this->lang->get('EMAIL'); ?>:<br />
			<input type="email" name="email" autofocus /><br /><br />

			<?php $this->lang->get('PASSWORD'); ?>:<br />
			<input type="password" name="pass" /><br /><br />

			<input type="submit" value="<?php $this->lang->get('SIGNIN'); ?>" />
		</form>
		<br />
		<a href="<?php echo BASE_URL; ?>login/signup"><?php $this->lang->get('SIGNUP'); ?></a> | <a href="<?php echo BASE_URL; ?>login/forget">
			<?php $this->lang->get('FORGOTPASSWORD'); ?></a>
	</div>
</body>

</html>