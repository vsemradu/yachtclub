<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use common\models\CrewMemberRole;
use common\models\Yacht;

?>

<script>
    $(function () {



        $('.js-yacht-select-type select').change(function (event) {
            if ($(this).val() == <?= Yacht::TYPE_OTHER ?>) {
                $('.js-yacht-type').show();
            } else {
                $('.js-yacht-type').hide();
            }
        });

        $('.js-blog-add').click(function (event) {
            $('.js-blog-block').show();
            event.preventDefault();
        });
        $('.js-add-crew').click(function (event) {
            $.post("/yacht/ajax-crew", {form: '<?= json_encode($form) ?>'})
                    .done(function (data) {
                        $('.js-crew-form').append(data);
                        $('.js-crew_description').show();
                    });
            event.preventDefault();
        });

        $('.js-add-season').click(function (event) {
            $.post("/yacht/ajax-season", {form: '<?= json_encode($form) ?>'})
                    .done(function (data) {
                        $('.js-season-form').append(data);
                    });
            event.preventDefault();
        });

        $('body').on('click', '.js-remove', function (event) {


            var crewmember_id = $(this).data('id');
            var yacht_id = $(this).data('yacht_id');
            if (crewmember_id != '' && yacht_id != '') {
                $.get("/yacht/ajax-delete-crewmember", {yacht_id: yacht_id, crewmember_id: crewmember_id});
            }

            $(this).parents('.js-crew-block').remove();


            event.preventDefault();
        });
        $('body').on('click', '.js-season-remove', function (event) {

            var season_id = $(this).data('id');
            var yacht_id = $(this).data('yacht_id');
            if (season_id != '' && yacht_id != '') {
                $.get("/yacht/ajax-delete-season", {yacht_id: yacht_id, season_id: season_id});
            }

            $(this).parents('.js-season-block').remove();


            event.preventDefault();
        });
        $('body').on('click', '.js-remove-blog-yacht', function (event) {


            var yacht_id = <?php echo!empty($model->id) ? $model->id : 0; ?>;
            var blog_id = $(this).data('id');
            if (yacht_id != 0 && blog_id != '') {

                if (confirm("Are you sure you want to delete the blog?")) {
                    $.post("/yacht/delete-blog", {yacht_id: yacht_id, blog_id: blog_id}).done(function () {
                        $.pjax.reload({container: '#blogs_yacht'});
                    });
                }


            }




            event.preventDefault();
        });

    });


</script>