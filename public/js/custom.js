/* КАРУСЕЛЬ  BEGIN*/
$('#nc-carouselSalons').carousel()
/* КАРУСЕЛЬ  END*/

// СЛАЙДЕРЫ ФИЛЬТРА

$("#nc-age").slider({
    id: "nc-age",
    min: 18,
    max: 66,
    step: 1,
    value: [23, 45],

    tooltip:'show',
    
    tooltip_split: true,
});

$("#nc-height").slider({
    id: "nc-height",
    min: 150,
    max: 200,
    step: 1,
    value: [175, 185],

    tooltip:'show',
    
    tooltip_split: true,
});

$("#nc-boobs").slider({
    id: "nc-boobs",
    min: 1,
    max: 10,
    step: 1,
    value: [2, 5],

    tooltip:'show',
    
    tooltip_split: true,
});

//ОТКРЫТИЕ ЗАКРЫТИЕ УСЛУГ
$('#services-desk').css('margin-bottom','-' + $('#services-desk').height() + 'px');
$('#services').click(function(){
    $('#services-desk').toggle();
});