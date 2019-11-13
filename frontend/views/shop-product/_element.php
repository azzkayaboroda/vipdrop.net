<div class="item-bshop">
                    <div class="item-bshop-tpl">
                        <div class="item-bshop-img">
                            <img src="/images/<?=$model->photo?>" alt="<?=$model->name?>" class="some-image">
                            <div class="item-bshop-price"><?=$model->price?></div>
                            <div class="item-bshop-logo">b</div>
                        </div>
                        <div class="item-bshop-info">
                            <div class="item-bshop-btn-block">
                                <button <?php
	                               if ($model->price > Yii::$app->user->identity->bonuses) echo '  disabled="disabled" ';
                                ?> data-weapon_id="<?=$model->id?>" type="button" data-price="<?=$model->price?>" class="item-bshop-btn buy_weapon">Купить</button>
                            </div>
                            <h2 class="item-bshop-title">
                                <?=$model->name?>
                            </h2>
                            <div class="item-bshop-type"><?=$model->type_name->name?></div>
                            <div class="row center">
                                <?php 
                                    $cases = $model->get_Cases();
                                    foreach ($cases as $case):
                                ?>
                                        <div class="col-item-bshop" style="background-image: url(/images/cases/<?= $case->template->image ?>); background-size: cover; background-position: center -3px; background-repeat: no-repeat;">
                                            <a href="/shop-case/view?id=<?=$case->id?>"> <img src="/images/cases/<?= $case->image ?>" alt="<?= $case->name ?>"/></a>
                                        </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
</div>