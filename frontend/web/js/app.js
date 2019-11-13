objectFitImages('img.some-image');
new WOW().init();

$('#weapon-marquee').slick({
    infinite: true,
    autoplay: 5000,
    variableWidth: true,
    arrows: false,
    draggable: false,
});

// $('#latest_stamped_slick').slick({
// 	infinite: true,
// 	autoplay: 5000,
// 	slidesToShow: 8,
// 	slidesToScroll: 8,
// 	responsive: [
// 		{
// 			breakpoint: 1200,
// 			settings: {
// 				slidesToShow: 5,
// 				slidesToScroll: 5
// 			},
// 		},
// 		{
// 			breakpoint: 992,
// 			settings: {
// 				slidesToShow: 3,
// 				slidesToScroll: 3
// 			},
// 		},
// 		{
// 			breakpoint: 480,
// 			settings: {
// 				slidesToShow: 2,
// 				slidesToScroll: 2
// 			},
// 		},
// 	],
// });

var list = document.getElementsByClassName('case_tpl');
for (var i = 0; i < list.length; i++) {
    var src = list[i].getAttribute('data-bg');
    list[i].style.backgroundImage = "url('" + src + "')";
}

var list_g = document.getElementsByClassName('graphic_element');
for (var i = 0; i < list_g.length; i++) {
    var src = list_g[i].getAttribute('data-bg');
    list_g[i].style.backgroundImage = "url('" + src + "')";
}

document.addEventListener('DOMContentLoaded', function() {
    //The first argument are the elements to which the plugin shall be initialized
    //The second argument has to be at least a empty object or a object with your desired options
    OverlayScrollbars(document.querySelectorAll('.container_modal_case'), {
        overflowBehavior: {
            x: 'hidden',
            y: 'scroll',
        },
    });
});

var elementRcm = $('.col-rcm').length;
if (elementRcm > 1 && elementRcm < 4) {
    $('.col-rcm').addClass('three');
    $('.col-rcm_case').addClass('three');
    $('.roulette_case_row').removeClass('row');
} else if (elementRcm > 3) {
    $('.col-rcm').addClass('six');
    $('.col-rcm_case').addClass('six');
}

var owl = $('.slick_roulette_case');
owl.owlCarousel({
    margin: 0,
    nav: true,
    loop: false,
    autoWidth: true,
    responsive: {
        0: {
            items: 1,
        },
        479: {
            items: 1,
        },
        480: {
            items: 2,
        },
        790: {
            items: 3,
        },
        1306: {
            items: 3,
        },
        1900: {
            items: 6,
        },
    },
}).on('dragged.owl.carousel', function(event) {
    if (event.relatedTarget.direction == 'left') {
        owl2.trigger('next.owl.carousel')
    } else {
        owl2.trigger('prev.owl.carousel')
    }
});


var owl2 = $('.case_headers');
owl2.owlCarousel({
    margin: 0,
    //nav: true,
    loop: false,
    //center: true,
    autoWidth: true,
    responsive: {
        0: {
            items: 1,
        },
        479: {
            items: 1,
        },
        480: {
            items: 2,
        },
        790: {
            items: 3,
        },
        1306: {
            items: 3,
        },
        1900: {
            items: 6,
        },
    },
}).on('dragged.owl.carousel', function(event) {
    if (event.relatedTarget.direction == 'left') {
        owl.trigger('next.owl.carousel')
    } else {
        owl.trigger('prev.owl.carousel')
    }
});

// Sync nav
owl.on('click', '.owl-next', function() {
    owl2.trigger('next.owl.carousel')
});
owl.on('click', '.owl-prev', function() {
    owl2.trigger('prev.owl.carousel')
});

//вся ифна о модальном окне https://jquerymodal.com/
$('a[href="#case_modal"]').on('click', function(event) {
    event.preventDefault();
    $(this).modal({
        fadeDuration: 250,
    });
});
$('a[href="#roulette_case_modal"]').on('click', function(event) {
    event.preventDefault();
    $(this).modal({
        fadeDuration: 250,
    });
});

// var lsi_count = 1;
// var lsi_length = $('.item_lsi').length;
// $('.item_lsi').each(function () {
// 	var remainder = lsi_count % 8;
// 	if (remainder == 0 && lsi_count != lsi_length) {
// 		$(this).after('</div></div></div>');
// 		$(this).after('<div class="lsi_row"><div class="container"><div class="lsi_row_tpl">');
// 	}
// 	lsi_count++;
// });

