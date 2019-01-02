<?php get_header(); ?>
<div class="about-page">
    <header class="entry-header" style="background-image:url(<?php echo get_the_post_thumbnail_url(null, 'full') ?>)">
        <div class="container">
            <div class="head-container">
                <div class="taxonomies">
                    Under Strap
                </div>
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </div>
        </div> 
    </header>
    <div class="entry-content">
        <div class="page-text-content">
            <div class="row">
                <div class="col-sm-48 about-content">
                    <p class="opening">Our aim is simple - to ensure that our passengers reach their chosen destination comfortably, conveniently and on time.</p>
                    <p>Choosing Under Strap gives you access to a dedicated team of aviation professionals and some of the finest aircraft in the skies. We bring over 10 years industry experience and a wealth of knowledge to present you the most appropriate service for your individual needs. Because we’ve built strong relationships across the whole of the aviation industry and related authorities, we’re able to respond quickly and efficiently to all enquiries.</p>
                    <p>Our reputation is built on excellence, and we pride ourselves on treating each and every one of our passengers with respect and integrity.</p>
                    <p>We are proud to deliver the personal touch. We offer a 24 hour service, 365 days a year and we’ll always have a real person for you to talk to rather than hiding behind a website.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-24">
                    <div class="detail-section">
                        <h2>24/7 Personal Touch</h2>
                        <p>We believe that the personal approach goes a long way, which is why we don’t use automated messages or call centres. Choosing Under Strap means you’ll always have access to your own personal account manager who will be happy to answer your queries any time, any place.</p>
                    </div>
                </div>
                <div class="col-sm-24">
                    <div class="detail-section">
                        <h2>Worldwide Service</h2>
                        <p>We can accommodate any trip, anywhere in the world. We have a network of over 20,000 Aircraft WORLDWIDE. At Under Strap we will use only tried and tested aircraft and crew.</p>
                        <p>It may sound like a cliché, but there really is no job too big or too small. Whether you need a small helicopter to arrive at an event in style or a large aircraft for your crew movements, we’re here to meet your every need.</p>
                    </div>
                </div>
            </div>
            <div class="detail-section">
                <h2>Flight Safety</h2>
                <p>Flight safety is Under Strap’s primary concern and the security, comfort and peace of mind of our clients remains at the heart of everything we do.</p>
                <p>To ensure the best possible experience for all our clients, we insist that all suppliers have full Aircraft Operators Certificates, type rated crew and carry full public liability insurance. We also undertake rigorous checks and investigations on all private aircraft operators wishing to join our esteemed global network.</p>
                <p>To discover why so many discerning passengers choose Under Strap, contact us today.</p>
            </div>
        </div>
    </div>
    <?php the_content() ?>
</div>
<?php get_footer(); ?>
