var cart = {
	add: function(product_id, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {
				$('.alert-dismissible, .text-danger').remove();
				if (json['redirect']) {
					location = json['redirect'];
				}
				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success alert-dismissible">' + json['success'] + '</div>');
					$('#cart > button').html('<i class="fa fa-shopping-cart"></i> ' + json['total']);
					$('html, body').animate({ scrollTop: 0 }, 'slow');
					$('#cart').load('index.php?route=common/cart/info #cart > *');
				}
			}
		});
	}
};