$('.edit_user_btn').click(function() {
    $('.inp_name_user').prop('disabled', false);
});
$('.name_user_btn').click(function() {
    $('.inp_name_user').prop('disabled', true);
});
$('.col-year_filter_lsi .cf_lsi_btn').click(function() {
    $('.col-lsi-month').removeClass('active');
    $(this)
        .parent()
        .toggleClass('active');
});
$('.col-lsi-month-after .cf_lsi_btn').click(function() {
    $('.col-year_filter_lsi').removeClass('active');
    $('.col-lsi-month-before').removeClass('active');
    $(this)
        .parent()
        .toggleClass('active');
});
$('.col-lsi-month-before .cf_lsi_btn').click(function() {
    $('.col-year_filter_lsi').removeClass('active');
    $('.col-lsi-month-after').removeClass('active');
    $(this)
        .parent()
        .toggleClass('active');
});

function updateURLParameter(url, param, paramVal) {
    var TheAnchor = null;
    var newAdditionalURL = '';
    var tempArray = url.split('?');
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = '';

    if (additionalURL) {
        var tmpAnchor = additionalURL.split('#');
        var TheParams = tmpAnchor[0];
        TheAnchor = tmpAnchor[1];
        if (TheAnchor) additionalURL = TheParams;
        tempArray = additionalURL.split('&');

        for (var i = 0; i < tempArray.length; i++) {
            if (tempArray[i].split('=')[0] != param) {
                newAdditionalURL += temp + tempArray[i];
                temp = '&';
            }
        }
    } else {
        var tmpAnchor = baseURL.split('#');
        var TheParams = tmpAnchor[0];
        TheAnchor = tmpAnchor[1];
        if (TheParams) baseURL = TheParams;
    }

    if (TheAnchor) paramVal += '#' + TheAnchor;
    var rows_txt = temp + '' + param + '=' + paramVal;
    return baseURL + '?' + newAdditionalURL + rows_txt;
}

function dateRedirect() {
    var year = $('.dropdodown_lsi_year input:checked').val();
    var monthFrom = $('.col-lsi-month-before input:checked').data('month');
    var monthTo = $('.col-lsi-month-after input:checked').data('month');
    var fromStr = '01.' + monthFrom + '.' + year;
    var toStr = '30.' + monthTo + '.' + year;
    var url = updateURLParameter(document.location.href.replace(location.hash, ''), 'fromDate', fromStr);
    var secondUrl = updateURLParameter(url, 'toDate', toStr);
    var page_count = getAllUrlParams().page_count;
    if (page_count) secondUrl + "&page_count=" + page_count;
    //document.location.href = secondUrl + '#latest_stamped_items';
    return secondUrl + '#latest_stamped_items';
}

$('.dropdodown_lsi_year input, .col-lsi-month-before input, .col-lsi-month-after input').change(function() {
    //dateRedirect();
    $.pjax.reload({
        url: dateRedirect(),
        container: "#last_weapons",
        async: false
    });
    $('html, body').animate({
            scrollTop: $('#last_weapons').offset().top - 80
        },
        1500); // анимируем скроолинг к элементу scroll_e
});

$('.dropdodown_lsi_year label').click(function() {
    var dval = $(this)
        .find('input')
        .val();
    $(this)
        .parents('.col-year_filter_lsi')
        .find('.cf_lsi_btn')
        .text(dval);
    $(this)
        .parents('.col-year_filter_lsi')
        .removeClass('active');
});

// if ($('.dropdodown_lsi_year label input').is(':checked')) {
// 	var cval = $(this).val();
// 	$('.cf_lsi_btn').html(cval);
// 	console.log('sdfsdf');
// };
$('.dropdodown_lsi_year label input').each(function() {
    if ($(this).is(':checked')) {
        var cval = $(this).val();
        $(this)
            .parents('.col-year_filter_lsi')
            .find('.cf_lsi_btn')
            .html(cval);
    }
});

$('.dropdodown_lsi_month label').click(function() {
    var dval = $(this)
        .find('input')
        .val();
    $(this)
        .parents('.col-lsi-month')
        .find('.cf_lsi_btn')
        .text(dval);
    $(this)
        .parents('.col-lsi-month')
        .removeClass('active');
});
$('.dropdodown_lsi_month label input').each(function() {
    if ($(this).is(':checked')) {
        var cval = $(this).val();
        $(this)
            .parents('.col-lsi-month')
            .find('.cf_lsi_btn')
            .html(cval);
    }
});

$('.name_user_btn').click(function() {
    var username = $('.inp_name_user').val(),
        uid = $(this).data('uid');
    $.ajax({
        url: '/user/update?id=' + uid + '&new_name=' + username,
        type: 'GET',
        success: function(data) {
            console.log(data);
        },
    });
});

$('#turl_change').click(function() {
    var url = $('#new_t_url').val(),
        uid = $(this).data('uid');
    $.ajax({
        url: '/user/update?id=' + uid + '&t_url=' + url,
        type: 'GET',
        success: function(data) {
            console.log(data);
        },
    });
});

