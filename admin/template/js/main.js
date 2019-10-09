var toggleSelectAvatarButton = function() {
    var avatarList = $('[name="avatar-id[]"]');
    for (var i = 0; i < avatarList.length; i++) {
        if (avatarList[i].getAttribute('value') == $('.slider li.active img').attr('data-photo-id')) {
            $('.select-avatar').attr('disabled', 'disabled');
            break;
        } else {
            $('.select-avatar').removeAttr('disabled');
        }
    }
};
var toogleCulturePhoto = function() {
    var idCulture = $('.slider li.active img').attr('data-culture-id');
    $('[name="culture"] option').removeAttr('selected');
    $('[name="culture"] option[value="' + idCulture + '"]').attr('selected', 'selected');
    $('[name="culture"]').material_select();
};
var toogleDescPhoto = function() {
    $('[name="desc"]').val($('.slider li.active img').attr('data-photo-desc'));
    if ($('.slider li.active img').attr('data-photo-desc') != '')
        $('[name="desc"]').parent().find('label').addClass('active');
    else
        $('[name="desc"]').parent().find('label').removeClass('active');
};
var toogleTagsPhoto = function() {
    $(".tagList .chip.tag").remove();

    var tagList = $('.slider li.active img').attr('data-photo-tags');
    if (tagList != null && tagList != undefined) {
        var tagListArr = tagList.split(',');

        var name = 'selectTags[]';
        for (var i = 0; i < tagListArr.length; i++) {
            var value = tagListArr[i];
            if (value == '')
                continue;

            $(".tagList").append(
                '<div class="chip tag">\
                    <input type="hidden" name="' + name + '" value="' + value + '">' + value + '\
                <i class="close material-icons">close</i>\
            </div>');
        }
    }
};
var toogleShowPhoto = function() {
      if ($('.slider li.active img').attr('data-show') == "0") {
          $('.publish').css('display', 'inline-block');
      } else {
          $('.publish').css('display', 'none');
      }
};

var generateOption = function(valueStart, valueEnd) {
    var optionStr = "";
    if (valueEnd > valueStart) {
        while (valueStart <= valueEnd) {
            optionStr += '<option value="' + valueStart + '">' + valueStart++ + '</option>';
        }
    }
    return optionStr;
};

var generateOptionFromSelect = function(cssSelector) {
    var html = "";
    $(cssSelector).last().find('option').each(function() {
        var select = $(this).clone().removeAttr('selected');

        html += select.prop('outerHTML');
    });

    return html;
};

