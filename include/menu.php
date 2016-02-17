<nav id ="header" class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
            if (strstr($_SERVER['REQUEST_URI'], '/membre/'))
                echo '<a class="navbar-brand" href="../index.php">BDE - <span class="lighter">Lycée De La Salle</span></a>';
            else
                echo '<a class="navbar-brand" href="index.php">BDE - <span class="lighter">Lycée De La Salle</span></a>';
            ?>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class = "nav navbar-nav navbar-right">
                <?php
                if (strstr($_SERVER['REQUEST_URI'], '/membre/')){
                    echo '<li><a href="../index.php">Accueil</a></li>';
                    echo '<li><a href="../news.php">News</a></li>';
                    echo '<li><a href="../evenement.php">Evenements</a></li>';
                    echo '<li><a href="../album.php">Galerie</a></li>';
                    echo '<li><a href="../contact.php">Contact</a></li>';
                } else {
                    echo '<li><a href="index.php">Accueil</a></li>';
                    echo '<li><a href="news.php">News</a></li>';
                    echo '<li><a href="evenement.php">Evenements</a></li>';
                    echo '<li><a href="album.php">Galerie</a></li>';
                    echo '<li><a href="contact.php">Contact</a></li>';
                }
                ?>
                <li class = "dropdown">

                    <a href = "#" class = "dropdown-toggle" data-toggle = "dropdown">Espace Membre<b class = "caret"></b></a>
                    <ul class = "dropdown-menu">
                        <?php
                        if (isset($_SESSION['numMembre'])) //les membres non connectes ne peuvent pas se deconnecter
                        {
                            if (strstr($_SERVER['REQUEST_URI'], '/membre/')){
                                echo '<li><a href="index.php">Mon compte</a></li>';
                                echo '<li role="separator" class="divider"></li>';
                                echo '<li><a href="logout.php">Déconnexion</a></li>';;
                                if ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'owner') { //Si le membre est admin, il peut avoir ce menu
                                    echo '<li role="separator" class="divider"></li>';
                                    echo '<li><a href="admin.php">Administration</a></li>';
                                }
                            } else {
                                echo '<li><a href="membre/index.php">Mon compte</a></li>';
                                echo '<li role="separator" class="divider"></li>';
                                echo '<li><a href="membre/logout.php">Déconnexion</a></li>';
                                if ($_SESSION['privilege'] == 'admin' || $_SESSION['privilege'] == 'owner') { //Si le membre est admin, il peut avoir ce menu
                                    echo '<li role="separator" class="divider"></li>';
                                    echo '<li><a href="membre/admin.php">Administration</a></li>';
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
        </div><!--/.nav-collapse -->
    </div>
</nav>