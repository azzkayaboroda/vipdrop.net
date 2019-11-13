<?php 
    use yii\helpers\Html;
    use yii\helpers\HtmlPurifier;
?>

<div class="search_product_element">
    <div class="row">
        <div class="col-lg-1 v-center">
            <input type="checkbox" <?php
               if ($model_products) if (in_array($model->id, $model_products)) echo " checked='checked' ";
            ?> name="products_case[]" value="<?=$model->id?>">
        </div>
        <div class="col-lg-1 v-center">
            <img class="w-100" alt="" src="/images/<?=$model->photo?>" />
        </div>
        <div class="col-lg-7 v-center">
            <span><?=$model->name?></span>
        </div>
    </div>
</div>