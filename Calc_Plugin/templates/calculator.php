<?php
/**
 * The template for the sp calculator
 *
 *
 * @package SPCalculator Plugin
 */
 
global $wpdb;
$settings = $wpdb->get_results( "SELECT * FROM wp_sp_calculator_settings WHERE id = 1" );
$heading = $settings[0]->heading;
$GLOBALS['sp_heading_page'] = $heading;
$instruction = $settings[0]->instruction;

function my_page_title() {
    global $sp_heading_page;
    unset($GLOBALS['sp_heading_page']);
    return html_entity_decode($sp_heading_page);
}

add_action( 'pre_get_document_title', 'my_page_title' );
get_header();
?>
<section id="sp-calculator-plugin">

<h1 id="sp-calculator-plugin-heading"><?php echo html_entity_decode($heading); ?></h1>

<p id="sp-calculator-plugin-instruction" style="white-space: pre-line;">
    <?php echo html_entity_decode($instruction); ?>
</p>

<div id="sp-calculator-plugin-block">

    <div class="before-calculator">
        <h2> Before </h2>
        <table class="sp-calculator-table">
            <tbody>
                <tr>
                    <td>Avg. Opportunities/Mo </td>
                    <td></td>
                    <td><input type="text" id="before-avg-opportunies-mo" placeholder=" Enter value"></td>
                </tr>
                <tr>
                    <td>Closing Ratio (%) </td>
                    <td></td> 
                    <td>X<input percentage-value="true" type="text" id="before-closing-ratio" placeholder=" Enter value"></td>
                </tr>
                <tr>
                    <td>Systems Solid/Mo </td>
                    <td></td>
                    <td>=<input type="text" id="before-systems-solid-mo" disabled="disabled"></td>
                </tr>
                <tr>
                    <td>Avg. Sys. Price </td>
                    <td></td>
                    <td>X<span style="font-size:20px;color:rgb(132, 190, 115);font-weight:bold !important; padding-left: 6px;"> $</span> <input type="text" id="before-avg-sys-price" placeholder=" Enter value"></td>
                </tr>
                <tr>
                    <td>Monthly Sales ($) </td>
                    <td></td>
                    <td>=<input type="text" class="highlight-value" id="before-monthly-sales" disabled="disabled"></td>
                </tr>
                <tr>
                    <td>Annual Sales ($) </td>
                    <td></td>
                    <td><input type="text" class="highlight-value" id="before-annual-sales" disabled="disabled"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="after-calculator">
        <h2> After </h2>
        <table class="sp-calculator-table">
            <tbody>
                <tr>
                    <td>Avg. Opportunities/Mo </td>
                    <td></td>
                    <td><input type="text" id="after-avg-opportunies-mo" disabled="disabled"></td>
                </tr>
                <tr>
                    <td>Closing Ratio (%) </td>
                    <td></td>
                    <td>X<input type="text" percentage-value="true" id="after-closing-ratio" placeholder=" Enter value"></td>
                </tr>
                <tr>
                    <td>Systems Solid/Mo </td>
                    <td></td>
                    <td>=<input type="text" id="after-systems-solid-mo" disabled="disabled"></td>
                </tr>
                <tr>
                    <td>Avg. Sys. Price </td>
                    <td></td>
                    <td>X<span style="font-size:20px;color:rgb(132, 190, 115);font-weight:bold !important; padding-left: 6px;">$</span> <input type="text" id="after-avg-sys-price" placeholder=" Enter value"></td>
                </tr>
                <tr>
                    <td>Monthly Sales ($) </td>
                    <td></td>
                    <td>=<input type="text" class="highlight-value" id="after-monthly-sales" disabled="disabled"></td>
                </tr>
                <tr>
                    <td>New Annual Sales ($) </td>
                    <td></td>
                    <td><input type="text" class="highlight-value" id="after-new-annual-sales" disabled="disabled"></td>
                </tr>
                <tr>
                    <td>Old Annual Sales ($) </td>
                    <td></td>
                    <td><input type="text" class="highlight-value" id="after-old-annual-sales" disabled="disabled"></td>
                </tr>
                <tr>
                    <td>Additional Sales ($) </td>
                    <td></td>
                    <td><input type="text" class="highlight-value" id="after-additional-sales" disabled="disabled"></td>
                </tr>
                <tr>
                    <td class="after-equipment-percentage-sales">Equipment <input percentage-value="true" style="max-width: 55px !important;" type="text" id="after-equipment-percentage-sales">%</td>
                    <td></td>
                    <td><input style="display:block !important;" type="text" id="after-equipment-sales" disabled="disabled"></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('input').focus(function(){
            $(this).addClass('focus')
        }).blur(function(){
            if($(this).val() === ''){
                $(this).removeClass('focus')
            }
        })
    })
</script>
	<!-- #primary -->

<?php
get_footer();