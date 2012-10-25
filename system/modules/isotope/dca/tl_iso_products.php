<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Isotope eCommerce Workgroup 2009-2012
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @author     Fred Bliss <fred.bliss@intelligentspark.com>
 * @author     Christian de la Haye <service@delahaye.de>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Include the callback provider
 */
require_once(TL_ROOT . '/system/modules/isotope/providers/ProductCallbacks.php');


/**
 * Table tl_iso_products
 */
$GLOBALS['TL_DCA']['tl_iso_products'] = array
(

	// Config
	'config' => array
	(
		'label'						=> &$GLOBALS['TL_LANG']['MOD']['iso_products'][0],
		'dataContainer'				=> 'ProductData',
		'enableVersioning'			=> true,
		'closed'					=> true,
		'gtable'					=> 'tl_iso_groups',
		'ctable'					=> array('tl_iso_downloads', 'tl_iso_product_categories', 'tl_iso_prices'),
		'onload_callback' => array
		(
			array('ProductCallbacks', 'applyAdvancedFilters'),
			array('ProductCallbacks', 'checkPermission'),
			array('ProductCallbacks', 'buildPaletteString'),
			array('ProductCallbacks', 'loadDefaultProductType')
		),
		'oncopy_callback' => array
		(
			array('ProductCallbacks', 'updateCategorySorting'),
		),
		'onsubmit_callback' => array
		(
			array('IsotopeBackend', 'truncateProductCache'),
			array('ProductCallbacks', 'storeDateAdded')
		),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'					=> 5,
			'fields'				=> array('name'),
			'flag'					=> 1,
			'panelLayout'			=> 'filter;sort,search',
			'icon'					=> 'system/modules/isotope/html/store-open.png',
			'paste_button_callback'	=> array('ProductCallbacks', 'pasteProduct'),
			'rootPaste'				=> true,
		),
		'label' => array
		(
			'fields'				=> array('name'),
			'format'				=> '%s',
			'label_callback'		=> array('ProductCallbacks', 'getRowLabel'),
		),
		'global_operations' => array
		(
			'new_product' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['new_product'],
				'href'				=> 'act=paste&mode=create&type=product',
				'class'				=> 'header_new',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
			),
			'new_variant' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['new_variant'],
				'href'				=> 'act=paste&mode=create&type=variant',
				'class'				=> 'header_new',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
			),
			'filter' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['filter'],
				'class'				=> ('header_iso_filter' . (is_array($this->Input->get('filter')) ? ' header_iso_filter_active' : '')),
				'attributes'		=> 'onclick="Backend.getScrollOffset();" style="display:none"',
			),
			'filter_noimages' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['filter_noimages'],
				'href'				=> 'filter[]=noimages',
				'class'				=> 'header_iso_filter_noimages isotope-filter',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
				'button_callback'	=> array('ProductCallbacks', 'filterButton'),
			),
			'filter_nocategory' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['filter_nocategory'],
				'href'				=> 'filter[]=nocategory',
				'class'				=> 'header_iso_filter_nocategory isotope-filter',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
				'button_callback'	=> array('ProductCallbacks', 'filterButton'),
			),
			'filter_new_today' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['filter_new_today'],
				'href'				=> 'filter[]=new_today',
				'class'				=> 'header_iso_filter_new_today isotope-filter',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
				'button_callback'	=> array('ProductCallbacks', 'filterButton'),
			),
			'filter_new_week' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['filter_new_week'],
				'href'				=> 'filter[]=new_week',
				'class'				=> 'header_iso_filter_new_week isotope-filter',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
				'button_callback'	=> array('ProductCallbacks', 'filterButton'),
			),
			'filter_new_month' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['filter_new_month'],
				'href'				=> 'filter[]=new_month',
				'class'				=> 'header_iso_filter_new_month isotope-filter',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
				'button_callback'	=> array('ProductCallbacks', 'filterButton'),
			),
			'filter_remove' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['filter_remove'],
				'href'				=> 'filter[]=test',
				'class'				=> 'header_iso_filter_remove isotope-filter',
				'attributes'		=> ('onclick="Backend.getScrollOffset();"' . (is_array($this->Input->get('filter')) ? '' : ' style="display:none"')),
				'button_callback'	=> array('ProductCallbacks', 'filterRemoveButton'),
			),
			'tools' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['tools'],
				'class'				=> 'header_isotope_tools',
				'attributes'		=> 'onclick="Backend.getScrollOffset();" style="display:none"',
			),
			'all' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'				=> 'act=select',
				'class'				=> 'header_edit_all isotope-tools',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"'
			),
			'toggleGroups' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['toggleGroups'],
				'href'				=> 'gtg=all',
				'class'				=> 'header_toggle isotope-tools',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
				'button_callback'	=> array('ProductCallbacks', 'toggleGroups')
			),
			'toggleVariants' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['toggleVariants'],
				'href'				=> 'ptg=all',
				'class'				=> 'header_toggle isotope-tools',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
				'button_callback'	=> array('ProductCallbacks', 'toggleVariants')
			),
			'groups' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['groups'],
				'href'				=> 'table=tl_iso_groups',
				'class'				=> 'header_iso_groups isotope-tools',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
				'button_callback'	=> array('ProductCallbacks', 'groupsButton')
			),
			'import' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['import'],
				'href'				=> 'key=import',
				'class'				=> 'header_import_assets isotope-tools',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
			),
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['edit'],
				'href'				=> 'act=edit',
				'icon'				=> 'edit.gif',
			),
			'copy' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['copy'],
				'href'				=> 'act=paste&amp;mode=copy&amp;childs=1',
				'icon'				=> 'copy.gif',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
			),
			'cut' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['copy'],
				'href'				=> 'act=paste&amp;mode=cut',
				'icon'				=> 'cut.gif',
				'attributes'		=> 'onclick="Backend.getScrollOffset();"',
			),
			'delete' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['delete'],
				'href'				=> 'act=delete',
				'icon'				=> 'delete.gif',
				'attributes'		=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
			),
			'toggle' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['toggle'],
				'icon'				=> 'visible.gif',
				'attributes'		=> 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'	=> array('tl_iso_products', 'toggleIcon')
			),
			'show' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['show'],
				'href'				=> 'act=show',
				'icon'				=> 'show.gif'
			),
			'tools' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['tools'],
				'icon'				=> 'system/modules/isotope/html/lightning.png',
				'attributes'		=> 'class="invisible isotope-contextmenu"',
			),
			'quick_edit' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['quick_edit'],
				'href'				=> 'key=quick_edit',
				'icon'				=> 'system/modules/isotope/html/table-select-cells.png',
				'button_callback'	=> array('ProductCallbacks', 'quickEditButton'),
				'attributes'		=> 'class="isotope-tools"',
			),
			'generate' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['generate'],
				'href'				=> 'key=generate',
				'icon'				=> 'system/modules/isotope/html/table-insert-row.png',
				'button_callback'	=> array('ProductCallbacks', 'generateButton'),
				'attributes'		=> 'class="isotope-tools"',
			),
			'related' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['related'],
				'href'				=> 'table=tl_iso_related_products',
				'icon'				=> 'system/modules/isotope/html/sitemap.png',
				'button_callback'	=> array('ProductCallbacks', 'relatedButton'),
				'attributes'		=> 'class="isotope-tools"',
			),
			'downloads' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['downloads'],
				'href'				=> 'table=tl_iso_downloads',
				'icon'				=> 'system/modules/isotope/html/paper-clip.png',
				'button_callback'	=> array('ProductCallbacks', 'downloadsButton'),
				'attributes'		=> 'class="isotope-tools"',
			),
			'prices' => array
			(
				'label'				=> &$GLOBALS['TL_LANG']['tl_iso_products']['prices'],
				'href'				=> 'table=tl_iso_prices',
				'icon'				=> 'system/modules/isotope/html/price-tag.png',
				'button_callback'	=> array('ProductCallbacks', 'pricesButton'),
				'attributes'		=> 'class="isotope-tools"',
			),
		),
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'				=> array('type', 'pid', 'protected'),
		'default'					=> '{general_legend},type',
	),

	// Subpalettes
	'subpalettes' => array
	(
		'protected'					=> 'groups',
	),

	// Fields
	'fields' => array
	(
		'pid' => array
		(
			// Fix for DC_Table, otherwise getPalette() will not use the PID value
			'eval'					=> array('submitOnChange'=>true),
		),
		'dateAdded' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['MSC']['dateAdded'],
			'eval'					=> array('rgxp'=>'datim'),
			'attributes'			=> array('fe_sorting'=>true),
		),
		'type' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['type'],
			'exclude'               => true,
			'filter'				=> true,
			'inputType'				=> 'select',
			'options_callback'		=> array('ProductCallbacks', 'getProductTypes'),
			'foreignKey'			=> (strlen($this->Input->get('table')) ? 'tl_iso_producttypes.name' : null),
			'eval'					=> array('mandatory'=>true, 'submitOnChange'=>true, 'includeBlankOption'=>true),
			'attributes'			=> array('legend'=>'general_legend', 'fixed'=>true, 'inherit'=>true),
		),
		'pages' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['pages'],
			'exclude'               => true,
			'filter'				=> true,
			'inputType'				=> 'pageTree',
			'foreignKey'			=> 'tl_page.title',
			'eval'					=> array('mandatory'=>false, 'multiple'=>true, 'fieldType'=>'checkbox'),
			'attributes'			=> array('legend'=>'general_legend', 'fixed'=>true, 'inherit'=>true),
			'load_callback'			=> array
			(
				array('ProductCallbacks', 'loadProductCategories'),
			),
			'save_callback'			=> array
			(
				array('ProductCallbacks', 'saveProductCategories'),
			),
		),
		'inherit' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['inherit'],
			'exclude'               => true,
			'inputType'				=> 'inheritCheckbox',
			'eval'					=> array('multiple'=>true, 'doNotShow'=>true),
		),
		'alias' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['alias'],
			'exclude'               => true,
			'search'				=> true,
			'sorting'				=> true,
			'inputType'				=> 'text',
			'eval'					=> array('rgxp'=>'alnum', 'doNotCopy'=>true, 'spaceToUnderscore'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'attributes'			=> array('legend'=>'general_legend', 'fixed'=>true, 'inherit'=>true),
			'save_callback' => array
			(
				array('ProductCallbacks', 'generateAlias'),
			),
		),
		'sku' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['sku'],
			'exclude'               => true,
			'search'				=> true,
			'sorting'				=> true,
			'inputType'				=> 'text',
			'eval'					=> array('mandatory'=>true, 'maxlength'=>128, 'unique'=>true, 'tl_class'=>'w50'),
			'attributes'			=> array('legend'=>'general_legend', 'fe_sorting'=>true, 'fe_search'=>true),
		),
		'name' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['name'],
			'exclude'               => true,
			'search'				=> true,
			'sorting'				=> true,
			'inputType'				=> 'text',
			'eval'					=> array('mandatory'=>true, 'tl_class'=>'clr long'),
			'attributes'			=> array('legend'=>'general_legend', 'multilingual'=>true, 'fixed'=>true, 'fe_sorting'=>true, 'fe_search'=>true),
		),
		'teaser' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['teaser'],
			'exclude'               => true,
			'search'				=> true,
			'inputType'				=> 'textarea',
			'eval'					=> array('style'=>'height:80px'),
			'attributes'			=> array('legend'=>'general_legend', 'multilingual'=>true),
		),
		'description' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['description'],
			'exclude'               => true,
			'search'				=> true,
			'inputType'				=> 'textarea',
			'eval'					=> array('mandatory'=>true, 'rte'=>'tinyMCE', 'tl_class'=>'clr'),
			'attributes'			=> array('legend'=>'general_legend', 'multilingual'=>true, 'fe_search'=>true),
		),
		'description_meta' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['description_meta'],
			'exclude'               => true,
			'search'				=> true,
			'inputType'				=> 'textarea',
			'eval'					=> array('style'=>'height:60px'),
			'attributes'			=> array('legend'=>'meta_legend', 'multilingual'=>true),
		),
		'keywords_meta' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['keywords_meta'],
			'exclude'               => true,
			'search'				=> true,
			'inputType'				=> 'textarea',
			'eval'					=> array('style'=>'height:40px'),
			'attributes'			=> array('legend'=>'meta_legend', 'multilingual'=>true),
		),
		'price' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['price'],
			'exclude'               => true,
			'inputType'				=> 'text',
			'eval'					=> array('mandatory'=>true, 'maxlength'=>13, 'rgxp'=>'price', 'tl_class'=>'w50'),
			'attributes'			=> array('legend'=>'pricing_legend', 'fe_sorting'=>true, 'dynamic'=>true),
		),
		'prices' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['prices'],
			'inputType'				=> 'dcaWizard',
			'foreignTable'			=> 'tl_iso_prices',
			'eval'					=> array('tl_class'=>'clr'),
		),
		'price_tiers' => array
		(
			'eval'					=> array('dynamic'=>true),
			'tableformat' => array
			(
				'min'		=> array
				(
					'label'			=> &$GLOBALS['TL_LANG']['tl_iso_products']['price_tiers']['min'],
					'format'		=> &$GLOBALS['TL_LANG']['tl_iso_products']['price_tiers']['min_format'],
				),
				'price'		=> array
				(
					'label'			=> &$GLOBALS['TL_LANG']['tl_iso_products']['price_tiers']['price'],
					'rgxp'			=> 'price'
				),
				'tax_class'	=> array
				(
					'doNotShow'		=> true,
				),
			),
		),
		'tax_class' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['tax_class'],
			'exclude'               => true,
			'inputType'				=> 'select',
			'foreignKey'			=> 'tl_iso_tax_class.name',
			'attributes'			=> array('legend'=>'pricing_legend', 'tl_class'=>'w50'),
			'eval'					=> array('includeBlankOption'=>true, 'dynamic'=>true),
		),
		'baseprice' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['baseprice'],
			'exclude'               => true,
			'inputType'				=> 'timePeriod',
			'foreignKey'			=> 'tl_iso_baseprice.name',
			'attributes'			=> array('legend'=>'pricing_legend', 'tl_class'=>'w50'),
			'eval'					=> array('includeBlankOption'=>true),
		),
		'shipping_weight' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['shipping_weight'],
			'exclude'               => true,
			'inputType'				=> 'timePeriod',
			'default'				=> array('', 'kg'),
			'options'				=> array('mg', 'g', 'kg', 't', 'ct', 'oz', 'lb', 'st', 'grain'),
			'reference'				=> &$GLOBALS['ISO_LANG']['WGT'],
			'eval'					=> array('rgxp'=>'digit', 'tl_class'=>'w50 wizard', 'helpwizard'=>true),
			'attributes'			=> array('legend'=>'shipping_legend'),
		),
		'shipping_exempt' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['shipping_exempt'],
			'exclude'               => true,
			'inputType'				=> 'checkbox',
			'eval'					=> array('tl_class'=>'w50'),
			'attributes'			=> array('legend'=>'shipping_legend'),
		),
		'images' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['images'],
			'exclude'               => true,
			'inputType'				=> 'mediaManager',
			'explanation'			=> 'mediaManager',
			'eval'					=> array('extensions'=>'jpeg,jpg,png,gif', 'helpwizard'=>true),
			'attributes'			=> array('legend'=>'media_legend', 'fixed'=>true, 'multilingual'=>true, 'dynamic'=>true),
		),
		'protected' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['protected'],
			'exclude'               => true,
			'inputType'				=> 'checkbox',
			'eval'					=> array('submitOnChange'=>true, 'tl_class'=>'clr'),
			'attributes'			=> array('legend'=>'expert_legend'),
		),
		'groups' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['groups'],
			'exclude'               => true,
			'inputType'				=> 'checkbox',
			'foreignKey'			=> 'tl_member_group.name',
			'eval'					=> array('mandatory'=>true, 'multiple'=>true),
		),
		'guests' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['guests'],
			'exclude'               => true,
			'inputType'				=> 'checkbox',
			'eval'					=> array('tl_class'=>'w50'),
			'attributes'			=> array('legend'=>'expert_legend'),
		),
		'cssID' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['cssID'],
			'exclude'               => true,
			'inputType'				=> 'text',
			'eval'					=> array('multiple'=>true, 'size'=>2, 'tl_class'=>'w50'),
			'attributes'			=> array('legend'=>'expert_legend'),
		),
		'published' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['published'],
			'exclude'               => true,
			'filter'				=> true,
			'inputType'				=> 'checkbox',
			'eval'					=> array('doNotCopy'=>true),
			'attributes'			=> array('legend'=>'publish_legend', 'fixed'=>true, 'variant_fixed'=>true),
			'save_callback' => array
			(
				array('IsotopeBackend', 'truncateProductCache'),
			),
		),
		'start' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['start'],
			'exclude'               => true,
			'inputType'				=> 'text',
			'eval'					=> array('rgxp'=>'date', 'datepicker'=>(method_exists($this,'getDatePickerString') ? $this->getDatePickerString() : true), 'tl_class'=>'w50 wizard'),
			'attributes'			=> array('legend'=>'publish_legend', 'fixed'=>true, 'variant_fixed'=>true),
		),
		'stop' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['stop'],
			'exclude'               => true,
			'inputType'				=> 'text',
			'eval'					=> array('rgxp'=>'date', 'datepicker'=>(method_exists($this,'getDatePickerString') ? $this->getDatePickerString() : true), 'tl_class'=>'w50 wizard'),
			'attributes'			=> array('legend'=>'publish_legend', 'fixed'=>true, 'variant_fixed'=>true),
		),
		'source' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['source'],
			'eval'					=> array('mandatory'=>true, 'required'=>true, 'fieldType'=>'radio'),
		),
		'variant_attributes' => array
		(
			'label'					=> &$GLOBALS['TL_LANG']['tl_iso_products']['variant_attributes'],
			'inputType'				=> 'variantWizard',
			'options'				=> array(),
			'eval'					=> array('doNotSaveEmpty'=>true),
		),
	),
);


