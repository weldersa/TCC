<!--
DATA: 03/05/16    
ARQUIVO: menu.php
DESCRIÇÃO: Arquivo com o código do Menu e da Navbar do site
-->        

        <div id="menu-lateral" class="navmenu navmenu-default navmenu-fixed-left offcanvas-sm"> <!-- Menu lateral -->
            <ul class="nav navmenu-nav" class="collapse-group">
				<?PHP
					switch ($_SESSION["user_tipo"]){
						case "P":
							echo '
								<li class="active" id="home"><a href="home.php">Início</a></li>
								<li data-toggle="collapse" id="nav_questionarios" data-target="#opcoes_questionario"><a href="#">Questionários</a></li>
									<ul class="collapse" id="opcoes_questionario">
										<li class="submenu" id="criar_questionario"><a href="criar_questionario.php">Criar</a></li>
										<li class="submenu" id="meus_questionarios"><a href="meus_questionarios.php">Meus Questionários</a></li>
										<li class="submenu"><a href="#">Corrigir</a></li>                   
									</ul>
								<li><a href="#">Consultar Notas</a></li>
								<li><a id="about" href="about.php">Sobre</a></li>
							';
							break;
				
						case "A":
							echo '
								<li class="active" id="home"><a href="home.php">Início</a></li>
								<li id="responderQuestionarios"><a href="questionarios_para_responder.php">Responder Questionários</a></li>
								<!--<li data-toggle="collapse" data-target="#opcoes_questionario"><a href="#">Questionários</a></li>
									<ul class="collapse" id="opcoes_questionario">
									</ul>-->
								<li><a href="#">Consultar Notas</a></li>
								<li><a id="about" href="about.php">Sobre</a></li>
							';
							break;
				
						case "I":
							echo '
								<li class="active" id="home"><a href="home.php">Início</a></li>
								<li data-toggle="collapse" data-target="#opcoes_questionario"><a href="#">Questionários</a></li>
									<ul class="collapse" id="opcoes_questionario">
										<li class="submenu" id="criar_questionario"><a href="#">Criar</a></li>
										<li class="submenu"><a href="#">Responder</a></li>
										<li class="submenu"><a href="#">Corrigir</a></li>                   
									</ul>
								<li data-toggle="collapse" data-target="#opcoes_admin"><a href="#">Admin</a></li>
									<ul class="collapse" id="opcoes_admin">
										<li class="submenu" id="turmas"><a href="turmas.php">Turmas</a></li>                   
										<li class="submenu" id="professores"><a href="professores.php">Professores</a></li>
										<li class="submenu" id="alunos"><a href="alunos.php">Alunos</a></li>
									</ul>
								<li><a href="consultar_notas.php">Consultar Notas</a></li>
								<li><a id="about" href="about.php">Sobre</a></li>
							';
							break;
					}
				?>
			</ul>
        </div> <!-- Fim do Menu Lateral -->
        
        <nav class="navbar navbar-default navbar-fixed-top"> <!-- Começo da Barra de Navegação -->
            <div class="container-fluid">
                <div class="navbar-header navbar-left pull-left">
                   <button id="toogle-button" type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".navmenu"> <!-- Botão que esconde o menu -->
                        <!--Cria o ícone de "Hamburger"-->
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
					<a class="navbar-brand hidden-xs hidden-sm" href="home.php" style="padding-top: 0px;">	
						<img alt="brand" height="50px" src="resources/images/logo-white-sm.png">
				    </a>
                </div> 
                <div class="navbar-header navbar-right pull-right"> <!-- Parte direita da Barra Superior -->
                    <ul class="nav pull-left">
                        <li class="navbar-text pull-left"><?PHP echo $_SESSION['user_nome']; ?></li>
                        <li class="dropdown pull-right">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle dropdown-user" style="margin-top: 5px;">
                                <span class="glyphicon glyphicon-user"></span>
                                <b class="caret caret-user"></b>
                            </a>                                
                            <ul class="dropdown-menu">
                                <li><a href="logout.php" title="Sair">Sair</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>            
            </div>
        </nav> <!-- Fim da barra de Navegação --> 