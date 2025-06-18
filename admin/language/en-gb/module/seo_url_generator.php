<?php

/**
 * @category   OpenCart
 * @package    SEO URL Generator FREE
 * @copyright  © Serge Tkach, 2017–2023, http://sergetkach.com/
 */

// Heading
$_['heading_title'] = 'SEO URL Generator FREE';

// Text
$_['text_extension'] = 'Extensions';
$_['text_success']   = 'Success: You have modified SEO URL Generator FREE module!';
$_['text_edit']      = 'Edit setting';
$_['button_save']    = 'Save';
$_['button_cancel']  = 'Cancel';
$_['button_save_licence']  = 'Save licence';

$_['text_author']         = 'Author';
$_['text_author_support'] = 'Support';

$_['entry_licence'] = 'Licence code';
$_['entry_status']  = 'Status';


// Success
$_['success']         = 'Success: You have modified SEO URL Generator FREE module!';
$_['success_licence'] = 'The licence code was saved!';


// Error
$_['error_permission'] = 'Warning: You don\'t have permission to modify module SEO URL Generator FREE';
$_['error_warning']    = 'Warning: Please check the form carefully for errors!';
$_['error_licence']           = 'The licence code is not valid!';
$_['error_licence_empty']     = 'Input the licence code!';
$_['error_licence_not_valid'] = 'The licence code is not valid!';


// Part Settings
$_['text_part_settings'] = 'Settings';

$_['fieldset_base']         = 'Base settings';
$_['entry_licence']         = 'Input the licence code';
$_['entry_system']          = 'What system are you using?'; // for OC 2.x only
$_['entry_limit']           = 'Limit of items per a step in time of mass generation';
$_['help_limit']            = 'If you have a powerfull server you can select a greater number';
$_['entry_debug']           = 'Debug mode (for developers only)';
$_['help_debug']            = 'If there will happen any error in time of mass generation of SEO URLs, logs will help to find place and reason of error. Logs are written to the folder ' . DIR_LOGS . '. Don\'t forget to turn off Debug mode after testing';
$_['debug_0']               = 'Turn off logs';
$_['debug_1']               = 'Error - record errors only';
$_['debug_2']               = 'Info - record all actions';
$_['debug_3']               = 'Debug - record actions and their data';
$_['debug_4']               = 'Trace - record all data';

$_['fieldset_stores']           = 'Settings for each store'; // for OC 3.x

$_['fieldset_translit']           = 'Transliteration';
$_['entry_language_id']           = 'Source language'; // for OC 2.x only
$_['entry_translit_function']     = 'The transliteration rule';
$_['entry_delimiter_char']        = 'Symbol for separation of words';
$_['help_delimiter_char']         = 'This character (in computer sense) will replace other symbols that are bad for SEO URL. I mean such symbols as spaces, exclamation or question marks, commas and others.';
$_['char_underscore']             = 'Underscore &quot;_&quot;';
$_['char_hyphen']                 = 'Hyphen &quot;-&quot;';
$_['entry_change_delimiter_char'] = 'Changing of the separation symbol';
$_['help_change_delimiter_char']  = 'Actually symbols &quot;_&quot; and &quot;-&quot; both are convinient for SEO URLs. But there is an esthetic difference.';
$_['change_donot']                = 'Don\'t replace symbols &quot;-&quot; and &quot;_&quot;';
$_['change_underscore_to_hyphen'] = 'Replace &quot;_&quot; for &quot;-&quot;';
$_['change_hyphen_to_underscore'] = 'Replace &quot;-&quot; for &quot;_&quot;';
$_['entry_rewrite_on_save']       = 'Check up SEO URLs in time of editing';
$_['help_rewrite_on_save']        = 'If you will change names of product (and others essences) then their SEO URL have difference with names.<br><br>If you will turn on this option then SEO URL change according current name in time of each saving. And old SEO URL will be recorded for redirects.';
$_['title_custom_replace']        = 'Custom symbols for replacing';
$_['help_custom_replace']         = 'Fill a symbol per a line';
$_['entry_custom_replace_from']   = 'Search symbol';
$_['entry_custom_replace_to']     = 'Replace with symbol';