$('#user-file').change(function(e) {
    $('#user-form').submit();
});

$('.change_avatar a').click(function() {
    $('#user-file').click();
});

$('.cbp_btn').on('click', function() {

    var selectedArray = [];
    $(this)
        .parent()
        .addClass('select');

    $('body').addClass('select-multiple');
    $('.case-item').each(function(index) {
        $(this).addClass('select');
    });
    //$('.cbp_start_text').toggle(); // CHANGED 250619
    $('.cbp_start_text').hide();
    //$('.cbp_select').toggle(); // CHANGED 250619
    $('.cbp_select').show();
    $('.case-item.select').on('click', function() {
        if ($(this).hasClass('stop_select')) {
            return false;
        }
        var productId = $(this).data('id');

        if (
            $(this)
            .find('.select_case')
            .hasClass('select')
        ) {
            for (var i = 0; i < selectedArray.length; i++) {
                if (selectedArray[i] === productId) {
                    selectedArray.splice(i, 1);
                }
            }
            $(this)
                .find('.select_case')
                .removeClass('select');
        } else {
            selectedArray.push(productId);
            //console.log(selectedArray);
            $(this)
                .find('.select_case')
                .addClass('select');
        }
        console.log(selectedArray.length);
        $('.cbp_count').text(selectedArray.length);
        //максимальное количество выбора кейсов
        // if (selectedArray.length == 6) {
        if (selectedArray.length == 3) {
            $('.case-item').each(function(index) {
                if (!$(this)
                    .find('.select_case')
                    .hasClass('select')
                ) {
                    $(this).removeClass('select');
                    $(this).addClass('stop_select');
                }
            });
        } else {
            $('.case-item').each(function(index) {
                $(this).removeClass('stop_select select');
                $(this).addClass('select');
            });
        }
    });
    // Переход на вращение нескольких кейсов----
    if ($(this).hasClass("go")) {
        //console.log(selectedArray);
        var case_index = "",
            i = 1;
        $('.case-item.select').each(function(index) {
            if (
                $(this)
                .find('.select_case')
                .hasClass('select')
            ) {
                var productId = $(this).data('id');
                case_index += "&case" + i + "=" + productId;
                i++;
            }
        });
        //console.log(case_index);
        if (case_index != "") document.location.href = "/shop-case/many_view?" + case_index;
    } else {
        $(this).addClass('go');
    }
    //==========================================
});
$('.cbp_close').on('click', function() {
    $(this)
        .parent()
        .removeClass('select');
    $('.cbp_btn').removeClass('go');
    $('body').removeClass('select-multiple');
    $('.case-item').each(function(index) {
        $(this).removeClass('select');
        $(this).removeClass('stop_select');
        $(this)
            .find('.select_case')
            .removeClass('select');
    });
    $('.cbp_count').text(0);
    //$('.cbp_start_text').toggle(); // CHANGED 250619
    $('.cbp_start_text').show();
    //$('.cbp_select').toggle(); // CHANGED 250619
    $('.cbp_select').hide();

    $('.case-item').unbind();
});

// При переключении инпутов количества прокруток, отправляем запрос на сервер
// что бы получить итоговую цену и количество начисленных бонусов,
// после чего пишем их в дивы
// Так же скрываем кнопку крутилки если баланс не позволяет
if ($('.amount_twisted_count')) {
    $('.amount_twisted_count').change(function() {
        twistedCount = $('.amount_twisted_count:checked').val();
        var caseId = $('.amount_twisted_count:checked').data('case-id');
        var type_roll = $('#type_roll_cases').val(),
            case_array = [];

        if (type_roll == "many") {
            $(".case_in_roll").each(function(index, el) {
                var case_id = $(el).data('case_id');
                case_array.push(case_id);
            });
            $.ajax({
                url: '/shop-case/calc_many_price',
                type: 'POST',
                data: {
                    count: twistedCount,
                    cases: case_array
                },
                success: function(data) {
                    $('#total_roll_summ').html(data.total_price);
                    $('#total_roll_bonus').html(data.total_bonuses);
                    $('#total_roll_sale').html(data.total_sale);
                    if (data.status === false) {
                        $('.at_forward_block.yes').hide();
                        $('.at_forward_block.no').show();
                    } else {
                        $('.at_forward_block.no').hide();
                        $('.at_forward_block.yes').show();
                    }
                },
            });

        } else {
            $.ajax({
                url: '/shop-case/calc_price?id=' + caseId,
                type: 'POST',
                data: {
                    count: twistedCount,
                },
                success: function(data) {
                    $('#roll-price').html(data.total_price);
                    $('#roll-bonus').html(data.total_bonuses);
                    if (data.status === false) {
                        $('.at_forward_block.yes').hide();
                        $('.at_forward_block.no').show();
                    } else {
                        $('.at_forward_block.no').hide();
                        $('.at_forward_block.yes').show();
                    }
                },
            });
        }
    });
}

