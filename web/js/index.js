jQuery(document).ready(function () {

    if ($("#search_input").length > 0) {
        $("#search_input").autocomplete({
            minLength: 2,
            scrollHeight: 220,
            source: function(req, add) {
                return $.ajax({
                    url: $("#search_input").attr('data-url'),
                    type: "get",
                    dataType: "json",
                    data: "query=" + req.term,
                    async: true,
                    cache: true,
                    success: function(data) {
                        return add($.map(data, function(item) {
                            return {
                                nom: item.nom,
                                url: item.url
                            };
                        }));
                    }
                });
            },
            focus: function(event, ui) {
                $(this).val(ui.item.nom);
                return false;
            },
            select: function(event, ui) {
                window.location.href = ui.item.url;
                return false;
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li></li>").data("ui-autocomplete-item", item).append("<a href=\"" + item.url + "\">" + item.nom + "</span></a>").appendTo(ul.addClass("list-row"));
        };
    }


    jQuery.fn.highlight = function (str, className) {
        var regex = new RegExp(str, "gi");
        return this.each(function () {
            $(this).contents().filter(function() {
                return this.nodeType == 3 && (regex.test(this.nodeValue) || regex.test(this.nodeText));
            }).replaceWith(function() {
                    return (this.nodeValue || "").replace(regex, function(match) {
                        return "<span class=\"" + className + "\">" + match + "</span>";
                    });
                });
        });
    };

    var search = $('#search_input').text();
    $("#listmovies *").highlight(search, "highlight");
});


