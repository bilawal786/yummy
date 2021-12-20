
		"use strict";

		$(document).ready(function() {
			var paymentType = jQuery('#payment_type').val();
			if (paymentType == 15) {
				$('.stripe-payment-method-div').show('slow');
			} else {
				$('.stripe-payment-method-div').hide('slow');
			}
		});

		var style = {
			base: {
				iconColor: '#666EE8',
				color: '#000000',
				lineHeight: '40px',
				fontWeight: 300,
				fontFamily: 'Helvetica Neue',
				fontSize: '15px',
				'::placeholder': {
					color: '#000000',
				},
			},
			invalid: {
				color: '#fa755a',
				iconColor: '#fa755a'
			}
		};

		const stripe = Stripe(stripeKey, { locale: 'fr' }); // Create a Stripe client.
		const elements = stripe.elements(); // Create an instance of Elements.
		const cardElement = elements.create('card', { style: style }); // Create an instance of the card Element.
		const cardButton = document.getElementById('card-button');
		const clientSecret = cardButton.dataset.secret;

		cardElement.mount('#card-element'); // Add an instance of the card Element into the `card-element` <div>.

		// Handle real-time validation errors from the card Element.
		cardElement.addEventListener('change', function(event) {
			var displayError = document.getElementById('card-errors');
			if (event.error) {
				displayError.textContent = event.error.message;
			} else {
				displayError.textContent = '';
			}
		});

		// Handle form submission.
		var form = document.getElementById('payment-form');

		form.addEventListener('submit', function(event) {
			event.preventDefault();
			//console.log(tmp);
			var paymentType = jQuery('#payment_type').val();
			if (paymentType == 15) {
				stripe.handleCardPayment(clientSecret||tmp, cardElement, {
					payment_method_data: {
						//billing_details: { name: cardHolderName.value }
					},
					setup_future_usage: 'off_session'
				})
					.then(function(result) {
						console.log(result);
						if (result.error) {
							// Inform the user if there was an error.
							var errorElement = document.getElementById('card-errors');
							errorElement.textContent = result.error.message;
						} else {
							console.log(result);
							// token contains id, last4, and card type
							var pm = result.paymentIntent.payment_method;
							// insert the token into the form so it gets submitted to the server
							form.submit();
						}
					});
			}else{
				form.submit();
			}
		});

		$('.credit-card').click(function(){
			$('.bank').removeClass('active');
			$('.payment_type').val('15');
			$('.stripe-payment-method-div').show('slow');
			$(this).addClass('active');
		});
		$('.bank').click(function(){
			$('.credit-card').removeClass('active');
			$('.payment_type').val('20');
			$('.stripe-payment-method-div').hide('slow');
			$(this).addClass('active');
		});

		function stripeTokenHandler(token) {
			var form = document.getElementById('payment-form');
			var hiddenInput = document.createElement('input');
			hiddenInput.setAttribute('type', 'hidden');
			hiddenInput.setAttribute('name', 'stripeToken');
			hiddenInput.setAttribute('value', token.id);
			form.appendChild(hiddenInput);
			form.submit();
		}
