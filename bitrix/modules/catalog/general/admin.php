<?
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class CCatalogAdmin
{
	function get_other_elements_menu($IBLOCK_TYPE_ID, $IBLOCK_ID, $arSection, &$more_url)
	{
		$urlSectionAdminPage = CIBlock::GetAdminSectionListLink($IBLOCK_ID, array('catalog' => null));
		$more_url[] = $urlSectionAdminPage."&find_section_section=".(int)$arSection["ID"];
		$more_url[] = CIBlock::GetAdminSectionEditLink($IBLOCK_ID, $arSection["ID"], array('catalog' => null));

		if (($arSection["RIGHT_MARGIN"] - $arSection["LEFT_MARGIN"]) > 1)
		{
			$rsSections = CIBlockSection::GetList(
				Array("left_margin"=>"ASC"),
				Array(
					"IBLOCK_ID" => $IBLOCK_ID,
					"SECTION_ID" => $arSection["ID"],
				),
				false,
				array("ID", "IBLOCK_SECTION_ID", "NAME", "LEFT_MARGIN", "RIGHT_MARGIN")
			);
			while($arSubSection = $rsSections->Fetch())
				CCatalogAdmin::get_other_elements_menu($IBLOCK_TYPE_ID, $IBLOCK_ID, $arSubSection, $more_url);
		}
	}

	function get_sections_menu($IBLOCK_TYPE_ID, $IBLOCK_ID, $DEPTH_LEVEL, $SECTION_ID, $arSectionsChain = false)
	{
		global $adminMenu;
		if (false === $arSectionsChain)
		{
			$arSectionsChain = array();
			if (isset($_REQUEST['admin_mnu_menu_id']))
			{
				$menu_id = "menu_catalog_category_".$IBLOCK_ID."/";
				if (0 == strncmp($_REQUEST['admin_mnu_menu_id'], $menu_id, strlen($menu_id)))
				{
					$rsSections = CIBlockSection::GetNavChain($IBLOCK_ID, substr($_REQUEST['admin_mnu_menu_id'], strlen($menu_id)), array('ID', 'IBLOCK_ID'));
					while ($arSection = $rsSections->Fetch())
						$arSectionsChain[$arSection["ID"]] = $arSection["ID"];
				}
			}
			if(
				isset($_REQUEST["find_section_section"])
				&& (int)$_REQUEST["find_section_section"] > 0
				&& isset($_REQUEST["IBLOCK_ID"])
				&& $_REQUEST["IBLOCK_ID"] == $IBLOCK_ID
			)
			{
				$rsSections = CIBlockSection::GetNavChain($IBLOCK_ID, $_REQUEST["find_section_section"], array('ID', 'IBLOCK_ID'));
				while ($arSection = $rsSections->Fetch())
					$arSectionsChain[$arSection["ID"]] = $arSection["ID"];
			}
		}

		$urlSectionAdminPage = CIBlock::GetAdminSectionListLink($IBLOCK_ID, array('catalog' => null));

		$arSections = array();
		$rsSections = CIBlockSection::GetList(array(
			"left_margin" => "ASC",
		), array(
			"IBLOCK_ID" => $IBLOCK_ID,
			"SECTION_ID" => $SECTION_ID,
		), false, array(
			"ID",
			"IBLOCK_SECTION_ID",
			"NAME",
			"LEFT_MARGIN",
			"RIGHT_MARGIN",
		));
		$intCount = 0;
		$arOtherSectionTmp = array();
		$limit = (int)COption::GetOptionInt("iblock", "iblock_menu_max_sections");
		while ($arSection = $rsSections->Fetch())
		{
			if ($limit > 0 && $intCount >= $limit)
			{
				if (empty($arOtherSectionTmp))
				{
					$arOtherSectionTmp = array(
						"text" => Loc::getMessage("CAT_MENU_ALL_OTH"),
						"url" => $urlSectionAdminPage."&find_section_section=".(int)$arSection["IBLOCK_SECTION_ID"],
						"more_url" => array(
							CIBlock::GetAdminSectionEditLink($IBLOCK_ID, $arSection["ID"], array('catalog' => null)),
						),
						"title" => Loc::getMessage("CAT_MENU_ALL_OTH_TITLE"),
						"icon" => "iblock_menu_icon_sections",
						"page_icon" => "iblock_page_icon_sections",
						"skip_chain" => true,
						"items_id" => "menu_catalog_category_".$IBLOCK_ID."/".$arSection["ID"],
						"module_id" => "catalog",
						"items" => array()
					);
					CCatalogAdmin::get_other_elements_menu($IBLOCK_TYPE_ID, $IBLOCK_ID, $arSection, $arOtherSectionTmp["more_url"]);
				}
				else
				{
					$arOtherSectionTmp['more_url'][] = $urlSectionAdminPage."&find_section_section=".(int)$arSection["ID"];
					$arOtherSectionTmp['more_url'][] = CIBlock::GetAdminSectionEditLink($IBLOCK_ID, $arSection["ID"], array('catalog' => null));
				}
			}
			else
			{
				$arSectionTmp = array(
					"text" => htmlspecialcharsex($arSection["NAME"]),
					"url" => $urlSectionAdminPage."&find_section_section=".$arSection["ID"],
					"more_url" => array(
						CIBlock::GetAdminSectionEditLink($IBLOCK_ID, $arSection["ID"], array('catalog' => null)),
					),
					"title" => htmlspecialcharsex($arSection["NAME"]),
					"icon" => "iblock_menu_icon_sections",
					"page_icon" => "iblock_page_icon_sections",
					"skip_chain" => true,
					"items_id" => "menu_catalog_category_".$IBLOCK_ID."/".$arSection["ID"],
					"module_id" => "catalog",
					"dynamic" => (($arSection["RIGHT_MARGIN"] - $arSection["LEFT_MARGIN"]) > 1),
					"items" => array(),
				);

				if (isset($arSectionsChain[$arSection["ID"]]))
				{
					$arSectionTmp["items"] = CCatalogAdmin::get_sections_menu($IBLOCK_TYPE_ID, $IBLOCK_ID, $DEPTH_LEVEL + 1, $arSection["ID"], $arSectionsChain);
				}
				elseif (method_exists($adminMenu, "IsSectionActive"))
				{

					if ($adminMenu->IsSectionActive("menu_catalog_category_".$IBLOCK_ID."/".$arSection["ID"]))
						$arSectionTmp["items"] = CCatalogAdmin::get_sections_menu($IBLOCK_TYPE_ID, $IBLOCK_ID, $DEPTH_LEVEL + 1, $arSection["ID"], $arSectionsChain);
				}

				$arSections[] = $arSectionTmp;
			}
			$intCount++;
		}
		if (!empty($arOtherSectionTmp))
			$arSections[] = $arOtherSectionTmp;
		return $arSections;
	}

	function OnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
	{
		if (!Loader::includeModule("iblock"))
			return;
		//When UnRegisterModuleDependences is called from module uninstall
		//cached EventHandlers may be called
		if (defined("BX_CATALOG_UNINSTALLED"))
			return;

		$aMenu = array(
			"text" => Loc::getMessage("CAT_MENU_ROOT"),
			"title" => "",
			"items_id" => "menu_catalog_list",
			"items" => array(),
		);
		$arCatalogs = array();
		$arCatalogSku = array();
		$rsCatalog = CCatalog::GetList(
			array(),
			array(),
			false,
			false,
			array('IBLOCK_ID', 'PRODUCT_IBLOCK_ID')
		);
		while ($ar = $rsCatalog->Fetch())
		{
			$ar["PRODUCT_IBLOCK_ID"] = (int)$ar["PRODUCT_IBLOCK_ID"];
			$ar["IBLOCK_ID"] = (int)$ar["IBLOCK_ID"];
			if (0 < $ar["PRODUCT_IBLOCK_ID"])
			{
				$arCatalogs[$ar["PRODUCT_IBLOCK_ID"]] = 1;
				$arCatalogSku[$ar["PRODUCT_IBLOCK_ID"]] = $ar["IBLOCK_ID"];
			}
			else
			{
				$arCatalogs[$ar["IBLOCK_ID"]] = 1;
			}
		}
		if (empty($arCatalogs))
		{
			return;
		}
		$rsIBlocks = CIBlock::GetList(
			array("SORT" => "ASC", "NAME" => "ASC"),
			array('ID' => array_keys($arCatalogs), "MIN_PERMISSION" => "S")
		);
		while ($arIBlock = $rsIBlocks->Fetch())
		{
			if (CIBlock::GetAdminListMode($arIBlock["ID"]) == 'C')
				$url = "cat_product_list.php";
			else
				$url = "cat_product_admin.php";

			$arItems = array(
				array(
					"text" => Loc::getMessage("CAT_MENU_PRODUCT_LIST"),
					"url" => $url."?lang=".LANGUAGE_ID."&IBLOCK_ID=".$arIBlock["ID"]."&type=".urlencode($arIBlock["IBLOCK_TYPE_ID"]).'&find_section_section=-1',
					"more_url" => array(
						"cat_product_admin.php?IBLOCK_ID=".$arIBlock["ID"],
						"cat_product_list.php?IBLOCK_ID=".$arIBlock["ID"].'&find_section_section=-1',
						"cat_product_edit.php?IBLOCK_ID=".$arIBlock["ID"],
					),
					"title" => "",
					"page_icon" => "iblock_page_icon_elements",
					"items_id" => "menu_catalog_goods_".$arIBlock["ID"],
					"module_id" => "catalog",
				),
				array(
					"text" => htmlspecialcharsex(CIBlock::GetArrayByID($arIBlock["ID"], "SECTIONS_NAME")),
					"url" => "cat_section_admin.php?lang=".LANGUAGE_ID."&type=".$arIBlock["IBLOCK_TYPE_ID"]."&IBLOCK_ID=".$arIBlock["ID"]."&find_section_section=0",
					"more_url" => array(
						"cat_section_admin.php?IBLOCK_ID=".$arIBlock["ID"]."&find_section_section=0",
						"cat_section_edit.php?IBLOCK_ID=".$arIBlock["ID"]."&find_section_section=0",
					),
					"title" => "",
					"page_icon" => "iblock_page_icon_sections",
					"items_id" => "menu_catalog_category_".$arIBlock["ID"],
					"module_id" => "catalog",
					"items" => CCatalogAdmin::get_sections_menu($arIBlock["IBLOCK_TYPE_ID"], $arIBlock["ID"], 1, 0),
				),
			);
			if(CIBlockRights::UserHasRightTo($arIBlock["ID"], $arIBlock["ID"], "iblock_edit"))
			{
				$arItems[] = array(
					"text" => Loc::getMessage("CAT_MENU_PRODUCT_PROPERTIES"),
					"url" => "iblock_property_admin.php?lang=".LANGUAGE_ID."&IBLOCK_ID=".$arIBlock["ID"]."&admin=N",
					"more_url" => array(
						"iblock_property_admin.php?IBLOCK_ID=".$arIBlock["ID"]."&admin=N",
						"iblock_edit_property.php?IBLOCK_ID=".$arIBlock["ID"]."&admin=N",
					),
					"title" => "",
					"page_icon" => "iblock_page_icon_settings",
					"items_id" => "menu_catalog_attributes_".$arIBlock["ID"],
					"module_id" => "catalog",
				);
			}

			if (isset($arCatalogSku[$arIBlock["ID"]]))
			{
				$intOffersIBlockID = $arCatalogSku[$arIBlock["ID"]];
				if (CIBlockRights::UserHasRightTo($intOffersIBlockID, $intOffersIBlockID, "iblock_edit"))
				{
					$arItems[] = array(
						"text" => Loc::getMessage("CAT_MENU_SKU_PROPERTIES"),
						"url" => "iblock_property_admin.php?lang=".LANGUAGE_ID."&IBLOCK_ID=".$intOffersIBlockID."&admin=N",
						"more_url" => array(
							"iblock_property_admin.php?IBLOCK_ID=".$intOffersIBlockID."&admin=N",
							"iblock_edit_property.php?IBLOCK_ID=".$intOffersIBlockID."&admin=N",
						),
						"title" => "",
						"page_icon" => "iblock_page_icon_settings",
						"items_id" => "menu_catalog_attributes_".$intOffersIBlockID,
						"module_id" => "catalog",
					);
				}
			}

			if(CIBlockRights::UserHasRightTo($arIBlock["ID"], $arIBlock["ID"], "iblock_edit"))
			{
				$arItems[] = array(
					"text" => Loc::getMessage("CAT_MENU_CATALOG_SETTINGS"),
					"url" => "cat_catalog_edit.php?lang=".LANGUAGE_ID."&IBLOCK_ID=".$arIBlock["ID"],
					"more_url" => array(
						"cat_catalog_edit.php?IBLOCK_ID=".$arIBlock["ID"],
					),
					"title" => "",
					"page_icon" => "iblock_page_icon_settings",
					"items_id" => "menu_catalog_edit_".$arIBlock["ID"],
					"module_id" => "catalog",
				);
			}

			$aMenu["items"][] = array(
				"text" => htmlspecialcharsEx($arIBlock["NAME"]),
				"title" => "",
				"page_icon" => "iblock_page_icon_sections",
				"items_id" => "menu_catalog_".$arIBlock["ID"],
				"module_id" => "catalog",
				"items" => $arItems,
			);
		}

		if (!empty($aMenu["items"]))
		{
			if (count($aMenu["items"]) == 1)
				$aMenu = $aMenu["items"][0];

			$aMenu["parent_menu"] = "global_menu_store";
			$aMenu["section"] = "catalog_list";
			$aMenu["sort"] = 200;
			$aMenu["icon"] = "iblock_menu_icon_sections";
			$aMenu["page_icon"] = "iblock_page_icon_types";
			$aModuleMenu[] = $aMenu;
		}
	}

	function OnAdminListDisplay(&$obList)
	{
		global $USER;

		if(!preg_match("/^tbl_catalog_section_/", $obList->table_id))
			return;

		if(!is_object($USER) || !$USER->CanDoOperation("clouds_upload"))
			return;

		foreach($obList->aRows as $obRow)
		{
			$obRow->aActions[] = array("SEPARATOR"=>true);
			$tmpVar = CIBlock::ReplaceDetailUrl($obRow->arRes["SECTION_PAGE_URL"], $obRow->arRes, true, "S");
			$obRow->aActions[] = array(
				"ICON" => "view",
				"TEXT" => Loc::getMessage("CAT_ACT_MENU_VIEW_SECTION"),
				"ACTION" => $obList->ActionRedirect(htmlspecialcharsbx($tmpVar)),
			);
			$tmpVar = CIBlock::GetAdminElementListLink($obRow->arRes["IBLOCK_ID"], array(
				'find_section_section' => $obRow->arRes["ID"],
				'set_filter' => 'Y',
			));
			$obRow->aActions[] = array(
				"ICON" => "list",
				"TEXT" => CIBlock::GetArrayByID($obRow->arRes["IBLOCK_ID"], "ELEMENTS_NAME"),
				"ACTION" => $obList->ActionRedirect(htmlspecialcharsbx($tmpVar)),
			);
		}
	}

	function OnBuildSaleMenu(&$arGlobalMenu, &$arModuleMenu)
	{
		if (!Loader::includeModule("sale"))
			return;
		if (defined("BX_CATALOG_UNINSTALLED"))
			return;

		if (!defined("BX_SALE_MENU_CATALOG_CLEAR") || 'Y' != BX_SALE_MENU_CATALOG_CLEAR)
			return;

		CCatalogAdmin::OnBuildSaleMenuItem($arModuleMenu);
	}

	function OnBuildSaleMenuItem(&$arMenu)
	{
		$arMenuID = array(
			'menu_sale_discounts',
			'menu_sale_taxes',
			'menu_sale_settings',
			'menu_catalog_store',
		);

		foreach ($arMenu as &$arMenuItem)
		{
			if (!isset($arMenuItem['items']) || !is_array($arMenuItem['items']))
				continue;

			if (!isset($arMenuItem['items_id']) || !is_string($arMenuItem['items_id']) || !in_array($arMenuItem['items_id'], $arMenuID))
				continue;

			switch ($arMenuItem['items_id'])
			{
				case 'menu_sale_discounts':
					CCatalogAdmin::OnBuildSaleDiscountMenu($arMenuItem['items']);
					break;
				case 'menu_sale_taxes':
					CCatalogAdmin::OnBuildSaleTaxMenu($arMenuItem['items']);
					break;
				case 'menu_sale_settings':
					CCatalogAdmin::OnBuildSaleSettingsMenu($arMenuItem['items']);
					break;
				case 'menu_catalog_store':
					CCatalogAdmin::OnBuildSaleStoreMenu($arMenuItem['items']);
					break;
			}

			CCatalogAdmin::OnBuildSaleMenuItem($arMenuItem['items']);
		}
		if (isset($arMenuItem))
			unset($arMenuItem);
	}

	function OnBuildSaleDiscountMenu(&$arItems)
	{
		global $USER;

		if (!CCatalog::IsUserExists())
			return;
		if (!is_array($arItems))
			return;

		$boolRead = $USER->CanDoOperation('catalog_read');
		$boolDiscount = $USER->CanDoOperation('catalog_discount');

		if ($boolRead || $boolDiscount)
		{
			$arResult = array();
			$arResult[] = array(
				"text" => Loc::getMessage("CM_DISCOUNTS3"),
				"url" => "cat_discount_admin.php?lang=".LANGUAGE_ID,
				"more_url" => array("cat_discount_edit.php"),
				"title" => Loc::getMessage("CM_DISCOUNTS_ALT2"),
				"readonly" => !$boolDiscount,
			);
			if (!empty($arItems))
				$arResult = array_merge($arResult, $arItems);
			if (CBXFeatures::IsFeatureEnabled('CatDiscountSave'))
			{
				$arResult[] = array(
					"text" => Loc::getMessage("CAT_DISCOUNT_SAVE"),
					"url" => "cat_discsave_admin.php?lang=".LANGUAGE_ID,
					"more_url" => array("cat_discsave_edit.php"),
					"title" => Loc::getMessage("CAT_DISCOUNT_SAVE_DESCR"),
					"readonly" => !$boolDiscount,
				);
			}

			$arResult[] = array(
				"text" => Loc::getMessage("CM_COUPONS"),
				"url" => "cat_discount_coupon.php?lang=".LANGUAGE_ID,
				"more_url" => array("cat_discount_coupon_edit.php"),
				"title" => Loc::getMessage("CM_COUPONS_ALT"),
				"readonly" => !$boolDiscount,
			);

			$arItems = $arResult;
		}
	}

	function OnBuildSaleTaxMenu(&$arItems)
	{
		global $USER;

		if (!CCatalog::IsUserExists())
			return;
		if (!is_array($arItems))
			return;

		$boolRead = $USER->CanDoOperation('catalog_read');
		$boolVat = $USER->CanDoOperation('catalog_vat');

		if ($boolRead || $boolVat)
		{
			$arItems[] = array(
				"text" => Loc::getMessage("VAT"),
				"url" => "cat_vat_admin.php?lang=".LANGUAGE_ID,
				"more_url" => array("cat_vat_edit.php"),
				"title" => Loc::getMessage("VAT_ALT"),
				"readonly" => !$boolVat,
			);
		}
	}

	function OnBuildSaleSettingsMenu(&$arItems)
	{
		global $USER;
		if (!CCatalog::IsUserExists())
			return;
		if (!is_array($arItems))
			return;

		$boolRead = $USER->CanDoOperation('catalog_read');
		$boolGroup = $USER->CanDoOperation('catalog_group');
		$boolPrice = $USER->CanDoOperation('catalog_price');
		$boolMeasure = $USER->CanDoOperation('catalog_measure');
		$boolExportEdit = $USER->CanDoOperation('catalog_export_edit');
		$boolExportExec = $USER->CanDoOperation('catalog_export_exec');
		$boolImportEdit = $USER->CanDoOperation('catalog_import_edit');
		$boolImportExec = $USER->CanDoOperation('catalog_import_exec');

		if ($boolRead || $boolGroup)
		{
			$arItems[] = array(
				"text" => Loc::getMessage("GROUP"),
				"url" => "cat_group_admin.php?lang=".LANGUAGE_ID,
				"more_url" => array("cat_group_edit.php"),
				"title" => Loc::getMessage("GROUP_ALT"),
				"readonly" => !$boolGroup,
			);
		}

		if (CBXFeatures::IsFeatureEnabled('CatMultiPrice'))
		{
			if ($boolRead || $boolPrice)
			{
				$arItems[] = array(
					"text" => Loc::getMessage("EXTRA"),
					"url" => "cat_extra.php?lang=".LANGUAGE_ID,
					"more_url" => array("cat_extra_edit.php"),
					"title" => Loc::getMessage("EXTRA_ALT"),
					"readonly" => !$boolPrice,
				);
			}
		}

		if ($boolRead || $boolMeasure)
		{
			$arItems[] = array(
				"text" => Loc::getMessage("MEASURE"),
				"url" => "cat_measure_list.php?lang=".LANGUAGE_ID,
				"more_url" => array("cat_measure_edit.php"),
				"title" => Loc::getMessage("MEASURE_ALT"),
				"readonly" => !$boolMeasure,
			);
		}

		if ($boolRead || $boolExportEdit || $boolExportExec)
		{
			$arItems[] = array(
				"text" => Loc::getMessage("SETUP_UNLOAD_DATA"),
				"url" => "cat_export_setup.php?lang=".LANGUAGE_ID,
				"more_url" => array("cat_exec_exp.php"),
				"title" => Loc::getMessage("SETUP_UNLOAD_DATA_ALT"),
				"dynamic" => true,
				"module_id" => "sale",
				"items_id" => "mnu_catalog_exp",
				"readonly" => !$boolExportEdit && !$boolExportExec,
				"items" => CCatalogAdmin::OnBuildSaleExportMenu("mnu_catalog_exp"),
			);
		}

		if ($boolRead || $boolImportEdit || $boolImportExec)
		{
			$arItems[] = array(
				"text" => Loc::getMessage("SETUP_LOAD_DATA"),
				"url" => "cat_import_setup.php?lang=".LANGUAGE_ID,
				"more_url" => array("cat_exec_imp.php"),
				"title" => Loc::getMessage("SETUP_LOAD_DATA_ALT"),
				"dynamic" => true,
				"module_id" => "sale",
				"items_id" => "mnu_catalog_imp",
				"readonly" => !$boolImportEdit && !$boolImportExec,
				"items" => CCatalogAdmin::OnBuildSaleImportMenu("mnu_catalog_imp"),
			);
		}
	}

	function OnBuildSaleStoreMenu(&$arItems)
	{
		global $USER;
		if (!CCatalog::IsUserExists())
			return;
		if (!is_array($arItems))
			return;

		$boolRead = $USER->CanDoOperation('catalog_read');
		$boolStore = $USER->CanDoOperation('catalog_store');

		if ($boolRead || $boolStore)
		{
			$arResult = array();
			if(COption::GetOptionString('catalog','default_use_store_control','N') == 'Y')
			{
				$arResult[] = array(
					"text" => Loc::getMessage("CM_STORE_DOCS"),
					"url" => "cat_store_document_list.php?lang=".LANGUAGE_ID,
					"more_url" => array("cat_store_document_edit.php"),
					"title" => Loc::getMessage("CM_STORE_DOCS"),
					"readonly" => !$boolStore,
				);

				$arResult[] = array(
					"text" => Loc::getMessage("CM_CONTRACTORS"),
					"url" => "cat_contractor_list.php?lang=".LANGUAGE_ID,
					"more_url" => array("cat_contractor_edit.php"),
					"title" => Loc::getMessage("CM_CONTRACTORS"),
					"readonly" => !$boolStore,
				);
			}
			$arResult[] = array(
				"text" => Loc::getMessage("CM_STORE"),
				"url" => "cat_store_list.php?lang=".LANGUAGE_ID,
				"more_url" => array("cat_store_edit.php"),
				"title" => Loc::getMessage("CM_STORE"),
				"readonly" => !$boolStore,
			);
			$arItems = $arResult;
		}

	}

	function OnBuildSaleExportMenu($strItemID)
	{
		// this code copying to catalog menu
		global $USER;

		global $adminMenu;

		if (!CCatalog::IsUserExists())
			return;
		if (empty($strItemID))
			return array();

		$boolRead = $USER->CanDoOperation('catalog_read');
		$boolExportEdit = $USER->CanDoOperation('catalog_export_edit');
		$boolExportExec = $USER->CanDoOperation('catalog_export_exec');

		$arProfileList = array();

		if (($boolRead || $boolExportEdit || $boolExportExec) && method_exists($adminMenu, "IsSectionActive"))
		{
			if ($adminMenu->IsSectionActive($strItemID))
			{
				$rsProfiles = CCatalogExport::GetList(array("NAME"=>"ASC", "ID"=>"ASC"), array("IN_MENU"=>"Y"));
				while ($arProfile = $rsProfiles->Fetch())
				{
					$strName = (strlen($arProfile["NAME"]) > 0 ? $arProfile["NAME"] : $arProfile["FILE_NAME"]);
					if ('Y' == $arProfile['DEFAULT_PROFILE'])
					{
						$arProfileList[] = array(
							"text" => htmlspecialcharsbx($strName),
							"url" => "cat_exec_exp.php?lang=".LANGUAGE_ID."&ACT_FILE=".$arProfile["FILE_NAME"]."&ACTION=EXPORT&PROFILE_ID=".$arProfile["ID"]."&".bitrix_sessid_get(),
							"title" => Loc::getMessage("CAM_EXPORT_DESCR_EXPORT")." &quot;".htmlspecialcharsbx($strName)."&quot;",
							"readonly" => !$boolExportExec,
						);
					}
					else
					{
						$arProfileList[] = array(
							"text" => htmlspecialcharsbx($strName),
							"url" => "cat_export_setup.php?lang=".LANGUAGE_ID."&ACT_FILE=".$arProfile["FILE_NAME"]."&ACTION=EXPORT_EDIT&PROFILE_ID=".$arProfile["ID"]."&".bitrix_sessid_get(),
							"title"=>Loc::getMessage("CAM_EXPORT_DESCR_EDIT")." &quot;".htmlspecialcharsbx($strName)."&quot;",
							"readonly" => !$boolExportEdit,
						);
					}
				}
			}
		}
		return $arProfileList;
	}

	function OnBuildSaleImportMenu($strItemID)
	{
		global $USER;

		global $adminMenu;

		if (!CCatalog::IsUserExists())
			return;
		if (empty($strItemID))
			return array();

		$boolRead = $USER->CanDoOperation('catalog_read');
		$boolImportEdit = $USER->CanDoOperation('catalog_import_edit');
		$boolImportExec = $USER->CanDoOperation('catalog_import_exec');

		$arProfileList = array();

		if (($boolRead || $boolImportEdit || $boolImportExec) && method_exists($adminMenu, "IsSectionActive"))
		{
			if ($adminMenu->IsSectionActive($strItemID))
			{
				$rsProfiles = CCatalogImport::GetList(array("NAME"=>"ASC", "ID"=>"ASC"), array("IN_MENU"=>"Y"));
				while ($arProfile = $rsProfiles->Fetch())
				{
					$strName = (strlen($arProfile["NAME"]) > 0 ? $arProfile["NAME"] : $arProfile["FILE_NAME"]);
					if ('Y' == $arProfile['DEFAULT_PROFILE'])
					{
						$arProfileList[] = array(
							"text" => htmlspecialcharsbx($strName),
							"url" => "cat_exec_imp.php?lang=".LANGUAGE_ID."&ACT_FILE=".$arProfile["FILE_NAME"]."&ACTION=IMPORT&PROFILE_ID=".$arProfile["ID"]."&".bitrix_sessid_get(),
							"title" => Loc::getMessage("CAM_IMPORT_DESCR_IMPORT")." &quot;".htmlspecialcharsbx($strName)."&quot;",
							"readonly" => !$boolImportExec,
						);
					}
					else
					{
						$arProfileList[] = array(
							"text" => htmlspecialcharsbx($strName),
							"url" => "cat_import_setup.php?lang=".LANGUAGE_ID."&ACT_FILE=".$arProfile["FILE_NAME"]."&ACTION=IMPORT_EDIT&PROFILE_ID=".$arProfile["ID"]."&".bitrix_sessid_get(),
							"title" => Loc::getMessage("CAM_IMPORT_DESCR_EDIT")." &quot;".htmlspecialcharsbx($strName)."&quot;",
							"readonly" => !$boolImportEdit,
						);
					}
				}
			}
		}

		return $arProfileList;
	}
}
?>