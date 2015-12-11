<?php include('include/head.php'); ?>
<?php include('include/menu.php'); ?>
<br><br><br><br>

<!-- Script pour la gallerie -->
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
        html += '<div style="height:25px;clear:both;display:block;">';
        html += '<a class="controlsgallerie nextgallerie" href="'+ (clicked.nextImg) + '">next &raquo;</a>';
        html += '<a class="controlsgallerie previous" href="' + (clicked.prevImg) + '">&laquo; prev</a>';
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
            $('a.nextgallerie').attr('href', clicked.nextImg);
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
            $('a.nextgallerie').hide();
        }else{
            $('a.nextgallerie').show()
        }

        if(clicked.prevImg === -1){
            $('a.previous').hide();
        }else{
            $('a.previous').show()
        }
    }

    $(document).ready(function(){
        $(this).on('click', 'a.controlsgallerie', nextPrevHandler);
        $('li').not('.clearfix').each(function(i){
            $(this).attr('data-index',i);
            var img = $(this).find('img');
            img.on('click',showModal);
        });
    }) //end doc ready
})();
</script>

<section class="container gallerie">
    <div class="row">
        <h1><center>Gallerie</center></h1><hr>
    </div>

    <ul class="row">
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-174908-rocking-the-night-away-xs.jpg">
            <div class="text">Consectetur adipiscing elit</div>
        </li>
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-287182-blah-blah-blah-yellow-road-sign-xs.jpg">
            <div class="text">Lorem ipsum dolor sit amet, labore et dolore magna aliqua. Ut enim ad minim veniam</div>
        </li>
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-460760-colors-xs.jpg">
        </li>


        <li class="clearfix visible-xs-block"></li>


        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-461673-retro-party-xs.jpg">
            <div class="text">Lorem, do eiusmod tempor incid Ut enim ad minim veniam</div>
        </li>


        <li class="clearfix visible-sm-block"></li>


        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-514834-touchscreen-technology-xs.jpg">
            <div class="text">Do eiusmod tempor</div>
        </li>
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-916206-legal-xs.jpg">
            <div class="text">Eiusmod tempor enim ad minim veniam</div>
        </li>


        <li class="clearfix visible-lg-block  visible-md-block visible-xs-block"></li>


        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-1062948-nature-xs.jpg">
            <div class="text">Adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</div>
        </li>
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-1471528-insant-camera-kid-xs.jpg">
            <div class="text">Lorem ipsum dolor sit amet, labore et dolore magna aliqua. Ut enim ad minim veniam</div>
        </li>


        <li class="clearfix visible-sm-block"></li>



        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-2255072-relaxed-man-xs.jpg">
            <div class="text">Eiusmod tempor enim ad minim veniam</div>
        </li>


        <li class="clearfix visible-xs-block"></li>


        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-2360379-colors-xs.jpg">
            <div class="text">Consectetur adipiscing elit</div>
        </li>
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-2360571-jump-xs.jpg">
            <div class="text">Lorem ipsum dolor sit amet, labore et dolore magna aliqua. Ut enim ad minim veniam</div>
        </li>
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-2361384-culture-for-business-xs.jpg">
            <div class="text">Adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</div>
        </li>


        <li class="clearfix visible-lg-block  visible-md-block visible-sm-block visible-xs-block"></li>


        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-2441670-spaghetti-with-tuna-fish-and-parsley-s.jpg">
            <div class="text">Lorem ipsum dolor sit amet, labore et dolore magna aliqua. Ut enim ad minim veniam</div>
        </li>
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-2943363-budget-xs.jpg">
            <div class="text">Adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</div>
        </li>
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-3444921-street-art-xs.jpg">
            <div class="text">Consectetur adipiscing elit, re magna aliqua. Ut enim ad minim veniam</div>
        </li>


        <li class="clearfix visible-xs-block"></li>


        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-3552322-insurance-xs.jpg">
            <div class="text">Ut enim ad minim veniam</div>
        </li>


        <li class="clearfix visible-sm-block"></li>


        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-3807845-food-s.jpg">
            <div class="text">Eiusmod tempor enim ad minim veniam</div>
        </li>
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-3835655-down-office-worker-xs.jpg">
            <div class="text">Ut enim ad minim veniam</div>
        </li>


        <li class="clearfix visible-lg-block  visible-md-block visible-xs-block"></li>


        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-4619216-ui-control-knob-regulators-xs.jpg">
            <div class="text">Do eiusmod tempor</div>
        </li>

        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-5771958-health-xs.jpg">
            <div class="text">Lorem ipsum dolor sit amet, labore et dolore magna aliqua. Ut enim ad minim veniam</div>
        </li>


        <li class="clearfix visible-sm-block"></li>


        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-268693-businesswoman-using-laptop-outdoors-xs.jpg">
            <div class="text">Consectetur adipiscing elit, re magna aliqua. Ut enim ad minim veniam</div>
        </li>
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-352207-search-of-code-s.jpg">
            <div class="text">Adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</div>
        </li>

        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-247190-secret-email-xs.jpg">
        </li>
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-xxs-12">
            <img class="img-responsive" src="style/gallerie/images/photodune-682990-online-search-xs.jpg">
            <div class="text">Eiusmod tempor enim ad minim veniam</div>
        </li>
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