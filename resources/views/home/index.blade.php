@extends('userpanel.index')
@section('userpanel')
    <section id="slider" style="width: 100% !important; margin-top: -13px;">
        <div class="section mb-0 mt-3" style="padding: 32px 0; background: #dee2dc;">
            <div class="container">
                <div class="heading-block nobottomborder center bottommargin-sm">
                    <span class="font-primary ls1 color">Steg för ordning</span>
                    <h3 class="nott font-secondary ls0" style="font-size: 52px; line-height: 1.3;">Hur får du din mat</h3>
                </div>

                <div class="clear"></div>

                <div class="row mt-5 clearfix">
                    <div class="col-lg-4 col-sm-6 bottommargin-sm">
                        <div class="feature-box media-box">
                            <div class="fbox-media" style="width: 60px; height: 60px">
                                <img src="{{ URL::to('public/front/restaurent/images/icons/route.svg' ) }}" alt="">
                            </div>
                            <h3>1. Välj din plats</h3>
                            <p>Välj först din nuvarande plats. Se sedan katarinservice med en radie på 7 km.!</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 bottommargin-sm">
                        <div class="feature-box media-box">
                            <div class="fbox-media" style="width: 60px; height: 60px">
                                <img src="{{ URL::to('public/front/restaurent/images/icons/shop.svg' ) }}" alt="">
                            </div>
                            <h3>2. Välj din mat</h3>
                            <p>Välj matvaran från catarine-menyn. Beställ sedan det. Var försiktig så att du inte kan välja matvaror utanför radien på 7 km.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 bottommargin-sm">
                        <div class="feature-box media-box">
                            <div class="fbox-media" style="width: 75px; height: 60px">
                                <img src="{{ URL::to('public/front/restaurent/images/icons/delivery-bg.svg' ) }}" alt="">
                            </div>
                            <h3>3. Din artikel är på väg</h3>
                            <p>När katarinservice får denna beställning. De kommer att bekräfta denna beställning via telefon eller e-post. Med inom 40 minuter får du din beställningsmat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clear"></div>
