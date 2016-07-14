/**
 * Created by Bram on 14-7-2016.
 */

// Functions

function deleteProduct(productID) {

    var isConfirmed = confirm("Wilt u dit product definitief verwijderen?");
    if(isConfirmed) {

        var data = {'id' : productID};
        $.ajax({
            type: 'POST',
            url: 'delete_product.php',
            data: data,
            dataType: 'json'
        }).done(function() {
            // reload page
            console.log('test');
           location.reload();
        }).fail(function(error) {
            alert('Er ging iets fout, melding: \n' + error.responseText);
        });
    }
} // end deleteProduct()
