'use strict';

var fieldIndexes = {};

function fileInputCopyPast(e, n) {
    var t = $(n), i = t.closest(".form-group"), a = t.find(".errors"), o = t.find(".no-value"), c = t.find(".has-value"), r = t.find(".thumbnail img.has-value"), d = t.find(".imageValue"), s = new Flow({
        target: t.data("target"),
        testChunks: !1,
        chunkSize: 1073741824,
        query: {_token: t.data("token")}
    });

    s.assignBrowse(t.find(".imageBrowse"), !1, !0), s.on("filesSubmitted", function (e) {
        s.upload()
    }), s.on("fileSuccess", function (e, n) {
        s.removeFile(e), a.html(""), i.removeClass("has-error");
        var t = $.parseJSON(n);
        r.attr("src", t.url), c.find("span").text(t.value), d.val(t.value), o.addClass("hidden"), c.removeClass("hidden")
    }), s.on("fileError", function (e, n) {
        s.removeFile(e);
        var t = $.parseJSON(n), o = "";
        $.each(t, function (e, n) {
            o += '<p class="help-block">' + n + "</p>"
        }), a.html(o), i.addClass("has-error")
    }), t.find(".imageRemove").click(function () {
        d.val(""), o.removeClass("hidden"), c.addClass("hidden")
    })
}

function imageInputCopyPast(e, n, imageSelectArea) {
    var t = $(n), i = t.closest(".form-group"), a = t.find(".errors"), o = t.find(".no-value"), c = t.find(".has-value"), r = t.find(".thumbnail img.has-value"), s = t.find(".imageValue"), d = new Flow({
        target: t.data("target"),
        testChunks: !1,
        chunkSize: 1073741824,
        query: {_token: t.data("token")}
    });
    d.assignBrowse(t.find(".imageBrowse"), !1, !0), d.on("filesSubmitted", function (e) {
        d.upload()
    }), d.on("fileSuccess", function (e, n) {
        d.removeFile(e), a.html(""), i.removeClass("has-error");
        var t = $.parseJSON(n);
        r.attr("src", t.url), c.find("span").text(t.value), s.val(t.value), o.addClass("hidden"), c.removeClass("hidden")

        var imgOb = new Image();
        imgOb.onload = function() {
            r.imgAreaSelect({
                handles: true,
                imageHeight: this.height,
                imageWidth: this.width,
                onSelectEnd: function (img, selection) {
                    $('input[name="coords"]').val(JSON.stringify(selection));
                }
            });
        };
        imgOb.src = c[0].src;

    }), d.on("fileError", function (e, n) {
        d.removeFile(e);
        var t = $.parseJSON(n), o = "";
        $.each(t, function (e, n) {
            o += '<p class="help-block">' + n + "</p>"
        }), a.html(o), i.addClass("has-error")
    }), t.find(".imageRemove").click(function () {
        s.val(""), o.removeClass("hidden"), c.addClass("hidden")
    })
}


function addField($btn){
    var $destination = $btn.parents('.panel-body').find('.parts');
    var fieldType = $btn.data('add');
    var index = fieldIndexes[fieldType] || 777;
    var url = $btn.data('url') + '&index=' + index;

    $.get(url, function(response){
        $destination.append(response);
        fieldIndexes[fieldType] = index + 1;

        if (fieldType == 'timer'){
            $btn.hide();
        }else{
            fileInputCopyPast(index, $destination.find('input[name*="files[' + index + '][value]"]').parents('.imageUpload')[0]);
            imageInputCopyPast(index, $destination.find('input[name*="images[' + index + '][value]"]').parents('.imageUpload')[0], fieldType == 'image_piece');
        }

        var $addedFieldSortNumber = $destination.find('input[name*="' + fieldType + 's[' + index + '][sort_number]"]');
        $addedFieldSortNumber.val(+$addedFieldSortNumber.parents('.form-group.row').prev().prev('.form-group').find('input[name*=sort_number]').val() + 1);

        if (isNaN($addedFieldSortNumber.val())){
            $addedFieldSortNumber.val(0);
        }
    });
}


function movePart($part, direction) {
    var $hr = $part.next('hr'),
        $parts = direction == 'up' ? $part.prevAll('.form-group') : $part.nextAll('.form-group'),
        $changePart = $parts.first();

    if ($parts.length) {

        $part.find('input[name*=sort_number]').val(+$changePart.find('input[name*=sort_number]').val());

        var $changePartSortNumber = $changePart.find('input[name*=sort_number]');
        if (direction == 'up') {
            $changePartSortNumber.val(+$changePartSortNumber.val() + 2);
        } else {
            $changePartSortNumber.val(+$changePartSortNumber.val() - 2);
        }

        $parts.each(function () {
            var $this = $(this),
                $sortNumberField = $this.find('input[name*=sort_number]'),
                sortNumber = +$sortNumberField.val();

            if (direction == 'up') {
                $sortNumberField.val(sortNumber - 1);
                $changePart.before($part);
                $part.after($hr);
            } else {
                $sortNumberField.val(sortNumber + 1);
                $changePart.after($part);
                $part.before($hr);
            }
        });
    }
}


