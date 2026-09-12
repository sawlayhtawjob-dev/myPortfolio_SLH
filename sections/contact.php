<section
    class="section contact-section"
    id="contact"
>

    <div class="container">

        <div class="contact-box reveal">

            <div class="contact-copy">

                <span class="section-kicker">
                    LET'S CONNECT
                </span>

                <h2>
                    Have a project
                    <span>in mind?</span>
                </h2>

                <p>
                    Feel free to send a message.
                </p>

                <a
                    href="mailto:<?= e($profile['email'] ?? '') ?>"
                    class="contact-email"
                >
                    <?= e($profile['email'] ?? '') ?>
                </a>

            </div>


            <form
                action="<?= url('actions/contact_action.php') ?>"
                method="POST"
                class="contact-form"
            >

                <?= csrf_field() ?>

                <div class="form-grid">

                    <div class="form-field">

                        <label>Name</label>

                        <input
                            type="text"
                            name="name"
                            required
                            maxlength="150"
                            placeholder="Your name"
                        >

                    </div>


                    <div class="form-field">

                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            required
                            maxlength="150"
                            placeholder="you@example.com"
                        >

                    </div>

                </div>


                <div class="form-field">

                    <label>Subject</label>

                    <input
                        type="text"
                        name="subject"
                        maxlength="200"
                        placeholder="Project / Opportunity"
                    >

                </div>


                <div class="form-field">

                    <label>Message</label>

                    <textarea
                        name="message"
                        rows="6"
                        required
                        placeholder="Tell me about your project..."
                    ></textarea>

                </div>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Send Message
                    <span>↗</span>
                </button>

            </form>

        </div>

    </div>

</section>