/**
 * Class tl_iso_products
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_iso_products extends Backend
{


	/**
	 * Import a back end user and Isotope objects
	 */
	public function __construct()
	{
		parent::__construct();

		$this->import('BackendUser', 'User');
		$this->import('Isotope');
	}


	/**
	 * Generate all combination of product attributes
	 * @param object
	 * @return string
	 */
	public function generateVariants($dc)
	{
		$objProduct = $this->Database->prepare("SELECT id, pid, language, type, (SELECT attributes FROM tl_iso_producttypes WHERE id=tl_iso_products.type) AS attributes, (SELECT variant_attributes FROM tl_iso_producttypes WHERE id=tl_iso_products.type) AS variant_attributes FROM tl_iso_products WHERE id=?")->limit(1)->execute($dc->id);

		$doNotSubmit = false;
		$strBuffer = '';
		$arrOptions = array();
		$arrAttributes = deserialize($objProduct->attributes);

		if (is_array($arrAttributes))
		{
			foreach ($arrAttributes as $attribute => $arrConfig)
			{
				// Skip disabled attributes
				if (!$arrConfig['enabled'])
				{
					continue;
				}

				if ($GLOBALS['TL_DCA']['tl_iso_products']['fields'][$attribute]['attributes']['variant_option'])
				{
					$GLOBALS['TL_DCA']['tl_iso_products']['fields'][$attribute]['eval']['mandatory'] = true;
					$GLOBALS['TL_DCA']['tl_iso_products']['fields'][$attribute]['eval']['multiple'] = true;

					$arrField = $this->prepareForWidget($GLOBALS['TL_DCA']['tl_iso_products']['fields'][$attribute], $attribute);

					foreach ($arrField['options'] as $k => $option)
					{
						if ($option['value'] == '')
						{
							unset($arrField['options'][$k]);
						}
					}

					$objWidget = new CheckBox($arrField);

					if ($this->Input->post('FORM_SUBMIT') == 'tl_product_generate')
					{
						$objWidget->validate();

						if ($objWidget->hasErrors())
						{
							$doNotSubmit = true;
						}
						else
						{
							$arrOptions[$attribute] = $objWidget->value;
						}
					}

					$strBuffer .= $objWidget->parse();
				}
			}

			if ($this->Input->post('FORM_SUBMIT') == 'tl_product_generate' && !$doNotSubmit)
			{
				$time = time();
				$arrCombinations = array();

				foreach ($arrOptions as $name => $options)
				{
					$arrTemp = $arrCombinations;
					$arrCombinations = array();

					foreach ($options as $option)
					{
						if (empty($arrTemp))
						{
							$arrCombinations[][$name] = $option;
							continue;
						}

						foreach ($arrTemp as $temp)
						{
							$temp[$name] = $option;
							$arrCombinations[] = $temp;
						}
					}
				}

				foreach ($arrCombinations as $combination)
				{
					$objVariant = $this->Database->prepare("SELECT * FROM tl_iso_products WHERE pid=? AND " . implode('=? AND ', array_keys($combination)) . "=?")
												 ->execute(array_merge(array($objProduct->id), $combination));

					if (!$objVariant->numRows)
					{
						$this->Database->prepare("INSERT INTO tl_iso_products (tstamp,pid,inherit,type," . implode(',', array_keys($combination)) . ") VALUES (?,?,?,?" . str_repeat(',?', count($combination)) . ")")
									   ->execute(array_merge(array($time, $objProduct->id, array_diff((array)$objProduct->variant_attributes, array('sku', 'price', 'shipping_weight', 'published')), $objProduct->type), $combination));
					}
				}

				$this->redirect(str_replace('&key=generate', '&key=quick_edit', $this->Environment->request));
			}
		}

		// Return form
		return '
<div id="tl_buttons">
<a href="'.ampersand(str_replace('&key=generate', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
</div>

<h2 class="sub_headline">'.sprintf($GLOBALS['TL_LANG']['tl_iso_products']['generate'][1], $dc->id).'</h2>'.$this->getMessages().'

<form action="'.ampersand($this->Environment->request, true).'" id="tl_product_generate" class="tl_form" method="post">
<div class="tl_formbody_edit">
<input type="hidden" name="FORM_SUBMIT" value="tl_product_generate">
<input type="hidden" name="REQUEST_TOKEN" value="'.REQUEST_TOKEN.'">

<div class="tl_tbox block">
' . $strBuffer . '
</div>

</div>

<div class="tl_formbody_submit">

<div class="tl_submit_container">
  <input type="submit" name="save" id="save" class="tl_submit" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['tl_iso_products']['generate'][0]).'">
