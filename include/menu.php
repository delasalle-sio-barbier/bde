<header id="header" class="navbar navbar-inverse navbar-fixed-top" role="banner" style="background-color: #848484; color:white;">
    <div class="container">
        <div class="navbar-header">
            <!-- Your Logo -->
            <a class="navbar-brand">BDE - <span class="lighter">Lycée De La Salle</span></a>
        </div>
        <!-- Start Navigation -->
        <nav class="navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
            <ul class="nav navbar-nav">
                <?php
                if (strstr($_SERVER['REQUEST_URI'], '/membre/')){
                    echo '<li><a href="../index.php">Accueil</a></li>';
                    echo '<li><a href="../news.php">News</a></li>';
                    echo '<li><a href="../agenda.php">Agenda</a></li>';
                    echo '<li><a href="../galerie.php">Galerie</a></li>';
                    echo '<li><a href="../contact.php">Contact</a></li>';
                } else {
                    echo '<li><a href="index.php">Accueil</a></li>';
                    echo '<li><a href="news.php">News</a></li>';
                    echo '<li><a href="agenda.php">Agenda</a></li>';
                    echo '<li><a href="galerie.php">Galerie</a></li>';
                    echo '<li><a href="contact.php">Contact</a></li>';
                }
                ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Espace Membre<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php
                        if (isset($_SESSION['id'])) //les membres non connectes ne peuvent pas se deconnecter
                        {
                            if (strstr($_SERVER['REQUEST_URI'], '/membre/')){
                                echo '<li><a href="index.php">Mon compte</a></li>';
                                echo '<li role="separator" class="divider"></li>';
                                echo '<li><a href="logout.php">Déconnexion</a></li>';;
                                if ($_SESSION['level'] == '1') { //Si le membre est admin, il peut avoir ce menu
                                    echo '<li role="separator" class="divider"></li>';
                                    echo '<li><a href="admin/index.php">Administration</a></li>';
                                }
                            } else {
                                echo '<li><a href="membre/index.php">Mon compte</a></li>';
                                echo '<li role="separator" class="divider"></li>';
                                echo '<li><a href="membre/logout.php">Déconnexion</a></li>';
                                if ($_SESSION['level'] == '1') { //Si le membre est admin, il peut avoir ce menu
                                    echo '<li role="separator" class="divider"></li>';
                                    echo '<li><a href="membre/admin">Administration</a></li>';
                                }
                            }
                        }else {
                            if (strstr($_SERVER['REQUEST_URI'], '/membre/')) {
                                echo '<li><a href="login.php">Connexion</a></li>';
                            } else {
                                echo '<li><a href="membre/login.php">Connexion</a></li>';
                            }
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>