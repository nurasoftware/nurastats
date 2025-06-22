<style type="text/css">
    .container {
        display: flex;
        flex-direction: row;
        margin-left: auto;
        margin-right: auto;
        width: 80%;
        min-height: 100vh;
    }

    .column {
        width: 50%;
    }
</style>
<!-- Paddle include -->
<script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>

{{-- {{ dd($checkout->options()) }} --}}

<div class="card">
    <div class="card-body">
        <div class="container">
            <div class="column">
                <div class="fw-bold fs-4">Order summary</div>

                <div id="items-table"></div>

                <div class="fw-bold fs-5 mt-4">To pay today</div>
                <div>Subtotal: <span class="currency">USD</span><span id="subtotal">0.00</span></div>
                <div>Tax: <span class="currency">USD</span><span id="tax">0.00</span></div>
                <div class="fw-bold">Total: <span class="currency">USD</span><span id="total">0.00</span></div>

                <div class="fw-bold fs-5 mt-4">To pay each <span id="recurring-interval">period</span></div>
                <div>Subtotal: <span class="currency">USD</span><span id="recurring-subtotal">0.00</span></div>
                <div>Tax: <span class="currency">USD</span><span id="recurring-tax">0.00</span></div>
                <div>Total: <span class="currency">USD</span><span id="recurring-total">0.00</span></div>
            </div>

            <div class="checkout-container column"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // set up Paddle
    Paddle.Environment.set("sandbox");
    Paddle.Setup({
        token: '{{ config('clevada.paddle_client_side_token') }}',
        eventCallback: function(event) {
            if (event.name == "checkout.loaded" || event.name == "checkout.items.updated") {
                //console.log(event); // useful for debugging
                const data = event.data;
                displayProductsInTable(data.items);
                displayTotals(data);
            }
        },
    });

    // DOM queries
    const itemsTable = document.getElementById("items-table");
    const currencyLabels = document.querySelectorAll(".currency");
    const subtotalEl = document.getElementById("subtotal");
    const taxEl = document.getElementById("tax");
    const totalEl = document.getElementById("total");
    const recurringSubtotalEl = document.getElementById("recurring-subtotal");
    const recurringTaxEl = document.getElementById("recurring-tax");
    const recurringTotalEl = document.getElementById("recurring-total");

    // update items table
    function displayProductsInTable(items) {
        let table = "<table class='table'>\n<tr><th>Product Name</th><th>Subtotal</th></tr>\n";
        items.forEach(({
            product,
            quantity,
            totals
        }) => {
            table += `<tr><td>${product.name}</td><td>${totals.subtotal.toFixed(2)}</td></tr>\n`;
        });
        table += "</table>";
        itemsTable.innerHTML = table;
    }

    // update totals
    function displayTotals({
        currency_code,
        totals,
        recurring_totals
    }) {
        for (const currencyLabel of currencyLabels) {
            currencyLabel.innerHTML = currency_code + " ";
        }
        // one-time
        subtotalEl.innerHTML = totals.subtotal.toFixed(2);
        taxEl.innerHTML = totals.tax.toFixed(2);
        totalEl.innerHTML = totals.total.toFixed(2);
        // recurring
        if (typeof recurring_totals !== "undefined") {
            recurringSubtotalEl.innerHTML = recurring_totals.subtotal.toFixed(2);
            recurringTaxEl.innerHTML = recurring_totals.tax.toFixed(2);
            recurringTotalEl.innerHTML = recurring_totals.total.toFixed(2);
        }
    }

    // open checkout
    Paddle.Checkout.open({
        settings: {
            displayMode: "inline",
            locale: "en",
            frameTarget: "checkout-container",
            frameInitialHeight: "500",
            frameStyle: "width: 100%; min-width: 312px; background-color: transparent; border: none;"
        },
        items: [
            @foreach ($checkout->options()['items'] as $item)
                {
                    priceId: '{{ $item['priceId'] }}',
                    quantity: {{ $item['quantity'] }}
                },
            @endforeach
        ],
        customer: {
            email: "{{ $user->email }}",
        }
    });
</script>
