<?php

/* @var $this yii\web\View */

$this->title = 'VipDrop.net';
?>

<main id="main">
    <!--add class "select"-->
    <div class="case_block_play">
        <div class="cbp_container">
            <span class="cbp_start_text">Выбрать несколько</span>
            <div class="cbp_select">Выбранно:<span class="cbp_count">0</span></div>
        </div>
        <div class="cbp_btn_block">
            <button class="cbp_btn">GO!</button>
            <button class="cbp_close"><span></span></button>
        </div>

    </div>
    <div class="case_container">
        <?php foreach ($case_categorys as $category) : ?>
        <div class="case_block">
            <h2 class="title">
                <div class="fadeInDown animated wow"><span class="icon"><img src="/images/cases/<?= $category->image ?>" alt=""></span><?= $category->name ?>
                    <?php if ($category->is_vip) : ?>
                    <div class="vip_line">VIP line</div>
                    <?php endif; ?>
                </div>

            </h2>
            <div class="row row_case">
                <?php foreach ($category->cases as $case) :
                        $case_element = $case->first_product(); ?>
                <div class="col-case fadeIn animated wow" data-wow-delay="0.0s">
                    <div class="case_tpl <?= $case->color_light ?> case-item" data-id="<?= $case->id ?>" data-bg="/images/cases/<?= $case->template->shirt ?>">
                        <a href="/shop-case/view?id=<?= $case->id ?>"></a>
                        <div class="case_tpl_bg tr">
                            <div class="logo_case"><img src="/img/logo_from_case.png" /></div>
                            <div class="graphic_element" data-bg="/images/cases/<?= $case->template->image ?>">
                                <div class="light_effect none">
                                    <img src="/images/cases/<?= $case->image ?>" alt="" />
                                </div>
                            </div>
                            <div class="case_name_and_price">
                                <?php if ($category->is_vip) : ?>
                                <div class="case_star"><img src="/img/star.png" alt=""></div>
                                <?php endif; ?>
                                <h3 class="case_name white_before" data-text="<?= $case->name ?>">
                                    <span><?= $case->name ?></span>
                                </h3>
                                <div class="case_price"><?= $case->price ?> v.</div>
                            </div>
                        </div>
                        <div class="select_case">
                            <div class="plus_icon_block"><span class="plus_icon"></span></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</main>