(function( $ ) {
    $.fn.autocompleteSelect = function(options) {
        $this = $(this);
        $this.each(function() {
            var idGenerate = new Date().getTime();

            $self = $(this);
            $self.attr('data-id', idGenerate);

            $container = $self.parent('.select-wrapper').parent();

            var onAutocompleteStandart = function(val) {
                $('select[name="' + nameSelect + '"][data-id="' + idGenerate + '"] option').removeAttr('selected');
                $('select[name="' + nameSelect + '"][data-id="' + idGenerate + '"] option').each(function() {
                    if (val.trim() == $(this).text().trim()) {
                        $(this).attr('selected', 'selected');
                    }
                });
            };

            var onAutocomplete = function() {

            };

            var settings = $.extend( {
                'onAutocomplete': onAutocomplete
            }, options);

            $self.parent('.select-wrapper').css('display', 'none');


            var dataAutoComplete = [];
            $self.find('option').each(function() {
                dataAutoComplete.push($(this).text());
            });

            var nameAutoComplete = $self.attr('name').replace('[]', '') + '-autocomplete';
            if ($self.attr('name').indexOf('[]') !== -1) {
                nameAutoComplete += '[]';
            }

            var idAutoComplete = nameAutoComplete + '-id-' + idGenerate;
            var inputAutoComplete = $("<input>", {
                'id': idAutoComplete,
                'name': nameAutoComplete,
                'class': 'autocomplete',
                'type': 'text'
            });

            $(this).data(idAutoComplete, dataAutoComplete);

            if ($self.find('option[selected]').text() != '') {
                inputAutoComplete.val($self.find('option[selected]').text());
            }

            $container.find('label').before(inputAutoComplete);
            $container.find('label').attr('for', idAutoComplete);

            var nameSelect = $self.attr('name');
            $container.find('input[name="' + nameAutoComplete + '"]').autocomplete({
                minLength: 0,
                data: $(this).data(idAutoComplete),
                onAutocomplete: function(val) {
                    onAutocompleteStandart(val);
                    settings.onAutocomplete(val);
                }
            });
        });
    };
})(jQuery);