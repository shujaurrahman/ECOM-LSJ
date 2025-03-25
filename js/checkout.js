jQuery(document).ready(function($) {
    $('#PayNow').click(function(e) {
        e.preventDefault();

        if (!$('#checkoutForm')[0].checkValidity()) {
            $('#checkoutForm')[0].reportValidity();
            return;
        }

        // Show loading state
        $('#PayNow')
            .prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        // Get form data
        var formData = new FormData($('#checkoutForm')[0]);
        formData.append('amount', $('#grandTotal').text().replace(/[^0-9]/g, ''));

        // Process payment
        $.ajax({
            type: 'POST',
            url: 'pg/process_payment.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success && response.redirectUrl) {
                    window.location.href = response.redirectUrl;
                } else {
                    alert('Payment initialization failed: ' + (response.error || 'Unknown error'));
                    resetButton();
                }
            },
            error: function(xhr, status, error) {
                console.error('Payment Error:', error);
                alert('Payment initialization failed. Please try again.');
                resetButton();
            }
        });
    });

    function resetButton() {
        $('#PayNow')
            .prop('disabled', false)
            .html('Place Order');
    }
});