var files = 0;
$(document).ready(function(){
    $('select').material_select();
    $('.carousel').carousel({full_width: true});
    $('.slider').slider({
        autoplay: false
    });
    $('.slider').slider('pause');

    if(window.location.toString().indexOf('regdata/add') > 0 || window.location.toString().indexOf('certification/add') > 0)  {
        $(".show_hidden_fields").on("click", function () {
            $(".hidden_fields").toggle();
            if ($(".hidden_fields").is(":visible")) {
                $("span.text_1").text("Скрыть");
            } else {
                $("span.text_1").text("Показать");
            }
        });

        // После выбора препарата формируем список вредных объектов
        $('select[name="product"]').autocompleteSelect({
            onAutocomplete: function(val) {
                var idProduct = $('select[name="product"]').val();

                $("#selectObject").html('');
                $.post('selectObject', {'idProduct': idProduct}, function(data) {
                    $("#selectObject").html(data);
                    $("#selectObject").material_select();
                    $(".objectList").html('<div class="chip light-blue darken-2 white-text">Добавленные вредные объекты:</div>');
                });
            }
        });

        $('.addFieldsBtn').click(function() {
            var nameNumber = 'number[]';
            var nameDay = 'day[]';
            var nameMonth = 'month[]';
            var nameYear = 'year[]';
            var nameFileName = 'fileName[]';
            var nameFile = 'file[]';

            var html_item = '\
            <div class="col s12 m6">\
                <div class="card grey darken-3">\
                    <div class="card-content white-text">\
                    <div class="row">\
                    <span class="card-close"><i class="material-icons">close</i></span>\
                        <div class="col s12">Номер свидетельства: <input type="text" name="' + nameNumber + '" /></div>\
                        <div class="col s12">\
                            <div class="row">\
                                <div class="col s6">Дата окончания свидетельства</div>\
                                <div class="col s2">\
                                    <input type="text" name="' + nameDay + '" placeholder="День" size="4">\
                                </div>\
                                <div class="col s2">\
                                    <select name="' + nameMonth + '">' + generateOption(1, 12) + '</select>\
                                </div>\
                                <div class="col s2">\
                                    <select name="' + nameYear + '">' + generateOption(2013, 2030) + '</select>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="col s12">Название файла: <input type="text" name="' + nameFileName + '"  size="12">\
                            <input type="file" name="' + nameFile + '">\
                        </div>\
                    </div>\
                    </div>\
                </div>\
            </div>';
            $("#container_hidden_fields").append(html_item);

            $('[name="' + nameMonth + '"], [name="' + nameYear + '"]').material_select();

            $('.card-close').on('click', function() {
               $(this).parents('.card').parent().remove();
            });
        });
        // Восстановление культур после запроса
        $('[name="selectCulture[]"]').each(function() {
            var value = $(this).val();
            $(this).parent().append($('#selectCulture option[value="' + value + '"]').text());
        });
        // Добавление культур
        $('.cultureListAdd').click(function() {
            var name = 'selectCulture[]';
            var value = $("#selectCulture").val();
            var text = $("#selectCulture option[value='" + value + "']").text();

            if ($('[name^="selectCulture"][value="' + value + '"]').length == 0) {
                $(".cultureList").append(
                '<div class="chip">\
                            <input type="hidden" name="' + name + '" value="' + value + '">' + text + '\
                    <i class="close material-icons">close</i>\
                </div>');
            }
        });
        // Восстановление объектов после запроса
        $('[name="selectObject[]"]').each(function() {
            var value = $(this).val();
            $(this).parent().append($('#selectObject option[value="' + value + '"]').text());
        });
        $('[name="selectObject2[]"]').each(function() {
            var value = $(this).val();
            $(this).parent().append($('#selectObject2 option[value="' + value + '"]').text());
        });
        // Добавление группы объектов
        $('.objectListAdd').click(function() {
            var name = 'selectObject[]';
            var value = $("#selectObject").val();
            var text = $("#selectObject option[value='" + value + "']").text();

            if ($('[name^="selectObject"][value="' + value + '"]').length == 0) {
                $(".objectList").append(
                    '<div class="chip">\
                        <input type="hidden" name="' + name + '" value="' + value + '">' + text + '\
                <i class="close material-icons">close</i>\
            </div>');
            }
        });
        // Добавление объектов
        $('.objectListAdd2').click(function() {
            var name = 'selectObject2[]';
            var value = $("#selectObject2").val();
            var text = $("#selectObject2 option[value='" + value + "']").text();

            if ($('[name^="selectObject2"][value="' + value + '"]').length == 0) {
                $(".objectList2").append(
                    '<div class="chip">\
                        <input type="hidden" name="' + name + '" value="' + value + '">' + text + '\
                <i class="close material-icons">close</i>\
            </div>');
            }
        });
    }


    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 17,
        today: 'Сегодня',
        clear: 'Назад',
        close: 'ОК',
        closeOnSelect: true
    });

    $('select[name="productId"]').autocompleteSelect({
        onAutocomplete: function(val) {
            $('[name="datePrice"] option').remove();

            $.post('price/date', {'idProduct': $('select[name="productId"]').val()}, function(data) {
                var dates = JSON.parse(data);
                for (var i = 0; i < dates.length; i++) {
                    $('[name="datePrice"]').append('<option value="' + dates[i]['id_date'] + '">' + dates[i]['date'] + '</option>');
                }
                $('[name="datePrice"]').material_select();
                dateFunc();
            });

            $('[name="idProductSave"]').val($('select[name="productId"]').val());
            $('[name="idProductAdd"]').val($('select[name="productId"]').val());
        }
    });

    $('select[name="objectId"]').autocompleteSelect({
        onAutocomplete: function(val) {
            $.post(PATH + '/object/desc/get', {'idObject': $('select[name="objectId"] option[selected]').val()}, function(data) {
                var descInfo = JSON.parse(data);
                if (descInfo['descBiologyText'] !== undefined && descInfo['descBiologyIdBiblioLink'] !== undefined) {
                    for (var i = 0; i < descInfo['descBiologyText'].length; i++) {
                        if ((i > 0 && $('.desc_biology_block').length != 0) || $('.desc_biology_block').length == 0) {
                            $('.add_desc_biology_block').click();
                        }

                        updTextArea('desc_biology[]', descInfo['descBiologyText'][i]);
                        updSelect('desc_biology_biblio_link[]', descInfo['descBiologyIdBiblioLink'][i]);
                    }
                }
                if (descInfo['descDevelopmentText'] !== undefined && descInfo['descDevelopmentIdBiblioLink'] !== undefined) {
                    for (var i = 0; i < descInfo['descDevelopmentText'].length; i++) {
                        if ((i > 0 && $('.desc_development_block').length != 0) || $('.desc_development_block').length == 0) {
                            $('.add_desc_development_block').click();
                        }

                        updTextArea('desc_development[]', descInfo['descDevelopmentText'][i]);
                        updSelect('desc_development_biblio_link[]', descInfo['descDevelopmentIdBiblioLink'][i]);
                    }
                }
                if (descInfo['descSignificanceText'] !== undefined && descInfo['descSignificanceIdBiblioLink'] !== undefined) {
                    for (var i = 0; i < descInfo['descSignificanceText'].length; i++) {
                        if ((i > 0 && $('.desc_significance_block').length != 0) || $('.desc_significance_block').length == 0) {
                            $('.add_desc_significance_block').click();
                        }

                        updTextArea('desc_significance[]', descInfo['descSignificanceText'][i]);
                        updSelect('desc_significance_biblio_link[]', descInfo['descSignificanceIdBiblioLink'][i]);
                    }
                }
                if (descInfo['descSymptomsText'] !== undefined && descInfo['descSymptomsIdBiblioLink'] !== undefined) {
                    for (var i = 0; i < descInfo['descSymptomsText'].length; i++) {
                        if ((i > 0 && $('.desc_symptoms_block').length != 0) || $('.desc_symptoms_block').length == 0) {
                            $('.add_desc_symptoms_block').click();
                        }

                        updTextArea('desc_symptoms[]', descInfo['descSymptomsText'][i]);
                        updSelect('desc_symptoms_biblio_link[]', descInfo['descSymptomsIdBiblioLink'][i]);
                    }
                }
            });
        }
    });

    // Вызов добавления блоков описаний
    $('.add_desc_biology_block').click(function() {
        var descName = 'биологии объекта';

        var blockClass = 'desc_biology_block';
        var textareaId = 'desc_biology';
        var textareaName = 'desc_biology[]';
        var selectName = 'desc_biology_biblio_link[]';

        descAdd(descName, blockClass, textareaId, textareaName, selectName);
    });
    $('.add_desc_development_block').click(function() {
        var descName = 'развития поражения';

        var blockClass = 'desc_development_block';
        var textareaId = 'desc_development';
        var textareaName = 'desc_development[]';
        var selectName = 'desc_development_biblio_link[]';

        descAdd(descName, blockClass, textareaId, textareaName, selectName);
    });
    $('.add_desc_significance_block').click(function() {
        var descName = 'экономического значения';

        var blockClass = 'desc_significance_block';
        var textareaId = 'desc_significance';
        var textareaName = 'desc_significance[]';
        var selectName = 'desc_significance_biblio_link[]';

        descAdd(descName, blockClass, textareaId, textareaName, selectName);
    });
    $('.add_desc_symptoms_block').click(function() {
        var descName = 'симптомов';

        var blockClass = 'desc_symptoms_block';
        var textareaId = 'desc_symptoms';
        var textareaName = 'desc_symptoms[]';
        var selectName = 'desc_symptoms_biblio_link[]';

        descAdd(descName, blockClass, textareaId, textareaName, selectName);
    });

    // Добавление блока описания объекта
    var descAdd = function(descName, blockClass, textareaId, textareaName, selectName) {
        var indexDesc = $('.' + blockClass).length + 1;

        var sourceHTML = '<div class="row ' + blockClass + ' desc-block">' +
            '<div class="col s12"><h5><span class="index">' + indexDesc + '.</span> Описание ' + descName + '\
                <div class="chip chip-desc-block">Удалить<i class="close close-desc-block material-icons">close</i></div></h5></div>\
                <div class="input-field col s12">\
                    <textarea id="' + textareaId + '" class="materialize-textarea" name="' + textareaName + '"></textarea>\
                    <label for="' + textareaId + '">Описание ' + descName + '</label>\
                </div>\
                <div class="input-field col s12">\
                    <select name="' + selectName + '">'
            + generateOptionFromSelect('[name="biblio_link"]') +
            '</select>\
            <label>Литературный источник для описания ' + descName + '</label>\
                </div>' +
            '</div>';
        var selector = '.' + blockClass;
        if ($(selector).length == 0)
        {
            selector = '.add_' + blockClass;
            $(selector).last().parent().parent().before(sourceHTML);
        } else {
            $(selector).last().after(sourceHTML);
        }

        $('select[name="' + selectName + '"]').last().material_select();
        $('select[name="' + selectName + '"]').last().autocompleteSelect();

        $('.chip-desc-block').off('click');
        $('.chip-desc-block').click(descDel);
    };

    var descDel = function() {
        var blockClass = '';
        if ($(this).parents('.desc-block').hasClass('desc_biology_block')) {
            blockClass = 'desc_biology_block';
        }
        if ($(this).parents('.desc-block').hasClass('desc_development_block')) {
            blockClass = 'desc_development_block';
        }
        if ($(this).parents('.desc-block').hasClass('desc_significance_block')) {
            blockClass = 'desc_significance_block';
        }
        if ($(this).parents('.desc-block').hasClass('desc_symptoms_block')) {
            blockClass = 'desc_symptoms_block';
        }

        $(this).parents('.desc-block').remove();

        var index = 1;
        $('.' + blockClass + ' .index').each(function() {
            $(this).html(index++ + '.');
        });
    };
    $('.chip-desc-block').click(descDel);

    var updSelect = function(name, val) {
        $('select[name="' + name + '"]').last().find('option').removeAttr('selected');
        $('select[name="' + name + '"]').last().find('option[value="' + val + '"]').attr('selected', 'selected');
        $('input[name="' + name.replace('[]', '') + '-autocomplete[]"]').last()
            .val($('select[name="' + name + '"] option[value="' + val + '"]').last().text());
        $('input[name="' + name.replace('[]', '') + '-autocomplete[]"] + label').last().addClass('active');
    };
    var updTextArea = function(name, val) {
        $('[name="' + name + '"]').last().text(val);
        $('[name="' + name + '"] + label').last().addClass('active');
    };

    $('select[name="desc_biology_biblio_link[]"]').autocompleteSelect();
    $('select[name="desc_development_biblio_link[]"]').autocompleteSelect();
    $('select[name="desc_significance_biblio_link[]"]').autocompleteSelect();
    $('select[name="desc_symptoms_biblio_link[]"]').autocompleteSelect();

    $('[name="datePrice"]').on('change', function() {
        dateFunc();
    });

    var dateFunc = function() {
        $.post('price/info', {'idProduct': $('[name="productId"]').val(),
            'idDate': $('[name="datePrice"]').val()}, function(data) {
            if (data != null)
            {
                var prices = JSON.parse(data);
                if (prices['price_rub'] != undefined && prices['price_rub'] != '')
                    $(".card-exists [name='price_rub']").val(prices['price_rub']);
                if (prices['price_usd'] != '')
                    $(".card-exists [name='price_usd']").val(prices['price_usd']);
                if (prices['id_importer']) {
                    $(".card-exists select").val(prices['id_importer']).material_select();
                }

                if (prices['actuality'] == 1)
                    $('.card-exists [name="actualitySave"]').attr('checked', 'checked');
                else
                    $('.card-exists [name="actualitySave"]').removeAttr('checked');
            }
        });
        $('[name="idDate"]').val($('[name="datePrice"]').val());
    };

    $('.chip.letter-select').click(function() {
        $('.chip.letter-select').removeClass('select');
        $(this).addClass('select');
        $('[name="id_letter"]').val($(this).attr('data-id-letter'));
    });

    $('select[name="id_grobject"]').autocompleteSelect();
    $('select[name="idObject"]').autocompleteSelect();

    $('select[name="id_synonym"]').autocompleteSelect();

    $('select[name="tag_ids"]').autocompleteSelect();

    $('select[name="tara_ids"]').autocompleteSelect();

    $('select[name="countries"]').autocompleteSelect();

    $('select[name="tara"]').autocompleteSelect();

    $('select[name="element"]').autocompleteSelect();

    $('[name="lnamespecies"], [name="rnameobject"], [name="name_product_rus"], ' +
        '[name="name_manufacture_rus"], [name="fertiliser_name"]').keydown(function() {
        var value = $(this).val();
        var nameLetter = $(this).attr('data-name-letter');

        if (value.length > 0 && $('[name="' + nameLetter + '"]').val() == '') {
            $('.chip.letter-select').each(function() {
                if ($(this).text().toUpperCase() == value[0].toUpperCase()) {
                    $(this).click();
                    return false;
                }
            });
        }
        else if (value.length <= 1) {
            $('.chip.letter-select').removeClass('select');
            $('[name="' + nameLetter + '"]').val('');
        }
    });

    $('.culture-add-btn').click(function() {
        var name = 'selectCulture[]';
        var value = $("#selectCulture").val();

        if ($('[name="' + name + '"][value="' + value + '"]').length == 0) {
            var text = $("#selectCulture option[value='" + value + "']").text();

            $(".cultureList").append(
                '<div class="chip">\
                    <input type="hidden" name="' + name + '" value="' + value + '">' + text + '\
                <i class="close material-icons">close</i>\
            </div>');
        }

        return false;
    });

    $('.object-add-btn').click(function() {
        var name = 'selectObject[]';
        var value = $("#selectObject").val();

        if ($('[name="' + name + '"][value="' + value + '"]').length == 0) {
            var text = $("#selectObject option[value='" + value + "']").text();

            $(".objectList").append(
                '<div class="chip">\
                    <input type="hidden" name="' + name + '" value="' + value + '">' + text + '\
                <i class="close material-icons">close</i>\
            </div>');
        }

        return false;
    });

    $('.tag-add-btn').click(function() {
        var name = 'selectTags[]';
        var value = $("[name='tag_ids-autocomplete']").val();

        if (value !== '' && !$('[name="' + name + '"][value="' + value + '"]').is('input')) {
            $(".tagList").append(
                '<div class="chip">\
                    <input type="hidden" name="' + name + '" value="' + value + '">' + value + '\
                <i class="close material-icons">close</i>\
            </div>');
        }

        return false;
    });

    // Добавление класса удобрения в форме
    $('.fertiliser-class-add-btn').click(function() {
        var name = 'fertiliser_class[]';
        var value = $("#selectFertiliserClass").val();

        if (value !== '' && value != 0 && !$('[name="' + name + '"][value="' + value + '"]').is('input')) {
            var text = $("#selectFertiliserClass option[value='" + value + "']").text();

            $(".fertiliserClassList").append(
                '<div class="chip">\
                    <input type="hidden" name="' + name + '" value="' + value + '">' + text + '\
                <i class="close material-icons">close</i>\
            </div>');

            $('#fertiliser_class_ids-autocomplete-id').val('');
            $('[for="fertiliser_class_ids-autocomplete-id"]').removeClass('active');
        }

        return false;
    });


    $('.tara-add-btn').click(function() {
        var name = 'tara[]';
        var value = $("#selectTara").val();

        if (value !== '' && value != 0 && !$('[name="' + name + '"][value="' + value + '"]').is('input')) {
            var text = $("#selectTara option[value='" + value + "']").text();

            $(".taraList").append(
                '<div class="chip">\
                    <input type="hidden" name="' + name + '" value="' + value + '">' + text + '\
                <i class="close material-icons">close</i>\
            </div>');

            $('#tara_ids-autocomplete-id').val('');
            $('[for="tara_ids-autocomplete-id"]').removeClass('active');
        }

        return false;
    });

    // Удаление препаративной формы
    $('.delete-button-form').click(function() {
        $.post('delete', {'idSolution': $(this).attr('data-id')}, function (data) {
            if (data == 'ok') {
                location.reload();
            }
        });
    });
    // Удаление производителя
    $('.delete-button-manufacture').click(function() {
        $.post('delete', {'idManufacture': $(this).attr('data-id')}, function (data) {
            if (data == 'ok') {
                location.reload();
            }
        });
    });

    // Фотографии объектов
    $('.indicator-item').click(function() {
        toggleSelectAvatarButton();
        toogleDescPhoto();
        toogleTagsPhoto();
        toogleCulturePhoto();
        toogleShowPhoto();

        $('.slider').slider('pause');
    });
    toggleSelectAvatarButton();
    toogleDescPhoto();
    toogleTagsPhoto();
    toogleCulturePhoto();
    toogleShowPhoto();

    $('form.selectObjectForImage').submit(function() {
        if (location.href.indexOf('image/') !== -1) {
            location.href = location.href.substr(0, location.href.indexOf('image/')) + 'image/' + $('select[name="idObject"] option[selected]').val();
        } else {
            location.href = 'image/' + $('select[name="idObject"] option[selected]').val();
        }
        return false;
    });
    $('.save-photo-param').click(function() {
        var tagList = '';
        $('[name="selectTags[]"]').each(function() {
            tagList += $(this).val() + ',';
        });

        $.post('param', {'id': $('.slider li.active img').attr('data-photo-id'),
            'desc': $('[name="desc"]').val(),
            'tagList': tagList,
            'idCulture': $('[name="culture"]').val()}, function(data) {
            if (data == 'ok') {
                location.reload();
            }
        });

        return false;
    });

    $('.select-avatar').click(function() {
        $.post('avatar',
            {'id': $('.slider li.active img').attr('data-photo-id'),
            'idCulture': $('[name="culture"]').val()}, function(data) {
            if (data != 'err') {
                $('[name="avatar-id[]"][value="' + data + '"]').remove();
                $('.slider .button-row').append('<input type="hidden" name="avatar-id[]" value="' + $('.slider li.active img').attr('data-photo-id') + '">');
                toggleSelectAvatarButton();
            }
        });
        return false;
    });

    $('.delete-photo').click(function() {
        $.post('delete', {'id': $('.slider li.active img').attr('data-photo-id')}, function(data) {
            if (data == 'ok') {
                location.reload();
            }
        });
        return false;
    });

    $('.publish').click(function() {
        $.post('publish', {'id': $('.slider li.active img').attr('data-photo-id'),
                           'idObject': $('[name="idObject"]').val(),
                           'idCulture': $('[name="culture"]').val()}, function(data) {
            if (data != 'err') {
                $('.slider li.active img').attr('data-show', '1');
                toogleShowPhoto();
            }
        });
        return false;
    });

    if (document.forms.upload != undefined) {
        document.forms.upload.onsubmit = function() {
            var input = this.getElementsByClassName('photos')[0];
            if (input.files.length + +$('[name="countalready"]').val() > 10) {
                $('.photos-row').append('<p class="delete">Максимальное количество 10 фотографий. Выберите меньшее количество.</p>');
                return false;
            } else {
                $('.delete').remove();
            }
            for (var i = 0; i < input.files.length; i++) {
                if (input.files[i]) {
                    upload(input.files[i]);
                }
            }
            setTimeout(function() {
                // location.reload();
            }, 1000);
            return false;
        };

        function upload(file) {
            $('.photos-row').append('<div class="col s2" file-name="' + file.name + '">\
        <p class="name">' + file.name + '</p>\
        <div class="progress">\
        <div class="determinate" style="width: 0%"></div>\
        </div>\
        </div>');
            var xhr = new XMLHttpRequest();

            xhr.upload.onprogress = function(event) {
                var deter = Math.round(event.loaded * 100 / event.total);
                if (deter > 100)
                    deter = 100;

                if (!$('[file-name="' + file.name + '"] .determinate').hasClass('red'))
                    $('[file-name="' + file.name + '"] .determinate').css('width', deter + '%');
            };

            xhr.onload = xhr.onerror = function() {
                if (this.status == 200) {
                    $('[file-name="' + file.name + '"] .determinate').addClass('waves-light blue');
                } else {
                    $('[file-name="' + file.name + '"] .determinate').addClass('red');
                }
            };

            xhr.open("POST", "post", true);

            var formData = new FormData();
            formData.append("photo", file);
            xhr.send(formData);
        }
    }

    $('[name="regdata"]').change(function() {
        $.post('merge/regDataAndObjectGroup', {idRegData: $(this).val()}, function(data) {
            $('[type="checkbox"][name="grobject[]"]').removeAttr('checked');
            var regDataAndObjectGroup = JSON.parse(data);
            for (var i = 0; i < regDataAndObjectGroup.length; i++) {
                $('[type="checkbox"][name="grobject[]"][value="' + regDataAndObjectGroup[i] + '"]').attr('checked', 'checked');
            }
        });
    });

    $('#modalImage').modal();
    $('[href="#modalImage"]').click(function() {
        $('#modalImage img').attr('src', $(this).find('img').attr('src'));
    });

    $('.add-element').click(function() {
        var count = $('.element').length;
        $('.element-container').append('<div class="col s12 m6 element"><div class="card grey darken-3">\
            <div class="card-content white-text"><div class="row"><div class="input-field col s10">\
            <select name="element_' + count + '">' + generateOptionFromSelect('[name="element_0"]') +
            '</select><label>Выберите элемент</label></div>\
            <div class="col s2"><a href="javascript:void(0);">Добавить элемент</a></div>\
            <div class="input-field col s12">\
            <input id="concentration" name="concentration[]" placeholder="Концентрация" type="text" class="validate">\
            <label for="concentration">Концентрация</label></div>\
            <div class="input-field col s12"><select name="idSubstanceUnit[]">' +
            generateOptionFromSelect('[name="idSubstanceUnit[]"]') +
            '</select><label>Единица измерения</label></div></div></div></div></div>');

        $('.element-container .element').last().find('select').material_select();

        $('select[name="element_' + count + '"]').autocompleteSelect();
        return false;
    });
    $('select[name="element_0"]').autocompleteSelect();

    $('select[name="idFertiliser"]').autocompleteSelect();

    $('select[name="idFertiliserAdv"]').autocompleteSelect({
        'onAutocomplete': function() {
            $('.descAdvList .chip:not([class*="light-blue"])').remove();
            $.post(PATH + '/fertiliser/descAdv/get/' + $('select[name="idFertiliserAdv"]').val(), function(data) {
                $('.descAdvList').append(data);
            });
        }
    });

    $('.descAdv-add-btn').click(function() {
        var name = 'descAdv[]';
        var value = $("[name='descAdv']").val();
        var text = value;

        $(".descAdvList").append(
            '<div class="chip">\
                        <input type="hidden" name="' + name + '" value="' + value + '">' + text + '\
                <i class="close material-icons">close</i>\
            </div>');

        $("[name='descAdv']").val('');
        return false;
    });

  $('.card-close').on('click', function() {
    $(this).parents('.card').parent().remove();
  });

  $('span.tara').each(function() {
      $(this).text($('select#selectTara option[value="' + $(this).attr('data-tara-id') + '"]').text());
  });
  $('span.fertiliser_class').each(function() {
    $(this).text($('select#selectFertiliserClass option[value="' + $(this).attr('data-tara-id') + '"]').text());
  });

});