<script>
    var apiGoogleKey = '<?= Yii::$app->params['apiGoogleKey'] ?>';
    var zoom = <?= $model->zoom ?>;
    var lat = <?= $model->location_lat ?>;
    var lng = <?= $model->location_lng ?>;
    var weather = <?= !empty($weather) ? 1 : 0 ?>;


</script>
<script src="/js/google_map_local_info.js"></script>
<section class="local-page_map">


    <div style="width: 100%; height: 510px; position: absolute;clear: both;" class="map-canvas off" id="js-map-canvas"></div>
    <button class="go-down-btn second" id="go-down">
        <i class="fa fa-chevron-down"></i>
    </button>
    <?php if (!empty($model->image_id) && empty($map_false)) { ?>
        <div class="photo-flag">
            <img src="<?= $model->image->imageUrl ?>" class="local-image" alt="">
        </div>
    <?php } ?>
</section>