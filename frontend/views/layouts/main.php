<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\History;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <div id="app">
        <div id="shadow">
            <div id="user_dialog">
                <p class="dialog_text">передать предмет?</p>
                <p>
                    <button class="first_button"></button>
                    <button class="second_button"></button>
                </p>
            </div>
            <div id="alt_dialog">
                <p><button class="first_button"></button> <span>действительно продать?</span> <button data-product-id="0" data-history-id="0" class="second_button"></button></p>
            </div>
            <div id="sold_info">
                <p><button>продано за 1000v!</button></p>
            </div>
            <div id="buy_dialog">
                <p><button class="first_button"></button> <span>Подтвердите покупку</span> <button data-product-id="0" class="second_button"></button></p>
            </div>
            <div id="close_modal_dialog">
                 <p><button class="first_button"></button> <span>действительно выйти?</span> <button data-product-id="0" data-history-id="0" class="second_button"></button></p>           
            </div>
        </div>
        <div id="weapon-marquee">
            <?php
            $last_wins = History::Head_lenta();
            foreach ($last_wins as $record) : ?>
                <div class="wm-item">
                    <div class="wm-item-img"><img src="/images/<?= $record->product->photo ?>" alt="<?= $record->product->name ?>" class="some-image" /></div>
                    <div class="wm-block-down">
                        <div class="wm-shadow-blue"></div>
                        <div class="wm-shadow-black"></div>
                        <div class="wm-weapon-name"><span><?= $record->product->get_short_name() ?></span></div>
                        <div class="wm-case-name"><a href="/shop-case/view?id=<?= $record->case_id ?>" data-text="нейтрино"><?= $record->case->name ?></a></div>
                        <div class="wm-user">
                            <div class="wm-user-avatar">
                                <a href="#">
                                    <?php if ($record->user->avatar) { ?>
                                        <img src="/avatars/<?= $record->user->avatar ?>" alt="" class="some-image " />
                                    <?php } else { ?>
                                        <img src="/img/papa-rimskiy-big.jpg" alt="" class="some-image " />
                                    <?php } ?>
                                </a>
                            </div>
                            <div class="wm-user-name"><a href="#"><?= $record->user->username ?></a></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <header id="header">
            <div class="header_container">
                <div class="row">
                    <div class="col-lr">
                        <a href="/shop-product/index" class="btn btn-blue btn-blue-shadow">
                            <span data-text="BONUS SHOP">BONUS SHOP</span>
                        </a>
                        <div class="case_info">
                            <ul>
                                <li><span>Кейсов выбито:</span> <i>0 р.</i></li>
                                <?php
                                ?>
                                <li><span class="vip_cab">VIP-КАБИНЕТ <img alt="" src="/img/white_star.png" /></span> <i style="color: #FDCCFF;">Недоступен</i></li>
                                <?php
                                ?>
                            </ul>
                        </div>
                        <div class="social">
                            <ul>
                                <li><a href="#" class="vk"></a></li>
                                <li><a href="#" class="ytb"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-c">
                        <div class="logo">
                            <a href="/"> <img src="/img/logo_640.png" alt="" /> </a>
                        </div>
                    </div>
                    <div class="col-lr">
                        <?php if (Yii::$app->user->isGuest) { ?>
                            <?php echo \nodge\eauth\Widget::widget(['action' => 'site/login']); ?>
                        <?php } else { ?>
                            <a href="/user/view?id=<?= Yii::$app->user->identity->id ?>" class="btn btn-gray blue-black-shadow">
                                <span data-text="АВТОРИЗОВАТЬСЯ">Личный кабинет</span>
                            </a>
                        <?php } ?>
                        <div class="user-name"><?php
                                                if (Yii::$app->user->isGuest) echo "No Name";
                                                else echo Yii::$app->user->identity->username;
                                                ?></div>
                        <div class="user_info">
                            <ul>
                                <li><span>Баланс:</span> <i id="user-balans"><?php
                                                                                if (Yii::$app->user->isGuest) echo "0";
                                                                                else echo substr(Yii::$app->user->identity->balance, 0, 8);
                                                                                ?> </i> <i class="money-icon"></i></li>
                                <li><span>Бонусы:</span> <i id="user-bonus"><?php
                                                                            if (Yii::$app->user->isGuest) echo "0";
                                                                            else echo Yii::$app->user->identity->bonuses;
                                                                            ?></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>


        <?= Alert::widget() ?>
        <?= $content ?>

        <footer id="footer">
            <div class="footer_nav">
                <ul>
                    <li><a href="/pages/view?id=2">ПРАВОВАЯ ИНФОРМАЦИЯ</a></li>
                    <li><a href="/faq">FAQ</a></li>
                </ul>
            </div>
            <div class="footer_block">
                <div class="footer_logo">
                    <a href="/"><img src="/img/footer_logo.png" alt="VIPDROP.NET" /></a>
                </div>
            </div>
        </footer>

    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>