function sell_confirm(product_id, history_id) {
    console.log(product_id + " " + history_id);
    $('#shadow').toggle();
    $('#alt_dialog').toggle();
    $('#alt_dialog .second_button').attr("data-product-id", product_id);
    $('#alt_dialog .second_button').attr("data-history-id", history_id);
}

function trade_confirm(product_id, history_id) {
    console.log(product_id + " " + history_id);
    $('#shadow').toggle();
    $('#user_dialog').toggle();
    $('#user_dialog .second_button').attr("data-product-id", product_id);
    $('#user_dialog .second_button').attr("data-history-id", history_id);
}

// При клике на кнопку вызывается этот метод который отправляет звпрос на сервер о продаже товара
function sellProduct() {
    var btn = $(this);
    var productId = btn.data('product-id');
    var historyId = btn.data('history-id');
    sell_confirm(productId, historyId);

    /*if (confirm('Вы действительно хотите продать предмет?')) {

        $.ajax({
            url: '/shop-product/sell_product?id=' + productId,
            type: 'POST',
            data: {
                history_id: historyId,
            },
            success: function(data) {
                if (data.status === true) {
                    var price = parseInt(data.price);
                    var userBalans = parseInt($('#user-balans').html());
                    $('#user-balans').html(userBalans + price);
                    if (btn.hasClass('product-sell-btn')) {
                        btn.closest('.item_lsi').animate({
                                opacity: 0,
                            },
                            1000,
                            function() {
                                btn.closest('.item_lsi').remove();
                            }
                        );
                    } else {
                        btn.remove();
                        alert('Предмет продан за ' + price + 'V');
                    }
                }
            },
        });
    }*/
}

$('#alt_dialog .second_button').click(function() {
    var btn = $(this);
    var productId = btn.attr('data-product-id');
    var historyId = btn.attr('data-history-id');
    $(this).attr('data-history-id', "0");
    //sell_confirm(productId, historyId);
    console.log("send data id:" + productId + " history:" + historyId)
    $.ajax({
        url: '/shop-product/sell_product?id=' + productId,
        type: 'POST',
        data: {
            history_id: historyId,
        },
        success: function(data) {
            if (data.status === true) {
                $('#alt_dialog').fadeOut("slow");
                var price = parseInt(data.price);
                var userBalans = parseInt($('#user-balans').html());
                $('#user-balans').html(userBalans + price);
                if ($('*[data-history-id="' + historyId + '"]').hasClass('product-sell-btn')) {
                    $('*[data-history-id="' + historyId + '"]').closest('.item_lsi').animate({
                            opacity: 0,
                        },
                        1000,
                        function() {
                            $('*[data-history-id="' + historyId + '"]').closest('.item_lsi').remove();
                        }
                    );
                    $('#sold_info button').html('Продано за ' + price + 'V!');
                    $('#sold_info').fadeIn("slow");
                } else {
                    $('*[data-history-id="' + historyId + '"]').closest('.win').addClass("sell_confirm");
                    $('button[data-history-id="' + historyId + '"]').parent().addClass("delAfter");
                    $('*[data-history-id="' + historyId + '"]').remove();
                    $('#sold_info button').html('Продано за ' + price + 'V!');
                    $('#sold_info').fadeIn("slow");
                    //alert('Предмет продан за ' + price + 'V');
                }
            }
        },
    });
});

$('#user_dialog .second_button').click(function() {
    var btn = $(this);
    var productId = btn.data('product-id');
    var historyId = btn.data('history-id');

    $.ajax({
        url: '/shop-product/send_product?id=' + productId,
        type: 'POST',
        data: {
            history_id: historyId,
        },
        success: function(data) {
            if (data.status === true) {
                window.open(data.offer_url, 'Передача предмета', 'width=600,height=400');
                location.reload();
                $('*[data-history-id="' + historyId + '"]').closest('.item_lsi').animate({
                        opacity: 0,
                    },
                    1000,
                    function() {
                        $('*[data-history-id="' + historyId + '"]').closest('.item_lsi').remove();
                    }
                );
            }
        },
    });
});

$('#sold_info button').click(function() {
    $('#sold_info').fadeOut("slow");
    $('#shadow').fadeOut("slow");
});

$('#alt_dialog .first_button').click(function() {
    $('#alt_dialog').fadeOut("slow");
    $('#shadow').fadeOut("slow");
});


