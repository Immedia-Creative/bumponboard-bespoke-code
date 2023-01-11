//var baseUrl = 'https://www.bumponboard.co.uk/';
var baseUrl = window.location;

function special_func(user_id) {
    if (user_id > 0) {

        var user = user_id;
        let current_page_location = window.location.href;

        let popup = document.getElementById('bumponboard_iframe');
        // let popup = document.getElementById('bump-board-data-popup');

        let price = '';


        let image = baseUrl + 'wp-content/plugins/gift-picker/BOB-logo-Dark-Grey.png';

        let product_title = document.getElementsByTagName('title');
        let bob_product_title = product_title.length > 0 ? product_title[0].innerText : '';

        let priceTag = document.getElementById('priceblock_ourprice');
        price = priceTag ? priceTag.innerText : '';
        // console.log("P1", price);
        if (!price) {
            priceTag = document.getElementsByClassName('pdp-price');
            price = priceTag ? ((priceTag.length > 0) ? priceTag[0].innerText : '') : '';
            console.log("P2", price);

            if (!price) {
                let priceTag = document.getElementById('priceblock_dealprice');
                price = priceTag ? priceTag.innerText : '';
                console.log("P3", price);
                if (!price) {
                    let priceTag = document.getElementById('priceblock_saleprice');
                    price = priceTag ? priceTag.innerText : '';
                    console.log("P3", price);
                    if (!price) {
                        priceTag = document.getElementsByClassName('f_price');
                        price = priceTag ? ((priceTag.length > 0) ? priceTag[0].innerText : '') : '';
                        console.log("P4", price);

                        if (!price) {
                            priceTag = document.getElementsByClassName('price');
                            price = priceTag ? ((priceTag.length > 0) ? priceTag[0].innerText : ' ') : ' ';
                            console.log("price");
                        }
                    }
                }

            }
        }



        //priceBlockDealPriceString
        let imageData = document.getElementsByClassName('banner-image');
        image = imageData.length > 0 ? imageData[0].src : '';
        console.log("1", image);
        if (!image) {
            let imageData = document.getElementById('landingImage');
            image = imageData ? imageData.src : '';
            console.log("2", image);
            if (!image) {
                imageData = document.getElementsByClassName('image-grid-image');
                image = imageData.length > 0 ? imageData[0].style.backgroundImage.replace('url(', '').replace(')', '').replace(/\"/gi, "") : '';
                console.log("3", image);

                if (!image) {
                    let imageData = document.getElementsByTagName('video');
                    image = imageData.length > 0 ? imageData[0].poster : '';
                    console.log("4, Alibaba", image);
                }

                if (!image) {
                    let imageData = document.querySelectorAll('meta[property="og:image"]');
                    image = imageData.length > 0 ? imageData[0].content : '';
                    console.log("5, og", image);
                }

                if (!image) {
                    let x = 0;
                    // Last option get first image
                    let allImages = document.images;
                    for (let i = 0; i < allImages.length; i++) {
                        const element = allImages[i];
                        if (element.height > 100 && element.width > 100) {
                            image = element.src;
                            console.log("in", image, x);
                            // if(x>0){
                            break;
                            // }
                            x++;
                        }

                    }
                    console.log("out", image);
                }
            }
        }
        console.log("Final image", image);
        if (price != '') {

            price = parseFloat(price.replace(/[^\d\.]*/g, ''));
        }
        document.body.insertAdjacentHTML('beforeend', `<iframe allowtransparency="true" src="${baseUrl}wp-content/plugins/gift-picker/bob-gift-popup.html?&=bob${encodeURI(bob_product_title)}&=bob${encodeURI(price)}&=bob${encodeURI(image)}&=bob${encodeURI(current_page_location)}&=bob${encodeURI(user)}&=bob${encodeURI(baseUrl)}" name="bump-on-board_iframe" id="bumponboard_iframe" scrolling="no" style="border: none; height: 100%; width: 100%; position: fixed; z-index: 2147483647; top: 0px; left: 0px; background-color: transparent; clip: auto; overflow: hidden; opacity: 1; display: block !important; visibility: visible;"></iframe>`);
    } else {
        var url = baseUrl + "member-login";
        window.open(url, '_blank');
    }
}

// })();