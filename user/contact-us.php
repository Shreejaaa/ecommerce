<title>Contact Us</title>

<?php
    include("header.php")
?>

<section class="contact__section">
    <div class="container-lg">
        <div class="contact__section-content">
            <h2 class="contact__section-title">Send us Message</h2>
            <form class="contact__section-form" action="index.html" method="post">
                <div class="contact__section-group">
                    <input type="text" name="" placeholder="First Name" value="">
                    <input type="text" name="" placeholder="Email" value="">
                </div>
                <div class="contact__section-group">
                    <input type="text" name="" placeholder="Phone" value="">
                    <input type="text" name="" placeholder="Subject" value="">
                </div>
                <div class="contact__section-group">
                    <textarea name="name" placeholder="Message" rows="6" cols="80"></textarea>
                </div>
                <div class="contact__section-btn">
                    <button type="submit" name="button">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="contact__section">
    <div class="container-lg">
        <div class="contact__info-content">
            <div class="contact__info">
                <div class="contact__info-item">
                    <i class="fa fa-phone"></i>
                    <div class="">
                        +44 - 00 0000 000 00
                    </div>
                </div>
                <div class="contact__info-item">
                    <i class="fa fa-envelope"></i>
                    <div class="">
                        submart@gmail.com
                    </div>
                </div>
                <div class="contact__info-item contact__info-media">
                    <div class="">
                        Follow us on
                    </div>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f fa-2x"></i></a>
                        <a href="#"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#"><i class="fab fa-instagram fa-2x"></i></a>
                    </div>
                </div>
            </div>
            <div class="contact__map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14130.3592906684!2d85.28176420712896!3d27.69906966775302!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1860ae22d385%3A0x7c2444e8284cef52!2sKalimati%2C%20Kathmandu%2044600!5e0!3m2!1sen!2snp!4v1715980938246!5m2!1sen!2snp" width="600" height="320" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>

<?php
include("footer.php")
?>