<section id="content">
    <div class="content-wrap">
    <div class="container clearfix">
        <div class="col_one_third nobottommargin">
            <div class="feature-box media-box">
                <div class="fbox-media">
                    <img src="{{ URL::to('public/front/img/portfolio/img1.png' ) }}" alt="Why choose Us?">
                </div>
                <div class="fbox-desc">
                    <h3>Varför NCiE HOME<span class="subtitle">Eftersom vi är pålitliga</span></h3>
                    <p>Vi har samlat några av Sveriges bästa hemma kockar under
                        ett tak. När en kock trivs och känner sej bekväm i sitt kök
                        kan underverk hända.</p>
                </div>
            </div>
        </div>
        <div class="col_one_third nobottommargin">
            <div class="feature-box media-box">
                <div class="fbox-media">
                    <img src="{{ URL::to('public/front/img/portfolio/img2.png' ) }}" alt="Why choose Us?">
                </div>
                <div class="fbox-desc">
                    <h3>Våran Filosofi<span class="subtitle">Bra råvaror i dem bästa händerna</span></h3>
                    <p>Vi vill att våra kunder ska kunna ta del av den otroliga
                        kunskap som finns bland svenska kockar. Det är sällan man
                        får den roligaste maten på krogen. Då man ofta utgår från vad
                        som säljer bäst på en meny. Inget illa sagt om Ceasar sallad
                        och hamburgare, men det börjar bli lite tråkigt. Vi ger våra
                        kockar frihet att skapa och tolka sin egen meny.</p>
                </div>
            </div>
        </div>
        <div class="col_one_third nobottommargin col_last">
            <div class="feature-box media-box">
                <div class="fbox-media">
                    <img src="{{ URL::to('public/front/img/portfolio/img3.png' ) }}" alt="Why choose Us?">
                </div>
                <div class="fbox-desc">
                    <h3>Vad vi vill göra<span class="subtitle">Gör våra kunder lyckliga</span></h3>
                    <p>Vi vill göra våra kunder glada och nöjda. Vi vill stärka länken
                        mellan lokala producenter och matkreatörer. På så sätt kan vi
                        erbjuda det bästa Sverige har att erbjuda. Vare sej det är
                        lokalt producerat lamm från Norrtälje eller färska örter från
                        Uppsala. Så vill vi se till att våra kunder är en del i att få
                        igång det svenska kretsloppet.</p>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="section dark bottommargin-lg" style="height: 500px;">
        <div class="container-fluid center clearfix vertical-middle">

            <i class="i-plain i-xlarge icon-food2 divcenter bottommargin"></i>

            <div class="slider-caption slider-caption-center">
                <h2 data-animate="fadeInUp">Lysande service</h2>
                <p class="d-none d-sm-block" data-animate="fadeInUp" data-delay="200">"Bra mat till bra pris"</p>
            </div>
        </div>
        <div class="video-wrap">
            <video poster="{{ URL::to('public/front/images/videos/explore.jpg' ) }}" preload="auto" loop autoplay muted>
            </video>
            <div class="video-overlay" style="background-color: rgba(0,0,0,0.35);"></div>
        </div>
    </div>
    <div class="container clearfix">

        <div class="col_one_fourth nobottommargin">
            <div class="feature-box fbox-center fbox-plain nobottomborder">
                <div class="fbox-icon">
                    <a href="javascript://"><img src="{{ URL::to('public/front/img/restaurent/restaurent1.png' ) }}" alt="Icon" data-animate="zoomIn"></a>
                </div>
                <h3>EXKLUSIVT DRYCK<span class="subtitle">Hemgjord Komboucha</span></h3>
            </div>
        </div>
        <div class="col_one_fourth nobottommargin">
            <div class="feature-box fbox-center fbox-plain nobottomborder">
                <div class="fbox-icon">
                    <a href="#"><img src="{{ URL::to('public/front/img/restaurent/restaurent2.png' ) }}" alt="Icon" data-animate="zoomIn" data-delay="200"></a>
                </div>
                <h3>INTERNATIONELL MATMENY<span class="subtitle">Världsberömda recept</span></h3>
            </div>
        </div>
        <div class="col_one_fourth nobottommargin">
            <div class="feature-box fbox-center fbox-plain nobottomborder">
                <div class="fbox-icon">
                    <a href="#"><img src="{{ URL::to('public/front/img/restaurent/restaurent3.png' ) }}" alt="Icon" data-animate="zoomIn" data-delay="400"></a>
                </div>
                <h3>Lunch tillgänglig<span class="subtitle">Specialiserade lunchmenyer</span></h3>
            </div>
        </div>
        <div class="col_one_fourth nobottommargin col_last">
            <div class="feature-box fbox-center fbox-plain nobottomborder">
                <div class="fbox-icon">
                    <a href="#"><img src="{{ URL::to('public/front/img/restaurent/restaurent4.png' ) }}" alt="Icon" data-animate="zoomIn" data-delay="600"></a>
                </div>
                <h3>Catering & Event<span class="subtitle">Privat Företag</span></h3>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="section nobg topmargin-lg nobottommargin">
        <div class="container clearfix">
            <div class="col_half nobottommargin center">
                <img src="{{ URL::to('public/front/img/catarine/res1.png' ) }}" alt="Image" data-animate="fadeInLeft">
            </div>
            <div class="col_half nobottommargin col_last">
                <div class="heading-block" style="padding-top: 40px;">
                    <h2>Fräscha råvaror i händerna på dem bästa kockarna.</h2>
                    <span>Kocken Tipsar!</span>
                </div>
                <p>Vi har både varma och kalla rätter för Take Away och
                    hemkörning. Våra lådor är anpassade så att du själv kan
                    göra din egen matlåda, spara en portion och värma vid ett
                    senare tillfälle. Vi har även väldigt många bra recept och
                    matlagnings videor som du får tillgång till så fort du har
                    registrerat dej.</p>
                <a href="{{ URL::to('search-catarine') }}" class="button button-border button-large button-rounded topmargin-sm noleftmargin">Sök kock</a>
            </div>
        </div>
    </div>
    <div class="section nobg notopmargin noborder bottommargin-sm">
        <div class="container clearfix">
            <div class="col_half nobottommargin">
                <div class="heading-block" style="padding-top: 40px;">
                    <h2>Hemlagat är bäst</h2>
                    <span>Kontakta oss för fler recept</span>
                </div>
                <p>Vi byter meny ofta och med säsongens tillgång som
                    underlag. Men du får gärna komma med förslag på rätter
                    som du vill se på kommande menyer.</p>

                <a href="{{ URL::to('contact-us') }}" class="button button-border button-large button-rounded topmargin-sm noleftmargin">KONTAKT</a>
            </div>
            <div class="col_half bottommargin-sm center col_last">
                <img src="{{ URL::to('public/front/img/catarine/res2.png' ) }}" alt="Image" data-animate="fadeInRight">
            </div>
        </div>
    </div>
    <div class="container clearfix">
        <div class="col_one_fourth nobottommargin">
            <div class="fancy-title title-border">
                <h4>Öppettider</h4>
            </div>
            <p>Håll kontrollen över din restaurangwebverksamhet med vår realtidsrapportmodul. Beställningsstatistik, fullständiga kundlistor, leveransvärmekarta och mycket mer.</p>
            <ul class="iconlist nobottommargin">
                <li><i class="icon-time color"></i> <strong>Tisdag - Söndag</strong> 11AM - 21PM</li>
            </ul>
        </div>
        <div class="col_one_fourth nobottommargin">
            <div class="fancy-title title-border">
                <h4>Alltid på Menyn</h4>
            </div>
            <p>Vi älskar bland annat Karibisk mat och har alltid Jerk
                kyckling på meny. Vi anser att det är en perfekt rätt för Take
                Away, och blir det mat över är det lika gott nästa dag.</p>
            <a href="{{ URL::to('search-catarine') }}" class="button button-rounded button-dark noleftmargin"><i class="icon-file-alt"></i>SÖK</a>
        </div>
        <div class="col_half nobottommargin col_last">
            <div class="fancy-title title-border">
                <h4>Senaste Instagram</h4>
            </div>
            <div class="masonry-thumbs grid-4 clearfix" data-lightbox="gallery" style="width: 100.3%;">
                <a href="{{ URL::to('public/front/images/restaurant/3.jpg' ) }}" data-lightbox="gallery-item"><img class="image_fade" src="{{ URL::to('public/front/images/restaurant/thumb/gallery/3.jpg' ) }}" alt="Gallery Thumb 1" data-animate="zoomIn"></a>
                <a href="{{ URL::to('public/front/images/restaurant/5.jpg' ) }}" data-lightbox="gallery-item"><img class="image_fade" src="{{ URL::to('public/front/images/restaurant/thumb/gallery/5.jpg' ) }}" alt="Gallery Thumb 2" data-animate="zoomIn" data-delay="100"></a>
                <a href="{{ URL::to('public/front/images/restaurant/6.jpg' ) }}" data-lightbox="gallery-item"><img class="image_fade" src="{{ URL::to('public/front/images/restaurant/thumb/gallery/6.jpg' ) }}" alt="Gallery Thumb 3" data-animate="zoomIn" data-delay="200"></a>
                <a href="{{ URL::to('public/front/images/restaurant/7.jpg' ) }}" data-lightbox="gallery-item"><img class="image_fade" src="{{ URL::to('public/front/images/restaurant/thumb/gallery/7.jpg' ) }}" alt="Gallery Thumb 4" data-animate="zoomIn" data-delay="300"></a>
                <a href="{{ URL::to('public/front/images/restaurant/8.jpg' ) }}" data-lightbox="gallery-item"><img class="image_fade" src="{{ URL::to('public/front/images/restaurant/thumb/gallery/8.jpg' ) }}" alt="Gallery Thumb 5" data-animate="zoomIn" data-delay="400"></a>
                <a href="{{ URL::to('public/front/images/restaurant/10.jpg' ) }}" data-lightbox="gallery-item"><img class="image_fade" src="{{ URL::to('public/front/images/restaurant/thumb/gallery/10.jpg' ) }}" alt="Gallery Thumb 6" data-animate="zoomIn" data-delay="500"></a>
                <a href="{{ URL::to('public/front/images/restaurant/11.jpg' ) }}" data-lightbox="gallery-item"><img class="image_fade" src="{{ URL::to('public/front/images/restaurant/thumb/gallery/11.jpg' ) }}" alt="Gallery Thumb 7" data-animate="zoomIn" data-delay="600"></a>
                <a href="{{ URL::to('public/front/images/restaurant/12.jpg' ) }}" data-lightbox="gallery-item"><img class="image_fade" src="{{ URL::to('public/front/images/restaurant/thumb/gallery/12.jpg' ) }}" alt="Gallery Thumb 8" data-animate="zoomIn" data-delay="700"></a>
            </div>
        </div>
    </div>
</div>
</section>
@stop