$('#user_dialog .first_button').click(function() {
    $('#user_dialog').fadeOut("slow");
    $('#shadow').fadeOut("slow");
});


$('.product-send-btn').on('click', function() {
    var btn = $(this);
    var productId = btn.data('product-id');
    var historyId = btn.data('history-id');
    trade_confirm(productId, historyId);
    /*if (confirm('Вы действительно хотите передать предмет себе?')) {
        $.ajax({
            url: '/shop-product/send_product?id=' + productId,
            type: 'POST',
            data: {
                history_id: historyId,
            },
            success: function(data) {
                if (data.status === true) {
                    window.open(data.offer_url, 'Передача предмета', 'width=600,height=400');
                    btn.closest('.item_lsi').animate({
                            opacity: 0,
                        },
                        1000,
                        function() {
                            btn.closest('.item_lsi').remove();
                        }
                    );
                }
            },
        });
    }*/
});

// В личном кабинете пользователя на кнопку продажи так же вешаем событие
$('.product-sell-btn').on('click', sellProduct);

// Скрипт прокрутки
function fckngRoll() {
    var caseId = $('.amount_twisted_count:checked').data('case-id');
    var twistedCount = $('.amount_twisted_count:checked').val();
    // Уничтожаем ненужные элементы крутилки если уже крутили и создаем новые что бы сбросить события прокрутки от скрипта с анимацией
    if ($('#start-roll').hasClass('roll-again')) {
        $('#start-roll').removeClass('roll-again');
        for (var i=0; i<$('.owl-item').length; i++) {
            owl.trigger('remove.owl.carousel', [i])
                                      .trigger('refresh.owl.carousel');
         }
        owl.trigger('destroy.owl.carousel');
        owl.find('.owl-stage-outer').children().empty();
        owl.find('.owl-stage-outer').children().unwrap();
    
        owl.removeClass("owl-center owl-loaded owl-text-select-on");
        for (let i = 0; i < twistedCount; i++) {
            $('.roulete-col-first')
                .clone()
                .removeClass('d-none')
                .removeClass('roulete-col-first')
                .appendTo('.slick_roulette_case');
        }

        owl.owlCarousel({
            //margin: 0,
            nav: true,
            loop: false,
            //  center:true,
            // navContainer:".slick_roulette_case",
            autoWidth: true,
            responsive: {
                0: {
                    items: 1,
                    center: true,
                },
                479: {
                    items: 1,
                    center: true,
                },
                480: {
                    items: 2,
                    //center: true,
                },
                790: {
                    items: 3,
                },
                1306: {
                    items: 3,
                },
                1900: {
                    items: 6,
                },
            },
        });
        $('.roulete-col-first').addClass('d-none');
    }
    // Отключаем кнопку при начале кручения
    $('#start-roll').attr('disabled', true);

    // Делаем запрос на сервер что бы получить выигрышные айдишники товаров
    $.ajax({
        url: '/shop-case/roll_single?id=' + caseId,
        type: 'POST',
        data: {
            count: twistedCount,
        },
        success: function(data) {
            // Если всё норм
            if (data.status == 'good') {
                // перебираем каждую крутилку и инициализируем на ней алгоритм кручения
                $('.roulete-col:not(.roulete-col-first)').each(function(index, element) {
                    var winId = data['roll_' + index];
                    var historyId = data['history_' + index + '_id'];
                    var winKey = $('*[data-product-id="' + winId + '"]').data('key');
                    winKey = parseInt(winKey);
                    // Инициализирвем алгоритм крутилки и задаем параметры, randomize отвечает за выигрышный.
                    var machine = new SlotMachine(element, {
                        active: 1,
                        delay: 500,
                        randomize: function() {
                            return winKey - 1;
                        },
                    });

                    $('#static_rombs_v2 .rcm_tpl:nth-child(2) .rcm_tpl_img').addClass('romb_anime');

                    // Запускаем анимацию
                    machine.shuffle(10, function() {
                        
                        // После остановки меняем текст кнопки
                        setTimeout(function() {
                        $('#static_rombs_v2 .rcm_tpl_img').removeClass('romb_anime');
                        $('#start-roll')
                            .attr('data-text', 'Крутить ещё')
                            .removeAttr('disabled')
                            .html('Крутить ещё')
                            .addClass('roll-again');
                        }, 4000);
                        // Добавляем кнопку продажи и вешаем на неё событие продажи предмета
                        $(element)
                            .find('*[data-product-id="' + winId + '"]')
                            .first()
                            .addClass('center set win')
                            .find('.rcm_tpl_img')
                            .append(
                                '<button data-history-id="' +
                                historyId +
                                '" data-product-id="' +
                                winId +
                                '" class="rcm_button"></button>'
                            );
                        $(element)
                            .find('button.rcm_button')
                            .on('click', sellProduct);
                    });
                });
                // Меняем баланс юзера
                var price = parseInt($('#roll-price').html());
                var bonus = parseInt($('#roll-bonus').html());
                var userBalans = parseInt($('#user-balans').html());
                var userBonus = parseInt($('#user-bonus').html());
                $('#user-balans').html(userBalans - price);
                $('#user-bonus').html(userBonus + bonus);
            } else {
                alert(data.text_info);
            }
        },
    });
}

