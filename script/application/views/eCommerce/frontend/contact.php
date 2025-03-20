    <!-- contact form -->
    <div class="contact_form section_padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-12">
                    <div class="billing_form">
                        <h4 class="title_2"><?php echo escape_output(isset($contact_data->title) && $contact_data->title ? $contact_data->title : '');?></h4>
                        <p><?php echo escape_output(isset($contact_data->description) && $contact_data->description ? $contact_data->description : '');?></p>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="contact_us_mini_card">
                                    <i class="las la-map-marker-alt"></i>
                                    <p><?php echo lang('location');?></p>
                                    <p><?php echo escape_output(isset($contact_data->location_name) && $contact_data->location_name ? $contact_data->location_name : '');?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="contact_us_mini_card">
                                    <i class="las la-phone"></i>
                                    <p><?php echo escape_output(isset($contact_data->contact_number) && $contact_data->contact_number ? $contact_data->contact_number : '');?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="contact_us_mini_card">
                                    <i class="lar la-envelope"></i>
                                    <p><?php echo escape_output(isset($contact_data->email_address) && $contact_data->email_address ? $contact_data->email_address : '');?></p>
                                </div>
                            </div>
                        </div>

                        <?php if ($this->session->flashdata('exception')) : ?>
                        <section class="alert-wrapper">
                            <div class="alert alert-success alert-dismissible fade show">
                                <div class="alert-body">
                                    <?= escape_output($this->session->flashdata('exception')); ?>
                                    <?php unset($_SESSION['exception']); ?>
                                </div>
                            </div>
                        </section>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('exception_error')) : ?>
                        <section class="alert-wrapper">
                            <div class="alert alert-danger alert-dismissible fade show">
                                <div class="alert-body">
                                    <?= escape_output($this->session->flashdata('exception_error')); ?>
                                    <?php unset($_SESSION['exception_error']); ?>
                                </div>
                            </div>
                        </section>
                        <?php endif; ?>


                        <form action="<?php echo base_url('e-contact-store'); ?>" method="POST">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="single_billing_inp">
                                        <input type="text" id="first_name" placeholder="<?php echo lang('full_name');?> *" name="name">
                                    </div>
                                    <?php if (form_error('name')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single_billing_inp">
                                        <input type="text" id="email_phonbe" placeholder="<?php echo lang('phone_email')?> *" name="email_phone">
                                    </div>
                                    <?php if (form_error('email_phone')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('email_phone'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-12">
                                    <div class="single_billing_inp">
                                        <input type="text" id="subject" placeholder="<?php echo lang('subject');?> *" name="subject">
                                    </div>
                                    <?php if (form_error('subject')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('subject'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-12">
                                    <div class="single_billing_inp">
                                        <textarea id="county_region" placeholder="<?php echo lang('message');?> *" name="message"></textarea>
                                    </div>
                                    <?php if (form_error('message')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('message'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="submit" value="submit" class="default_btn xs_btn px-4">
                                        <?php echo lang('send_message');?>
                                        <i class="bi bi-arrow-right ps-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-6 col-12 mt-4 mt-lg-0">
                    <div class="shadow_sm">
                        <iframe src="<?php echo isset($contact_data->location) && $contact_data->location ? $contact_data->location : '';?>" width="100%" height="500px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
