<style>
    .print-btn {
        margin-bottom: 15px;
    }

    .print-btn button {
        padding: 8px 15px;
        cursor: pointer;
        border: 1px solid #000;
        background: #fff;
    }

    .invoice-wrapper {
        width: 900px;
        margin: auto;
        background: #fff;
        padding: 20px;
        border: 1px solid #000;
    }

    .title {
        text-align: center;
        font-weight: bold;
        margin-bottom: 15px;
        font-size: 18px;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .info-table td {
        padding: 4px 6px;
        vertical-align: top;
    }

    .label {
        font-weight: bold;
        width: 180px;
    }

    .value {
        width: 250px;
    }

    table.grid {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    table.grid th,
    table.grid td {
        border: 1px solid #000;
        padding: 6px;
        font-size: 13px;
    }

    table.grid th {
        background: #d9d9d9;
        text-align: center;
    }

    .right {
        text-align: right;
    }

    .center {
        text-align: center;
    }

    .total-row td {
        font-weight: bold;
    }

    .section-title {
        font-weight: bold;
        margin: 10px 0 5px;
    }

    /* ================= PRINT SETTINGS ================= */
    @media print {

        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            background: #fff;
        }

        .invoice-wrapper {
            width: 100%;
            margin: 0;
            border: none;
        }

        .print-btn {
            display: none;
        }

        .main-content-wrapper > :not(.invoice-wrapper) {
            display: none !important;
        }
    }
</style>

<div class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));
        unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>


    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <a href="<?php echo base_url('Sale/package'); ?>" class="btn btn-primary"><i
                        class="fa fa-arrow-left"></i> Back </a>
                <h3 class="top-left-header mt-2"><?php echo lang('add_edit_sale_package'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection' => lang('customer'), 'secondSection' => lang('package')]) ?>
        </div>
    </section>


    <!-- PRINT AREA -->
    <div class="invoice-wrapper">

        <div class="title">PACKAGE REIMBURSEMENT DETAILS</div>

        <table class="info-table">
            <tr>
                <td class="label">PATIENT PIN/NAME</td>
                <td class="value">: <?= $package_data->customer_name ?></td>

                <td class="label">INVOICE DATE</td>
                <td class="value">: <?= date('d/m/Y', strtotime($package_data->purchase_date)) ?></td>
            </tr>
            <tr>
                <td class="label">PURCHASED ON</td>
                <td class="value">: <?= date('d/m/Y', strtotime($package_data->purchase_date)) ?></td>

                <td class="label">INVOICE NUMBER</td>
                <td class="value">: <?= $package_data->invoice_no ?></td>
            </tr>
            <tr>
                <td class="label">PACKAGE CODE/NAME</td>
                <td colspan="3">: <?= $package_data->package_name ?></td>
            </tr>
        </table>

        <table class="grid">
            <thead>
                <tr>
                    <th style="width:40px;">S#</th>
                    <th>ITEM DESCRIPTION</th>
                    <th style="width:60px;">QTY</th>
                    <th style="width:90px;">DISCOUNT</th>
                    <th style="width:70px;">VAT</th>
                    <th style="width:90px;">NET</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="center">1</td>
                    <td><?= $package_data->package_name ?></td>
                    <td class="center"><?= $package_data->session_count ?></td>
                    <td class="right"><?= $package_data->total_amt ?></td>
                    <td class="right">0.00</td>
                    <td class="right"><?= $package_data->total_amt ?></td>
                </tr>
                <tr class="total-row">
                    <td colspan="5" class="right">TOTAL</td>
                    <td class="right"><?= $package_data->total_amt ?> AED</td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">Acupuncture</div>

        <table class="grid">
            <thead>
                <tr>
                    <th style="width:40px;">Sr.</th>
                    <th style="width:120px;">Date</th>
                    <th style="width:120px;">Time</th>
                    <th style="width:120px;">Duration</th>
                    <th style="width:60px;">Quantity</th>
                    <th style="width:90px;">Amount per session</th>
                    <th style="width:90px;">Doctor Attended</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($package_data->sessions as $key => $session) { ?>
                    <tr>
                        <td class="center"><?= $key + 1 ?></td>
                        <td class="center"><?= $session->in_time ? date('d/m/Y', strtotime($session->in_time)) : '-' ?></td>
                        <td class="center"><?= $session->in_time ? date('h:i A', strtotime($session->in_time)) : '-' ?></td>
                        <td class="center"><?= $session->time_frame ? $session->time_frame : '-' ?></td>
                        <td class="center">1</td>
                        <td class="center"><?= number_format((float) $session->price, 2) ?></td>
                        <td class="center"><?= $session->employee_name ?? '-' ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
    <div class="print-btn">
        <button type="button" onclick="printInvoice()">Print</button>
    </div>
</div>

    <!-- PRINT SCRIPT -->
    <script>
        function printInvoice() {
            window.print();
        }
    </script>
