CarGurus = window.CarGurus || { DealRatingBadge: { } };
CarGurus.DealRatingBadge.options = {
 "style": "STYLE1",
 "minRating": "GOOD_PRICE",
 "defaultHeight": "60"
};

(function() {
    var script = document.createElement('script');
    script.src = "https://static.cargurus.com/js/api/en_US/1.0/dealratingbadge.js";
    script.async = true;
    var entry = document.getElementsByTagName('script')[0];
    entry.parentNode.insertBefore(script, entry);
})();