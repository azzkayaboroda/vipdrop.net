<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ShopCase */

$this->title = $model->name;
//$this->params['breadcrumbs'][] = ['label' => 'Shop Cases', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<main id="main">
    <div class="case_page_wrapper">
        <div class="container">
            <div class="case_contents_btn_block">
                <a class="case_contents_btn" id="case_modal_ancor" href="#case_modal">СОДЕРЖИМОЕ</a>
            </div>
            <div class="row center row_cases">
                <!--Дописывается класс one_element-->
                <div class="col-case-page one_element">
                    <div class="case_page_tpl">
                        <div class="case_page_image" style="background-image: url(/images/cases/<?= $model->template->image ?>);">
                            <img src="/images/cases/<?= $model->image ?>" alt="<?= $model->name ?>" class="some_image">
                        </div>
                        <h4 class="case_page_title" data-text="<?= $model->name ?>"><?= $model->get_short_name() ?></h4>
                    </div>
                </div>
            </div>
            <div class="row center calculator_row">
                <div class="calculator-col">
                    <div class="calc_logo vip"></div>
                    <div id="roll-price" class="calc_price"><?= $model->price ?></div>
                </div>
                <div class="calculator-col-seporator"><img src="/img/equally.png" alt=""></div>
                <div class="calculator-col">
                    <div class="calc_logo bonus">B</div>
                    <div id="roll-bonus" class="calc_price"><?= $model->price / 100 * $bonuses->value ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="quantity_strike_case">
        <div class="row center">
            <div class="qsc-col">
                <div class="qsc-title">Всего выбито</div>
                <div id="was-roll" class="qsc-count red">400</div>
            </div>
            <div class="qsc-col">
                <div class="qsc-title">Осталось выбить</div>
                <div id="end-roll" class="qsc-count blue">100</div>
            </div>
        </div>
    </div>
    <div class="amount_twisted_block">
        <div class="row center">
            <label class="amount_twisted_btn"><input data-case-id="<?= $model->id ?>" class="amount_twisted_count" type="radio" checked="checked" name="amount_twisted" value="1"><span>1</span></label>
            <label class="amount_twisted_btn"><input data-case-id="<?= $model->id ?>" class="amount_twisted_count" type="radio" name="amount_twisted" value="2"><span>2</span></label>
            <label class="amount_twisted_btn"><input data-case-id="<?= $model->id ?>" class="amount_twisted_count" type="radio" name="amount_twisted" value="3"><span>3</span></label>
            <label class="amount_twisted_btn"><input data-case-id="<?= $model->id ?>" class="amount_twisted_count" type="radio" name="amount_twisted" value="4"><span>4</span></label>
        </div>
        <? echo ($model->price > Yii::$app->user->identity->balance) ? 'd-none' : ''; ?>
        <div <? echo ($model->price > Yii::$app->user->identity->balance) ? 'style="display:block;"' : 'style="display:none;"'; ?> class="at_forward_block no"><a href="/user/view?id=<?= Yii::$app->user->identity->id; ?>" class="at_forward_btn"><span data-text="Нет денег">Нет денег</span></a></div>
        <div <? echo ($model->price > Yii::$app->user->identity->balance) ? 'style="display:none;"' : 'style="display:block;"'; ?> class="at_forward_block yes"><a href="#roulette_case_modal" class="at_forward_btn"><span data-text="Вперед!">Вперед!</span></a></div>
    </div>



    <div id="case_modal" class="modal">
        <div class="modal-content">
            <a class="close-case_modal modal_close_full" rel="modal:close"></a>
            <div class="container">
                <a class="close-case_modal modal_close" rel="modal:close">
                    <span></span>
                </a>
                <div class="container_modal_case">
                    <div class="row case-modal-row">
                        <?php foreach ($all_products as $product) : ?>
                        <div class="case-modal-col">
                            <div class="graphic_element shadow-blue-n" data-bg="/images/cases/<?= $model->template->gun_shirt ?>"></div>
                            <div class="cmc_content">
                                <div class="cm_logo"><img src="/img/logo_from_case.png" alt=""></div>
                                <div class="case-modal-img">
                                    <img src="/images/<?= $product->photo ?>" alt="<?= $product->name ?>" class="some-image" />
                                </div>
                                <div class="case-modal-name row center"><span><?= $product->get_short_name() ?></span>
                                </div>
                                <div class="case-modal-desc row center"><span><?php if (isset($product->type)) echo $product->type_name->name; ?></span></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="roulette_case_modal" class="modal">
        <div class="modal-content">
            <a class="close-roulette_case_modal" rel="modal:close"></a>
            <div class="container">
                <div class="owl-block-roulette">
                    <div id="static_rombs_v2">
                    </div>
                    <div class="">
                        <div class="col-rcm slotMachine roulete-col roulete-col-first">
                            <?php foreach ($all_products as $key => $product) : ?>
                            <div class="rcm_tpl" data-key="<?= $key; ?>" data-product-id="<?= $product->id; ?>">
                                <div class="rcm_tpl_img">
                                    <img src="/images/<?= $product->photo ?>" class="some-image" alt=""><span></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="owl-carousel slick_roulette_case off_romb">

                        </div>
                    </div>

                    <div class="row center rcm-row-down">
                        <div class="rcm-down-col">
                            <div class="rcm-down-block-btn">
                                <!--у кнопки есть оформленный disabled-->
                                <button id="start-roll" data-text="Крутить">Крутить</button>
                            </div>
                            <a class="close-roulette_case_modal">Закрыть</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>