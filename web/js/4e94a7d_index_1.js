jQuery(document).ready(function () {

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

    var search = $('#searchword').text();
    $("#searchproduct *").highlight(search, "highlight");
});


