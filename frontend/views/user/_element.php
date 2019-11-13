<div class="item_lsi <?=($model->product->vip ? "vip" : "")?>">
    <div class="item_lsi_img">
        <img src="/images/<?=$model->product->photo?>" alt="" class="some-image" />
    </div>
    <div class="lsi_title"><?=$model->product->get_short_name()?></div>
    <div class="item_lsi_price">
        <?=$model->product->price?> V
    </div>
    <div class="lsi_btn">
        <button data-product-id="<?=$model->product_id?>" data-history-id="<?=$model->id?>" class="btn_sell tr product-sell-btn"></button><button data-product-id="<?=$model->product_id?>" data-history-id="<?=$model->id?>" class="product-send-btn btn_steam tr"></button>
    </div>
    <div class="lsi_date"><?=date('d.m.Y', $model->created_at)?></div>
</div>