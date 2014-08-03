;(function ($) {
    $(function () {
        var $ul = $('.pkj-selectedlist');
        var $adders = $('.pkj-selectlist-add');

        $ul.on('click', '.ntdelbutton', function () {
            $(this).parents('span').remove();
            console.log("test");
        });

        var cache = {};
        $adders.autocomplete({
            source: function( request, response ) {
                var term = request.term;
                if ( term in cache ) {
                    response( cache[ term ] );
                    return;
                }
                $.post(ajaxurl, {
                        'action': 'pkj_search_post_types'
                    },
                    function (result) {
                        $.each(result.data.lookup, function (index, item) {
                            cache[index] = {value: index, label: item};
                        });
                        response( cache );
                    }
                );
            },
            select: function( event, ui ) {
                var label = ui.item.label;
                var type = ui.item.value;
                var $input = $(event.target);
                var section = $input.data('section');

                var selectedElements = $('input[name="pkj-any-parent-post_types['+section+'][]"]');
                var currentVals = [];
                $.each(selectedElements, function () {
                    currentVals.push($(this).val());
                });

                if ($.inArray(type, currentVals) === -1) {
                    var item = $([
                        '<span>',
                        '<input name="pkj-any-parent-post_types['+section+'][]" type="hidden" value="'+type+'" />',
                        '<a  class="ntdelbutton">X</a>&nbsp;',
                        label,
                        '</span>'
                    ].join(''));
                    $('.pkj-selectedlist[data-section="'+section+'"]').append(item);
                }

                $input.val('');
                return false;
            }
        });


    });
})(jQuery);