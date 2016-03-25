$('#transactionModal').on('show.bs.modal', function (event) {

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
})

$('#budgetModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var modal = $(this)
})

$('#transactionForm').append(
    '<input type="hidden" name="ajax" value="true">'
);

$('#transactionForm').submit(function(e){
    e.preventDefault();
    var $form = $(this);
    $.ajax({
        async    : true,
        type     : "POST",
        cache    : false,
        url      : $form.attr('action'),
        data     : $form.serializeArray(),
        success  : function(data) {
            replaceWithResponse( data );
        }
    });
    
    // var $modal = $form.data('modal');
    // $($modal).modal('toggle');
    // console.log($modal);
});

function ajaxRequest(url, sendData){
    var result = $.post( url, sendData, function(){
        console.log('sent');
    })
    .done(function(data){
        replaceWithResponse( data );
    })
    .fail(function(data){
        console.log('failed');
        console.log(data);
    });
}
var $transactionTable = $('#transactionTable');
var $rightAside = $('#rightAside');

function replaceWithResponse( data ){
    $('#responseContainer').append( data );
    var newTable = $('#responseContainer #transactionTable');
    var newAside = $('#responseContainer #rightAside');
    $transactionTable.html(newTable.html());
    $rightAside.html(newAside.html());
    $('#responseContainer').empty();
}

$('.delete-category').on('click', function(e){
    e.preventDefault();
    var button = $(this);
    var budgetcategoryid = button.data('budgetcategoryid');
    var deleteRow = '#' + budgetcategoryid;
    var data = {
        action: "delete_category",
        budget_category_id: budgetcategoryid,
        ajax: true
    }
    var url = '/simpler/' + button.data('url');
    
    ajaxRequest(url, data);
    $(deleteRow).remove();
})