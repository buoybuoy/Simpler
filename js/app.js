// $('#transactionModal').on('show.bs.modal', function (event) {
//   var button = $(event.relatedTarget) // Button that triggered the modal
//   var recipient = button.data('whatever') // Extract info from data-* attributes
//   // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
//   // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
//   var modal = $(this)
//   modal.find('.modal-title').text('New message to ' + recipient)
//   modal.find('.modal-body input').val(recipient)
// })

$('#transactionModal').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget) // Button that triggered the modal
    var transactionId = button.data('transactionid') // Extract info from data-* attributes
    var description = button.data('description')
    var amount = button.data('amount')

    var modal = $(this)
    console.log(transactionId)
    modal.find('#transactionId').val(transactionId)

    //
    modal.find('#description').text(description)
    modal.find('#amount').text(amount)
})

$('#budgetModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var modal = $(this)
})