<!-- ======= Footer ======= -->
<section class="section-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="widget-a">
                    <div class="w-header-a">
                        <h3 class="w-title-a text-brand">Manadeep</h3>
                    </div>
                    <div class="w-body-a">
                        <p class="w-text-a color-text-a">
                            {{ __("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book") }}
                        </p>
                    </div>
                    <div class="w-footer-a">
                        <ul class="list-unstyled">
                            <li class="color-a">
                                <span class="color-text-a">{{ __('Email') }} .</span> contact@example.com
                            </li>
                            <li class="color-a">
                                <span class="color-text-a">{{ __('Phone') }} .</span> +12 345 678900
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 section-md-t3">
                <div class="widget-a">
                    <div class="w-header-a">
                        <h3 class="w-title-a text-brand">{{ __('Test Section') }}</h3>
                    </div>
                    <div class="w-body-a">
                        <div class="w-body-a">
                            <ul class="list-unstyled">
                                <li class="item-list-a">
                                    <a href="#">{{ __('Site Map') }}</a>
                                    <i class="fa fa-angle-{{app()->getLocale() == 'en' ? 'right' : 'left'}}"></i>
                                </li>
                                <li class="item-list-a">
                                    <a href="#">{{ __('Careers') }}</a>
                                    <i class="fa fa-angle-{{app()->getLocale() == 'en' ? 'right' : 'left'}}"></i>
                                </li>
                                <li class="item-list-a">
                                    <a href="/en/privacy">{{ __('Privacy Policy') }}</a>
                                    <i class="fa fa-angle-{{app()->getLocale() == 'en' ? 'right' : 'left'}}"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 section-md-t3">
                <div class="widget-a">
                    <div class="w-header-a">
                        <h3 class="w-title-a text-brand">{{ __('Test Section') }}</h3>
                    </div>
                    <div class="w-body-a">
                        <ul class="list-unstyled">
                            <li class="item-list-a">
                                <a href="#">{{ __('First item') }}</a>
                                <i class="fa fa-angle-{{app()->getLocale() == 'en' ? 'right' : 'left'}}"></i>
                            </li>
                            <li class="item-list-a">
                                <a href="#">{{ __('Second item') }}</a>
                                <i class="fa fa-angle-{{app()->getLocale() == 'en' ? 'right' : 'left'}}"></i>
                            </li>
                            <li class="item-list-a">
                                <a href="#">{{ __('Third item') }}</a>
                                <i class="fa fa-angle-{{app()->getLocale() == 'en' ? 'right' : 'left'}}"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="nav-footer">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="#">{{ __('Home') }}</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">{{ __('About') }}</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">{{ __('Contact') }}</a>
                        </li>
                    </ul>
                </nav>
                <div class="socials-a">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-2x fa-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-2x fa-twitter" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-2x fa-instagram" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fa fa-2x fa-whatsapp" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="copyright-footer">
                    <p class="copyright color-text-a">
                        &copy;&nbsp;{{ __('All Rights Reserved') }} <span class="color-a">Manadeep</span>.
                    </p>
                </div>
                <div class="credits">
                    Developed by <a href="https://ncitsolutions.com/">NCIT Solutions</a>
                </div>
            </div>
        </div>
    </div>
</footer><!-- End  Footer -->
