<?php
$s_status = ((defined('FCCPATH') && FCCPATH) ? FCCPATH : '');
$lng = $this->session->userdata('language');
$ln_text = (isset($lng) && $lng === "bangla") ? "bangla" : '';
$tax = '';
$inv_prev_due = 0;
if (@$sale_object->sale_vat_objects != '') {
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo escape_output(@$sale_object->invoice_no); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/google_font.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/print_invoice_ha4.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/inv_common.css">
    <style>
        p{
            font-size: 13px;
        }
        table thead tr th{
            font-size: 14px !important;
        }
        table tbody tr td{
            font-size: 13px !important;
        }
        .bill-to, .common-heading{
            font-size: 19px;
        }
    </style>
</head>

<body>
    <div id="wrapper" class="m-auto border-2s-e4e5ea br-5 p-30">
        <div class="d-flex justify-content-between">
            <div>
                <h3 class="pb-3 shop-name">
                    <?php
                    if ($s_status == 'Bangladesh') {
                        echo $this->session->userdata('business_name');
                    } else {
                        if ($inv_config->show_business_name == 'Yes') {
                            echo $this->session->userdata('business_name') . "<br>";
                            echo $inv_config->business_name_arabic;
                        }
                    } ?>
                </h3>

                <?php if (@$outlet_info->outlet_name) { ?>
                    <p class="pb-3 common-heading"><?php echo escape_output(@$outlet_info->outlet_name); ?></p>
                <?php } ?>
                <?php if (@$outlet_info->address) { ?>
                    <p class="pb-3 f-w-500 color-71"><?php echo escape_output(@$outlet_info->address); ?></p>
                <?php } ?>
                <?php if (@$outlet_info->email) { ?>
                    <p class="pb-3 f-w-500 color-71"><?php echo lang('email'); ?>:
                        <?php echo escape_output(@$outlet_info->email); ?>
                    </p>
                <?php } ?>
                <?php if (@$outlet_info->phone) { ?>
                    <p class="pb-3 f-w-500 color-71"><?php echo lang('phone'); ?>:
                        <?php echo escape_output(@$outlet_info->phone); ?>
                    </p>
                <?php } ?>
                <?php if ($this->session->userdata('collect_tax') == 'Yes' && $inv_config->show_business_tax_number == 'Yes' && $this->session->userdata('tax_registration_no')) { ?>
                    <p class="pb-7 f-w-900 rgb-71">
                        <?php echo $inv_config->business_tax_number_label ?>:
                        <?php echo $this->session->userdata('tax_registration_no'); ?>
                    </p>
                <?php } ?>
                <?php if (@$outlet_info->additional_information) { ?>
                    <p class="pb-7 f-w-900 rgb-71">
                        <?php echo html_entity_decode(escape_output(@$outlet_info->additional_information)); ?>
                    </p>
                <?php } ?>


            </div>
            <div class="d-flex align-items-center">
                <div class="m-auto">
                    <?php
                    $invoice_logo = $this->session->userdata('invoice_logo');
                    if ($s_status == 'Bangladesh' && $invoice_logo) {
                        ?>
                        <img style="height: 80px;" src="<?= base_url() ?>uploads/site_settings/<?= escape_output($invoice_logo) ?>">
                    <?php } else {
                        if ($inv_logo_is_show == 'Yes' && $invoice_logo) {
                            ?>
                            <img style="height: 80px;" src="<?= base_url() ?>uploads/site_settings/<?= escape_output($invoice_logo) ?>">
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
        <div class="text-center py-10">
            <h2 class="invoice-heading">
                <?php
                if ($s_status == 'Bangladesh') {
                    echo $inv_config->invoice_heading;
                } else {
                    echo $inv_config->invoice_heading . "<br>";
                    echo $inv_config->invoice_heading_arabic;
                } ?>
            </h2>
        </div>

        <div>
            <?php if (@$customer_info->name != '') { ?>
                <p class="pb-3 color-71">
                    <span class="f-w-600"><?php echo lang('bill_to'); ?>:</span>
                    <?php echo escape_output(@$customer_info->name) ?>
                </p>
            <?php } ?>

            <div class="d-flex justify-content-between">
                <div>
                    <?php if ($inv_config->show_customer_address == 'Yes' && $customer_info->address != '') { ?>
                        <p class="pb-3 color-71">
                            <span class="f-w-600"><?php echo lang('address'); ?>:</span>
                            <?php echo escape_output($customer_info->address) ?>
                        </p>
                    <?php } ?>
                    <?php if ($inv_config->show_customer_phone_number == 'Yes' && $customer_info->phone != '') { ?>
                        <p class="pb-3 color-71">
                            <span class="f-w-600"><?php echo lang('phone'); ?>:</span>
                            <?php echo escape_output($customer_info->phone) ?>
                        </p>
                    <?php } ?>
                    <?php if ($inv_config->show_customer_email == 'Yes' && $customer_info->email != '') { ?>
                        <p class="pb-3 color-71">
                            <span class="f-w-600"><?php echo lang('email'); ?>:</span>
                            <?php echo escape_output($customer_info->email) ?>
                        </p>
                    <?php } ?>
                </div>
                <div class="text-rigth">
                    <p class="pb-3">
                        <span class="f-w-600">Patient ID: </span>
                        <?php echo @$customer_info->patient_file_number ? escape_output($customer_info->patient_file_number) : '-'; ?>
                    </p>
                    <p class="pb-3">
                        <span class="f-w-600">
                            <?php
                            if ($s_status == 'Bangladesh') {
                                echo $inv_config->invoice_no_label . ': ';
                            } else {
                                if ($inv_config->invoice_no_label_arabic) {
                                    echo $inv_config->invoice_no_label;
                                    echo "<br>" . $inv_config->invoice_no_label_arabic . ': ';
                                } else {
                                    echo $inv_config->invoice_no_label . ': ';
                                }
                            } ?>
                        </span>
                        <?php echo escape_output(@$sale_object->invoice_no); ?>
                    </p>
                    <p class="pb-3 f-w-500 color-71">
                        <span class="f-w-600">
                            <?php
                            if ($s_status == 'Bangladesh') {
                                echo $inv_config->invoice_date_label . ': ';
                            } else {
                                if ($inv_config->invoice_date_label_arabic) {
                                    echo $inv_config->invoice_date_label;
                                    echo "<br>" . $inv_config->invoice_date_label_arabic . ': ';
                                } else {
                                    echo $inv_config->invoice_date_label . ': ';
                                }
                            } ?>
                        </span>
                        <?php echo date($this->session->userdata('date_format'), strtotime(@$sale_object->created_at ?? '')) ?>
                        <?php echo @$sale_object->created_at ? date('h:i A', strtotime(@$sale_object->created_at)) : '' ?>
                    </p>

                    <!-- <?php if ($inv_config->invoice_show_due_date == 'Yes' && @$sale_object->due_date) { ?>
                        <p class="pb-3 f-w-500 color-71">
                            <span class="f-w-600">
                                <?php
                                if ($s_status == 'Bangladesh') {
                                    echo $inv_config->invoice_due_date_label . ': ';
                                } else {
                                    if ($inv_config->invoice_due_date_label_arabic) {
                                        echo $inv_config->invoice_due_date_label;
                                        echo "<br>" . $inv_config->invoice_due_date_label_arabic . ': ';
                                    } else {
                                        echo $inv_config->invoice_due_date_label . ': ';
                                    }
                                } ?>
                            </span>
                            <?php echo date($this->session->userdata('date_format'), strtotime(@$sale_object->due_date ?? '')) ?>
                        </p>
                    <?php } ?> -->
                    
                </div>
            </div>
        </div>
        <div>
            <table class="table w-100">
                <thead class="br-3 bg-00c53">
                    <tr>
                        <th class="w-25">Sl No.</th>
                        <th class="w-30 text-center">Description</th>
                        <th class="w-30 text-center">Rate</th>
                        <th class="w-30 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <td>1</td>
                    <td class="text-center"><?= @$sale_object->package_name ?></td>
                    <td class="text-center"><?= @$sale_object->total_amt ?></td>
                    <td class="text-right"><?= @$sale_object->total_amt ?></td>
                </tbody>
                <tfoot class="tbl-footer-bg bt-1-gray bb-1-gray">
                    <tr>
                        <td colspan="2"></td>
                        <td class="text-right">Total</td>
                        <td class="text-right"><?= @$sale_object->total_amt ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div>



            <?php
            if (@$sale_object->total_amt) {
                ?>
                <div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2 border-bottom-dotted-gray">
                    <p class="f-w-600">
                        <?php
                        if ($s_status == 'Bangladesh') {
                            echo $inv_config->paid_amount_label;
                        } else {
                            echo $inv_config->paid_amount_label . "<br>";
                            echo $inv_config->paid_amount_label_arabic;
                        } ?>
                    </p>
                    <p><?php echo getAmtCustom($ln_text == "bangla" ? banglaNumber(@$sale_object->total_amt) : @$sale_object->total_amt) ?>
                    </p>
                </div>
                <?php
            }
            ?>

            <?php if ($inv_config->show_payment_method == 'Yes') { ?>
                <div class=" pt-2 pb-3 mt-2 mb-2">
                    <div class="">
                        <div class="d-flex justify-content-between pt-2 pb-3 mt-2 mb-2">
                            <p class="f-w-600">
                                <?php
                                if ($s_status == 'Bangladesh') {
                                    echo $inv_config->payment_method_label;
                                } else {
                                    echo $inv_config->payment_method_label . "<br>";
                                    echo $inv_config->payment_method_label_arabic;
                                } ?>
                            </p>
                            <?php
                                $payment_method_text = @$sale_object->payment_method;
                                $payment_method_decoded = json_decode($payment_method_text, true);
                                if (json_last_error() === JSON_ERROR_NONE && is_array($payment_method_decoded)) {
                                    $payment_parts = [];
                                    foreach ($payment_method_decoded as $payment_entry) {
                                        if (!is_array($payment_entry)) {
                                            continue;
                                        }
                                        $method_name = $payment_entry['payment_method'] ?? $payment_entry['method'] ?? '';
                                        if ($method_name === '') {
                                            continue;
                                        }
                                        if (isset($payment_entry['amount'])) {
                                            $payment_parts[] = $method_name . ' (' . getAmtCustom($payment_entry['amount']) . ')';
                                        } else {
                                            $payment_parts[] = $method_name;
                                        }
                                    }
                                    if (!empty($payment_parts)) {
                                        $payment_method_text = implode(', ', $payment_parts);
                                    }
                                }
                            ?>
                            <p><?php echo $payment_method_text; ?></p>
                        </div>
                        <p class="f-w-600">Advance Payment</p>
                    </div>
                </div>
            <?php } ?>

        </div>
        <?php if ($inv_config->show_total_in_words == 'Yes') { ?>
            <div class="d-flex justify-content-between">
                <p class="f-w-600">
                    <?= lang('amount_in_words'); ?>
                </p>
                <p class="text-capitalize">
                    <?php echo ucwords(numberToWords(@$sale_object->total_amt)) . ' ' . ($this->session->userdata('currency') == "AED" ? ' ' . lang('dirham') : $this->session->userdata('currency')) . ' ' . lang('only'); ?>
                </p>
            </div>
        <?php } ?>

        <div class="d-flex justify-content-between" style="margin-top: 20px">
            <div>
            </div>
            <div>
                <p class="f-w-600 "><?= lang('processed_by') ?></p>
                <p class=""><?= @$sale_object->user_name ?></p>
            </div>
        </div>
       
        <div class="d-flex justify-content-end" style="margin-top: 80px">
            <div>
                <p class="color-71 d-inline b-t-1p-e4e5ea">Customer Signature</p>
            </div>
        </div>
        <div class="d-flex justify-content-center pt-10">
            <div>
                <p class="font-size-15"><?php echo ($this->session->userdata('invoice_footer')); ?></p>
            </div>
        </div>
        <div class="d-flex justify-content-center pt-30">
            <button onclick="window.print();" type="button"
                class="print-btn no-print"><?php echo lang('print'); ?></button>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>frequent_changing/js/onload_print.js"></script>
</body>

</html>
