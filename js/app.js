$(document).ready(function(){

$('#transactionModal').on('show.bs.modal', function (event) {

    $('#alwaysCategorize').prop('checked', false);

    var button = $(event.relatedTarget) // Button that triggered the modal
    var date = button.data('date')
    var transactionId = button.data('transactionid') // Extract info from data-* attributes
    var rawdescription = button.data('rawdescription')
    var description = button.data('description')
    var category = button.data('category')
    var categorytype = button.data('categorytype')
    var budgetcategoryid = button.data('budgetcategoryid')
    var amount = button.data('amount')
    var modal = $(this)

    modal.find('#date').text(date)
    modal.find('#transactionId').val(transactionId)
    modal.find('#raw_description').text(rawdescription)
    modal.find('.description').text(description)
    modal.find('#category').text(category)
    modal.find('#category_type').text(categorytype)
    modal.find('#budgetcategoryid').text(budgetcategoryid)
    modal.find('#amount').text(amount)
});

$('.modal .form').append('<input type="hidden" name="ajax" value="true">');


$(document).on('submit', '.ajax-form', function(e){
    e.preventDefault();
    var $form = $(this);
    $.ajax({
        type     : "POST",
        cache    : false,
        url      : $form.attr('action'),
        data     : $form.serializeArray(),
        success  : function(data) {

            replaceWithResponse( data );
        
        }
    });
});


$(document).on('click', '.delete-category', function(e){
    e.preventDefault();
    var button = $(this);
    var budgetcategoryid = button.data('budgetcategoryid');
    var deleteRow = '#' + budgetcategoryid;
    var data = {
        action: "delete_category",
        budget_category_id: budgetcategoryid,
        ajax: true
    };
    var url = '/simpler/' + button.data('url');
    $.ajax({
        type     : "POST",
        cache    : false,
        url      : url,
        data     : data,
        success  : function(data) {

            replaceWithResponse( data );
        
        }
    });
    $(deleteRow).remove();
});

function replaceWithResponse( data ){
    var $transactionTable = $('#transactionTable');
    var $rightAside = $('#rightAside');
    var $transactionModal = $('#transactionModal');
    var $budgetModal = $('#budgetModal');
    $('#responseContainer').append( data );
    var newTable = $('#responseContainer #transactionTable');
    var newAside = $('#responseContainer #rightAside');
    var newTransactionModal = $('#responseContainer #transactionModal');
    var newBudgetModal = $('#responseContainer #budgetModal');
    $transactionTable.html(newTable.html());
    $rightAside.html(newAside.html());
    $transactionModal.html(newTransactionModal.html());
    $budgetModal.html(newBudgetModal.html());
    $('#responseContainer').empty();
    $('.modal .form').append('<input type="hidden" name="ajax" value="true">');
}

});