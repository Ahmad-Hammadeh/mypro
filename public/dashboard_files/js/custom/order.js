$(document).ready(function() {

    //add product btn
    $('.add-product-btn').on('click', function(e) {

        e.preventDefault();

        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $.number($(this).data('price'), 2, '.', ''); // Call The "$.number" Method Of Jquery Number Plugin
        var html = `<tr>
                        <td>${name}</td>
                        <td><input class="quantity" type="number" name="product[${id}][quantity]" data-price="${price}" value="1" min="1"></td>
                        <td class="quantity-price">${price}</td>
                        <td><a class="remove-product-btn btn btn-danger btn-sm" data-id="${id}" href="#"><i class="fa fa-trash"></i></a></td>
                    </tr>`;
        // Add The Product To Order List
        $('#add_order table .order-list').append(html);
        
        // Make This Button For Added Product Disables
        $(this).removeClass('btn-success').addClass('btn-default disabled');

        // Call Total Price Calculation Function
        totalCalculate();

    }); // End Add Product Button

    // Remove Product button
    $('body').on('click', '.remove-product-btn', function(e){

        e.preventDefault();

        var id = $(this).data('id');

        // Remove The Product From Order List
        $(this).closest('tr').remove();

        // Readd Success Class To The Add Button Of This Product
        $(`#product-${id}`).removeClass('btn-default disabled').addClass('btn-success');

        // Call Total Price Calculation Function
        totalCalculate();

    }); // End Remove Product button

    // Change Total Price Of The Product And The Order When Change The quantity Of The Product
     $('body').on('keyup change', '.quantity', function(){

        var unitPrice = Number( $(this).data('price') ), // Call The Native "number" Method Of Javescript
            quantity = parseInt( $(this).val() ),
            quantityPrice = unitPrice * quantity;

        $(this).parent('td').next('.quantity-price').number(quantityPrice, 2,'.', ''); // Call The "number" Method Of Jquery Number Plugin

        totalCalculate();

     });  // End Change Total Order Price When Change The quantity
    
    // Make Element With Atrribute "disabled" Disabled Realy
    $('body').on('click', '.disabled', function(e){
        
        e.preventDefault();
        
    }); // End Disabled Function
    
}); //end of document ready

// Calculate Total Order Price Function
function totalCalculate(){

    var totalPrice = 0;

    $('.quantity-price').each(function(){

        totalPrice += Number( $(this).text() ); // Call The Native "number" Method Of Javescript

    });

    $('#total-price').number( totalPrice, 2, '.', '' ); // Call The "number" Method Of Jquery Number Plugin

    // Toggle Disabled Class On Add Order Button
    if (totalPrice > 0) {

        $('#add-order-form-btn').removeClass('disabled');

    } else {

        $('#add-order-form-btn').addClass('disabled');
        
    }

} // End Calculate Total Order Price Function