function fckngRoll_many_roll() {
    var case_array = [];
    var twistedCount = $('.amount_twisted_count:checked').val(),
        case_count = 0,
        weapons_slots = null;

    if ($('#start-roll').hasClass('roll-again')) {
        $('#start-roll').removeClass('roll-again');

        $('.roulete-col:not(.roulete-col-first)').remove();
        $(".roulete-row").each(function(index) {
            var case_items = $(this).find('.roulete-col-first')
                .clone()
                .removeClass('d-none')
                .removeClass('roulete-col-first');
            $(this).append(case_items);
        });

        $('.rcm_tpl_klv').html("x" + twistedCount);
        $(".case_in_roll").each(function(index, el) {
            case_count++;
        });
        for (var i = 0; i < twistedCount; i++) {
            weapons_slots += '<div class="row center">';
            for (var j = 0; j < case_count; j++) {
                weapons_slots += ' <div class="embossed_cases_col"><div class="embossed_cases_tpl"></div></div>';
            }
            weapons_slots += '</div>';
        }
        $('.embossed_cases').html(weapons_slots);
    }
    // }
    // Отключаем кнопку при начале кручения
    $('#start-roll').attr('disabled', true);

    $(".case_in_roll").each(function(index, el) {
        var case_id = $(el).data('case_id');
        case_array.push(case_id);
    });

    //console.log(case_array);
    // Делаем запрос на сервер что бы получить выигрышные айдишники товаров
    $.ajax({
        url: '/shop-case/roll_many',
        //dataType: "json",
        type: 'POST',
        data: {
            count: twistedCount,
            cases: case_array
        },
        success: function(data) {

            // Если всё норм
            if (data.status == 'good') {
                var twistedCount = $('.amount_twisted_count:checked').val();
                var idx = 0,
                    Timeout = 500,
                    twisted_index = 0,
                    timer = 15500;

                $('.jquery-modal').animate({
                    scrollTop: 0
                }, 'slow');

                function roll_cases() {
                    //timer = 15000;
                    // console.log('прокрутка № '+idx);
                    // перебираем каждую крутилку и инициализируем на ней алгоритм кручения

                    if (twisted_index != twistedCount) {
                        $('.roulete-col:not(.roulete-col-first)').each(function(index, element) {

                            var case_id = $(this).data('case_id');
                            var winId = data['case_id_' + case_id + '_roll_' + twisted_index];
                            var historyId = data['history_' + idx + '_id'];
                            var winKey = $('*[data-product-id="' + winId + '"]').data('key');
                            var win_element, curent_index = index;
                            var current_twinded_index = twisted_index;

                            console.log("Вращение №" + twisted_index);

                            // console.log("case id: " + case_id + " winId: " + winId + " historyId: " + historyId + " winkey: " + winKey);
                            winKey = parseInt(winKey);
                            $('.embossed_cases .row:eq(' + current_twinded_index + ') .embossed_cases_col:eq(' + curent_index + ') .embossed_cases_tpl').addClass('next')
                                .addClass('rotate');

                            $('#static_rombs .rcm_tpl:nth-child(2) .rcm_tpl_img').addClass('romb_anime');
                            // Инициализирвем алгоритм крутилки и задаем параметры, randomize отвечает за выигрышный.
                            var machine = new SlotMachine(element, {
                                active: 1,
                                delay: 1500,
                                randomize: function() {
                                    return winKey - 1;
                                },
                            });

                            // Запускаем анимацию
                            machine.shuffle(10, function() {

                                // Добавляем кнопку продажи и вешаем на неё событие продажи предмета

                                //$('#static_rombs .rcm_tpl_img').removeClass('romb_anime');
                                win_element = $(element)
                                    .find('*[data-product-id="' + winId + '"]')
                                    .addClass('center set win');
                                win_element = $(element)
                                    .find('*[data-product-id="' + winId + '"]')
                                    .first();
                                /*.addClass('center set win')
                                .find('.rcm_tpl_img')
                                .append(
                                    '<button data-history-id="' +
                                    historyId +
                                    '" data-product-id="' +
                                    winId +
                                    '" class="rcm_button"></button>'
                                );*/
                                //console.log(historyId + " twisted index: " + current_twinded_index);
                                $('.embossed_cases .row:eq(' + current_twinded_index + ') .embossed_cases_col:eq(' + curent_index + ') .embossed_cases_tpl').removeClass('next')
                                    .removeClass('rotate');
                                $('.embossed_cases .row:eq(' + current_twinded_index + ') .embossed_cases_col:eq(' + curent_index + ') .embossed_cases_tpl').addClass('win')
                                    .html('<img src="' + win_element.find('img').attr('src') + '" class="some-image" alt=""><button data-history-id="' +
                                        historyId +
                                        '" data-product-id="' +
                                        winId +
                                        '" class="embossed_cases_btn"></button>');
                                $('.embossed_cases .row:eq(' + current_twinded_index + ') .embossed_cases_col:eq(' + curent_index + ')')
                                    .find('button.embossed_cases_btn')
                                    .on('click', sellProduct);
                                var curent_roll_index = twistedCount - current_twinded_index - 1;
                                $('.rcm_tpl_klv').html('x' + curent_roll_index);

                                //machine.destroy();
                                setTimeout(function() {
                                    $('.roulete-col .rcm_tpl').removeClass('center set win');
                                }, 1000);
                            });

                            //machine.destroy();
                            idx++;
                            //console.log("Timeout = " + Timeout);
                            Timeout += 4500;
                        });
                        twisted_index++;


                    }
                }

                setTimeout(function() {
                    roll_cases();
                }, 1000);

                var timerId = setInterval(function() {
                    // console.log(timer);
                    if (twisted_index != twistedCount) {
                        $('.roulete-col:not(.roulete-col-first)').remove();
                        $(".roulete-row").each(function(index) {
                            var case_items = $(this).find('.roulete-col-first')
                                .clone()
                                .removeClass('d-none')
                                .removeClass('roulete-col-first');
                            $(this).append(case_items);
                        });
                        roll_cases();
                    } else {
                        $('#static_rombs .rcm_tpl_img').removeClass('romb_anime');
                        // После остановки меняем текст кнопки
                        $('#start-roll')
                            .attr('data-text', 'Крутить ещё')
                            .removeAttr('disabled')
                            .html('Крутить ещё')
                            .addClass('roll-again');
                        clearInterval(timerId);
                    }
                }, timer);


                // Меняем баланс юзера
                var price = parseInt($('#total_roll_summ').html());
                var bonus = parseInt($('#total_roll_bonus').html());
                var userBalans = parseInt($('#user-balans').html());
                var userBonus = parseInt($('#user-bonus').html());
                $('#user-balans').html(userBalans - price);
                $('#user-bonus').html(userBonus + bonus);
            } else {
                alert(data.text_info);
            }
        },
    });
}

