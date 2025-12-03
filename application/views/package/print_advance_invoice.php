<?php
$s_status = ((defined('FCCPATH') && FCCPATH) ? FCCPATH : '');
$lng = $this->session->userdata('language');
$ln_text = (isset($lng) && $lng === "bangla") ? "bangla" : '';
$tax = '';
$inv_prev_due = 0;
if(@$sale_object->sale_vat_objects != ''){
    $tax = json_decode(@$sale_object->sale_vat_objects);
}
$rounding_type = $this->session->userdata('pos_total_payable_type');
$invoice_configuration = $this->session->userdata('invoice_configuration');
$inv_logo_is_show = $this->session->userdata('inv_logo_is_show');
$inv_config = json_decode($invoice_configuration);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Advance Receipt</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 30px;
        font-size: 14px;
    }
    .title {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 15px;
        text-decoration: underline;
    }
    .company {
        text-align: center;
        line-height: 20px;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    .bordered td, .bordered th {
        border: 1px solid #000;
        padding: 6px;
        vertical-align: top;
    }
    .section-title {
        font-weight: bold;
        margin: 15px 0 5px;
    }
    .amount-box {
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        margin-top: 10px;
    }
    .totals {
        width: 100%;
        border: 1px solid #000;
        margin-top: 20px;
    }
    .totals th, .totals td {
        border: 1px solid #000;
        padding: 5px;
        text-align: center;
    }
    .foot {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
        font-weight: bold;
    }

    .m-0{
        margin: 0px;
    }
</style>
</head>
<body>

<div class="title">Advance Receipt</div>

<div class="company">
    <h4><?= $this->session->userdata('business_name') ?></h4>
    <?php if($outlet_info->address){?>
        <p class="f-w-500 m-0 color-71 font-size-13"><?php echo escape_output($outlet_info->address); ?></p>
    <?php } ?>
    <?php if($outlet_info->email){?>
        <p class="f-w-500 m-0 color-71 font-size-13"><?php echo lang('email');?>: <?php echo escape_output($outlet_info->email); ?></p>
    <?php } ?>
    <?php if($outlet_info->phone){?>
        <p class="f-w-500 m-0 color-71 font-size-13"><?php echo lang('phone');?>: <?php echo escape_output($outlet_info->phone); ?></p>
    <?php } ?>
    <?php if($this->session->userdata('collect_tax') == 'Yes' && $inv_config->show_business_tax_number == 'Yes' && $this->session->userdata('tax_registration_no')){ ?>
        <p class="f-w-500 m-0 color-71 font-size-13">
            <?php echo $inv_config->business_tax_number_label ?>: 
            <?php echo $this->session->userdata('tax_registration_no'); ?>
        </p>
    <?php } ?>
    <?php if($outlet_info->additional_information){?>
        <p class="f-w-500 m-0 color-71 font-size-13">
            <?php echo html_entity_decode(escape_output($outlet_info->additional_information)); ?>
        </p>
    <?php } ?>
</div>

<br>
<div>
    <p class="f-w-500 m-0 color-71 font-size-13"><strong>Receipt No: </strong> <?php echo escape_output(@$packagedata->invoice_no); ?></p>
    <p class="f-w-500 m-0 color-71 font-size-13"><strong>Creation Date: </strong> <?php echo date('d M Y', strtotime(@$packagedata->purchase_date)); ?></p>
    <p class="f-w-500 m-0 color-71 font-size-13"><strong>Customer Name: </strong> <?php echo escape_output(@$packagedata->customer_name); ?></p>
    <p class="f-w-500 m-0 color-71 font-size-13"><strong>Customer Phone: </strong> <?php echo escape_output(@$packagedata->c_phone); ?></p>
    <p class="f-w-500 m-0 color-71 font-size-13"><strong>Customer Address: </strong> <?php echo escape_output(@$packagedata->c_address); ?></p>
</div>
<table class="bordered">
<tr>
    <th style="width: 50px;">Sl No.</th>
    <th>Package</th>
    <th style="width: 120px;">Rate</th>
    <th style="width: 120px;">Amount</th>
</tr>

<tr>
    <td>1</td>
    <td><?= @$packagedata->package_name ?></td>
    <td><?= @$packagedata->total_amt ?></td>
    <td><?= @$packagedata->total_amt ?></td>
</tr>
</table>

<div style="display: flex; justify-content: space-between; align-items: center;">
    Mode of Payment: <?php echo escape_output(@$packagedata->payment_method); ?>
    <div class="amount-box">
        <?= getAmtCustom(@$packagedata->total_amt) ?>
    </div>
</div>
<br>
<br>
<br>
<br>
<div class="foot">
    <div>Authorized Signature</div>
    <div>Customer Signature</div>
</div>

<script>
    window.print();
</script>
</body>
</html>