</div>

</div>
</form>';
	}


	/**
	 * Quickly edit the most common product variant data
	 * @param object
	 * @return string
	 */
	public function quickEditVariants($dc)
	{
		$objProduct = $this->Database->prepare("SELECT id, pid, language, type, (SELECT attributes FROM tl_iso_producttypes WHERE id=tl_iso_products.type) AS attributes, (SELECT variant_attributes FROM tl_iso_producttypes WHERE id=tl_iso_products.type) AS variant_attributes, (SELECT prices FROM tl_iso_producttypes WHERE id=tl_iso_products.type) AS prices FROM tl_iso_products WHERE id=?")->limit(1)->execute($dc->id);
		$arrQuickEditFields = $objProduct->prices ? array('sku', 'shipping_weight') : array('sku', 'price', 'shipping_weight');

		$arrFields = array();
		$arrAttributes = deserialize($objProduct->attributes);
		$arrVarAttributes = deserialize($objProduct->variant_attributes);

		if (is_array($arrAttributes))
		{
			foreach ($arrAttributes as $attribute => $arrConfig)
			{
				if ($arrConfig['enabled'] && $GLOBALS['TL_DCA']['tl_iso_products']['fields'][$attribute]['attributes']['variant_option'])
				{
					$arrFields[] = $attribute;
				}
			}
		}

		$objVariants = $this->Database->prepare("SELECT * FROM tl_iso_products WHERE pid=? AND language=''")->execute($dc->id);
		$strBuffer = '<div id="tl_buttons">
<a href="'.ampersand(str_replace('&key=quick_edit', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
</div>

<h2 class="sub_headline">'.sprintf($GLOBALS['TL_LANG']['tl_iso_products']['quick_edit'][1], $dc->id).'</h2>'.$this->getMessages().'

<form action="'.ampersand($this->Environment->request, true).'" id="tl_product_quick_edit" class="tl_form" method="post">
<div class="tl_formbody_edit">
<input type="hidden" name="FORM_SUBMIT" value="tl_product_quick_edit">
<input type="hidden" name="REQUEST_TOKEN" value="'.REQUEST_TOKEN.'">

<div class="tl_tbox block">
<table width="100%" border="0" cellpadding="5" cellspacing="0" summary="">
<thead>
<th>' . $GLOBALS['TL_LANG']['tl_iso_products']['variantValuesLabel'] . '</th>';

		foreach ($arrQuickEditFields as $field)
		{
			if ($arrVarAttributes[$field]['enabled'])
			{
				$strBuffer .= '<th>'.$GLOBALS['TL_LANG']['tl_iso_products'][$field][0].'</th>';
			}
		}

$strBuffer .= '<th style="text-align:center"><img src="system/themes/default/images/published.gif" width="16" height="16" alt="' . $GLOBALS['TL_LANG']['tl_iso_products']['published'][0].'"><br><input type="checkbox" onclick="Backend.toggleCheckboxes(this, \'ctrl_published\')"></th>
</thead>';

		$arrFields = array_flip($arrFields);
		$globalDoNotSubmit = false;

		while ($objVariants->next())
		{
			$arrWidgets = array();
			$doNotSubmit = false;
			$arrSet = array();

			$arrPublished[$objVariants->id] = $objVariants->published;

			foreach ($arrQuickEditFields as $field)
			{
				if ($arrVarAttributes[$field]['enabled'])
				{
					$strClass = $GLOBALS['BE_FFL'][$GLOBALS['TL_DCA']['tl_iso_products']['fields'][$field]['inputType']];
					$arrWidgets[$field] = new $strClass($this->prepareForWidget($GLOBALS['TL_DCA']['tl_iso_products']['fields'][$field], $field.'[' . $objVariants->id .']', $objVariants->{$field}));
				}
			}

			foreach ($arrWidgets as $key=>$objWidget)
			{
				switch ($key)
				{
					case 'sku':
						$objWidget->class = 'tl_text_2';
						break;

					case 'shipping_weight':
						$objWidget->class = 'tl_text_trbl';
						break;

					default:
						$objWidget->class = 'tl_text_3';
						break;
				}

				if ($this->Input->post('FORM_SUBMIT') == 'tl_product_quick_edit')
				{
					$objWidget->validate();

					if ($objWidget->hasErrors())
					{
						$doNotSubmit = true;
						$globalDoNotSubmit = true;
					}
					else
					{
						$arrSet[$key] = $objWidget->value;
					}
				}
			}


			if ($this->Input->post('FORM_SUBMIT') == 'tl_product_quick_edit' && !$doNotSubmit)
			{
				$arrPublished = $this->Input->post('published');
				$arrSet['published'] = ($arrPublished[$objVariants->id] ? $arrPublished[$objVariants->id] : '');

				$this->Database->prepare("UPDATE tl_iso_products %s WHERE id=?")
							   ->set($arrSet)
							   ->execute($objVariants->id);
			}

			$arrValues = array();

			foreach (array_intersect_key($objVariants->row(), $arrFields) as $k => $v)
			{
				$arrValues[$k] = $this->Isotope->formatValue('tl_iso_products', $k, $v);
			}

			$strBuffer .= '
<tr>
	<td>'.implode(', ', $arrValues).'</td>';
	foreach ($arrQuickEditFields as $field)
	{
		if ($arrVarAttributes[$field]['enabled'])
		{
			$strBuffer .= '<td>'.$arrWidgets[$field]->generate().'</td>';
		}
	}

	$strBuffer .= '<td style="text-align:center"><input type="checkbox" id="ctrl_published_'.$objVariants->id.'" name="published['.$objVariants->id.']" value="1"'.($arrPublished[$objVariants->id] ? ' checked="checked"' : '').' class="tl_checkbox"></td>
<tr>';

		}

		if ($this->Input->post('FORM_SUBMIT') == 'tl_product_quick_edit' && !$globalDoNotSubmit)
		{
			if (strlen($this->Input->post('saveNclose')))
			{
				$this->redirect(str_replace('&key=quick_edit', '', $this->Environment->request));
			}
			else
			{
				$this->reload();
			}
		}

		return $strBuffer . '
</table>
</div>

</div>

<div class="tl_formbody_submit">

<div class="tl_submit_container">
  <input type="submit" name="save" id="save" class="tl_submit" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['MSC']['save']).'">
  <input type="submit" name="saveNclose" id="saveNclose" class="tl_submit" accesskey="c" value="'.specialchars($GLOBALS['TL_LANG']['MSC']['saveNclose']).'">
