// Function: Opens the booking modal and sets values
function openBooking(id, price) {
    const modal = document.getElementById('bookingModal');
    const inputId = document.getElementById('item_id');
    const inputPrice = document.getElementById('price_per_day');
    
    if (modal && inputId && inputPrice) {
        inputId.value = id;
        inputPrice.value = price; 
        modal.style.display = 'block';
        calculateTotal(); 
    }
}

function calculateTotal() {
    const priceHolder = document.getElementById('price_per_day');
    const daysInput = document.getElementById('days');
    const display = document.getElementById('total_price');

    if (priceHolder && daysInput && display) {
        const price = parseFloat(priceHolder.value) || 0;
        const days = parseInt(daysInput.value) || 1;
        const total = price * days;
        
        // Updates the display using Indian English locale (en-IN) for Rupee formatting
        display.innerText = total.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
}
document.addEventListener('input', function (e) {
    if (e.target.id === 'days') {
        calculateTotal();
    }
});

function closeBooking() {
    const modal = document.getElementById('bookingModal');
    const form = document.getElementById('manage-booking');
    if (modal) modal.style.display = 'none';
    if (form) form.reset();
}

// AJAX Submission Logic
document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('manage-booking');
    if(bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('ajax.php?action=save_booking', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() == "1") {
                    alert("Success! Your booking has been saved.");
                    location.reload();
                } else {
                    alert("Error saving booking.");
                }
            });
        });
    }
});

function deleteItem(id) {
    if (confirm("Are you sure you want to delete this item? This cannot be undone.")) {
        fetch('ajax.php?action=delete_item', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() == "1") {
                alert("Item successfully deleted.");
                location.reload(); 
            } else {
                alert("An error occurred while deleting the item.");
            }
        });
    }
}