$_['fieldset_formulas']          = 'Formula for SEO URL generation';
$_['entry_category_formula']     = 'Formula SEO URL for categories';
$_['entry_product_formula']      = 'Formula SEO URL for products';
$_['entry_manufacturer_formula'] = 'Formula SEO URL for manufacturers';
$_['entry_information_formula']  = 'Formula SEO URL for information';
$_['text_available_vars']        = 'Available variables';
$_['help_vars']                  = '* You should use a symbol Symbol for separation of words between variables. For instance:';
$_['or']                         = 'or';

$_['button_save_settings'] = 'Save';

$_['error_formula_empty']     = 'Fill formula for generation of SEO URL!';
$_['error_formula_less_vars'] = 'There are not enough variables for generation of unique SEO URLs!';
$_['error_formula_pattern']   = 'You must use only declared <b>variables</b>. Also you should use Symbol for separation of words. You must delete such symbols as space, dot, comma, exclamation or question marks, "html" etc!';

$_['error_custom_replace_to_not_1_char'] = 'It is necessary that columns &quot;' . $_['entry_custom_replace_to'] . '&quot; and &quot;' . $_['entry_custom_replace_from'] . '&quot; contain equal number of symbols. Also it is possible use a single symbol in right column for replacing of all symbols from left column';


// Admin on Essences
$_['sug_button_generate'] = 'Generate SEO URL';
$_['sug_text_redirects'] = 'Redirects';
$_['sug_help_redirects'] = 'It is necessary to fill SEO URL of this essence without parent category or site address';
$_['sug_button_add_redirect'] = 'Add SEO URL for redirect';
$_['sug_button_delete_redirect'] = 'Delete redirect';
$_['sug_confirm_title'] = 'Confirm your action!';
$_['sug_confirm_body'] = '<p>Are you sure you want to remove the redirect ?</p><p>Keep in mind that this is an irreversible action and may affect the page\'s dropout from search. If suddenly you do not understand the meaning of this message, then please consult with the person who is responsible for SEO in your project.</p>';
$_['sug_confirm_btn_yes'] = 'Delete redirect';
$_['sug_confirm_btn_no'] = 'Cancel';

$_['sug_redirects_error_validate'] = 'SEO URL for redirect is invalid!';
$_['sug_redirects_error_title'] = 'Error!';
$_['sug_redirects_error_empty'] = 'SEO URL for redirect is empty!';
$_['sug_redirects_error_slash'] = 'SEO URL for redirect  contain slash!';
$_['sug_redirects_error_protocol'] = 'SEO URL contain site address!';
$_['sug_redirects_error_html'] = 'SEO URL contain extension .html - Often, it is wrong way!';
$_['sug_redirects_error_common'] = 'SEO URL for the redirect must meet the same requirements as the main SEO URL! That is, the SEO URL for the redirect should not contain the site address, parent category, the .html extension - only the SEO URL of a specific essence';


/* FREE VERSION
-------------------------------------------- */
$_['text_part_info'] = 'Information about extension';
$_['text_about_title'] = 'About extension';
$_['text_about'] = '<p>Perhaps this module is the most "thoughtful" extension that make SEO URLs in OpenCart.</p>
				<p>Unlike many similar solutions, <b>SEO URL Generator FREE by Serge Tkach</b> allows you to input redirects for products, categories, manufacturers. After all, it happens that a product or category needs to be assigned a different link. There is such functionality nn many other CMS. Using this module, this is possible in OpenCart too.</p>
				<p>In addition this extension will automatically change CNC with a 301 redirect in case if you change product or category name.
</p>';
$_['text_about_pro_title'] = 'About PRO version';
$_['text_about_pro'] = '<p>Version <b>SEO URL Generator PRO by Serge Tkach</b> can generate SEO URL not only for a single product, but massively generate CNC for hundreds or thousands of products that are already in the store. Mass generation can also come in handy if your store already has a CNC, but they are outdated (using underscore) or if you need to replace them with a shorter version (for example you can use product_id).</p>';