</div>

</div>
</form>';
	}


	/**
	 * Import images and other media file for products
	 * @param object
	 * @param array
	 * @return string
	 */
	public function importAssets($dc, $arrNewImages=array())
	{
		$objTree = new FileTree($this->prepareForWidget($GLOBALS['TL_DCA']['tl_iso_products']['fields']['source'], 'source', null, 'source', 'tl_iso_products'));

		// Import assets
		if ($this->Input->post('FORM_SUBMIT') == 'tl_iso_products_import' && $this->Input->post('source') != '')
		{
			$this->import('Files');

			$strPath = $this->Input->post('source');
			$arrFiles = scan(TL_ROOT . '/' . $strPath);

			if (empty($arrFiles))
			{
				$_SESSION['TL_ERROR'][] = $GLOBALS['ISO_LANG']['MSC']['noFilesInFolder'];
				$this->reload();
			}

			$arrDelete = array();
			$objProducts = $this->Database->prepare("SELECT * FROM tl_iso_products WHERE pid=0")
										  ->execute();

			while ($objProducts->next())
			{
				$arrImageNames  = array();
				$arrImages = deserialize($objProducts->images);

				if (!is_array($arrImages))
				{
					$arrImages = array();
				}
				else
				{
					foreach ($arrImages as $row)
					{
						if ($row['src'])
						{
							$arrImageNames[] = $row['src'];
						}
					}
				}

				$arrPattern = array();
				$arrPattern[] = $objProducts->alias ?  standardize($objProducts->alias, true) : null;
				$arrPattern[] = $objProducts->sku ? $objProducts->sku : null;
				$arrPattern[] = $objProducts->sku ? standardize($objProducts->sku, true) : null;
				$arrPattern[] = !empty($arrImageNames) ? implode('|', $arrImageNames) : null;

				// !HOOK: add custom import regex patterns
				if (isset($GLOBALS['ISO_HOOKS']['addAssetImportRegexp']) && is_array($GLOBALS['ISO_HOOKS']['addAssetImportRegexp']))
				{
					foreach ($GLOBALS['ISO_HOOKS']['addAssetImportRegexp'] as $callback)
					{
						$this->import($callback[0]);

						$arrPattern = $this->$callback[0]->$callback[1]($arrPattern,$objProducts);
					}
				}

				$strPattern = '@^(' . implode('|', array_filter($arrPattern)) . ')@i';

				$arrMatches = preg_grep($strPattern, $arrFiles);

				if (!empty($arrMatches))
				{
					$arrNewImages = array();

					foreach ($arrMatches as $file)
					{
						if (is_dir(TL_ROOT . '/' . $strPath . '/' . $file))
						{
							$arrSubfiles = scan(TL_ROOT . '/' . $strPath . '/' . $file);
							if (!empty($arrSubfiles))
							{
								foreach ($arrSubfiles as $subfile)
								{
									if (is_file($strPath . '/' . $file . '/' . $subfile))
									{
										$objFile = new File($strPath . '/' . $file . '/' . $subfile);

										if ($objFile->isGdImage)
										{
											$arrNewImages[] = $strPath . '/' . $file . '/' . $subfile;
										}
									}
								}
							}
						}
						elseif (is_file(TL_ROOT . '/' . $strPath . '/' . $file))
						{
							$objFile = new File($strPath . '/' . $file);

							if ($objFile->isGdImage)
							{
								$arrNewImages[] = $strPath . '/' . $file;
							}
						}
					}

					if (!empty($arrNewImages))
					{
						foreach ($arrNewImages as $strFile)
						{
							$pathinfo = pathinfo(TL_ROOT . '/' . $strFile);

							// Make sure directory exists
							$this->Files->mkdir('isotope/' . substr($pathinfo['filename'], 0, 1) . '/');

							$strCacheName = $pathinfo['filename'] . '-' . substr(md5_file(TL_ROOT . '/' . $strFile), 0, 8) . '.' . $pathinfo['extension'];

							$this->Files->copy($strFile, 'isotope/' . substr($pathinfo['filename'], 0, 1) . '/' . $strCacheName);
							$arrImages[] = array('src'=>$strCacheName);
							$arrDelete[] = $strFile;

							$_SESSION['TL_CONFIRM'][] = sprintf('Imported file %s for product "%s"', $pathinfo['filename'] . '.' . $pathinfo['extension'], $objProducts->name);

						}

						$this->Database->prepare("UPDATE tl_iso_products SET images=? WHERE id=?")->execute(serialize($arrImages), $objProducts->id);
					}
				}
			}

			if (!empty($arrDelete))
			{
				$arrDelete = array_unique($arrDelete);

				foreach ($arrDelete as $file)
				{
					$this->Files->delete($file);
				}
			}

			$this->reload();
		}

		// Return form
		return '
<div id="tl_buttons">
<a href="'.ampersand(str_replace('&key=import', '', $this->Environment->request)).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
</div>

<h2 class="sub_headline">'.$GLOBALS['TL_LANG']['tl_iso_products']['import'][1].'</h2>'.$this->getMessages().'

<form action="'.ampersand($this->Environment->request, true).'" id="tl_iso_products_import" class="tl_form" method="post">
<div class="tl_formbody_edit">
<input type="hidden" name="FORM_SUBMIT" value="tl_iso_products_import">
<input type="hidden" name="REQUEST_TOKEN" value="'.REQUEST_TOKEN.'">

<div class="tl_tbox block">
  <h3><label for="source">'.$GLOBALS['TL_LANG']['tl_iso_products']['source'][0].'</label> <a href="typolight/files.php" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['fileManager']) . '" onclick="Backend.getScrollOffset(); this.blur(); Backend.openWindow(this, 750, 500); return false;">' . $this->generateImage('filemanager.gif', $GLOBALS['TL_LANG']['MSC']['fileManager'], 'style="vertical-align:text-bottom;"') . '</a></h3>
  '.$objTree->generate().(strlen($GLOBALS['TL_LANG']['tl_iso_products']['source'][1]) ? '
  <p class="tl_help">'.$GLOBALS['TL_LANG']['tl_iso_products']['source'][1].'</p>' : '').'
