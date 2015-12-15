<div id ="header" class = "navbar navbar-inverse navbar-fixed-top">
    <div class = "container">
        <?php
        if (strstr($_SERVER['REQUEST_URI'], '/membre/'))
            echo '<a class="navbar-brand" href="../index.php">BDE - <span class="lighter">Lycée De La Salle</span></a>';
        else
            echo '<a class="navbar-brand" href="index.php">BDE - <span class="lighter">Lycée De La Salle</span></a>';
        ?>
        <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
            <span class = "icon-bar"></span>
            <span class = "icon-bar"></span>
            <span class = "icon-bar"></span>
        </button>
        <div class = "collapse navbar-collapse navHeaderCollapse">
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
                                if ($_SESSION['privilege'] == '1') { //Si le membre est admin, il peut avoir ce menu
                                    echo '<li role="separator" class="divider"></li>';
                                    echo '<li><a href="admin/index.php">Administration</a></li>';
                                }
                            } else {
                                echo '<li><a href="membre/index.php">Mon compte</a></li>';
                                echo '<li role="separator" class="divider"></li>';
                                echo '<li><a href="membre/logout.php">Déconnexion</a></li>';
                                if ($_SESSION['privilege'] == '1') { //Si le membre est admin, il peut avoir ce menu
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
        </div>
    </div>
</div>