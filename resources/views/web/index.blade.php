<!DOCTYPE html>
<html class="no-js" lang="en">

<head>

    <title>Clevada Analytics</title>
    <meta name="description" content="Clevada Analytics - a better alternative to Google Analytics">

    @include('web.global.head')

</head>

<body>

    @include('web.global.navigation')

    <!-- ========================= Top section start ========================= -->
    <section id="home" class="section-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="section-content">
                        <h1 class="wow fadeInUp" data-wow-delay=".3s">Clevada Analytics - a better alternative to Google Analytics</h1>

                        <p class="wow fadeInUp" data-wow-delay=".5s">
                            {{ __('We comply by design with all privacy policies. Including: GDPR, PECR, CCPA and more. We never, ever store any personal data about your visitors. No cookie banners.') }}
                        </p>

                        <p class="wow fadeInUp" data-wow-delay=".5s">
                            {{ __("Switching to Clevada Analytics will still give you visibility into how visitors are using your website, but you'll also be respecting their right to privacy.") }}
                        </p>

                        <div class="custom-btn">
                            <a href="#portfolio" class="main-btn border-btn btn-hover me-4" data-wow-delay=".5s">Features</a>
                            <a href="#contact" class="main-btn border-btn btn-hover" data-wow-delay=".5s">Demo</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="top-img wow fadeInUp" data-wow-delay=".5s">
                        <img class="img-fluid" src="{{ config('app.cdn') }}/assets/img/cms/business/hero.png" alt="Clevada Analytics">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================= Top section end ========================= -->


    <!-- ========================= Services section start ========================= -->
    <a class="anchor" href="#" id="services"></a>
    <section class="features-section pt-10">
        <div class="container">

            <div class="row justify-content-center">

                <h1 class="mb-3 wow fadeInUp text-center" data-wow-delay=".2s">{{ __('Why Clevada Analytics') }}</h1>

                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single-feature">
                        <div class="icon icon.color-1">
                            <i class="bi bi-shield-lock"></i>
                        </div>

                        <div class="content">
                            <h3 class="fs-4">{{ __('No need for cookie banners or GDPR consent') }}</h3>
                            <p>Clevada Analytics is privacy-friendly analytics. Cookies are not used and no personal data is collected. There are no persistent identifiers. No cross-site or cross-device tracking either.
                            </p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#features" class="btn btn-light wow fadeInUp mt-2 mb-2 btn-sm" data-wow-delay=".6s">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single-feature">
                        <div class="icon icon.color-1">
                            <i class="bi bi-speedometer2"></i>
                        </div>

                        <div class="content">
                            <h3 class="fs-4">{{ __('Lightweight script that keeps your site speed fast') }}</h3>
                            <p>Clevada Analytics is lightweight analytics. Our script size is only 15kb, several dozen times smaller than Google Analytics. Your page weight will be cut down, your site will load faster.
                            </p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#features" class="btn btn-light wow fadeInUp mt-2 mb-2 btn-sm" data-wow-delay=".6s">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single-feature">
                        <div class="icon icon.color-1">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div class="content">
                            <h3 class="fs-4">{{ __('Track visitors, goal conversions, events and campaigns') }}</h3>
                            <p>Answer the important questions about your visitors, content and referral sources. Analyze campaigns and custom events. Track engagement metrics like scroll depth, bounce rate, and time
                                spent on page.</p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#features" class="btn btn-light wow fadeInUp mt-2 mb-2 btn-sm" data-wow-delay=".6s">Read More</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-2">
                        <p class="wow fadeInUp mb-3" data-wow-delay=".4s">
                            The main purpose of digital consultancy services is to help companies and organizations achieve their goals in innovation and digital transformation in the most efficient way and stay relevant
                            in the market using information technology and digital channels.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- ========================= Services section end ========================= -->


    <!-- ========================= Portfolio start ========================= -->
    <a class="anchor" href="#" id="portfolio"></a>
    <section class="my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-2">
                        <h1 class="mb-3 wow fadeInUp" data-wow-delay=".2s">Our Portfolio</h1>
                        <p class="wow fadeInUp" data-wow-delay=".4s">
                            We enable a digital, globally connected business world by helping you & your customers realize the power of data for human innovation. With our business consulting approach, methodology and
                            skills, we work with you to select together business goals, organize
                            data sharing and boost your ability to innovate.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-4">

                <!-- Portfolio item -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a data-fancybox="gallery" href="assets/img/portfolio/portfolio1_big.jpg" class="mx-auto d-block">
                        <img class="img-fluid mb-4 mx-auto d-block wow fadeInUp" src="assets/img/portfolio/portfolio1.jpg" alt="Portfolio">
                    </a>
                </div>
                <!-- End Portfolio item -->

                <!-- Portfolio item -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a data-fancybox="gallery" href="assets/img/portfolio/portfolio2_big.jpg" class="mx-auto d-block">
                        <img class="img-fluid mb-4 mx-auto d-block wow fadeInUp" src="assets/img/portfolio/portfolio2.jpg" alt="Portfolio">
                    </a>
                </div>
                <!-- End Portfolio item -->

                <!-- Portfolio item -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a data-fancybox="gallery" href="assets/img/portfolio/portfolio3_big.jpg" class="mx-auto d-block">
                        <img class="img-fluid mb-4 mx-auto d-block wow fadeInUp" src="assets/img/portfolio/portfolio3.jpg" alt="Portfolio">
                    </a>
                </div>
                <!-- End Portfolio item -->

                <!-- Portfolio item -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a data-fancybox="gallery" href="assets/img/portfolio/portfolio4_big.jpg" class="mx-auto d-block">
                        <img class="img-fluid mb-4 mx-auto d-block wow fadeInUp" src="assets/img/portfolio/portfolio4.jpg" alt="Portfolio">
                    </a>
                </div>
                <!-- End Portfolio item -->

                <!-- Portfolio item -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a data-fancybox="gallery" href="assets/img/portfolio/portfolio5_big.jpg" class="mx-auto d-block">
                        <img class="img-fluid mb-4 mx-auto d-block wow fadeInUp" src="assets/img/portfolio/portfolio5.jpg" alt="Portfolio">
                    </a>
                </div>
                <!-- End Portfolio item -->

                <!-- Portfolio item -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a data-fancybox="gallery" href="assets/img/portfolio/portfolio6_big.jpg" class="mx-auto d-block">
                        <img class="img-fluid mb-4 mx-auto d-block wow fadeInUp" src="assets/img/portfolio/portfolio6.jpg" alt="Portfolio">
                    </a>
                </div>
                <!-- End Portfolio item -->

                <!-- Portfolio item -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a data-fancybox="gallery" href="assets/img/portfolio/portfolio7_big.jpg" class="mx-auto d-block">
                        <img class="img-fluid mb-4 mx-auto d-block wow fadeInUp" src="assets/img/portfolio/portfolio7.jpg" alt="Portfolio">
                    </a>
                </div>
                <!-- End Portfolio item -->

                <!-- Portfolio item -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a data-fancybox="gallery" href="assets/img/portfolio/portfolio8_big.jpg" class="mx-auto d-block">
                        <img class="img-fluid mb-4 mx-auto d-block wow fadeInUp" src="assets/img/portfolio/portfolio8.jpg" alt="Portfolio">
                    </a>
                </div>
                <!-- End Portfolio item -->

            </div>
        </div>
    </section>
    <!-- ========================= Portfolio end ========================= -->


    <!-- ========================= FAQ start ========================= -->
    <a class="anchor" href="#" id="faq"></a>
    <section class="my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-2">
                        <h1 class="mb-3 wow fadeInUp" data-wow-delay=".2s">F.A.Q.</h1>
                        <p class="wow fadeInUp" data-wow-delay=".4s">Here you can find the answers to Frequently Asked Questions</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-4">
                <div class="accordion" id="accordionFAQ">

                    <div class="accordion-item">
                        <h4 class="accordion-header" id="heading_1">
                            <button class="accordion-button faq_title" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_1" aria-expanded="true" aria-controls="collapse_1">
                                <b>Maecenas dictum eros ornare gravida placerat?</b>
                            </button>
                        </h4>
                        <div id="collapse_1" class="accordion-collapse collapse show" aria-labelledby="heading_1" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body">
                                <p><b>Maecenas dictum eros ornare gravida placerat. Nam cursus, risus eget sollicitudin convallis, velit ligula vehicula leo, sed tincidunt justo mauris sit amet metus.</b> Ut mollis, ante
                                    eget tincidunt consequat, diam
                                    urna consequat lacus, sit amet sollicitudin leo libero rhoncus dolor. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ut bibendum tortor. Sed quis porta ligula.
                                    Phasellus ac iaculis ex, sit amet
                                    viverra nulla. Proin vehicula finibus turpis. In hac habitasse platea dictumst. Suspendisse in volutpat est.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h4 class="accordion-header" id="heading_2">
                            <button class="accordion-button collapsed faq_title" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_2" aria-expanded="false" aria-controls="collapse_2">
                                <b>Curabitur facilisis risus et volutpat porttitor?</b>
                            </button>
                        </h4>
                        <div id="collapse_2" class="accordion-collapse collapse" aria-labelledby="heading_2" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body">
                                <p>Curabitur facilisis risus et volutpat porttitor. Pellentesque eget porta justo. Phasellus ut nibh non nibh luctus egestas vel eu ante. Curabitur viverra lectus nec risus tempor
                                    consectetur. Praesent a varius risus. Proin nec consequat massa. Mauris sodales
                                    risus nibh, ac dictum nunc bibendum nec.</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h4 class="accordion-header" id="heading_3">
                            <button class="accordion-button collapsed faq_title" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_3" aria-expanded="false" aria-controls="collapse_3">
                                <b>Fusce id urna rutrum, dictum nisi ut, tristique quam?</b>
                            </button>
                        </h4>
                        <div id="collapse_3" class="accordion-collapse collapse" aria-labelledby="heading_3" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body">
                                <p>Fusce id urna rutrum, dictum nisi ut, tristique quam. Proin vehicula euismod ex eu malesuada. Ut finibus orci sit amet eros accumsan, a laoreet metus malesuada. Vestibulum eu orci
                                    felis. Donec in dignissim elit, eu consequat felis. Sed porta, urna vel
                                    tristique fringilla, tellus mi accumsan quam, et scelerisque leo lacus id mauris. Curabitur scelerisque eget risus vitae dapibus.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!-- ========================= FAQ end ========================= -->


    <!-- ========================= Pricing start ========================= -->
    <a class="anchor" href="#" id="pricing"></a>
    <section class="pricing-table section my-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-2">
                        <h1 class="mb-3 wow fadeInUp" data-wow-delay=".2s">Pricing Plans</h1>
                        <p>Donec urna nulla, tristique et suscipit lacinia, dignissim sit amet lectus. Pellentesque quam arcu, feugiat at tellus in, venenatis fermentum lectus. Suspendisse potenti.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="single-table wow fadeInUp" data-wow-delay=".3s">
                        <div class="table-head">
                            <h4 class="title">Basic consulting <span>for personal use</span></h4>
                            <div class="price">
                                <p class="amount"><span class="curency">$</span>9<span class="duration">/mo</span></p>
                            </div>
                        </div>

                        <ul class="table-list">
                            <li>1 Admin</li>
                            <li>10 pages</li>
                            <li>20 Forms</li>
                        </ul>
                        <div class="button">
                            <a class="main-btn btn-hover wow fadeInUp" href="#"><i class="fas fa-shopping-cart"></i> Buy Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="single-table wow fadeInUp" data-wow-delay=".5s">
                        <div class="table-head">
                            <h4 class="title">Financial services <span>for small business</span></h4>
                            <div class="price">
                                <p class="amount"><span class="curency">$</span>29<span class="duration">/mo</span></p>
                            </div>
                        </div>

                        <ul class="table-list">
                            <li>5 Admins</li>
                            <li>100 pages</li>
                            <li>200 forms</li>
                        </ul>
                        <div class="button">
                            <a class="main-btn btn-hover wow fadeInUp" href="#"><i class="fas fa-shopping-cart"></i> Buy Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="single-table wow fadeInUp" data-wow-delay=".7s">
                        <p class="popular">Popular</p>

                        <div class="table-head">
                            <h4 class="title">VIP consulting <span>for medium business</span></h4>
                            <div class="price">
                                <p class="amount"><span class="curency">$</span>59<span class="duration">/mo</span></p>
                            </div>
                        </div>

                        <ul class="table-list">
                            <li>50 Users</li>
                            <li>Unlimited pages</li>
                            <li>Unlimited forms</li>
                        </ul>
                        <div class="button">
                            <a class="main-btn btn-hover wow fadeInUp" href="#"><i class="fas fa-shopping-cart"></i> Buy Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="single-table wow fadeInUp" data-wow-delay=".9s">
                        <div class="table-head">
                            <h4 class="title">Marketing and Finance <span>for large business</span></h4>
                            <div class="price">
                                <p class="amount"><span class="curency">$</span>79<span class="duration">/mo</span></p>
                            </div>
                        </div>

                        <ul class="table-list">
                            <li>Unlimited Users</li>
                            <li>Unlimited pages</li>
                            <li>Unlimited products</li>
                        </ul>
                        <div class="button">
                            <a class="main-btn btn-hover wow fadeInUp" href="#contact"><i class="fas fa-comments"></i> Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========================= Pricing end ========================= -->


    <!-- ========================= Team start ========================= -->
    <a class="anchor" href="#" id="team"></a>
    <section class="my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-2">
                        <h1 class="mb-3 wow fadeInUp" data-wow-delay=".2s">Our Team</h1>
                        <p class="wow fadeInUp" data-wow-delay=".4s">
                            We are different, each with unique skills, expertise and talents. But we are also a community of like-minded people and good friends.
                        </p>
                        <p class="wow fadeInUp" data-wow-delay=".4s">
                            More than half of our team are senior engineers with 10+ years of experience. We live and operate in the major tech hubs with business offices in Europe, Asia and North America and frequently
                            travel to our clients and partners when possible.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-4">

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <img class="img-fluid mb-4 wow fadeInUp mx-auto d-block" data-wow-delay=".4s" src="assets/img/persons/person1.jpg" alt="Person 1">
                    <div class="text-center text-muted">
                        <h4>Diana Doe</h4>
                        <div class="text-muted">Manager</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <img class="img-fluid mb-4 wow fadeInUp mx-auto d-block" data-wow-delay=".4s" src="assets/img/persons/person2.jpg" alt="Person 2">
                    <div class="text-center text-muted">
                        <h4>Maria Dover</h4>
                        <div class="text-muted">Technical Support</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <img class="img-fluid mb-4 wow fadeInUp mx-auto d-block" data-wow-delay=".4s" src="assets/img/persons/person3.jpg" alt="Person 3">
                    <div class="text-center text-muted">
                        <h4>Erica Joana</h4>
                        <div class="text-muted">Custom Development</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <img class="img-fluid mb-4 wow fadeInUp mx-auto d-block" data-wow-delay=".4s" src="assets/img/persons/person4.jpg" alt="Person 4">
                    <div class="text-center text-muted">
                        <h4>Michale Joe</h4>
                        <div class="text-muted">Account Manager</div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ========================= Team end ========================= -->


    <!-- ========================= Contact Us start ========================= -->
    <a class="anchor" href="#" id="contact"></a>
    <section class="my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-2">
                        <h1 class="mb-3 wow fadeInUp" data-wow-delay=".2s">Contact Us</h1>
                        <h3 class="wow fadeInUp" data-wow-delay=".4s">Let's talk about what we can build together</h3>
                        <p class="mt-3">
                            Your goals are also our goals. We stand by our words and take responsibility for every deadline, decision and choice we make. Trust is a solid ground for successful collaboration. We nurture
                            it through transparent communication, commitment and full understanding between clients and teams.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-4">

                <div class="col-12">

                    <form method="post" action="#">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Your name</label>
                                    <input id="name" type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input id="subject" type="text" name="subject" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea id="message" class="form-control" name="message" rows="5" required></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 justify-content-center">
                                <button type="submit" class="main-btn btn-hover wow fadeInUp">Send message</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>

        </div>

        <div class="maparea my-4">
            <div style="width: 100%"><iframe height="400" src="https://maps.google.com/maps?height=400&amp;hl=en&amp;q=Valencia+Spain&amp;ie=UTF8&amp;t=&amp;z=17&amp;iwloc=B&amp;output=embed"></iframe></div>
        </div>

    </section>
    <!-- ========================= Contact Us end ========================= -->


    <!-- ========================= Nura24 section start ========================= -->
    <section class="my-5">
        <div class="container text-center">
            <h2>Nura24: #1 Free Suite for Businesses, Communities, Teams, Collaboration or Personal Websites.</h2>
            <p>With Free Nura24 Suite, you have everything you need to build professional websites, from simple / personal websites to complex portals or business websites. Nura24 is a Free alternative to popular CMS or
                Business Software like Wordpress,
                Joomla, Drupal, Odoo, Hubspot, Zoho and others.
            </p>
            <a href="https://nura24.com" class="main-btn btn-hover wow fadeInUp mt-4 mb-4" data-wow-delay=".6s">Free Download</a>
        </div>
    </section>
    <!-- ========================= Nura24 section end ========================= -->


    @include('web.global.footer')

    @include('web.includes.modal-features')

</body>

</html>