</div>

</div>

<div class="tl_formbody_submit">

<div class="tl_submit_container">
<input type="submit" name="save" id="save" class="tl_submit" alt="import product assets" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['tl_iso_products']['import'][0]).'">
</div>

</div>
</form>';
	}


	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));

			// Stop the DC_ProductData overload detection
			$this->Session->set('PRODUCTDATA_OVERLOAD', false);

			$this->redirect($this->getReferer());
		}

/**
 * @todo tl_iso_products is missing in groups settings
 *
		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iso_products::published', 'alexf'))
		{
			return '';
		}
*/

		$objProductType = $this->Database->execute("SELECT * FROM tl_iso_producttypes WHERE id=" . (int) $row['type']);
		$arrAttributes = $row['pid'] ? deserialize($objProductType->variant_attributes, true) : deserialize($objProductType->attributes, true);
		$time = time();

		if (($arrAttributes['start']['enabled'] && $row['start'] != '' && $row['start'] > $time) || ($arrAttributes['stop']['enabled'] && $row['stop'] != '' && $row['stop'] < $time))
		{
			return $this->generateImage('system/modules/isotope/html/invisible-startstop.png', $label).' ';
		}
		elseif ($row['published'] != '1')
		{
			$icon = 'invisible.gif';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);
		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}


	/**
	 * Publish/unpublish a product
	 * @param integer
	 * @param boolean
	 * @return void
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to edit
		$this->Input->setGet('id', $intId);
		$this->Input->setGet('act', 'toggle');
		$this->checkPermission();

/**
 * @todo tl_iso_products is missing in groups settings
 *
		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_iso_products::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish product ID "'.$intId.'"', 'tl_iso_products toggleVisibility', TL_ERROR);
			$this->redirect($this->Environment->script.'?act=error');
		}
*/

		$this->createInitialVersion('tl_iso_products', $intId);

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_iso_products']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_iso_products']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_iso_products SET published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);

		$this->createNewVersion('tl_iso_products', $intId);
	}


	/**
	 * Initialize the tl_iso_products DCA
	 * @return void
	 */
	public function loadProductsDCA()
	{
		$objAttributes = $this->Database->execute("SELECT * FROM tl_iso_attributes");

		while ($objAttributes->next())
		{
			// Keep field settings made through DCA code
			$arrData = is_array($GLOBALS['TL_DCA']['tl_iso_products']['fields'][$objAttributes->field_name]) ? $GLOBALS['TL_DCA']['tl_iso_products']['fields'][$objAttributes->field_name] : array();

			$arrData['label']		= array($objAttributes->name, $objAttributes->description);
			$arrData['exclude']		= true;
			$arrData['inputType']	= ((TL_MODE == 'BE' && $GLOBALS['ISO_ATTR'][$objAttributes->type]['backend'] != '') ? $GLOBALS['ISO_ATTR'][$objAttributes->type]['backend'] : ((TL_MODE == 'FE' && $GLOBALS['ISO_ATTR'][$objAttributes->type]['frontend'] != '') ? $GLOBALS['ISO_ATTR'][$objAttributes->type]['frontend'] : $objAttributes->type));
			$arrData['attributes']	= $objAttributes->row();
			$arrData['eval']		= is_array($arrData['eval']) ? array_merge($arrData['eval'], $arrData['attributes']) : $arrData['attributes'];

			if ($objAttributes->be_filter)
			{
				$arrData['filter'] = true;
			}

			if ($objAttributes->be_search)
			{
				$arrData['search'] = true;
			}

			// Initialize variant options
			if ($objAttributes->variant_option)
			{
				$arrData['eval']['mandatory'] = true;
				$arrData['eval']['multiple'] = false;
				$arrData['eval']['size'] = 1;
			}

			// Add date picker
			if ($objAttributes->rgxp == 'date')
			{
				$arrData['eval']['datepicker'] = (method_exists($this, 'getDatePickerString') ? $this->getDatePickerString() : true);
			}

			// Textarea cannot be w50
			if ($objAttributes->type == 'textarea' || $objAttributes->rte != '')
			{
				$arrData['eval']['tl_class'] = 'clr';
			}

			// Customer defined widgets
			if ($GLOBALS['ISO_ATTR'][$objAttributes->type]['customer_defined'])
			{
				$arrData['attributes']['customer_defined'] = true;
			}

			// Install save_callback for upload widgets
			if ($objAttributes->type == 'upload')
			{
				$arrData['save_callback'][] = array('IsotopeFrontend', 'saveUpload');
			}

			// Parse multiline/multilingual foreignKey
			$objAttributes->foreignKey = $this->parseForeignKey($objAttributes->foreignKey, $GLOBALS['TL_LANGUAGE']);

			// Prepare options
			if ($objAttributes->foreignKey != '' && !$objAttributes->variant_option)
			{
				$arrData['foreignKey'] = $objAttributes->foreignKey;
				$arrData['eval']['includeBlankOption'] = true;
				unset($arrData['options']);
			}
			else
			{
				$arrData['options'] = array();
				$arrData['reference'] = array();

				if ($objAttributes->foreignKey)
				{
					$arrKey = explode('.', $objAttributes->foreignKey, 2);
					$arrOptions = $this->Database->execute("SELECT id AS value, {$arrKey[1]} AS label FROM {$arrKey[0]} ORDER BY label")->fetchAllAssoc();
				}
				else
				{
					$arrOptions = deserialize($objAttributes->options);
				}

				if (is_array($arrOptions) && !empty($arrOptions))
				{
					$strGroup = '';

					foreach ($arrOptions as $option)
					{
						if (!strlen($option['value']))
						{
							$arrData['eval']['includeBlankOption'] = true;
							$arrData['eval']['blankOptionLabel'] = $option['label'];
							continue;
						}
						elseif ($option['group'])
						{
							$strGroup = $option['value'];
							continue;
						}

						if (strlen($strGroup))
						{
							$arrData['options'][$strGroup][$option['value']] = $option['label'];
						}
						else
						{
							$arrData['options'][$option['value']] = $option['label'];
						}

						$arrData['reference'][$option['value']] = $option['label'];
					}
				}
			}

			unset($arrData['eval']['foreignKey']);
			unset($arrData['eval']['options']);

			if (is_array($GLOBALS['ISO_ATTR'][$objAttributes->type]['callback']) && !empty($GLOBALS['ISO_ATTR'][$objAttributes->type]['callback']))
			{
				foreach ($GLOBALS['ISO_ATTR'][$objAttributes->type]['callback'] as $callback)
				{
					$this->import($callback[0]);
					$arrData = $this->{$callback[0]}->{$callback[1]}($objAttributes->field_name, $arrData);
				}
			}

			$GLOBALS['TL_DCA']['tl_iso_products']['fields'][$objAttributes->field_name] = $arrData;
		}

		$GLOBALS['ISO_CONFIG']['variant_options'] = array();
		$GLOBALS['ISO_CONFIG']['multilingual'] = array();
		$GLOBALS['ISO_CONFIG']['dynamicAttributes'] = array();

		foreach ($GLOBALS['TL_DCA']['tl_iso_products']['fields'] as $attribute => $config)
		{
			if ($config['attributes']['variant_option'])
			{
				$GLOBALS['ISO_CONFIG']['variant_options'][] = $attribute;
			}

			if ($config['attributes']['multilingual'])
			{
				$GLOBALS['ISO_CONFIG']['multilingual'][] = $attribute;
			}

			if ($config['attributes']['dynamic'] || $config['eval']['multiple'])
			{
				$GLOBALS['ISO_CONFIG']['dynamicAttributes'][] = $attribute;
			}
		}
	}


	/**
	 * Returns the foreign key for a certain language with a fallback option
	 * @param string
	 * @param string
	 * @return mixed
	 */
	private function parseForeignKey($strSettings, $strLanguage=false)
	{
		$strFallback = null;
		$arrLines = trimsplit('@\r\n|\n|\r@', $strSettings);

		// Return false if there are no lines
		if ($strSettings == '' || !is_array($arrLines) || empty($arrLines))
		{
			return null;
		}

		// Loop over the lines
		foreach ($arrLines as $strLine)
		{
			// Ignore empty lines and comments
			if ($strLine == '' || strpos($strLine, '#') === 0)
			{
				continue;
			}

			// Check for a language
			if (strpos($strLine, '=') === 2)
			{
				list($language, $foreignKey) = explode('=', $strLine, 2);

				if ($language == $strLanguage)
				{
					return $foreignKey;
				}
				elseif (is_null($strFallback))
				{
					$strFallback = $foreignKey;
				}
			}

			// Otherwise the first row is the fallback
			elseif (is_null($strFallback))
			{
				$strFallback = $strLine;
			}
		}

		return $strFallback;
	}
}

