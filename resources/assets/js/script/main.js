$(document).ready(function() {
var Cart = function(formClass, changeClass, classRemove, product, prefix, empty_cartClass, cart_infoClass){
    // for local use     
    this.formClass = formClass; // class for form submit
    this.changeClass = changeClass; // class using on + and - btns on products 
    this.classRemove = classRemove; // class btn for remove 
    this.product = product; // block of whole product
    this.prefix = prefix; // prefix using in funct
    this.empty_cart = empty_cartClass; // Class of block with empty cart
    this.cart_info = cart_infoClass; //Class of block with cart information 



    // for use inside function
    var formClass = this.formClass;
    var classChange = this.changeClass;
    var classRemove = this.classRemove;
    var product = this.product;
    var prefix = this.prefix;
    var empty_cart = this.empty_cart;
    var cart_info = this.cart_info;


    // init function , add watchers on clasess
    this.init = function(){
            $('body').on('submit', formClass, function(event) {
                event.preventDefault();
                CartSend_form($(this));
            });
            $('body').on('click', classChange, function(event) {
                event.preventDefault();
                CartSend_link($(this));
            });
            $('body').on('click', classRemove, function(event) {
                event.preventDefault();
                cartRemove($(this));
            });
        };

    // function for update widget
    //get data from server parse it
    //and update value by name
    var widgetUpdate = function(data){
        if ($(empty_cart).is(':visible')) {
            $(empty_cart).hide();
            $(cart_info).show();
        }
        var object =  JSON.parse(data);
        $.each(object, function(index, value) {
            $(prefix+''+index).html(value)
        })
    };

    // function for update whole cart page
    //get data from server parse it
    //and update value by name
    var pageUpdate = function(data){
        var object =  JSON.parse(data);
        $.each(object.items, function(index, value) {
            $.each(value, function(i, val) {
                $('#'+value.id).find(prefix+''+i).val(val)
                $('#'+value.id).find(prefix+''+i).html(val)
            });
        });
    };

    //Function send form , this function
    //using for add product on product page
    //and product list
    var CartSend_form = function(form){
        var action = $(form).attr('action')
        var str = $(form).serialize();
         $.ajax({
            type: 'POST',
            data: str,
            url : action,
            success: function(data) {
                widgetUpdate(data);
            }
        })
    };

    //Function send request to server by
    //adress in href of link
    var CartSend_link = function(el){
        var action = $(el).attr('href')
         $.ajax({
            type: 'POST',
            data: {_token:static_token},
            url : action,
            success: function(data) {
                widgetUpdate(data);
                pageUpdate(data);
            }
        })
    };

    //Function send request to server by 
    //adress in href of link, and remove product
    //on success
    var cartRemove = function(el){
        var action = $(el).attr('href');
         $.ajax({
            type: 'POST',  
            data: {_token:static_token},
            url : action,
            success: function(data) {
                $(el).closest(product).remove();
                widgetUpdate(data);
                pageUpdate(data);
            }
        })
    }


}

}); 
