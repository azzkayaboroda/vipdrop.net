<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ShopCaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FAQ';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="ru-RU">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <meta name="csrf-param" content="_csrf-frontend">
    <meta name="csrf-token" content="ZJu9Bg_Yb6qD86i4T5_Zgbqm7xv5A4uZSbo5m6VmOiMzxMo0dq9fm_Gs7P0azaG13tGGdLF71MAl6n_T0SRZRQ==">

    <link href="/css/modal.css" rel="stylesheet">
    <link href="/css/libs.min.css" rel="stylesheet">
    <link href="/css/app.css?v=11" rel="stylesheet">
    <link href="/css/jquery.slotmachine.min.css" rel="stylesheet">

    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
</head>

<body>
    <div id="app">

    <header id="header" class="faq">
        <div class="header_container">
            <div class="row">
                <div class="col-c">
                    <div class="logo">
                        <a href="/"> <img src="/img/logo_640.png" alt="" /> </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="golden_line"></div>
        <div class="text">
            <div class="text_inner">
                VipDrop.ru это новый взгляд на игровой процесс, сохранияя лучшие традиции.
                Роскошный дизайн, адекватные цены, реальность в получении призов, адаптация под все разрешения, быстрая поддержка по любому вопросу и это только начало!
            </div>
        </div>
    </header>

    <main id="main" class="faq_latest_stamped_items">
        <div id="latest_stamped_items" class="latest_stamped_items" style="padding-bottom: 20px;">   
        <div class="container">
            <div class="breadcrumbs-2">
                <div class="bread"><a href="#"><img src="../img/icon_house.png"/>НАЗАД</a></div>
                <div class="bread"><a href="/"><img src="../img/icon_gamepad.png"/>ИГРАТЬ</a></div>
            </div>
            
            <div class="faq_articles" data-masonry='{ "itemSelector": ".faq_articles_article", "columnWidth": 25 }'>
                <div class="faq_articles_article">
                    <div class="faq_articles_article-name">1. Вывод баланса.</div>
                    <div class="faq_articles_article-block">
                        <iframe src="https://www.youtube.com/embed/b3OFazOMRC8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <div class="faq_articles_article-description">
                            1. Отныне пользователь сам  решает что ему делать со своими призами. Вывод работает без коммисии на популярные кошельки и карты банков.
                            Единственное ограничение для новых пользователей, которые зарегестрированны в системе менее 3 месяцев - вывод будет работать спустя сутки после запроса определенной суммы. Вывод работает от 300р.
                            После 3-х месячного периода пользования сайтом, временная блокировка снимается.                                    
                        </div>
                    </div>
                </div>
                <div class="faq_articles_article">
                    <div class="faq_articles_article-name">2. Независимость от других сервисов</div>
                    <div class="faq_articles_article-block">
                            <iframe src="https://www.youtube.com/embed/b3OFazOMRC8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <div class="faq_articles_article-description">
                                2. VIPdrop не зависит от других сайтов,чужих ботов и резких изменений цен в steam analitiky.Вы не рискуете потерять разницу при каких либо изменениях в работе steam.                                    
                        </div>
                    </div> 
                </div>
                <div class="faq_articles_article">
                    <div class="faq_articles_article-name">3. Собственные боты</div>
                    <div class="faq_articles_article-block">
                        <iframe src="https://www.youtube.com/embed/b3OFazOMRC8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <div class="faq_articles_article-description">
                            3. С недавнего времени другие похожие проекты, которые потверглись блокировкам ботов, а так же блокировке предметов на 2 недели, перешли на систему "купил и отдал". Они пользуются чужими ботами от чего могут теряться предметы, не прийти обмен и разумеется, скорость приёма предметов значительно ниже. На нашем сайте работают собственные боты, которые не зависят от других сервисов. Моментальные выводы теперь доступны! Не надо ждать пока "сайту"продадут предмет, а он передаст его вам.                               
                        </div>
                    </div>
                </div>
                <div class="faq_articles_article">
                    <div class="faq_articles_article-name">4. Первый легальный на территории РФ</div>
                    <div class="faq_articles_article-block">
                            <iframe src="https://www.youtube.com/embed/b3OFazOMRC8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <div class="faq_articles_article-description">
                            4. Да! Вам не показалось, наш сайт работает полностью на законном уровне. ООО "Арт-Сайт игра. Вы можете видеть кто является владельцем, где находится офис компании и её отчётность                                 
                        </div>
                    </div>
                </div>
                <div class="faq_articles_article">
                    <div class="faq_articles_article-name">5. LVL система позволяющая перейти в VIP отдел</div>
                    <div class="faq_articles_article-block">
                        <iframe src="https://www.youtube.com/embed/b3OFazOMRC8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <div class="faq_articles_article-description">
                            5. LVL система позволяющая перейти в VIP отдел и не только.По достижению каждого нового уровня,пользователь будет получать награды в виде (бонус на баланс). Предмет в инвертарь сайта,а так же при достижении максимального LVL, то для пользователя будет открыт VIP отдел,со своими привелегиями,скидками и постоянными бонусами. Вас это приятно удивит.                                
                        </div>
                    </div>
                </div>
                <div class="faq_articles_article">
                    <div class="faq_articles_article-name">6. Bonus shop</div>
                    <div class="faq_articles_article-block">
                        <iframe src="https://www.youtube.com/embed/b3OFazOMRC8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <div class="faq_articles_article-description">
                            6.Bonus shop. Открывая кейсы на нашем сайте,вы накапливаете бонусы,которые в последствии можно обменять на реальные предметы,которые можно продать или вывести себе в инвертарь.                                   
                        </div>
                    </div>
                </div>
                <div class="faq_articles_article">
                    <div class="faq_articles_article-name">7. Прокрутка до 6 кейсов одновременно</div>
                    <div class="faq_articles_article-block">
                        <iframe src="https://www.youtube.com/embed/b3OFazOMRC8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <div class="faq_articles_article-description">
                            7. Да-да! Мы сделали прокрутку сразу до 6 любимых кейсов одновременно,при прокрутке от 2 и более кейсов так же предоставляется скидка + суммируется все бонусы. Пользуйтесь на здоровье!                                  
                        </div>
                    </div>
                </div>
            </div>

            <div class="breadcrumbs-2">
                <div class="bread"><a href="#"><img src="../img/icon_house.png"/>НАЗАД</a></div>
                <div class="bread"><a href="/"><img src="../img/icon_gamepad.png"/>ИГРАТЬ</a></div>
            </div>
        </div>
        </div>
    </main>

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
    <script src="/assets/dd9bfca7/jquery.js"></script>
    <script src="/assets/2a4d5e67/yii.js"></script>
    <script src="/js/slotmachine.min.js"></script>
    <script src="/js/jquery.slotmachine.min.js"></script>
    <script src="/js/libs.min.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>