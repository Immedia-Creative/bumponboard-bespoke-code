// JavaScript Document

//$("input[type='checkbox']").change(function() {
$("#product-category input, #product-price input").change(function () {

    var category = [];
    var price = [];

    $("#product-category :radio").each(function () {
        var ischecked = $(this).prop("checked");
        if (ischecked) {
            var catVal = $(this).val();
            catVal = escape(catVal);
            category.push(catVal);
            category.join();
        }
    });

    $("#product-price :checkbox").each(function () {
        var ischecked = $(this).is(":checked");
        if (ischecked) {
            var priceVal = $(this).val();
            priceVal = escape(priceVal);
            price.push(priceVal);
            price.join();
        }
    });

    function getUrlVars() {
        var vars = [],
            hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
    var bumpID = getUrlVars()["bump-id"];

    //console.log("Categories:" + category);
    //console.log("Prices:" + price);
    //console.log("BumpID:" + bumpID);

    //Variables are sent to productajax function
    productajax(
        category,
        price,
        bumpID
    );

});

function productajax(category, price, bumpID) {

    /*
    $myteststring = "<p>Category string is ";
    $myteststring += category;
    $myteststring += "</p><p>price string is ";
    $myteststring += price;
    $myteststring += "</p><p>bump ID string is ";
    $myteststring += bumpID;
    $myteststring += "</p>";

    document.getElementById("myfilter").innerHTML = $myteststring;
    */

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            var response = this.responseText;
            //catch if no results are got from query
            //if (response.indexOf('product-box') > -1)
            //{
            document.getElementById("product-filter-response").innerHTML = response;
            //} else {
            //	document.getElementById("product-filter-response").innerHTML = 'No results to display, try refining your search.';
            //}

            return;
        }

    }

    xmlhttp.open("GET", "/wp-content/themes/immedia-child-theme/getdata.php?ajax=ajax&category=" + category + "&price=" + price + "&bumpID=" + bumpID, true);
    xmlhttp.send();
	reinitializeMasonry();

}

