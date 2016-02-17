<?php include('include/head.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Script pour la galerie -->
<script>
(function(){
    "use strict";

    var clicked = {};

    function showModal(){

        var src = $(this).attr('src');
        var img = '<img src="' + src + '" class="img-responsive"/>';
        var index = $(this).parent('li').attr('data-index');

        clicked.prevImg = parseInt(index) - parseInt(1);
        clicked.nextImg = parseInt(index) + parseInt(1);

        var html = '';
        html += img;
        html += '<div style="height:30px;clear:both;display:block;">';
        html += '<a class="controlsgalerie nextgalerie" href="'+ (clicked.nextImg) + '">Suivant &raquo;</a>';
        html += '<a class="controlsgalerie previous" href="' + (clicked.prevImg) + '">&laquo; Précédent</a>';
        html += '</div>';

        $('#myModal').modal();
        $('#myModal').on('shown.bs.modal', function(){
            $('#myModal .modal-body').html(html);
            showHideControls();
        })
        $('#myModal').on('hidden.bs.modal', function(){
            $('#myModal .modal-body').html('');
        });
    }

    function nextPrevHandler(){

        var index = $(this).attr('href');
        var src = $('li[data-index="'+index+'"] img').attr('src');

        $('.modal-body img').attr('src', src);

        clicked.prevImg = parseInt(index) - 1;
        clicked.nextImg = parseInt(clicked.prevImg) + 2;

        if($(this).hasClass('previous')){
            $(this).attr('href', clicked.prevImg);
            $('a.nextgalerie').attr('href', clicked.nextImg);
        }else{
            $(this).attr('href', clicked.nextImg);
            $('a.previous').attr('href', clicked.prevImg);
        }

        showHideControls();

        return false;

    }

    function showHideControls(){

        var total = ($('li').not('.clearfix').length);

        if(total === clicked.nextImg){
            $('a.nextgalerie').hide();
        }else{
            $('a.nextgalerie').show()
        }

        if(clicked.prevImg === -1){
            $('a.previous').hide();
        }else{
            $('a.previous').show()
        }
    }

    $(document).ready(function(){
        $(this).on('click', 'a.controlsgalerie', nextPrevHandler);
        $('li').not('.clearfix').each(function(i){
            $(this).attr('data-index',i);
            var img = $(this).find('img');
            img.on('click',showModal);
        });
    }) //end doc ready
})();
</script>

<section class="container galerie">
    <div class="row">
        <h1><center>Galerie</center></h1><hr>
    </div>
    <ul class="row">
        <?php
        require 'include/connectbdd.php';
        $requete = 'SELECT numPhoto, nomPhoto, urlPhoto FROM photo WHERE numAlbum = '.$_GET["numAlbum"].' ORDER BY numPhoto';
        $req = $bdd->prepare($requete);
        $req->execute();
        $compteur = 0;
        while ($row = $req->fetch()) {
            echo '<li class="col-lg-2 col-md-2 col-sm-4 col-xs-4 col-xxs-12">';
            echo '  <img class="img-responsive" src="style/images/galerie/'.$row["urlPhoto"].'">';
            if (!empty($row["nomPhoto"]))
                echo '  <div class="text">'.$row["nomPhoto"].'</div>';
            echo '</li>';
            $compteur += 1;
            if ($compteur % 6 == 0) {
                echo '<li class="clearfix visible-lg  visible-md"></li><br class="visible-lg visible-md">';
            } elseif ($compteur % 3 == 0) {
                echo '<li class="clearfix visible-xs visible-sm"></li><br class="visible-xs visible-sm">';
            }
        }
        $req->closeCursor();
        ?>
    </ul>
</section> <!-- /container -->


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php include('include/footer.php'); ?>