<?php 
    use yii\helpers\Html;
    use yii\helpers\HtmlPurifier;
?>

<div class="search_product_element">
    <div class="row">
        <div class="col-lg-1 v-center">
            <input type="checkbox" name="user_products_id[]" value="<?=$model->id?>">
        </div>
        <div class="col-lg-3 v-center">
            <img class="w-100" alt="" src="/images/<?=$model->photo?>" />
        </div>
        <div class="col-lg-4 v-center">
            <span><?=$model->name?></span>
        </div>
        <div class="col-lg-3 v-center">
            <input class="item_count" type="number" name ="user_products_count[]" value ="<?=$model->count?>" />
        </div>
    </div>
</div>