function downloadAnswerButtons(type){
    var $panel = $('.answer-panel');
    var $buttons = $('.answer-buttons');

    $.get($panel.data('buttons-url') + '?type=' + type, function(response){
        var $parts = $('div.parts');
        $parts.empty();
        $buttons.html(response);
        if ($.trim(response) == ''){
            $parts.html('<p class="text-muted">Без компонентов</p>');
        }
    });
}


function handleRightChoiceAnswer($checkbox, type){
    type = type || 'text_choice';
    var $allCheckboxes = $checkbox.parents('.parts').find('.' + type + '-checkbox');

    $allCheckboxes.prop('checked', false);
    $checkbox.prop('checked', true);
}


function handleImageAreaSelect() {
    var $input = $('input[name="coords"]');

    if ($.trim($input.val()) != '') {
        var selection = $.parseJSON($input.val());
        var $img = $input.parents('.form-group').find('img.has-value');

        var $tabs = $('.nav-tabs').find('li');

        $tabs.on('click', function(){
            if ($(this).find('.fa-check-circle').length){
                setTimeout(function(){
                    $img.imgAreaSelect({
                        handles: true,
                        x1: selection.x1,
                        y1: selection.y1,
                        x2: selection.x2,
                        y2: selection.y2,
                        onSelectEnd: function (img, selection) {
                            $input.val(JSON.stringify(selection));
                        }
                    });
                }, 100);

            }else{
                $img.imgAreaSelect({remove:true});
            }
        });


    }
}

function resetSelectArea () {
    var $input = $('input[name="coords"]');
    if ($.trim($input.val()) != '') {
        var image = $('img.has-value');
        image.imgAreaSelect({
            remove: true
        });
    }

}

(function ($) {
    $('img.has-value').attr('width', '');
    $('img.has-value').attr('height', '');

    resetSelectArea();

    $(document).on('click', '.nav-tabs li', function(){
        var tabInfo = $(this).find('i').data('tab_name').split('.');
        var pageName = tabInfo[0];
        var tabName  = tabInfo[1];
        var data = {};
        var pageInfo = {};
        pageInfo['page_name'] = pageName;
        pageInfo['tab_name'] = tabName;
        data[pageName] = [];
        data[pageName].push(pageInfo);
        //  data[pageName]['tab_name'] = [];
        /*      data[pageName]['page_name'] = pageName;
         data[pageName]['tab_name'] = tabName;*/
        console.log(data);
        localStorage.setItem('tab_name'+'|'+pageName, tabName);
        localStorage.setItem('page_name'+'|'+pageName, pageName);
    });

    var currentPage = window.location.pathname.indexOf('quests') +1 ? 'quests' : 'question';
    // window.localStorage.clear();
    if(localStorage.getItem('page_name'+'|'+currentPage)){
        var pageName = localStorage.getItem('page_name'+'|'+currentPage);
        var tabName  = localStorage.getItem('tab_name'+'|'+currentPage);
        if(window.location.pathname.indexOf(pageName) +1){
            setTimeout(function(){
                $('.nav-tabs li [data-tab_name="'+ pageName + '.' +tabName+'"]').click();
            },100);
        }
    }

    $(document).on('click', '.add-part', function(e){
        resetSelectArea();
        e.preventDefault();
        addField($(this));
    });

    $(document).on('click', '.imageRemove', function(){
        var $this = $(this);
        setTimeout(function(){
            $this.parents('.form-group').remove();
        }, 1);
    });

    $(document).on('click', '.part-order button[data-move]', function(e){
        e.preventDefault();
        var $this = $(this);

        movePart($this.parents('.form-group'), $this.data('move'));
    });

    $(document).on('click', '.part-remove button', function(e){
        resetSelectArea();
        e.preventDefault();
        var $this = $(this);

        $this.parents('.form-group.row').next().remove().end().remove();
    });

    $(document).on('change', '#quest_question_type', function(e){
        resetSelectArea();
        e.preventDefault();

        downloadAnswerButtons($(this).val());
    });

    $(document).on('change', '.text_choice-checkbox', function(){
        handleRightChoiceAnswer($(this));
    });

    $(document).on('change', '.image_choice-checkbox', function(){
        handleRightChoiceAnswer($(this), 'image_choice');
    });

    handleImageAreaSelect();
})(jQuery);