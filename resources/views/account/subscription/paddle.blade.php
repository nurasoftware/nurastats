<!doctype html>
<html lang="en">

<head>
    <title>Pricing page</title>
    <meta charset="utf-8" />
    <script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>

    <style type="text/css">
        .pricing-page-container {
            max-width: 900px;
            margin: auto;
            text-align: center;
            margin-top: 2em;
            padding-left: 1em;
            padding-right: 1em;
        }

        .pricing-grid {
            display: block;
            margin-bottom: 1em;
        }

        .pricing-grid .starter-plan {
            background-color: AliceBlue
        }

        .pricing-grid .pro-plan {
            background-color: HoneyDew
        }

        .pricing-grid .enterprise-plan {
            background-color: LavenderBlush
        }

        .pricing-grid>* {
            padding: 1rem;
        }

        @media (min-width: 768px) {
            .pricing-grid {
                display: grid;
                grid-auto-rows: 1fr;
                grid-template-columns: 1fr 1fr 1fr;
            }
        }
    </style>
    <!-- MVP.css: https://andybrewer.github.io/mvp/ -->
    <link rel="stylesheet" href="https://unpkg.com/mvp.css@1.12.0/mvp.css" media="print" onload="this.media='all'">

</head>


<body onLoad="getPrices(billingCycle)">



    <div class="pricing-page-container">
        <h1>Choose your plan</h1>
        <div class="pricing-toggle">
            <input type="radio" name="plan" value="month" id="month" onclick="getPrices('month')"><label for="month">Monthly</label>
            <input type="radio" name="plan" value="year" id="year" onclick="getPrices('year')" checked><label for="year">Yearly <sup>save 20%</sup></label>
        </div>
        <div class="pricing-grid">
            <div class="starter-plan">
                <h3>Starter</h3>
                <p id="starter-price">$100.00</p>
                <p><small>per user</small></p>
                <button>Sign up now</button>
            </div>
            <div class="pro-plan">
                <h3>Pro</h3>
                <p id="pro-price">$300.00</p>
                <p><small>per user</small></p>
                <button>Sign up now</button>
            </div>
            <div class="enterprise-plan">
                <h3>Enterprise</h3>
                <p>Contact us</p>
                <p><small>bespoke pricing</small></p>
                <button>Inquire now</button>
            </div>
        </div>

        <div class="country-selector">
            <select name="country" id="country" autocomplete="off">
                <option value="US">🇺🇸 United States</option>
                <option value="GB">🇬🇧 United Kingdom</option>
                <option value="ES">🇪🇸 Spain</option>
                <option value="IN">🇮🇳 India</option>
                <option value="US">🌍 Other</option>
            </select>
        </div>
    </div>

</body>

<script type="text/javascript">
    Paddle.Environment.set("sandbox");
    Paddle.Setup({
        token: 'test_4094d26520950900fbb966e5530' // replace with a client-side token
    });

    // define products and prices
    var websiteBasicProduct = 'pro_01hhyb7h0wgaqdh147as26gybz';
    var websitePlusProduct = 'pro_01hhyb95yy98zaawq2s5x2c3nc';
    var monthItems = [{
            quantity: 1,
            priceId: 'pri_01hhybsfb3hamsbyyv13ke9978',
        },
        {
            quantity: 1,
            priceId: 'pri_01hhycg7bt42xtd77dmq9937sd',
        }
    ];
    var yearItems = [{
            quantity: 1,
            priceId: 'pri_01hpvs7ht6tvp3ah9r1228qmbb',
        },
        {
            quantity: 1,
            priceId: 'pri_01hpvsb70hze65vxx59f7nydsn',
        }
    ];

    // DOM queries
    var starterPriceLabel = document.getElementById("starter-price");
    var proPriceLabel = document.getElementById("pro-price");

    // set initial billing cycle
    var billingCycle = 'year'

    // set initial country
    var billingCountry = 'US';

    // choose country
    var dropdown = document.getElementById("country");
    dropdown.addEventListener("change", function() {
        billingCountry = dropdown.value;
        console.log("country changed: " + billingCountry + "cycle: " + billingCycle);
        getPrices(billingCycle)
    });

    // get prices
    function getPrices(cycle) {
        if (cycle === 'month') {
            var billingCycle = cycle;
            var itemsList = monthItems;
        } else if (cycle === 'year') {
            var billingCycle = cycle;
            var itemsList = yearItems;
        }

        var request = {
            items: itemsList,
            address: {
                countryCode: billingCountry
            }
        }

        Paddle.PricePreview(request)
            .then((result) => {
                console.log(result);

                var items = result.data.details.lineItems;
                for (item of items) {
                    if (item.product.id === websiteBasicProduct) {
                        starterPriceLabel.innerHTML = item.formattedTotals.subtotal
                        console.log('starter ' + item.formattedTotals.subtotal)
                    } else if (item.product.id === websitePlusProduct) {
                        proPriceLabel.innerHTML = item.formattedTotals.subtotal
                        console.log('pro ' + item.formattedTotals.subtotal)
                    }
                }
            })
            .catch((error) => {
                console.error(error);
            });
    }
</script>


</html>
