<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

require_once Adm()->plugin_path() . '/Empty_Legs_Post.php';

get_header(); ?>
<div class="container contact-us-page">
    <p class="text-center h4">Our dedicated and professional team are ready to take your call 24 hours a day on:</p>
    <h2 class="text-center"><a href="tel:+442071839655">+44 (0) 207 183 9655</a></h2>
    <div class="row">
        <div class="col-md-24 col-md-push-12">

            <h2 class="text-center">Email Us</h2>
            <p class="text-muted text-center">And we will get back to you very soon</p>
            <form id="contactForm" class="ajax-form" method="post" action="Contact">
                <?php wp_nonce_field('ajax-contact-nonce', 'security'); ?>
                <div class="alert d-none fade show" role="alert"></div>
                <div class="row">
                    <div class="col-xs-14">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <select class="form-control" id="title" name="title">
                                <option value="">Choose</option>
                                <?php
                                foreach(Contact::title_list() as $k => $v){
                                    echo '<option value="' . $v . '">' . $v . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-34">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                </div>
                <div class="form-group">
                    <label for="company">Company</label>
                    <input type="text" class="form-control" id="company" name="company" placeholder="Company Name">
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <select id="country" name="country" class="form-control">
                        <option value="">Select a Country</option>
                        <?php
                        foreach(Contact::country_list() as $k => $v){
                            echo '<option value="' . $v['code'] . '">' . $v['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" placeholder="Enter your message here" class="form-control autosize"></textarea>
                </div>
                <button type="submit" class="btn btn-lg btn-success">Contact Us</button>
            </form>

        </div>
    </div>
</div>
<?php get_footer(); ?>