$('.close-roulette_case_modal').click(function() {
    $('#shadow').toggle();
    $('#close_modal_dialog').toggle();
});
$('#close_modal_dialog .first_button').click(function() {
    $('#close_modal_dialog').fadeOut("slow");
    $('#shadow').fadeOut("slow");
});
$('#close_modal_dialog .second_button').click(function() {
    $('#close_modal_dialog').fadeOut("slow");
    $('#shadow').fadeOut("slow");
    $.modal.close();
});

// При открытии модалки нужно добавить нужное количество крутилок и повесить на кнопку событие прокрутки
$('#roulette_case_modal').on($.modal.OPEN, function(event, modal) {
    var twistedCount = $('.amount_twisted_count:checked').val(),
        type_roll = $('#type_roll_cases').val(),
        weapons_slots = "",
        case_count = 0;

    if (type_roll == "many") {
        $('.rcm_tpl_klv').html("x" + twistedCount);
        $(".roulete-row").each(function(index) {
            var case_items = $(this).find('.roulete-col-first')
                .clone()
                .removeClass('d-none')
                .removeClass('roulete-col-first');
            $(this).append(case_items);
        });
        $('.roulete-col-first').addClass('d-none');
        $(".case_in_roll").each(function(index, el) {
            case_count++;
        });
        for (var i = 0; i < twistedCount; i++) {
            weapons_slots += '<div class="row center">';
            for (var j = 0; j < case_count; j++) {
                weapons_slots += ' <div class="embossed_cases_col"><div class="embossed_cases_tpl"></div></div>';
            }
            weapons_slots += '</div>';
        }
        $('.embossed_cases').html(weapons_slots);
        document.getElementById('start-roll') &&
            document.getElementById('start-roll').addEventListener('click', fckngRoll_many_roll);

    } else {
        $('#static_rombs_v2').html('');
        var content = "";
        owl.trigger('destroy.owl.carousel');
        owl.find('.owl-stage-outer').children().unwrap();
        owl.removeClass("owl-center owl-loaded owl-text-select-on");
        for (let i = 0; i < twistedCount; i++) {
            $('.roulete-col-first')
                .clone()
                .removeClass('d-none')
                .removeClass('roulete-col-first')
                .appendTo('.slick_roulette_case');
            $('#static_rombs_v2').append(' <div class="romb_row"><div class=""><div class="rcm_tpl"><div class="rcm_tpl_img"><span></span></div></div><div class="rcm_tpl"><div class="rcm_tpl_img"><span></span></div></div><div class="rcm_tpl"><div class="rcm_tpl_img"><span></span></div></div></div></div>');
        }

        owl.owlCarousel({
            //margin: 0,
            nav: true,
            loop: false,
            //  center:true,
            // navContainer:".slick_roulette_case",
            autoWidth: true,
            responsive: {
                0: {
                    items: 1,
                    center: true,
                },
                479: {
                    items: 1,
                    center: true,
                },
                480: {
                    items: 2,
                    //center: true,
                },
                790: {
                    items: 3,
                },
                1306: {
                    items: 3,
                },
                1900: {
                    items: 6,
                },
            },
        });
        $('.roulete-col-first').addClass('d-none');
        if (document.querySelector('.roulete-col')) {
            document.getElementById('start-roll') &&
                document.getElementById('start-roll').addEventListener('click', fckngRoll);
        }
    }
});

