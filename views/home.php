<div class="container">
    <!-- informações do usuário -->
    <div class="userinfo">
        Logado como:
        <strong><?php echo ucfirst($user['name']); ?> </strong>
        <a href="<?php BASE_URL; ?>settings" class="submenu">
            <img src="<?php echo BASE_URL; ?>assets/images/multimedia.png" alt="Configurações" title="Configurações" width="14" height="12" alt="Configurações">

        </a>

        <a href="<?php echo BASE_URL; ?>login/logout"> Logout</a>
    </div>
    <!-- fim das informações do usuário -->

    <!-- nav para os grupos -->
    <nav>
        <ul>
            <!--Lista dos grupos-->
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <button class="add_tab">+</button>
    </nav>
    <!-- fim da lista dos grupos -->
    <!-- barra de progresso envio de arquivo -->
    <div class="progress">
        <div class="progressbar" style="width: 0%;">

        </div>
    </div>
    <!-- fim da barra de progresso do envio de arquivo  -->
    <section>
        <!-- inicio das mensagens -->
        <div class="messages">
            <div class="message">
                <div class=" m_info">
                    <span class="m_sender">André Motta</span>
                    <span class="m_date">10:00</span>
                </div>
                <div class="m_body">
                    Regras gerais do site:
                    <ul>
                        <li>Trate todos com respeito.</li>
                        <li>Não é permitido nenhum tipo de conteúdo inapropriado.</li>
                        <li>Proibido o uso de palavras de baixo calão no chat.</li>
                        <li>Não fazer divulgação de outras comunidades e até mesmo posts no grupo.</li>
                        <li>Não brigar.</li>
                        <li>Divulgação em geral (Spam)</li>
                        <li>Imagens de cunho inapropriado</li>
                    </ul>
                    <h2>Para entrar em uma sala clique no + no canto superior direito.</h2>
                    <h3>=)</h3>
                </div>
            </div>
        </div>
        <!-- fim das mensagens -->

        <!-- inicio da lista de usuarios -->
        <div class="user_list">
            <ul>

            </ul>
        </div>
        <!-- fim da lista de usuarios -->
    </section>
    <!-- envio de texto -->
    <footer>
        <div class="sender_area">

            <input type="file" id="sender_input_img" />
            <input type="text" id="sender_input" placeholder="Digite aqui sua mensagem" autocomplete="off" autofocus />
            <div class="sender_tools">
                <div class="sender_tool imgUploadBtn"></div>
                <div class="sender_tool"></div>
            </div>
        </div>
    </footer>
    <!-- fim do envio de texto -->

</div>