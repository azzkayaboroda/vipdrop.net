<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\ShopCase */

$this->title = "Вращение нескольких кейсов";

\yii\web\YiiAsset::register($this);

?>
<style>
    .roulete-row {
        height: 450px;
    }
</style>
<div id="test"></div>
<div id="many_case_container">
    <?php Pjax::begin(); ?>
    <main id="main">
        <div class="case_page_wrapper">
            <div class="container">
                <div class="case_contents_btn_block">
                    <a class="case_contents_btn" id="case_modal_ancor" href="#case_modal">СОДЕРЖИМОЕ</a>
                </div>
                <div class="row center row_cases">
                    <!--Дописывается класс one_element-->
                    <?php

                    $i = 1;
                    foreach ($cases as $case) :
                        $current_url = Yii::$app->request->url;
                        for ($i = 1; $i < 7; $i++) {
                            $current_url = str_replace("&case$i=$case->id", "", $current_url);
                        }
                        ?>
                    <div class="col-case-page case_in_roll" data-case_id="<?= $case->id ?>">
                        <div class="case_page_tpl">
                            <div class="case_page_image" style="background-image: url(/images/cases/<?= $case->template->image ?>);">
                                <img src="/images/cases/<?= $case->image ?>" alt="<?= $case->name ?>" class="some_image" />
                            </div>
                            <h4 class="case_page_title" data-text="<?= $case->name ?>"><?= $case->get_short_name() ?></h4>
                        </div>
                        <button class="case_page_tpl_close"><a href="<?= $current_url ?>"></a></button>
                    </div>
                    <?php
                        $i++;
                    endforeach; ?>
                </div>
                <div class="row center calculator_row">
                    <div class="calculator-col">
                        <div class="calc_logo vip"></div>
                        <div id="total_roll_summ" class="calc_price"><?= $total_summ ?></div>
                        <div class="calc_desc">*<?= count($cases) ?></div>
                    </div>
                    <div class="calculator-col-seporator"><img src="/img/bolshe.png" alt=""></div>
                    <div class="calculator-col">
                        <div class="calc_logo vip orange"></div>
                        <div id="total_roll_sale" class="calc_price"><?= $sale_value ?></div>
                        <div class="calc_desc">- <?= $case_procent->value ?>%</div>
                    </div>
                    <div class="calculator-col-seporator"><img src="/img/equally.png" alt=""></div>
                    <div class="calculator-col">
                        <div class="calc_logo bonus">B</div>
                        <div id="total_roll_bonus" class="calc_price"><?= $total_summ / 100 * $bonuses->value ?></div>
                        <div class="calc_desc">*<?= count($cases) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="quantity_strike_case">
            <div class="row center">
                <div class="qsc-col">
                    <div class="qsc-title">Всего выбито</div>
                    <div class="qsc-count red">499</div>
                </div>
                <div class="qsc-col">
                    <div class="qsc-title">Осталось выбить</div>
                    <div class="qsc-count blue">001</div>
                </div>
            </div>
        </div>
        <div class="amount_twisted_block">
            <input type="hidden" id="type_roll_cases" value="many">
            <div class="row center">
                <label class="amount_twisted_btn"><input class="amount_twisted_count" checked="checked" value="1" type="radio" name="amount_twisted"><span>1</span></label>
                <label class="amount_twisted_btn"><input class="amount_twisted_count" value="2" type="radio" name="amount_twisted"><span>2</span></label>
                <label class="amount_twisted_btn"><input class="amount_twisted_count" value="3" type="radio" name="amount_twisted"><span>3</span></label>
                <label class="amount_twisted_btn"><input class="amount_twisted_count" value="4" type="radio" name="amount_twisted"><span>4</span></label>
            </div>
            <? echo ($total_summ > Yii::$app->user->identity->balance) ? 'd-none' : ''; ?>
            <div <? echo ($total_summ > Yii::$app->user->identity->balance) ? 'style="display:block;"' : 'style="display:none;"'; ?> class="at_forward_block no"><a href="/user/view?id=<?= Yii::$app->user->identity->id; ?>" class="at_forward_btn"><span data-text="Нет денег">Нет денег</span></a></div>
            <div <? echo ($total_summ > Yii::$app->user->identity->balance) ? 'style="display:none;"' : 'style="display:block;"'; ?> class="at_forward_block yes"><a href="#roulette_case_modal" class="at_forward_btn"><span data-text="Вперед!">Вперед!</span></a></div>
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
                            <?php foreach ($cases as $case) {
                                $products = $case->case_products();
                                foreach ($products as $product) : ?>
                            <div class="case-modal-col">
                                <div class="graphic_element shadow-blue-n" data-bg="/images/cases/<?= $case->template->gun_shirt ?>"></div>
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
                            <?php endforeach;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="roulette_case_modal" class="modal" style="overflow-y: visible; height: auto;">
            <div class="modal-content">
                <a class="close-roulette_case_modal" rel="modal:close"></a>
                <div class="container">

                    <div class="owl-block-roulette">
                        <div class="owl-carousel case_headers">
                            <?php foreach ($cases as $case) { ?>
                            <div class="col-rcm six">
                                <div class="rcm_case">
                                    <img src="/images/cases/<?= $case->image ?>" alt="<?= $case->name ?>" class="some-image" style="background-image: url(/images/cases/<?= $case->template->image ?>);">
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="owl-block-roulette">
                        <div id="static_rombs">
                            <?php foreach ($cases as $case) { ?>
                            <div class="romb_row">
                                <div class="">
                                    <div class="rcm_tpl">
                                        <div class="rcm_tpl_img">
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="rcm_tpl">
                                        <div class="rcm_tpl_img">
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="rcm_tpl">
                                        <div class="rcm_tpl_img">
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="owl-carousel slick_roulette_case off_romb">
                            <?php foreach ($cases as $case) { ?>
                            <div class="col-rcm">
                                <div class="roulete-row">
                                    <div data-case_id="<?= $case->id ?>" class="roulete-col roulete-col-first">
                                        <?php $products = $case->case_products();
                                            foreach ($products as $key => $product) : ?>
                                        <div class="rcm_tpl" data-key="<?= $key; ?>" data-product-id="<?= $product->id; ?>">
                                            <div class="rcm_tpl_img">
                                                <img src="/images/<?= $product->photo ?>" class="some-image" alt=""><span></span>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <?php } ?>
                        </div>
                    </div>
                    <div id="roulette_counter" class="row center">
                        <?php foreach ($cases as $case) { ?>
                        <div class="col-rcm">
                            <div class="rcm_tpl_klv">
                                x4
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="embossed_cases">

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
    </main>
    <?php Pjax::end(); ?>
</div>