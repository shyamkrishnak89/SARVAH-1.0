$(document).ready(function () {
	$(document).on('click', '#checkAll', function () {
		$(".itemRow").prop("checked", this.checked);
	});
	$(document).on('click', '.itemRow', function () {
		if ($('.itemRow:checked').length == $('.itemRow').length) {
			$('#checkAll').prop('checked', true);
		} else {
			$('#checkAll').prop('checked', false);
		}
	});
	var count = $(".itemRow").length;
	$(document).on('click', '#addRows', function () {
		count++;
		var htmlRows = '';
		htmlRows += '<tr>';
		htmlRows += '<td><input class="itemRow" type="checkbox"></td>';
		htmlRows += '<td><input type="text" name="productCode[]" id="productCode_' + count + '" class="form-control" autocomplete="off"></td>';
		htmlRows += '<td><input type="text" name="productName[]" id="productName_' + count + '" class="form-control" autocomplete="off" readonly></td>';
		htmlRows += '<td><input type="number" name="quantity[]" id="quantity_' + count + '" class="form-control quantity" autocomplete="off"></td>';
		htmlRows += '<td><input type="number" name="price[]" id="price_' + count + '" class="form-control price" autocomplete="off" readonly></td>';
		htmlRows += '<td><input type="number" name="total[]" id="total_' + count + '" class="form-control total" autocomplete="off"></td>';
		htmlRows += '</tr>';
		$('#invoiceItem').append(htmlRows);
	});
	$(document).on('click', '#removeRows', function () {
		$(".itemRow:checked").each(function () {
			$(this).closest('tr').remove();
		});
		$('#checkAll').prop('checked', false);
		calculateTotal();
	});
	$(document).on('blur', "[id^=quantity_]", function () {
		calculateTotal();
	});
	// $(document).on('blur', "[id^=price_]", function () {
	// 	calculateTotal();
	// });
	// $(document).on('blur', "#taxRate", function(){		
	// 	calculateTotal();
	// });	
	$(document).on('blur', "#amountPaid", function () {
		var amountPaid = $(this).val();
		var paymentTillNow = $('#previousPayment').val();
		var totalAftertax = $('#totalAftertax').val();
		var due = totalAftertax - paymentTillNow;
		if (amountPaid && totalAftertax) {
			due = due - amountPaid;
			$('#amountDue').val(due);
		} else {
			$('#amountDue').val(due);
		}
		paymentTillNow = paymentTillNow + amountPaid;
		console.log("Payment till now: "+paymentTillNow);
		$('#spreviousPayment').val(parseFloat(paymentTillNow));
	});
	$(document).on('click', '.deleteInvoice', function () {
		var id = $(this).attr("id");
		if (confirm("Are you sure you want to remove this?")) {
			$.ajax({
				url: "action.php",
				method: "POST",
				dataType: "json",
				data: { id: id, action: 'delete_invoice' },
				success: function (response) {
					if (response.status == 1) {
						$('#' + id).closest("tr").remove();
					}
				}
			});
		} else {
			return false;
		}
	});
	$('#print_table').click(function(){
		
    
		var data = $('#card-body').clone();
		var ns = $('noscript').clone();
			 ns.append(data)
	var nw = window.open('','_blank','width=900,height=600')
	nw.document.write("<style> #print_table{display:none;} </style>");
	nw.document.write("<style> #create_excel{display:none;} </style>");
	nw.document.write('<p class="text-center"><b>കിഴുത്തുള്ളി ശ്രീ മഹാവിഷ്ണു ക്ഷേത്രം നെടുമ്പാൾ</b></p>');
	nw.document.write("<style> .datatable-top{display:none;} .datatable-bottom{display:none;} </style>");
	nw.document.write("<style> th:nth-child(5){display:none;} </style>");
	nw.document.write("<style> td:nth-child(5){display:none;} </style>");
	nw.document.write("<style> th:nth-child(6){display:none;} </style>");
	nw.document.write("<style> td:nth-child(6){display:none;} </style>");
	nw.document.write("<style> th:nth-child(7){display:none;} </style>");
	nw.document.write("<style> td:nth-child(7){display:none;} </style>");
	nw.document.write(ns.html());
	nw.document.write("<p><br><br><br><br><br><br><br><br>&emsp;   &emsp; &emsp;Prepared By   &emsp;  &emsp;   &emsp;  &emsp;Verified By    &emsp;  &emsp;   &emsp;  &emsp;  Approved By   </p>");
	nw.document.write("<p><br><br><br>&emsp;   &emsp; &emsp;Treasurer   &emsp;  &emsp;   &emsp;  &emsp; &emsp;Secretary    &emsp;  &emsp;   &emsp; &emsp; &emsp;  President   </p>");
		nw.document.close()
		nw.print()
		setTimeout(() => {
			nw.close()
		}, 500);
	});
});
function calculateTotal() {
	var totalAmount = 0;
	$("[id^='price_']").each(function () {
		var id = $(this).attr('id');
		id = id.replace("price_", '');
		var price = $('#price_' + id).val();
		var quantity = $('#quantity_' + id).val();
		if (!quantity) {
			quantity = 1;
		}
		var total = price * quantity;
		$('#total_' + id).val(parseFloat(total));
		totalAmount += total;
		console.log("total of "+id+" is"+total);
	});
	$('#subTotal').val(parseFloat(totalAmount));
	var paymentTillNow = $('#previousPayment').val();
	var subTotal = $('#subTotal').val();
	console.log("Subtotal=" + subTotal);
	$('#totalAftertax').val(parseFloat(totalAmount));
	var amountPaid = $('#amountPaid').val();
	var totalAftertax = $('#totalAftertax').val();	
	if(amountPaid && totalAftertax) {
				totalAftertax = totalAftertax-paymentTillNow;			
				$('#amountDue').val(totalAftertax);
			} else {		
				$('#amountDue').val(subTotal);
			}
}



