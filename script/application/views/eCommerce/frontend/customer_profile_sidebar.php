<div class="col-lg-3">
    <div class="account_sidebar">
        <div class="account_profile position-relative shadow_sm">
            <div class="acprof_cont">
                <p><?php echo lang('Hello');?>,</p>
                <h4><?php echo $this->session->userdata('customer_name');?></h4>
            </div>
            <div class="profile_hambarg d-lg-none d-block">
                <i class="las la-bars"></i>
            </div>
        </div>
        <div class="acprof_wrap shadow_sm">
            <div class="acprof_links">
                <a href="<?php echo base_url();?>e-account" class="<?php echo (getUriSegment(1) == 'e-account' || getUriSegment(1) == 'e-account-info' || getUriSegment(1) == 'e-change-password') ? 'active' : ''?>">
                    <h4 class="acprof_link_title">
                        <i class="lar la-id-card"></i>
                        <?php echo lang('Manage_My_Account');?>
                    </h4>
                </a>
                <a href="<?php echo base_url();?>e-account-info" class="<?php echo (getUriSegment(1) == 'e-account-info') ? 'active' : ''?>">
                    <?php echo lang('Profile_Information');?>
                </a>
                <a href="<?php echo base_url();?>e-change-password" class="<?php echo (getUriSegment(1) == 'e-change-password') ? 'active' : ''?>">
                    <?php echo lang('change_password');?>
                </a>
                <a href="<?php echo base_url();?>e-manage-address" class="<?php echo (getUriSegment(1) == 'e-manage-address') ? 'active' : ''?>">
                    <?php echo lang('Manage_Address');?>
                </a>
            </div>
            <div class="acprof_links">
                <a href="<?php echo base_url();?>e-wish-list">
                    <h4 class="ac_link_title">
                        <i class="lar la-heart"></i>
                        <?php echo lang('my_wish_list');?>
                    </h4>
                </a>
            </div>
            <div class="acprof_links border-0">
                <a href="<?php echo base_url();?>e-logout">
                    <h4 class="acprof_link_title">
                        <i class="las la-power-off"></i>
                        <?php echo lang('Log_out');?>
                    </h4>
                </a>
            </div>
        </div>
    </div>
</div>