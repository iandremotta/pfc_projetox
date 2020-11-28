<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/login.css" />

<body>
    <div class="container editContainer">
        <?php if (!empty($msg)) : ?>
            <div class="warning">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="sadMsg">
                <h2> Excluir conta</h2>
                <p><small>Sentiremos sua falta.</small></p>
                <img src="<?php echo BASE_URL; ?>assets/images/sad.png" style="max-width: 60px;">
            </div>
            <br>
            <input type="text" name="data" autofocus placeholder="Digite confirmar" autocomplete="off" /><br /> <br>

            <input type="submit" value="Excluir conta" />
            <br><br>

            <a href="<?php BASE_URL; ?>/settings">Voltar</a>
        </form>
    </div>