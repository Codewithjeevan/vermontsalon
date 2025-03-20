<!-- faq page -->
<div class="section_padding_b faq_page">
    <div class="container">
        <div class="seconpage_banner">
            <h2><?php echo lang('Frequently_Ask_Questions');?></h2>
            <div class="breadcrumbs">
                <a href="<?php echo base_url('e-home');?>"><i class="las la-home"></i></a>
                <a href="<?php echo base_url('e-faq');?>" class="active"><?php echo lang('faq');?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="accord_wrap ">
                    <div class="title_3 mb-3 text-capitalize"><h4><?php echo lang('Most_Asking_FAQ');?></h4></div>
                    <?php if($faq){?>
                    <div class="accordion" id="accordionExample">
                        <?php foreach($faq as $value){?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-<?php echo $value->id;?>">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $value->id;?>" aria-expanded="true" aria-controls="collapse-<?php echo $value->id;?>">
                                    <?php echo escape_output($value->title);?>
                                </button>
                            </h2>
                            <div id="collapse-<?php echo $value->id;?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $value->id;?>" data-bs-parent="#accordionExample">
                                <div class="accordion-body text_md">
                                    <?php echo escape_output($value->description);?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>