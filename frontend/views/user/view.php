<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<main id="main">
    <div class="user_wrapper">
        <div class="uw_container">
            <div class="name_user">
                <input type="text" value="<?= $model->username ?>" class="inp_name_user" disabled>
                <button data-uid="<?= $model->id ?>" class="name_user_btn"></button>
            </div>
            <div class="line"></div>
            <div class="edit_user_btn_block">
                <button class="edit_user_btn tr">Редактировать</button>
            </div>
            <div class="user_avatar change_avatar">
                <?php Pjax::begin(['id' => 'new_avatar']); ?>
                <div class="hidden_block">
                    <?php $form = ActiveForm::begin(['id' => 'user-form', 'options' => ['data-pjax' => true]]); ?>
                    <?= $form->field($model, 'file')->fileInput() ?>
                    <?php ActiveForm::end(); ?>    
                </div>                
                <a>
                    <?php if ($model->avatar) { ?>
                        <img src="/avatars/<?= $model->avatar ?>" alt="" class="some-image " />
                    <?php } else { ?>
                        <img src="/img/papa-rimskiy-big.jpg" alt="" class="some-image " />
                    <?php } ?>
                                       
                </a>
                 <?php Pjax::end(); ?>
            </div>
            <div class="user_bnts_row center row">
                <div class="user_bnts_col">
                    <button class="cool_btn btn-block tr">
                        <span data-text="ПОПОЛНИТЬ БАЛАНС">ПОПОЛНИТЬ БАЛАНС</span>
                    </button>
                </div>
                <div class="user_bnts_col">
                    <button class="cool_btn btn-block tr"><span data-text="ВЫВЕСТИ">ВЫВЕСТИ</span></button>
                </div>
                <div class="user_bnts_col">
                    <button class="cool_btn btn-block tr">
                        <a href="/" data-text="ПРОДОЛЖИТЬ ИГРАТЬ">ПРОДОЛЖИТЬ ИГРАТЬ</a>
                    </button>
                </div>
            </div>
            <div class="user_panel_info">
                <div class="row center">
                    <div class="col-upi-balance-bonus">
                        <div class="upi_balance">Баланс: <span><?= $model->balance ?></span></div>
                    </div>
                    <div class="col-upi-balance-bonus">
                        <div class="upi_bonus">Бонусы: <span><?= $model->bonuses ?></span></div>
                    </div>
                    <div class="col-upi-case">
                        <div class="upi_case">
                            <i class="d-mob-none">Кейсов</i> <i class="big_first_letter">прокручено:</i>
                            <span>7500р.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="trade_url_block">

                <input type="text" id="new_t_url" placeholder="Trade - URL" value="<?= $model->trade_url ?>" />
                <button id="turl_change" data-uid="<?= $model->id ?>" class="tr">Сохранить</button>

            </div>
        </div>
    </div>
    <div id="latest_stamped_items" class="latest_stamped_items">
    
        <div class="container">
            <h1 class="title"><span>Последние выбитые предметы</span></h1>
            <?php
                $start_month = 1;
                $end_month = date('m');
                $year = 2019;
                if (isset($_GET['fromDate'])) {
                  $start_date = explode('.', $_GET['fromDate']);  
                  $start_month = $start_date[1];
                  $year = $start_date[2];
                }
                if (isset($_GET['toDate'])) {
                  $start_date = explode('.', $_GET['toDate']);  
                  $end_month = $start_date[1];
                }
            ?>
            <div class="lsi_block_filter">
                <div class="date_filter_lsi row center">
                    <div class="col-year_filter_lsi">
                        <div class="cf_lsi_title">Год</div>
                        <button class="cf_lsi_btn"></button>
                        <div class="dropdodown_lsi_year">
                            <label>
                                <input type="radio" name="lsi_year" value="2019" <?php if ($year == 2019) echo 'checked="checked"'?>>
                                <span class="checkmark">2019</span>
                            </label>
                            <label>
                                <input type="radio" name="lsi_year" value="2018"  <?php if ($year == 2018) echo 'checked="checked"'?>>
                                <span class="checkmark">2018</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-month_filter_lsi">
                        <div class="row">
                            <div class="col-lsi-month col-lsi-month-before">
                                <div class="cf_lsi_title">От <div class="lsi_seporator"></div>
                                </div>
                                <button class="cf_lsi_btn"></button>
                                <div class="dropdodown_lsi_month">
                                
                                    <label>
                                        <input data-month="01" type="radio" name="lsi_month_before" value="Январь" <?php if ($start_month == 1) echo 'checked="checked"'?> />
                                        <span class="checkmark">Янв</span>
                                    </label>
                                    <label>
                                        <input data-month="02" type="radio" name="lsi_month_before" value="Февраль" <?php if ($start_month == 2) echo 'checked="checked"'?> >
                                        <span class="checkmark">Фев</span>
                                    </label>
                                    <label>
                                        <input data-month="03" type="radio" name="lsi_month_before" value="Март" <?php if ($start_month == 3) echo 'checked="checked"'?> >
                                        <span class="checkmark">Мар</span>
                                    </label>
                                    <label>
                                        <input data-month="04" type="radio" name="lsi_month_before" value="Апрель" <?php if ($start_month == 4) echo 'checked="checked"'?> >
                                        <span class="checkmark">Апр</span>
                                    </label>
                                    <label>
                                        <input data-month="05" type="radio" name="lsi_month_before" value="Май" <?php if ($start_month == 5) echo 'checked="checked"'?> >
                                        <span class="checkmark">Май</span>
                                    </label>
                                    <label>
                                        <input data-month="06" type="radio" name="lsi_month_before" value="Июнь" <?php if ($start_month == 6) echo 'checked="checked"'?> >
                                        <span class="checkmark">Июн</span>
                                    </label>
                                    <label>
                                        <input data-month="07" type="radio" name="lsi_month_before" value="Июль" <?php if ($start_month == 7) echo 'checked="checked"'?> >
                                        <span class="checkmark">Июл</span>
                                    </label>
                                    <label>
                                        <input data-month="08" type="radio" name="lsi_month_before" value="Август" <?php if ($start_month == 8) echo 'checked="checked"'?> >
                                        <span class="checkmark">Авг</span>
                                    </label>
                                    <label>
                                        <input data-month="09" type="radio" name="lsi_month_before" value="Сентябрь" <?php if ($start_month == 9) echo 'checked="checked"'?> >
                                        <span class="checkmark">Сен</span>
                                    </label>
                                    <label>
                                        <input data-month="10" type="radio" name="lsi_month_before" value="Октябрь" <?php if ($start_month == 10) echo 'checked="checked"'?> >
                                        <span class="checkmark">ОКТ</span>
                                    </label>
                                    <label>
                                        <input data-month="11" type="radio" name="lsi_month_before" value="Ноябрь" <?php if ($start_month == 11) echo 'checked="checked"'?> >
                                        <span class="checkmark">НОЯ</span>
                                    </label>
                                    <label>
                                        <input data-month="12" type="radio" name="lsi_month_before" value="Декабрь" <?php if ($start_month == 12) echo 'checked="checked"'?> >
                                        <span class="checkmark">ДЕК</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lsi-month col-lsi-month-after">
                                <div class="cf_lsi_title">До</div>
                                <button class="cf_lsi_btn"></button>
                                <div class="dropdodown_lsi_month">
                                    <label>
                                        <input data-month="01" type="radio" name="lsi_month_after" value="Январь" <?php if ($end_month == 1) echo 'checked="checked"'?> >
                                        <span class="checkmark">Янв</span>
                                    </label>
                                    <label>
                                        <input data-month="02" type="radio" name="lsi_month_after" value="Февраль" <?php if ($end_month == 2) echo 'checked="checked"'?> >
                                        <span class="checkmark">Фев</span>
                                    </label>
                                    <label>
                                        <input data-month="03" type="radio" name="lsi_month_after" value="Март" <?php if ($end_month == 3) echo 'checked="checked"'?> >
                                        <span class="checkmark">Мар</span>
                                    </label>
                                    <label>
                                        <input data-month="04" type="radio" name="lsi_month_after" value="Апрель" <?php if ($end_month == 4) echo 'checked="checked"'?> >
                                        <span class="checkmark">Апр</span>
                                    </label>
                                    <label>
                                        <input data-month="05" type="radio" name="lsi_month_after" value="Май" <?php if ($end_month == 5) echo 'checked="checked"'?> >
                                        <span class="checkmark">Май</span>
                                    </label>
                                    <label>
                                        <input data-month="06" type="radio" name="lsi_month_after" value="Июнь" <?php if ($end_month == 6) echo 'checked="checked"'?> >
                                        <span class="checkmark">Июн</span>
                                    </label>
                                    <label>
                                        <input data-month="07" type="radio" name="lsi_month_after" value="Июль" <?php if ($end_month == 7) echo 'checked="checked"'?> >
                                        <span class="checkmark">Июл</span>
                                    </label>
                                    <label>
                                        <input data-month="08" type="radio" name="lsi_month_after" value="Август" <?php if ($end_month == 8) echo 'checked="checked"'?> >
                                        <span class="checkmark">Авг</span>
                                    </label>
                                    <label>
                                        <input data-month="09" type="radio" name="lsi_month_after" value="Сентябрь" <?php if ($end_month == 9) echo 'checked="checked"'?> >
                                        <span class="checkmark">Сен</span>
                                    </label>
                                    <label>
                                        <input data-month="10" type="radio" name="lsi_month_after" value="Октябрь" <?php if ($end_month == 10) echo 'checked="checked"'?> >
                                        <span class="checkmark">ОКТ</span>
                                    </label>
                                    <label>
                                        <input data-month="11" type="radio" name="lsi_month_after" value="Ноябрь" <?php if ($end_month == 11) echo 'checked="checked"'?> >
                                        <span class="checkmark">НОЯ</span>
                                    </label>
                                    <label>
                                        <input data-month="12" type="radio" name="lsi_month_after" value="Декабрь" <?php if ($end_month == 12) echo 'checked="checked"'?> >
                                        <span class="checkmark">ДЕК</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row center lsi_filter_last">
                    <div class="lsi_filter_last_title">Показать последние:</div>
                    <div class="col_lsi_filter_last">
                        <label>
                            <input type="radio" name="lsi_filter_last" <?php if (isset($_GET['page_count'])) if ($_GET['page_count'] == 20) echo "checked='checked'"; ?>>
                            <a href="/user/view?id=<?= $model->id ?>&page_count=20#latest_stamped_slick" class="checkmark">20</a>
                        </label>
                    </div>
                    <div class="col_lsi_filter_last">
                        <label>
                            <input type="radio" name="lsi_filter_last" <?php if (isset($_GET['page_count'])) if ($_GET['page_count'] == 50) echo "checked='checked'"; ?>>
                            <a href="/user/view?id=<?= $model->id ?>&page_count=50#latest_stamped_slick" class="checkmark">50</a>
                        </label>
                    </div>
                    <div class="col_lsi_filter_last">
                        <label>
                            <input type="radio" name="lsi_filter_last" <?php if (isset($_GET['page_count'])) if ($_GET['page_count'] == 100) echo "checked='checked'"; ?>>
                            <a href="/user/view?id=<?= $model->id ?>&page_count=100#latest_stamped_slick" class="checkmark">100</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <?php Pjax::begin(['id' => 'last_weapons']); ?>
        <div id="latest_stamped_slick">
            <div class="lsi_row">
                <div class="container">

                    <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => [
                            'class' => 'lsi_row_tpl'
                        ],
                        //'summary'=>'',
                        'itemView' => '_element',
                        'itemOptions' => [
                            'tag' => false
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
        <?php Pjax::end(); ?>
    </div>
</main>