// При закрытии окна нужно убрать соыбтие что бы избежать повторной отправки запросов или дублирования рулеток
$('#roulette_case_modal').on($.modal.AFTER_CLOSE, function(event, modal) {
    var type_roll = $('#type_roll_cases').val();
    if (type_roll == "many") {
        document.getElementById('start-roll').removeEventListener('click', fckngRoll_many_roll);
    } else {
        document.getElementById('start-roll').removeEventListener('click', fckngRoll);
        $('.roulete-col-first').removeClass('d-none');
        $('.roulete-col:not(.roulete-col-first)').remove();
    }
});

function getAllUrlParams(url) {

    // извлекаем строку из URL или объекта window
    var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

    // объект для хранения параметров
    var obj = {};

    // если есть строка запроса
    if (queryString) {

        // данные после знака # будут опущены
        queryString = queryString.split('#')[0];

        // разделяем параметры
        var arr = queryString.split('&');

        for (var i = 0; i < arr.length; i++) {
            // разделяем параметр на ключ => значение
            var a = arr[i].split('=');

            // обработка данных вида: list[]=thing1&list[]=thing2
            var paramNum = undefined;
            var paramName = a[0].replace(/\[\d*\]/, function(v) {
                paramNum = v.slice(1, -1);
                return '';
            });

            // передача значения параметра ('true' если значение не задано)
            var paramValue = typeof(a[1]) === 'undefined' ? true : a[1];

            // преобразование регистра
            paramName = paramName.toLowerCase();
            paramValue = paramValue.toLowerCase();

            // если ключ параметра уже задан
            if (obj[paramName]) {
                // преобразуем текущее значение в массив
                if (typeof obj[paramName] === 'string') {
                    obj[paramName] = [obj[paramName]];
                }
                // если не задан индекс...
                if (typeof paramNum === 'undefined') {
                    // помещаем значение в конец массива
                    obj[paramName].push(paramValue);
                }
                // если индекс задан...
                else {
                    // размещаем элемент по заданному индексу
                    obj[paramName][paramNum] = paramValue;
                }
            }
            // если параметр не задан, делаем это вручную
            else {
                obj[paramName] = paramValue;
            }
        }
    }

    return obj;
}

$('.buy_weapon').click(function() {
    var weapon_id = $(this).data('weapon_id'),
        price = $(this).data('price'),
        user_bonuses = parseInt($('#user-bonus').html());


    if (user_bonuses >= price) {
        $('#buy_dialog .second_button').attr("data-product-id", weapon_id);
        $('#shadow').toggle();
        $('#buy_dialog').toggle();
    } else {
        $('#shadow').toggle();
        $('#sold_info button').html('Недостаточно бонусов!');
        $('#sold_info').fadeIn("slow");
    }


});

$('#buy_dialog .first_button').click(function() {
    $('#buy_dialog').fadeOut("slow");
    $('#shadow').fadeOut("slow");
});

$('#buy_dialog .second_button').click(function() {
    var weapon_id = $(this).attr('data-product-id');
    $.ajax({
        url: '/shop-product/buy_weapon',
        type: 'POST',
        data: {
            weapon_id: weapon_id
        },
        success: function(data) {
            if (data.status === true) {
                $('#buy_dialog').fadeOut("slow");
                $('#user-bonus').html(data.bonuses);
                $('#sold_info button').html('Покупка совершена!');
                $('#sold_info').fadeIn("slow");
            }
        }
    });
});