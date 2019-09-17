$(document).ready(function() {
    $('#element-select').material_select();

    $('#element-select').change(function() {
        if ($(this).val() == 0) {
            location.href = location.href.substr(0, location.href.indexOf('/element-'));
        } else {
            if (location.href.indexOf('/element-') !== -1) {
                location.href = location.href.substr(0, location.href.indexOf('/element-')) + '/element-' + $(this).val();
            } else {
                location.href = location.href + '/element-' + $(this).val();
            }
        }
    });

    $('.search_input').keyup(function() {
       if ($(this).val().length >= 3 && $(this).val().length < 42) {
           $.post(PATH + '/search', {'query': $(this).val()}, function(data) {
                $('.search_autocomplete').html(data);
           });
       }
    });
    $('.search_input').blur(function() {
        setTimeout(function() {
            $('.search_autocomplete').html('');
        }, 500);
    });
    $('.search_input').focus(function() {
        if ($(this).val().length >= 3 && $(this).val().length < 42) {
            $.post(PATH + '/search', {'query': $(this).val()}, function(data) {
                $('.search_autocomplete').html(data);
            });
        }
    });

    $('.carousel').carousel();

    $('[href="#modalImage"]').click(function() {
        $('#modalImage img').attr('src', $(this).find('img').attr('src'));
        if ($(this).attr('data-desc') == '') {
            $('#modalImage p').css('display', 'none');
        } else {
            $('#modalImage p').html($(this).attr('data-desc'));
            $('#modalImage p').css('display', 'block');
        }

    });

    $('.modal').modal();
});