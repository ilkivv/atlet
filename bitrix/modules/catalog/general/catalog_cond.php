<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

define('BT_COND_LOGIC_EQ', 0);						// = (equal)
define('BT_COND_LOGIC_NOT_EQ', 1);					// != (not equal)
define('BT_COND_LOGIC_GR', 2);						// > (great)
define('BT_COND_LOGIC_LS', 3);						// < (less)
define('BT_COND_LOGIC_EGR', 4);						// => (great or equal)
define('BT_COND_LOGIC_ELS', 5);						// =< (less or equal)
define('BT_COND_LOGIC_CONT', 6);					// contain
define('BT_COND_LOGIC_NOT_CONT', 7);				// not contain

define('BT_COND_MODE_DEFAULT', 0);					// full mode
define('BT_COND_MODE_PARSE', 1);					// parsing mode
define('BT_COND_MODE_GENERATE', 2);					// generate mode
define('BT_COND_MODE_SQL', 3);						// generate getlist mode
define('BT_COND_MODE_SEARCH', 4);					// info mode

define('BT_COND_BUILD_CATALOG', 0);					// catalog conditions
define('BT_COND_BUILD_SALE', 1);					// sale conditions
define('BT_COND_BUILD_SALE_ACTIONS', 2);			// sale actions conditions

class CGlobalCondCtrl
{
	public static $arInitParams = false;
	public static $boolInit = false;

	public static function GetClassName()
	{
		return __CLASS__;
	}

	public static function GetControlDescr()
	{
		$strClassName = static::GetClassName();
		return array(
			"ID" => static::GetControlID(),
			"GetControlShow" => array($strClassName, "GetControlShow"),
			"GetConditionShow" => array($strClassName, "GetConditionShow"),
			"IsGroup" => array($strClassName, "IsGroup"),
			"Parse" => array($strClassName, "Parse"),
			"Generate" => array($strClassName, "Generate"),
			"ApplyValues" => array($strClassName, "ApplyValues"),
			"InitParams" => array($strClassName, "InitParams")
		);
	}

	public static function GetControlShow($arParams)
	{
		return array();
	}

	public static function GetConditionShow($arParams)
	{
		return '';
	}

	public static function IsGroup($strControlID = false)
	{
		return 'N';
	}

	public static function Parse($arOneCondition)
	{
		return '';
	}

	public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
	{
		return '';
	}

	public static function ApplyValues($arOneCondition, $arControl)
	{
		return array();
	}

	public static function InitParams($arParams)
	{
		if (is_array($arParams) && !empty($arParams))
		{
			static::$arInitParams = $arParams;
			static::$boolInit = true;
		}
	}

	public static function GetControlID()
	{
		return '';
	}

	public static function GetShowIn($arControls)
	{
		if (!is_array($arControls))
			$arControls = array($arControls);
		return array_values(array_unique($arControls));
	}

	public static function GetControls($strControlID = false)
	{
		return false;
	}

	public static function GetAtoms()
	{
		return array();
	}

	public static function GetAtomsEx($strControlID = false, $boolEx = false)
	{
		return array();
	}

	public static function GetJSControl($arControl, $arParams = array())
	{
		return array();
	}

	public static function OnBuildConditionAtomList()
	{

	}

	public static function GetLogic($arOperators = false)
	{
		$arOperatorsList = array(
			BT_COND_LOGIC_EQ => array(
				'ID' => BT_COND_LOGIC_EQ,
				'OP' => array(
					'Y' => 'in_array(#VALUE#, #FIELD#)',
					'N' => '#FIELD# == #VALUE#'
				),
				'PARENT' => ' || ',
				'VALUE' => 'Equal',
				'LABEL' => Loc::getMessage('BT_COND_LOGIC_EQ_LABEL')
			),
			BT_COND_LOGIC_NOT_EQ => array(
				'ID' => BT_COND_LOGIC_NOT_EQ,
				'OP' => array(
					'Y' => '!in_array(#VALUE#, #FIELD#)',
					'N' => '#FIELD# != #VALUE#'
				),
				'PARENT' => ' && ',
				'VALUE' => 'Not',
				'LABEL' => Loc::getMessage('BT_COND_LOGIC_NOT_EQ_LABEL')
			),
			BT_COND_LOGIC_GR => array(
				'ID' => BT_COND_LOGIC_GR,
				'OP' => array(
					'N' => '#FIELD# > #VALUE#',
					'Y' => 'CGlobalCondCtrl::LogicGreat(#FIELD#, #VALUE#)'
				),
				'VALUE' => 'Great',
				'LABEL' => Loc::getMessage('BT_COND_LOGIC_GR_LABEL')
			),
			BT_COND_LOGIC_LS => array(
				'ID' => BT_COND_LOGIC_LS,
				'OP' => array(
					'N' => '#FIELD# < #VALUE#',
					'Y' => 'CGlobalCondCtrl::LogicLess(#FIELD#, #VALUE#)'
				),
				'VALUE' => 'Less',
				'LABEL' => Loc::getMessage('BT_COND_LOGIC_LS_LABEL')
			),
			BT_COND_LOGIC_EGR => array(
				'ID' => BT_COND_LOGIC_EGR,
				'OP' => array(
					'N' => '#FIELD# >= #VALUE#',
					'Y' => 'CGlobalCondCtrl::LogicEqualGreat(#FIELD#, #VALUE#)'
				),
				'VALUE' => 'EqGr',
				'LABEL' => Loc::getMessage('BT_COND_LOGIC_EGR_LABEL')
			),
			BT_COND_LOGIC_ELS => array(
				'ID' => BT_COND_LOGIC_ELS,
				'OP' => array(
					'N' => '#FIELD# <= #VALUE#',
					'Y' => 'CGlobalCondCtrl::LogicEqualLess(#FIELD#, #VALUE#)'
				),
				'VALUE' => 'EqLs',
				'LABEL' => Loc::getMessage('BT_COND_LOGIC_ELS_LABEL')
			),
			BT_COND_LOGIC_CONT => array(
				'ID' => BT_COND_LOGIC_CONT,
				'OP' => array(
					'N' => 'false !== strpos(#FIELD#, #VALUE#)',
					'Y' => 'CGlobalCondCtrl::LogicContain(#FIELD#, #VALUE#)'
				),
				'PARENT' => ' || ',
				'VALUE' => 'Contain',
				'LABEL' => Loc::getMessage('BT_COND_LOGIC_CONT_LABEL')
			),
			BT_COND_LOGIC_NOT_CONT => array(
				'ID' => BT_COND_LOGIC_NOT_CONT,
				'OP' => array(
					'N' => 'false === strpos(#FIELD#, #VALUE#)',
					'Y' => 'CGlobalCondCtrl::LogicNotContain(#FIELD#, #VALUE#)'
				),
				'PARENT' => ' && ',
				'VALUE' => 'NotCont',
				'LABEL' => Loc::getMessage('BT_COND_LOGIC_NOT_CONT_LABEL')
			)
		);

		$boolSearch = false;
		$arSearch = array();
		if (!empty($arOperators) && is_array($arOperators))
		{
			foreach ($arOperators as &$intOneOp)
			{
				if (isset($arOperatorsList[$intOneOp]))
				{
					$boolSearch = true;
					$arSearch[$intOneOp] = $arOperatorsList[$intOneOp];
				}
			}
			if (isset($intOneOp))
				unset($intOneOp);
		}
		return ($boolSearch ? $arSearch : $arOperatorsList);
	}

	public static function GetLogicEx($arOperators = false, $arLabels = false)
	{
		$arOperatorsList = static::GetLogic($arOperators);
		if (!empty($arLabels) && is_array($arLabels))
		{
			foreach ($arOperatorsList as &$arOneOperator)
			{
				if (isset($arLabels[$arOneOperator['ID']]))
					$arOneOperator['LABEL'] = $arLabels[$arOneOperator['ID']];
			}
			if (isset($arOneOperator))
				unset($arOneOperator);
		}
		return $arOperatorsList;
	}

	public static function GetLogicAtom($arLogic)
	{
		if (is_array($arLogic) && !empty($arLogic))
		{
			$arValues = array();
			foreach ($arLogic as &$arOneLogic)
			{
				$arValues[$arOneLogic['VALUE']] = $arOneLogic['LABEL'];
			}
			if (isset($arOneLogic))
				unset($arOneLogic);
			$arResult = array(
				'id' => 'logic',
				'name' =>  'logic',
				'type' => 'select',
				'values' => $arValues,
				'defaultText' => current($arValues),
				'defaultValue' => key($arValues)
			);
			return $arResult;
		}
		else
		{
			return false;
		}
	}

	public static function GetValueAtom($arValue)
	{
		if (empty($arValue) || !is_array($arValue) || !isset($arValue['type']))
		{
			$arResult = array(
				'type' => 'input'
			);
		}
		else
		{
			$arResult = $arValue;
		}
		$arResult['id'] = 'value';
		$arResult['name'] = 'value';

		return $arResult;
	}

	public static function CheckLogic($strValue, $arLogic, $boolShow = false)
	{
		$boolShow = (true === $boolShow);
		if (!is_array($arLogic) || empty($arLogic))
			return false;
		$strResult = '';
		foreach ($arLogic as &$arOneLogic)
		{
			if ($strValue == $arOneLogic['VALUE'])
			{
				$strResult = $arOneLogic['VALUE'];
				break;
			}
		}
		if (isset($arOneLogic))
			unset($arOneLogic);
		if ('' == $strResult)
		{
			if ($boolShow)
			{
				$arOneLogic = current($arLogic);
				$strResult = $arOneLogic['VALUE'];
			}
		}
		return ('' == $strResult ? false : $strResult);
	}

	public static function SearchLogic($strValue, $arLogic)
	{
		$mxResult = false;
		if (!is_array($arLogic) || empty($arLogic))
			return $mxResult;
		foreach ($arLogic as &$arOneLogic)
		{
			if ($strValue == $arOneLogic['VALUE'])
			{
				$mxResult = $arOneLogic;
				break;
			}
		}
		if (isset($arOneLogic))
			unset($arOneLogic);
		return $mxResult;
	}

	public static function Check($arOneCondition, $arParams, $arControl, $boolShow)
	{
		$boolShow = (true === $boolShow);
		$arResult = array();
		$boolError = false;
		$boolFatalError = false;
		$arMsg = array();

		$arValues = array(
			'logic' => '',
			'value' => ''
		);
		$arLabels = array();

		static $intTimeOffset = false;
		if (false === $intTimeOffset)
			$intTimeOffset = CTimeZone::GetOffset();

		if ($boolShow)
		{
			if (!isset($arOneCondition['logic']))
			{
				$arOneCondition['logic'] = '';
				$boolError = true;
			}
			if (!isset($arOneCondition['value']))
			{
				$arOneCondition['value'] = '';
				$boolError = true;
			}
			$strLogic = static::CheckLogic($arOneCondition['logic'], $arControl['LOGIC'], $boolShow);
			if (false === $strLogic)
			{
				$boolError = true;
				$boolFatalError = true;
				$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_LOGIC_ABSENT');
			}
			else
			{
				$arValues['logic'] = $strLogic;
			}

			$boolValueError = static::ClearValue($arOneCondition['value']);
			if (!$boolValueError)
			{
				$boolMulti = is_array($arOneCondition['value']);
				switch ($arControl['FIELD_TYPE'])
				{
					case 'int':
						if ($boolMulti)
						{
							foreach ($arOneCondition['value'] as &$intOneValue)
							{
								$intOneValue = (int)$intOneValue;
							}
							if (isset($intOneValue))
								unset($intOneValue);
						}
						else
						{
							$arOneCondition['value'] = (int)$arOneCondition['value'];
						}
						break;
					case 'double':
						if ($boolMulti)
						{
							foreach ($arOneCondition['value'] as &$dblOneValue)
							{
								$dblOneValue = doubleval($dblOneValue);
							}
							if (isset($dblOneValue))
								unset($dblOneValue);
						}
						else
						{
							$arOneCondition['value'] = doubleval($arOneCondition['value']);
						}
						break;
					case 'char':
						if ($boolMulti)
						{
							foreach ($arOneCondition['value'] as &$strOneValue)
							{
								$strOneValue = substr($strOneValue, 0, 1);
							}
							if (isset($strOneValue))
								unset($strOneValue);
						}
						else
						{
							$arOneCondition['value'] = substr($arOneCondition['value'], 0 ,1);
						}
						break;
					case 'string':
						$intMaxLen = (int)(isset($arControl['FIELD_LENGTH']) && (int)$arControl['FIELD_LENGTH'] > 0 ? $arControl['FIELD_LENGTH'] : 255);
						if ($boolMulti)
						{
							foreach ($arOneCondition['value'] as &$strOneValue)
							{
								$strOneValue = substr($strOneValue, 0, $intMaxLen);
							}
							if (isset($strOneValue))
								unset($strOneValue);
						}
						else
						{
							$arOneCondition['value'] = substr($arOneCondition['value'], 0, $intMaxLen);
						}
						break;
					case 'text':
						break;
					case 'date':
					case 'datetime':
						if ('date' == $arControl['FIELD_TYPE'])
						{
							$strFormat = 'SHORT';
							$intOffset = 0;
						}
						else
						{
							$strFormat = 'FULL';
							$intOffset = $intTimeOffset;
						}
						$boolValueError = CGlobalCondCtrl::ConvertInt2DateTime($arOneCondition['value'], $strFormat, $intOffset);
						break;
					default:
						$boolValueError = true;
						break;
				}
			}
			if (!$boolValueError)
			{
				if ($boolMulti)
					$arOneCondition['value'] = array_values(array_unique($arOneCondition['value']));
			}

			if (!$boolValueError)
			{
				if (isset($arControl['PHP_VALUE']) && is_array($arControl['PHP_VALUE']) && isset($arControl['PHP_VALUE']['VALIDATE']) && !empty($arControl['PHP_VALUE']['VALIDATE']))
				{
					$arValidate = static::Validate($arOneCondition, $arParams, $arControl, $boolShow);
					if (false === $arValidate)
					{
						$boolValueError = true;
					}
					else
					{
						if (isset($arValidate['err_cond']) && 'Y' == $arValidate['err_cond'])
						{
							$boolValueError = true;
							if (isset($arValidate['err_cond_mess']) && !empty($arValidate['err_cond_mess']))
								$arMsg = array_merge($arMsg, $arValidate['err_cond_mess']);
						}
						else
						{
							$arValues['value'] = $arValidate['values'];
							if (isset($arValidate['labels']))
								$arLabels['value'] = $arValidate['labels'];
						}
					}
				}
				else
				{
					$arValues['value'] = $arOneCondition['value'];
				}
			}

			if ($boolValueError)
				$boolError = $boolValueError;
		}
		else
		{
			if (!isset($arOneCondition['logic']) || !isset($arOneCondition['value']))
			{
				$boolError = true;
			}
			else
			{
				$strLogic = static::CheckLogic($arOneCondition['logic'], $arControl['LOGIC'], $boolShow);
				if (!$strLogic)
				{
					$boolError = true;
				}
				else
				{
					$arValues['logic'] = $arOneCondition['logic'];
				}
			}

			if (!$boolError)
			{
				$boolError = static::ClearValue($arOneCondition['value']);
			}

			if (!$boolError)
			{
				$boolMulti = is_array($arOneCondition['value']);
				switch ($arControl['FIELD_TYPE'])
				{
					case 'int':
						if ($boolMulti)
						{
							foreach ($arOneCondition['value'] as &$intOneValue)
							{
								$intOneValue = (int)$intOneValue;
							}
							if (isset($intOneValue))
								unset($intOneValue);
						}
						else
						{
							$arOneCondition['value'] = (int)$arOneCondition['value'];
						}
						break;
					case 'double':
						if ($boolMulti)
						{
							foreach ($arOneCondition['value'] as &$dblOneValue)
							{
								$dblOneValue = doubleval($dblOneValue);
							}
							if (isset($dblOneValue))
								unset($dblOneValue);
						}
						else
						{
							$arOneCondition['value'] = doubleval($arOneCondition['value']);
						}
						break;
					case 'char':
						if ($boolMulti)
						{
							foreach ($arOneCondition['value'] as &$strOneValue)
							{
								$strOneValue = substr($strOneValue, 0, 1);
							}
							if (isset($strOneValue))
								unset($strOneValue);
						}
						else
						{
							$arOneCondition['value'] = substr($arOneCondition['value'], 0 ,1);
						}
						break;
					case 'string':
						$intMaxLen = (int)(isset($arControl['FIELD_LENGTH']) && (int)$arControl['FIELD_LENGTH'] > 0 ? $arControl['FIELD_LENGTH'] : 255);
						if ($boolMulti)
						{
							foreach ($arOneCondition['value'] as &$strOneValue)
							{
								$strOneValue = substr($strOneValue, 0, $intMaxLen);
							}
							if (isset($strOneValue))
								unset($strOneValue);
						}
						else
						{
							$arOneCondition['value'] = substr($arOneCondition['value'], 0, $intMaxLen);
						}
						break;
					case 'text':
						break;
					case 'date':
					case 'datetime':
						if ('date' == $arControl['FIELD_TYPE'])
						{
							$strFormat = 'SHORT';
							$intOffset = 0;
						}
						else
						{
							$strFormat = 'FULL';
							$intOffset = $intTimeOffset;
						}
						$boolError = CGlobalCondCtrl::ConvertDateTime2Int($arOneCondition['value'], $strFormat, $intOffset);
						break;
					default:
						$boolError = true;
						break;
				}
				if ($boolMulti)
				{
					if (!$boolError)
						$arOneCondition['value'] = array_values(array_unique($arOneCondition['value']));
				}
			}

			if (!$boolError)
			{
				if (isset($arControl['PHP_VALUE']) && is_array($arControl['PHP_VALUE']) && isset($arControl['PHP_VALUE']['VALIDATE']) && !empty($arControl['PHP_VALUE']['VALIDATE']))
				{
					$arValidate = static::Validate($arOneCondition, $arParams, $arControl, $boolShow);
					if (false === $arValidate)
					{
						$boolError = true;
					}
					else
					{
						$arValues['value'] = $arValidate['values'];
						if (isset($arValidate['labels']))
							$arLabels['value'] = $arValidate['labels'];
					}
				}
				else
				{
					$arValues['value'] = $arOneCondition['value'];
				}
			}
		}

		if ($boolShow)
		{
			$arResult = array(
				'id' => $arParams['COND_NUM'],
				'controlId' => $arControl['ID'],
				'values' => $arValues,
			);
			if (!empty($arLabels))
				$arResult['labels'] = $arLabels;
			if ($boolError)
			{
				$arResult['err_cond'] = 'Y';
				if ($boolFatalError)
					$arResult['fatal_err_cond'] = 'Y';
				if (!empty($arMsg))
					$arResult['err_cond_mess'] = implode('. ', $arMsg);
			}

			return $arResult;
		}
		else
		{
			$arResult = $arValues;
			return (!$boolError ? $arResult : false);
		}
	}

	public static function Validate($arOneCondition, $arParams, $arControl, $boolShow)
	{
		$boolShow = (true === $boolShow);
		$boolError = false;
		$arMsg = array();

		$arResult = array(
			'values' => '',
		);

		if (!(isset($arControl['PHP_VALUE']) && is_array($arControl['PHP_VALUE']) && isset($arControl['PHP_VALUE']['VALIDATE']) && !empty($arControl['PHP_VALUE']['VALIDATE'])))
		{
			$boolError = true;
		}

		if (!$boolError)
		{
			if ($boolShow)
			{
				// validate for show
				$boolMulti = is_array($arOneCondition['value']);
				switch($arControl['PHP_VALUE']['VALIDATE'])
				{
					case 'element':
						$rsItems = CIBlockElement::GetList(array(), array('ID' => $arOneCondition['value']), false, false, array('ID', 'NAME'));
						if ($boolMulti)
						{
							$arCheckResult = array();
							while ($arItem = $rsItems->Fetch())
							{
								$arCheckResult[(int)$arItem['ID']] = $arItem['NAME'];
							}
							if (!empty($arCheckResult))
							{
								$arResult['values'] = array_keys($arCheckResult);
								$arResult['labels'] = array_values($arCheckResult);
							}
							else
							{
								$boolError = true;
								$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_ELEMENT_ABSENT_MULTI');
							}
						}
						else
						{
							if ($arItem = $rsItems->Fetch())
							{
								$arResult['values'] = (int)$arItem['ID'];
								$arResult['labels'] = $arItem['NAME'];
							}
							else
							{
								$boolError = true;
								$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_ELEMENT_ABSENT');
							}
						}
						break;
					case 'section':
						$rsSections = CIBlockSection::GetList(array(), array('ID' => $arOneCondition['value']), false, array('ID', 'NAME'));
						if ($boolMulti)
						{
							$arCheckResult = array();
							while ($arSection = $rsSections->Fetch())
							{
								$arCheckResult[(int)$arSection['ID']] = $arSection['NAME'];
							}
							if (!empty($arCheckResult))
							{
								$arResult['values'] = array_keys($arCheckResult);
								$arResult['labels'] = array_values($arCheckResult);
							}
							else
							{
								$boolError = true;
								$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_SECTION_ABSENT_MULTI');
							}
						}
						else
						{
							if ($arSection = $rsSections->Fetch())
							{
								$arResult['values'] = (int)$arSection['ID'];
								$arResult['labels'] = $arSection['NAME'];
							}
							else
							{
								$boolError = true;
								$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_SECTION_ABSENT');
							}
						}
						break;
					case 'iblock':
						if ($boolMulti)
						{
							$arCheckResult = array();
							foreach ($arOneCondition['value'] as &$intIBlockID)
							{
								$strName = CIBlock::GetArrayByID($intIBlockID, 'NAME');
								if (false !== $strName && !is_null($strName))
								{
									$arCheckResult[$intIBlockID] = $strName;
								}
							}
							if (isset($intIBlockID))
								unset($intIBlockID);
							if (!empty($arCheckResult))
							{
								$arResult['values'] = array_keys($arCheckResult);
								$arResult['labels'] = array_values($arCheckResult);
							}
							else
							{
								$boolError = true;
								$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_IBLOCK_ABSENT_MULTI');
							}
						}
						else
						{
							$strName = CIBlock::GetArrayByID($arOneCondition['value'], 'NAME');
							if (false !== $strName && !is_null($strName))
							{
								$arResult['values'] = $arOneCondition['value'];
								$arResult['labels'] = $strName;
							}
							else
							{
								$boolError = true;
								$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_IBLOCK_ABSENT');
							}
						}
						break;
					case 'user':
						$by2 = 'ID';
						$order2 = 'ASC';
						if ($boolMulti)
						{
							$arCheckResult = array();
							foreach ($arOneCondition['value'] as &$intUserID)
							{

								$rsUsers = CUser::GetList($by2, $order2, array('ID_EQUAL_EXACT' => $intUserID),array('FIELDS' => array('ID', 'LOGIN', 'NAME', 'LAST_NAME')));
								if ($arUser = $rsUsers->Fetch())
								{
									$strName = trim($arUser['NAME'].' '.$arUser['LAST_NAME']);
									if ('' == $strName)
										$strName = $arUser['LOGIN'];
									$arCheckResult[$intUserID] = $strName;
								}
							}
							if (isset($intUserID))
								unset($intUserID);
							if (!empty($arCheckResult))
							{
								$arResult['values'] = array_keys($arCheckResult);
								$arResult['labels'] = array_values($arCheckResult);
							}
							else
							{
								$boolError = true;
								$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_USER_ABSENT_MULTI');
							}
						}
						else
						{
							$rsUsers = CUser::GetList($by2, $order2, array('ID_EQUAL_EXACT' => $arOneCondition['value']),array('FIELDS' => array('ID', 'LOGIN', 'NAME', 'LAST_NAME')));
							if ($arUser = $rsUsers->Fetch())
							{
								$arResult['values'] = $arOneCondition['value'];
								$arResult['labels'] = trim($arUser['NAME'].' '.$arUser['LAST_NAME']);
								if ('' == $arResult['labels'])
									$arResult['labels'] = $arUser['LOGIN'];
							}
							else
							{
								$boolError = true;
								$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_USER_ABSENT');
							}
						}
						break;
					case 'list':
						if (isset($arControl['JS_VALUE']) && is_array($arControl['JS_VALUE']) && isset($arControl['JS_VALUE']['values']) && !empty($arControl['JS_VALUE']['values']))
						{
							if ($boolMulti)
							{
								$arCheckResult = array();
								foreach ($arOneCondition['value'] as &$strValue)
								{
									if (isset($arControl['JS_VALUE']['values'][$strValue]))
										$arCheckResult[] = $strValue;
								}
								if (isset($strValue))
									unset($strValue);
								if (!empty($arCheckResult))
								{
									$arResult['values'] = $arCheckResult;
								}
								else
								{
									$boolError = true;
									$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_LIST_ABSENT_MULTI');
								}
							}
							else
							{
								if (isset($arControl['JS_VALUE']['values'][$arOneCondition['value']]))
								{
									$arResult['values'] = $arOneCondition['value'];
								}
								else
								{
									$boolError = true;
									$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_LIST_ABSENT');
								}
							}
						}
						else
						{
							$boolError = true;
						}
						break;
				}
			}
			else
			{
				// validate for save
				$boolMulti = is_array($arOneCondition['value']);
				switch($arControl['PHP_VALUE']['VALIDATE'])
				{
					case 'element':
						$rsItems = CIBlockElement::GetList(array(), array('ID' => $arOneCondition['value']), false, false, array('ID'));
						if ($boolMulti)
						{
							$arCheckResult = array();
							while ($arItem = $rsItems->Fetch())
							{
								$arCheckResult[] = (int)$arItem['ID'];
							}
							if (!empty($arCheckResult))
							{
								$arResult['values'] = $arCheckResult;
							}
							else
							{
								$boolError = true;
							}
						}
						else
						{
							if ($arItem = $rsItems->Fetch())
							{
								$arResult['values'] = (int)$arItem['ID'];
							}
							else
							{
								$boolError = true;
							}
						}
						break;
					case 'section':
						$rsSections = CIBlockSection::GetList(array(), array('ID' => $arOneCondition['value']), false, array('ID'));
						if ($boolMulti)
						{
							$arCheckResult = array();
							while ($arSection = $rsSections->Fetch())
							{
								$arCheckResult[] = (int)$arSection['ID'];
							}
							if (!empty($arCheckResult))
							{
								$arResult['values'] = $arCheckResult;
							}
							else
							{
								$boolError = true;
							}
						}
						else
						{
							if ($arSection = $rsSections->Fetch())
							{
								$arResult['values'] = (int)$arSection['ID'];
							}
							else
							{
								$boolError = true;
							}
						}
						break;
					case 'iblock':
						if ($boolMulti)
						{
							$arCheckResult = array();
							foreach ($arOneCondition['value'] as &$intIBlockID)
							{
								$strName = CIBlock::GetArrayByID($intIBlockID, 'NAME');
								if (false !== $strName && !is_null($strName))
								{
									$arCheckResult[] = $intIBlockID;
								}
							}
							if (isset($intIBlockID))
								unset($intIBlockID);
							if (!empty($arCheckResult))
							{
								$arResult['values'] = $arCheckResult;
							}
							else
							{
								$boolError = true;
							}
						}
						else
						{
							$strName = CIBlock::GetArrayByID($arOneCondition['value'], 'NAME');
							if (false !== $strName && !is_null($strName))
							{
								$arResult['values'] = $arOneCondition['value'];
							}
							else
							{
								$boolError = true;
							}
						}
						break;
					case 'user':
						$by2 = 'ID';
						$order2 = 'ASC';
						if ($boolMulti)
						{
							$arCheckResult = array();
							foreach ($arOneCondition['value'] as &$intUserID)
							{
								$rsUsers = CUser::GetList($by2, $order2, array('ID_EQUAL_EXACT' => $intUserID),array('FIELDS' => array('ID', 'LOGIN', 'NAME', 'LAST_NAME')));
								if ($arUser = $rsUsers->Fetch())
								{
									$arCheckResult[] = $intUserID;
								}
							}
							if (isset($intUserID))
								unset($intUserID);
							if (!empty($arCheckResult))
							{
								$arResult['values'] = $arCheckResult;
							}
							else
							{
								$boolError = true;
							}
						}
						else
						{
							$rsUsers = CUser::GetList($by2, $order2, array('ID_EQUAL_EXACT' => $arOneCondition['value']),array('FIELDS' => array('ID', 'LOGIN', 'NAME', 'LAST_NAME')));
							if ($arUser = $rsUsers->Fetch())
							{
								$arResult['values'] = $arOneCondition['value'];
							}
							else
							{
								$boolError = true;
							}
						}
						break;
					case 'list':
						if (isset($arControl['JS_VALUE']) && is_array($arControl['JS_VALUE']) && isset($arControl['JS_VALUE']['values']) && !empty($arControl['JS_VALUE']['values']))
						{
							if ($boolMulti)
							{
								$arCheckResult = array();
								foreach ($arOneCondition['value'] as &$strValue)
								{
									if (isset($arControl['JS_VALUE']['values'][$strValue]))
										$arCheckResult[] = $strValue;
								}
								if (isset($strValue))
									unset($strValue);
								if (!empty($arCheckResult))
								{
									$arResult['values'] = $arCheckResult;
								}
								else
								{
									$boolError = true;
								}
							}
							else
							{
								if (isset($arControl['JS_VALUE']['values'][$arOneCondition['value']]))
								{
									$arResult['values'] = $arOneCondition['value'];
								}
								else
								{
									$boolError = true;
								}
							}
						}
						else
						{
							$boolError = true;
						}
						break;
				}
			}
		}

		if ($boolShow)
		{
			if ($boolError)
			{
				$arResult['err_cond'] = 'Y';
				$arResult['err_cond_mess'] = $arMsg;
			}
			return $arResult;
		}
		else
		{
			return (!$boolError ? $arResult : false);
		}
	}

	public static function CheckAtoms($arOneCondition, $arParams, $arControl, $boolShow)
	{
		$arResult = array();

		$boolShow = (true === $boolShow);
		$boolError = false;
		$boolFatalError = false;
		$arMsg = array();

		$arValues = array();
		$arLabels = array();

		static $intTimeOffset = false;
		if (false === $intTimeOffset)
			$intTimeOffset = CTimeZone::GetOffset();

		if (!isset($arControl['ATOMS']) || empty($arControl['ATOMS']) || !is_array($arControl['ATOMS']))
		{
			$boolFatalError = true;
			$boolError = true;
			$arMsg[] = Loc::getMessage('BT_GLOBAL_COND_ERR_ATOMS_ABSENT');
		}
		if (!$boolError)
		{
			$boolValidate = false;
			if ($boolShow)
			{
				foreach ($arControl['ATOMS'] as &$arOneAtom)
				{
					$boolAtomError = false;
					$strID = $arOneAtom['ATOM']['ID'];
					$boolMulti = false;
					if (!isset($arOneCondition[$strID]))
					{
						$boolAtomError = true;
					}
					else
					{
						$boolMulti = is_array($arOneCondition[$strID]);
						switch ($arOneAtom['ATOM']['FIELD_TYPE'])
						{
							case 'int':
								if ($boolMulti)
								{
									foreach ($arOneCondition[$strID] as &$intOneValue)
									{
										$intOneValue = (int)$intOneValue;
									}
									if (isset($intOneValue))
										unset($intOneValue);
								}
								else
								{
									$arOneCondition[$strID] = (int)$arOneCondition[$strID];
								}
								break;
							case 'double':
								if ($boolMulti)
								{
									foreach ($arOneCondition[$strID] as &$dblOneValue)
									{
										$dblOneValue = doubleval($dblOneValue);
									}
									if (isset($dblOneValue))
										unset($dblOneValue);
								}
								else
								{
									$arOneCondition[$strID] = doubleval($arOneCondition[$strID]);
								}
								break;
							case 'strdouble':
								if ($boolMulti)
								{
									foreach ($arOneCondition[$strID] as &$dblOneValue)
									{
										if ('' != $dblOneValue)
											$dblOneValue = doubleval($dblOneValue);
									}
									if (isset($dblOneValue))
										unset($dblOneValue);
								}
								else
								{
									if ('' != $arOneCondition[$strID])
										$arOneCondition[$strID] = doubleval($arOneCondition[$strID]);
								}
								break;
							case 'char':
								if ($boolMulti)
								{
									foreach ($arOneCondition[$strID] as &$strOneValue)
									{
										$strOneValue = substr($strOneValue, 0, 1);
									}
									if (isset($strOneValue))
										unset($strOneValue);
								}
								else
								{
									$arOneCondition[$strID] = substr($arOneCondition[$strID], 0, 1);
								}
								break;
							case 'string':
								$intMaxLen = (int)(isset($arOneAtom['ATOM']['FIELD_LENGTH']) && (int)$arOneAtom['ATOM']['FIELD_LENGTH'] > 0 ? $arOneAtom['ATOM']['FIELD_LENGTH'] : 255);
								if ($boolMulti)
								{
									foreach ($arOneCondition[$strID] as &$strOneValue)
									{
										$strOneValue = substr($strOneValue, 0, $intMaxLen);
									}
									if (isset($strOneValue))
										unset($strOneValue);
								}
								else
								{
									$arOneCondition[$strID] = substr($arOneCondition[$strID], 0, $intMaxLen);
								}
								break;
							case 'text':
								break;
							case 'date':
							case 'datetime':
								if ('date' == $arOneAtom['ATOM']['FIELD_TYPE'])
								{
									$strFormat = 'SHORT';
									$intOffset = 0;
								}
								else
								{
									$strFormat = 'FULL';
									$intOffset = $intTimeOffset;
								}
								$boolAtomError = CGlobalCondCtrl::ConvertInt2DateTime($arOneCondition[$strID], $strFormat, $intOffset);
								break;
							default:
								$boolAtomError = true;
						}
					}
					if (!$boolAtomError)
					{
						if ($boolMulti)
							$arOneCondition[$strID] = array_values(array_unique($arOneCondition[$strID]));
						$arValues[$strID] = $arOneCondition[$strID];
						if (isset($arOneAtom['ATOM']['VALIDATE']) && !empty($arOneAtom['ATOM']['VALIDATE']))
							$boolValidate = true;
					}
					else
					{
						$arValues[$strID] = '';
					}
					if ($boolAtomError)
						$boolError = true;
				}
				if (isset($arOneAtom))
					unset($arOneAtom);

				if (!$boolError)
				{
					if ($boolValidate)
					{
						$arValidate = static::ValidateAtoms($arValues, $arParams, $arControl, $boolShow);
						if (false === $arValidate)
						{
							$boolError = true;
						}
						else
						{
							if (isset($arValidate['err_cond']) && 'Y' == $arValidate['err_cond'])
							{
								$boolError = true;
								if (isset($arValidate['err_cond_mess']) && !empty($arValidate['err_cond_mess']))
									$arMsg = array_merge($arMsg, $arValidate['err_cond_mess']);
							}
							else
							{
								$arValues = $arValidate['values'];
								if (isset($arValidate['labels']))
									$arLabels = $arValidate['labels'];
							}
						}
					}
				}
			}
			else
			{
				foreach ($arControl['ATOMS'] as &$arOneAtom)
				{
					$boolAtomError = false;
					$strID = $arOneAtom['ATOM']['ID'];
					$strName = $arOneAtom['JS']['name'];
					$boolMulti = false;
					if (!isset($arOneCondition[$strName]))
					{
						$boolAtomError = true;
					}
					else
					{
						$boolMulti = is_array($arOneCondition[$strName]);
					}
					if (!$boolAtomError)
					{
						switch ($arOneAtom['ATOM']['FIELD_TYPE'])
						{
							case 'int':
								if ($boolMulti)
								{
									foreach ($arOneCondition[$strName] as &$intOneValue)
									{
										$intOneValue = (int)$intOneValue;
									}
									if (isset($intOneValue))
										unset($intOneValue);
								}
								else
								{
									$arOneCondition[$strName] = (int)$arOneCondition[$strName];
								}
								break;
							case 'double':
								if ($boolMulti)
								{
									foreach ($arOneCondition[$strName] as &$dblOneValue)
									{
										$dblOneValue = doubleval($dblOneValue);
									}
									if (isset($dblOneValue))
										unset($dblOneValue);
								}
								else
								{
									$arOneCondition[$strName] = doubleval($arOneCondition[$strName]);
								}
								break;
							case 'strdouble':
								if ($boolMulti)
								{
									foreach ($arOneCondition[$strName] as &$dblOneValue)
									{
										if ('' != $dblOneValue)
											$dblOneValue = doubleval($dblOneValue);
									}
									if (isset($dblOneValue))
										unset($dblOneValue);
								}
								else
								{
									if ('' != $arOneCondition[$strName])
									{
										$arOneCondition[$strName] = doubleval($arOneCondition[$strName]);
									}
								}
								break;
							case 'char':
								if ($boolMulti)
								{
									foreach ($arOneCondition[$strName] as &$strOneValue)
									{
										$strOneValue = substr($strOneValue, 0, 1);
									}
									if (isset($strOneValue))
										unset($strOneValue);
								}
								else
								{
									$arOneCondition[$strName] = substr($arOneCondition[$strName], 0, 1);
								}
								break;
							case 'string':
								$intMaxLen = (int)(isset($arOneAtom['ATOM']['FIELD_LENGTH']) && (int)$arOneAtom['ATOM']['FIELD_LENGTH'] > 0 ? $arOneAtom['ATOM']['FIELD_LENGTH'] : 255);
								if ($boolMulti)
								{
									foreach ($arOneCondition[$strName] as &$strOneValue)
									{
										$strOneValue = substr($strOneValue, 0, $intMaxLen);
									}
									if (isset($strOneValue))
										unset($strOneValue);
								}
								else
								{
									$arOneCondition[$strName] = substr($arOneCondition[$strName], 0, $intMaxLen);
								}
								break;
							case 'text':
								break;
							case 'date':
							case 'datetime':
								if ('date' == $arOneAtom['ATOM']['FIELD_TYPE'])
								{
									$strFormat = 'SHORT';
									$intOffset = 0;
								}
								else
								{
									$strFormat = 'FULL';
									$intOffset = $intTimeOffset;
								}
								$boolAtomError = CGlobalCondCtrl::ConvertDateTime2Int($arOneCondition[$strName], $strFormat, $intOffset);
								break;
							default:
								$boolAtomError = true;
						}
						if (!$boolAtomError)
						{
							if ($boolMulti)
								$arOneCondition[$strName] = array_values(array_unique($arOneCondition[$strName]));
							$arValues[$strID] = $arOneCondition[$strName];
							if (isset($arOneAtom['ATOM']['VALIDATE']) && !empty($arOneAtom['ATOM']['VALIDATE']))
								$boolValidate = true;
						}
						else
						{
							$arValues[$strID] = '';
						}
					}
					if ($boolAtomError)
						$boolError = true;
				}
				if (isset($arOneAtom))
					unset($arOneAtom);

				if (!$boolError)
				{
					if ($boolValidate)
					{
						$arValidate = static::ValidateAtoms($arValues, $arParams, $arControl, $boolShow);
						if (false === $arValidate)
						{
							$boolError = true;
						}
						else
						{
							$arValues = $arValidate['values'];
							if (isset($arValidate['labels']))
								$arLabels = $arValidate['labels'];
						}
					}
				}
			}
		}

		if ($boolShow)
		{
			$arResult = array(
				'id' => $arParams['COND_NUM'],
				'controlId' => $arControl['ID'],
				'values' => $arValues
			);
			if (!empty($arLabels))
				$arResult['labels'] = $arLabels;
			if ($boolError)
			{
				$arResult['err_cond'] = 'Y';
				if ($boolFatalError)
					$arResult['fatal_err_cond'] = 'Y';
				if (!empty($arMsg))
					$arResult['err_cond_mess'] = implode('. ', $arMsg);
			}

			return $arResult;
		}
		else
		{
			$arResult = $arValues;

			return (!$boolError ? $arResult : false);
		}
	}

	public static function ValidateAtoms($arValues, $arParams, $arControl, $boolShow)
	{
		$boolShow = (true === $boolShow);
		$boolError = false;
		$arMsg = array();

		$arResult = array(
			'values' => array(),
			'labels' => array(),
			'titles' => array()
		);

		if (!isset($arControl['ATOMS']) || empty($arControl['ATOMS']) || !is_array($arControl['ATOMS']))
		{
			$boolError = true;
			$arMsg[] = Loc::getMessage('BT_GLOBAL_COND_ERR_ATOMS_ABSENT');
		}
		if (!$boolError)
		{
			if ($boolShow)
			{
				foreach ($arControl['ATOMS'] as &$arOneAtom)
				{
					$strID = $arOneAtom['ATOM']['ID'];
					if (!isset($arOneAtom['ATOM']['VALIDATE']) || empty($arOneAtom['ATOM']['VALIDATE']))
					{
						$arResult['values'][$strID] = $arValues[$strID];
						continue;
					}
					switch ($arOneAtom['ATOM']['VALIDATE'])
					{
						case 'list':
							if (isset($arOneAtom['JS']) && is_array($arOneAtom['JS']) && isset($arOneAtom['JS']['values']) && !empty($arOneAtom['JS']['values']))
							{
								if (is_array($arValues[$strID]))
								{
									$arCheckResult = array();
									foreach ($arValues[$strID] as &$strValue)
									{
										if (isset($arOneAtom['JS']['values'][$strValue]))
											$arCheckResult[] = $strValue;
									}
									if (isset($strValue))
										unset($strValue);
									if (!empty($arCheckResult))
									{
										$arResult['values'][$strID] = $arCheckResult;
									}
									else
									{
										$boolError = true;
										$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_LIST_ABSENT_MULTI');
									}
								}
								else
								{
									if (isset($arOneAtom['JS']['values'][$arValues[$strID]]))
									{
										$arResult['values'][$strID] = $arValues[$strID];
									}
									else
									{
										$boolError = true;
										$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_LIST_ABSENT');
									}
								}
							}
							else
							{
								$boolError = true;
							}
							break;
						case 'element':
							$rsItems = CIBlockElement::GetList(array(), array('ID' => $arValues[$strID]), false, false, array('ID', 'NAME'));
							if (is_array($arValues[$strID]))
							{
								$arCheckResult = array();
								while ($arItem = $rsItems->Fetch())
								{
									$arCheckResult[(int)$arItem['ID']] = $arItem['NAME'];
								}
								if (!empty($arCheckResult))
								{
									$arResult['values'][$strID] = array_keys($arCheckResult);
									$arResult['labels'][$strID] = array_values($arCheckResult);
								}
								else
								{
									$boolError = true;
									$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_ELEMENT_ABSENT_MULTI');
								}
							}
							else
							{
								if ($arItem = $rsItems->Fetch())
								{
									$arResult['values'][$strID] = (int)$arItem['ID'];
									$arResult['labels'][$strID] = $arItem['NAME'];
								}
								else
								{
									$boolError = true;
									$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_ELEMENT_ABSENT');
								}
							}
							break;
						case 'section':
							$rsSections = CIBlockSection::GetList(array(), array('ID' => $arValues[$strID]), false, array('ID', 'NAME'));
							if (is_array($arValues[$strID]))
							{
								$arCheckResult = array();
								while ($arSection = $rsSections->Fetch())
								{
									$arCheckResult[(int)$arSection['ID']] = $arSection['NAME'];
								}
								if (!empty($arCheckResult))
								{
									$arResult['values'][$strID] = array_keys($arCheckResult);
									$arResult['labels'][$strID] = array_values($arCheckResult);
								}
								else
								{
									$boolError = true;
									$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_SECTION_ABSENT_MULTI');
								}
							}
							else
							{
								if ($arSection = $rsSections->Fetch())
								{
									$arResult['values'][$strID] = (int)$arSection['ID'];
									$arResult['labels'][$strID] = $arSection['NAME'];
								}
								else
								{
									$boolError = true;
									$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_SECTION_ABSENT');
								}
							}
							break;
						case 'iblock':
							if (is_array($arValues[$strID]))
							{
								$arCheckResult = array();
								foreach ($arValues[$strID] as &$intIBlockID)
								{
									$strName = CIBlock::GetArrayByID($intIBlockID, 'NAME');
									if (false !== $strName && !is_null($strName))
									{
										$arCheckResult[$intIBlockID] = $strName;
									}
								}
								if (isset($intIBlockID))
									unset($intIBlockID);
								if (!empty($arCheckResult))
								{
									$arResult['values'][$strID] = array_keys($arCheckResult);
									$arResult['labels'][$strID] = array_values($arCheckResult);
								}
								else
								{
									$boolError = true;
									$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_IBLOCK_ABSENT_MULTI');
								}
							}
							else
							{
								$strName = CIBlock::GetArrayByID($arValues[$strID], 'NAME');
								if (false !== $strName && !is_null($strName))
								{
									$arResult['values'][$strID] = $arValues[$strID];
									$arResult['labels'][$strID] = $strName;
								}
								else
								{
									$boolError = true;
									$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_IBLOCK_ABSENT');
								}
							}
							break;
						case 'user':
							if (is_array($arValues[$strID]))
							{
								$arCheckResult = array();
								foreach ($arValues[$strID] as &$intUserID)
								{
									$rsUsers = CUser::GetList(($by2 = 'ID'),($order2 = 'ASC'),array('ID_EQUAL_EXACT' => $intUserID),array('FIELDS' => array('ID', 'LOGIN', 'NAME', 'LAST_NAME')));
									if ($arUser = $rsUsers->Fetch())
									{
										$strName = trim($arUser['NAME'].' '.$arUser['LAST_NAME']);
										if ('' == $strName)
											$strName = $arUser['LOGIN'];
										$arCheckResult[$intUserID] = $strName;
									}
								}
								if (isset($intUserID))
									unset($intUserID);
								if (!empty($arCheckResult))
								{
									$arResult['values'][$strID] = array_keys($arCheckResult);
									$arResult['labels'][$strID] = array_values($arCheckResult);
								}
								else
								{
									$boolError = true;
									$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_USER_ABSENT_MULTI');
								}
							}
							else
							{
								$rsUsers = CUser::GetList(($by2 = 'ID'),($order2 = 'ASC'),array('ID_EQUAL_EXACT' => $arValues[$strID]),array('FIELDS' => array('ID', 'LOGIN', 'NAME', 'LAST_NAME')));
								if ($arUser = $rsUsers->Fetch())
								{
									$arResult['values'][$strID] = $arValues[$strID];
									$arResult['labels'][$strID] = trim($arUser['NAME'].' '.$arUser['LAST_NAME']);
									if ('' == $arResult['labels'][$strID])
										$arResult['labels'][$strID] = $arUser['LOGIN'];
								}
								else
								{
									$boolError = true;
									$arMsg[] = Loc::getMessage('BT_MOD_COND_ERR_CHECK_DATA_USER_ABSENT');
								}
							}
							break;
					}
				}
				if (isset($arOneAtom))
					unset($arOneAtom);
			}
			else
			{
				foreach ($arControl['ATOMS'] as &$arOneAtom)
				{
					$strID = $arOneAtom['ATOM']['ID'];
					if (!isset($arOneAtom['ATOM']['VALIDATE']) || empty($arOneAtom['ATOM']['VALIDATE']))
					{
						$arResult['values'][$strID] = $arValues[$strID];
						continue;
					}
					switch ($arOneAtom['ATOM']['VALIDATE'])
					{
						case 'list':
							if (isset($arOneAtom['JS']) && is_array($arOneAtom['JS']) && isset($arOneAtom['JS']['values']) && !empty($arOneAtom['JS']['values']))
							{
								if (is_array($arValues[$strID]))
								{
									$arCheckResult = array();
									foreach ($arValues[$strID] as &$strValue)
									{
										if (isset($arOneAtom['JS']['values'][$strValue]))
											$arCheckResult[] = $strValue;
									}
									if (isset($strValue))
										unset($strValue);
									if (!empty($arCheckResult))
									{
										$arResult['values'][$strID] = $arCheckResult;
									}
									else
									{
										$boolError = true;
									}
								}
								else
								{
									if (isset($arOneAtom['JS']['values'][$arValues[$strID]]))
									{
										$arResult['values'][$strID] = $arValues[$strID];
									}
									else
									{
										$boolError = true;
									}
								}
							}
							else
							{
								$boolError = true;
							}
							break;
						case 'element':
							$rsItems = CIBlockElement::GetList(array(), array('ID' => $arValues[$strID]), false, false, array('ID'));
							if (is_array($arValues[$strID]))
							{
								$arCheckResult = array();
								while ($arItem = $rsItems->Fetch())
								{
									$arCheckResult[] = (int)$arItem['ID'];
								}
								if (!empty($arCheckResult))
								{
									$arResult['values'][$strID] = $arCheckResult;
								}
								else
								{
									$boolError = true;
								}
							}
							else
							{
								if ($arItem = $rsItems->Fetch())
								{
									$arResult['values'][$strID] = (int)$arItem['ID'];
								}
								else
								{
									$boolError = true;
								}
							}
							break;
						case 'section':
							$rsSections = CIBlockSection::GetList(array(), array('ID' => $arValues[$strID]), false, array('ID'));
							if (is_array($arValues[$strID]))
							{
								$arCheckResult = array();
								while ($arSection = $rsSections->Fetch())
								{
									$arCheckResult[] = (int)$arSection['ID'];
								}
								if (!empty($arCheckResult))
								{
									$arResult['values'][$strID] = $arCheckResult;
								}
								else
								{
									$boolError = true;
								}
							}
							else
							{
								if ($arSection = $rsSections->Fetch())
								{
									$arResult['values'][$strID] = (int)$arSection['ID'];
								}
								else
								{
									$boolError = true;
								}
							}
							break;
						case 'iblock':
							if (is_array($arValues[$strID]))
							{
								$arCheckResult = array();
								foreach ($arValues[$strID] as &$intIBlockID)
								{
									$strName = CIBlock::GetArrayByID($intIBlockID, 'NAME');
									if (false !== $strName && !is_null($strName))
									{
										$arCheckResult[] = $intIBlockID;
									}
								}
								if (isset($intIBlockID))
									unset($intIBlockID);
								if (!empty($arCheckResult))
								{
									$arResult['values'][$strID] = $arCheckResult;
								}
								else
								{
									$boolError = true;
								}
							}
							else
							{
								$strName = CIBlock::GetArrayByID($arValues[$strID], 'NAME');
								if (false !== $strName && !is_null($strName))
								{
									$arResult['values'][$strID] = $arValues[$strID];
								}
								else
								{
									$boolError = true;
								}
							}
							break;
						case 'user':
							if (is_array($arValues[$strID]))
							{
								$arCheckResult = array();
								foreach ($arValues[$strID] as &$intUserID)
								{
									$rsUsers = CUser::GetList(($by2 = 'ID'),($order2 = 'ASC'),array('ID_EQUAL_EXACT' => $intUserID),array('FIELDS' => array('ID', 'LOGIN', 'NAME', 'LAST_NAME')));
									if ($arUser = $rsUsers->Fetch())
									{
										$arCheckResult[] = $intUserID;
									}
								}
								if (isset($intUserID))
									unset($intUserID);
								if (!empty($arCheckResult))
								{
									$arResult['values'][$strID] = $arCheckResult;
								}
								else
								{
									$boolError = true;
								}
							}
							else
							{
								$rsUsers = CUser::GetList(($by2 = 'ID'),($order2 = 'ASC'),array('ID_EQUAL_EXACT' => $arValues[$strID]),array('FIELDS' => array('ID', 'LOGIN', 'NAME', 'LAST_NAME')));
								if ($arUser = $rsUsers->Fetch())
								{
									$arResult['values'][$strID] = $arValues[$strID];
								}
								else
								{
									$boolError = true;
								}
							}
							break;
					}
				}
				if (isset($arOneAtom))
					unset($arOneAtom);
			}
		}

		if ($boolShow)
		{
			if ($boolError)
			{
				$arResult['err_cond'] = 'Y';
				$arResult['err_cond_mess'] = $arMsg;
			}
			return $arResult;
		}
		else
		{
			return (!$boolError ? $arResult : false);
		}
	}

	public static function UndefinedCondition($boolFatal = false)
	{
		$boolFatal = (true === $boolFatal);
		$arResult = array(
			''
		);
	}

	static function LogicGreat($arField, $mxValue)
	{
		$boolResult = false;
		if (!is_array($arField))
			$arField = array($arField);
		if (!empty($arField))
		{
			foreach ($arField as &$mxOneValue)
			{
				if (null === $mxOneValue || '' === $mxOneValue)
					continue;
				if ($mxOneValue > $mxValue)
				{
					$boolResult = true;
					break;
				}
			}
			if (isset($mxOneValue))
				unset($mxOneValue);
		}
		return $boolResult;
	}

	static function LogicLess($arField, $mxValue)
	{
		$boolResult = false;
		if (!is_array($arField))
			$arField = array($arField);
		if (!empty($arField))
		{
			foreach ($arField as &$mxOneValue)
			{
				if (null === $mxOneValue || '' === $mxOneValue)
					continue;
				if ($mxOneValue < $mxValue)
				{
					$boolResult = true;
					break;
				}
			}
			if (isset($mxOneValue))
				unset($mxOneValue);
		}
		return $boolResult;
	}

	static function LogicEqualGreat($arField, $mxValue)
	{
		$boolResult = false;
		if (!is_array($arField))
			$arField = array($arField);
		if (!empty($arField))
		{
			foreach ($arField as &$mxOneValue)
			{
				if (null === $mxOneValue || '' === $mxOneValue)
					continue;
				if ($mxOneValue >= $mxValue)
				{
					$boolResult = true;
					break;
				}
			}
			if (isset($mxOneValue))
				unset($mxOneValue);
		}
		return $boolResult;
	}

	static function LogicEqualLess($arField, $mxValue)
	{
		$boolResult = false;
		if (!is_array($arField))
			$arField = array($arField);
		if (!empty($arField))
		{
			foreach ($arField as &$mxOneValue)
			{
				if (null === $mxOneValue || '' === $mxOneValue)
					continue;
				if ($mxOneValue <= $mxValue)
				{
					$boolResult = true;
					break;
				}
			}
			if (isset($mxOneValue))
				unset($mxOneValue);
		}
		return $boolResult;
	}

	static function LogicContain($arField, $mxValue)
	{
		$boolResult = false;
		if (!is_array($arField))
			$arField = array($arField);
		if (!empty($arField))
		{
			foreach ($arField as &$mxOneValue)
			{
				if (false !== strpos($mxOneValue, $mxValue))
				{
					$boolResult = true;
					break;
				}
			}
			if (isset($mxOneValue))
				unset($mxOneValue);
		}
		return $boolResult;
	}

	static function LogicNotContain($arField, $mxValue)
	{
		$boolResult = true;
		if (!is_array($arField))
			$arField = array($arField);
		if (!empty($arField))
		{
			foreach ($arField as &$mxOneValue)
			{
				if (false !== strpos($mxOneValue, $mxValue))
				{
					$boolResult = false;
					break;
				}
			}
			if (isset($mxOneValue))
				unset($mxOneValue);
		}
		return $boolResult;
	}

	public static function ClearValue(&$mxValues)
	{
		$boolLocalError = false;
		if (is_array($mxValues))
		{
			if (!empty($mxValues))
			{
				$arResult = array();
				foreach ($mxValues as &$strOneValue)
				{
					$strOneValue = trim((string)$strOneValue);
					if ('' != $strOneValue)
						$arResult[] = $strOneValue;
				}
				if (isset($strOneValue))
					unset($strOneValue);
				$mxValues = $arResult;
				if (empty($mxValues))
					$boolLocalError = true;
			}
			else
			{
				$boolLocalError = true;
			}
		}
		else
		{
			$mxValues = trim((string)$mxValues);
			if ('' == $mxValues)
			{
				$boolLocalError = true;
			}
		}
		return $boolLocalError;
	}

	static function ConvertInt2DateTime(&$mxValues, $strFormat, $intOffset)
	{
		global $DB;

		$boolValueError = false;
		if (is_array($mxValues))
		{
			foreach ($mxValues as &$strValue)
			{
				if ($strValue.'!' == (int)$strValue.'!')
				{
					$strValue = ConvertTimeStamp($strValue + $intOffset, $strFormat);
				}
				if (!$DB->IsDate($strValue, false, false, $strFormat))
				{
					$boolValueError = true;
				}
			}
			if (isset($strValue))
				unset($strValue);
		}
		else
		{
			if ($mxValues.'!' == (int)$mxValues.'!')
			{
				$mxValues = ConvertTimeStamp($mxValues + $intOffset, $strFormat);
			}
			$boolValueError = !$DB->IsDate($mxValues, false, false, $strFormat);
		}
		return $boolValueError;
	}

	static function ConvertDateTime2Int(&$mxValues, $strFormat, $intOffset)
	{
		global $DB;

		$boolError = false;
		if (is_array($mxValues))
		{
			$boolLocalErr = false;
			$arLocal = array();
			foreach ($mxValues as &$strValue)
			{
				if ($strValue.'!' != (int)$strValue.'!')
				{
					if (!$DB->IsDate($strValue, false, false, $strFormat))
					{
						$boolError = true;
						$boolLocalErr = true;
						break;
					}
					$arLocal[] = MakeTimeStamp($strValue) - $intOffset;
				}
				else
				{
					$arLocal[] = $strValue;
				}
			}
			if (isset($strValue))
				unset($strValue);
			if (!$boolLocalErr)
				$mxValues = $arLocal;
		}
		else
		{
			if ($mxValues.'!' != (int)$mxValues.'!')
			{
				if (!$DB->IsDate($mxValues, false, false, $strFormat))
				{
					$boolError = true;
				}
				else
				{
					$mxValues = MakeTimeStamp($mxValues) - $intOffset;
				}
			}
		}
		return $boolError;
	}
}

class CGlobalCondCtrlComplex extends CGlobalCondCtrl
{
	public static function GetClassName()
	{
		return __CLASS__;
	}

	public static function GetControlDescr()
	{
		$strClassName = static::GetClassName();
		return array(
			'COMPLEX' => 'Y',
			"GetControlShow" => array($strClassName, "GetControlShow"),
			"GetConditionShow" => array($strClassName, "GetConditionShow"),
			"IsGroup" => array($strClassName, "IsGroup"),
			"Parse" => array($strClassName, "Parse"),
			"Generate" => array($strClassName, "Generate"),
			"ApplyValues" => array($strClassName, "ApplyValues"),
			"InitParams" => array($strClassName, "InitParams"),
			'CONTROLS' => static::GetControls()
		);
	}

	public static function GetConditionShow($arParams)
	{
		if (!isset($arParams['ID']))
			return false;
		$arControl = static::GetControls($arParams['ID']);
		if (false === $arControl)
			return false;
		if (!isset($arParams['DATA']))
			return false;
		return static::Check($arParams['DATA'], $arParams, $arControl, true);
	}

	public static function Parse($arOneCondition)
	{
		if (!isset($arOneCondition['controlId']))
			return false;
		$arControl = static::GetControls($arOneCondition['controlId']);
		if (false === $arControl)
			return false;
		return static::Check($arOneCondition, $arOneCondition, $arControl, false);
	}

	public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
	{
		$strResult = '';
		$arValues = false;

		if (is_string($arControl))
		{
			$arControl = static::GetControls($arControl);
		}
		$boolError = !is_array($arControl);

		if (!$boolError)
		{
			$arValues = static::Check($arOneCondition, $arOneCondition, $arControl, false);
			$boolError = ($arValues === false);
		}
		if (!$boolError)
		{
			$boolError = !isset($arControl['MULTIPLE']);
		}

		if (!$boolError)
		{
			$arLogic = static::SearchLogic($arValues['logic'], $arControl['LOGIC']);
			if (!isset($arLogic['OP'][$arControl['MULTIPLE']]) || empty($arLogic['OP'][$arControl['MULTIPLE']]))
			{
				$boolError = true;
			}
			else
			{
				$strField = $arParams['FIELD'].'[\''.$arControl['FIELD'].'\']';
				switch ($arControl['FIELD_TYPE'])
				{
					case 'int':
					case 'double':
						$strResult = str_replace(array('#FIELD#', '#VALUE#'), array($strField, $arValues['value']), $arLogic['OP'][$arControl['MULTIPLE']]);
						break;
					case 'char':
					case 'string':
					case 'text':
						$strResult = str_replace(array('#FIELD#', '#VALUE#'), array($strField, '"'.EscapePHPString($arValues['value']).'"'), $arLogic['OP'][$arControl['MULTIPLE']]);
						break;
					case 'date':
					case 'datetime':
						$strResult = str_replace(array('#FIELD#', '#VALUE#'), array($strField, $arValues['value']), $arLogic['OP'][$arControl['MULTIPLE']]);
						break;
				}
			}
		}

		return (!$boolError ? $strResult : false);
	}

	public static function GetControls($strControlID = false)
	{
		return false;
	}
}

class CGlobalCondCtrlGroup extends CGlobalCondCtrl
{
	public static function GetClassName()
	{
		return __CLASS__;
	}

	public static function GetControlDescr()
	{
		$strClassName = static::GetClassName();
		return array(
			"ID" => static::GetControlID(),
			"GROUP" => "Y",
			"GetControlShow" => array($strClassName, "GetControlShow"),
			"GetConditionShow" => array($strClassName, "GetConditionShow"),
			"IsGroup" => array($strClassName, "IsGroup"),
			"Parse" => array($strClassName, "Parse"),
			"Generate" => array($strClassName, "Generate"),
			"ApplyValues" => array($strClassName, "ApplyValues")
		);
	}

	public static function GetControlShow($arParams)
	{
		return array(
			'controlId' => static::GetControlID(),
			'group' => true,
			'label' => Loc::getMessage('BT_CLOBAL_COND_GROUP_LABEL'),
			'defaultText' => Loc::getMessage('BT_CLOBAL_COND_GROUP_DEF_TEXT'),
			'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
			'visual' => static::GetVisual(),
			'control' => array_values(static::GetAtoms())
		);
	}

	public static function GetConditionShow($arParams)
	{
		$boolError = false;
		$arAtoms = static::GetAtoms();
		$arValues = array();
		foreach ($arAtoms as &$arOneAtom)
		{
			if (!isset($arParams['DATA'][$arOneAtom['id']]))
			{
				$boolError = true;
			}
			elseif (!is_string($arParams['DATA'][$arOneAtom['id']]))
			{
				$boolError = true;
			}
			elseif (!isset($arOneAtom['values'][$arParams['DATA'][$arOneAtom['id']]]))
			{
				$boolError = true;
			}
			if (!$boolError)
			{
				$arValues[$arOneAtom['id']] = $arParams['DATA'][$arOneAtom['id']];
			}
			else
			{
				$arValues[$arOneAtom['id']] = '';
			}
		}
		if (isset($arOneAtoms))
			unset($arOneAtom);

		$arResult = array(
			'id' => $arParams['COND_NUM'],
			'controlId' => static::GetControlID(),
			'values' => $arValues
		);
		if ($boolError)
			$arResult['err_cond'] = 'Y';

		return $arResult;
	}

	public static function GetControlID()
	{
		return 'CondGroup';
	}

	public static function GetAtoms()
	{
		return array(
			'All' => array(
				'id' => 'All',
				'name' => 'aggregator',
				'type' => 'select',
				'values' => array(
					'AND' => Loc::getMessage('BT_CLOBAL_COND_GROUP_SELECT_ALL'),
					'OR' => Loc::getMessage('BT_CLOBAL_COND_GROUP_SELECT_ANY')
				),
				'defaultText' => Loc::getMessage('BT_CLOBAL_COND_GROUP_SELECT_DEF'),
				'defaultValue' => 'AND',
				'first_option' => '...'
			),
			'True' => array(
				'id' => 'True',
				'name' => 'value',
				'type' => 'select',
				'values' => array(
					'True' => Loc::getMessage('BT_CLOBAL_COND_GROUP_SELECT_TRUE'),
					'False' => Loc::getMessage('BT_CLOBAL_COND_GROUP_SELECT_FALSE')
				),
				'defaultText' => Loc::getMessage('BT_CLOBAL_COND_GROUP_SELECT_DEF'),
				'defaultValue' => 'True',
				'first_option' => '...'
			)
		);
	}

	public static function GetVisual()
	{
		return array(
			'controls' => array(
				'All',
				'True'
			),
			'values' => array(
				array(
					'All' => 'AND',
					'True' => 'True'
				),
				array(
					'All' => 'AND',
					'True' => 'False'
				),
				array(
					'All' => 'OR',
					'True' => 'True'
				),
				array(
					'All' => 'OR',
					'True' => 'False'
				)
			),
			'logic' => array(
				array(
					'style' => 'condition-logic-and',
					'message' => Loc::getMessage('BT_CLOBAL_COND_GROUP_LOGIC_AND')
				),
				array(
					'style' => 'condition-logic-and',
					'message' => Loc::getMessage('BT_CLOBAL_COND_GROUP_LOGIC_NOT_AND')
				),
				array(
					'style' => 'condition-logic-or',
					'message' => Loc::getMessage('BT_CLOBAL_COND_GROUP_LOGIC_OR')
				),
				array(
					'style' => 'condition-logic-or',
					'message' => Loc::getMessage('BT_CLOBAL_COND_GROUP_LOGIC_NOT_OR')
				)
			)
		);
	}

	public static function IsGroup($strControlID = false)
	{
		return 'Y';
	}

	public static function Parse($arOneCondition)
	{
		$boolError = false;
		$arResult = array();
		$arAtoms = static::GetAtoms();
		foreach ($arAtoms as &$arOneAtom)
		{
			if (!isset($arOneCondition[$arOneAtom['name']]))
			{
				$boolError = true;
			}
			elseif (!is_string($arOneCondition[$arOneAtom['name']]))
			{
				$boolError = true;
			}
			elseif (!isset($arOneAtom['values'][$arOneCondition[$arOneAtom['name']]]))
			{
				$boolError = true;
			}
			if (!$boolError)
			{
				$arResult[$arOneAtom['id']] = $arOneCondition[$arOneAtom['name']];
			}
		}
		if (isset($arOneAtom))
			unset($arOneAtom);

		return (!$boolError ? $arResult : false);
	}

	public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
	{
		$mxResult = '';
		$boolError = false;

		$arAtoms = static::GetAtoms();

		foreach ($arAtoms as &$arOneAtom)
		{
			if (!isset($arOneCondition[$arOneAtom['id']]))
			{
				$boolError = true;
			}
			elseif (!is_string($arOneCondition[$arOneAtom['id']]))
			{
				$boolError = true;
			}
			elseif (!isset($arOneAtom['values'][$arOneCondition[$arOneAtom['id']]]))
			{
				$boolError = true;
			}
		}
		if (isset($arOneAtom))
			unset($arOneAtom);

		if (!isset($arSubs) || !is_array($arSubs))
		{
			$boolError = true;
		}
		elseif (empty($arSubs))
		{
			return '(1 == 1)';
		}

		if (!$boolError)
		{
			$strPrefix = '';
			$strLogic = '';
			$strItemPrefix = '';

			if ('AND' == $arOneCondition['All'])
			{
				$strPrefix = '';
				$strLogic = ' && ';
				$strItemPrefix = ('True' == $arOneCondition['True'] ? '' : '!');
			}
			else
			{
				$strItemPrefix = '';
				if ('True' == $arOneCondition['True'])
				{
					$strPrefix = '';
					$strLogic = ' || ';
				}
				else
				{
					$strPrefix = '!';
					$strLogic = ' && ';
				}
			}

			$strEval = $strItemPrefix.implode($strLogic.$strItemPrefix, $arSubs);
			if ('' != $strPrefix)
				$strEval = $strPrefix.'('.$strEval.')';
			$mxResult = $strEval;
		}

		return $mxResult;
	}

	public static function ApplyValues($arOneCondition, $arControl)
	{
		return (isset($arOneCondition['True']) && 'True' == $arOneCondition['True']);
	}
}

class CCatalogCondCtrl extends CGlobalCondCtrl
{
	public static function GetClassName()
	{
		return __CLASS__;
	}

}

class CCatalogCondCtrlComplex extends CGlobalCondCtrlComplex
{
	public static function GetClassName()
	{
		return __CLASS__;
	}
}

class CCatalogCondCtrlGroup extends CGlobalCondCtrlGroup
{
	public static function GetClassName()
	{
		return __CLASS__;
	}
}

class CCatalogCondCtrlIBlockFields extends CCatalogCondCtrlComplex
{
	public static function GetClassName()
	{
		return __CLASS__;
	}

	public static function GetControlID()
	{
		return array(
			'CondIBElement',
			'CondIBIBlock',
			'CondIBSection',
			'CondIBCode',
			'CondIBXmlID',
			'CondIBName',
			'CondIBActive',
			'CondIBDateActiveFrom',
			'CondIBDateActiveTo',
			'CondIBSort',
			'CondIBPreviewText',
			'CondIBDetailText',
			'CondIBDateCreate',
			'CondIBCreatedBy',
			'CondIBTimestampX',
			'CondIBModifiedBy',
			'CondIBTags',
			'CondCatQuantity',
			'CondCatWeight',
			'CondCatVatID',
			'CondCatVatIncluded',
		);
	}

	public static function GetControlShow($arParams)
	{
		$arControls = static::GetControls();
		$arResult = array(
			'controlgroup' => true,
			'group' =>  false,
			'label' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_CONTROLGROUP_LABEL'),
			'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
			'children' => array()
		);
		foreach ($arControls as &$arOneControl)
		{
			$arLogic = static::GetLogicAtom($arOneControl['LOGIC']);
			$arValue = static::GetValueAtom($arOneControl['JS_VALUE']);
			$arResult['children'][] = array(
				'controlId' => $arOneControl['ID'],
				'group' => false,
				'label' => $arOneControl['LABEL'],
				'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
				'control' => array(
					array(
						'id' => 'prefix',
						'type' => 'prefix',
						'text' => $arOneControl['PREFIX']
					),
					$arLogic,
					$arValue
				)
			);
		}
		if (isset($arOneControl))
			unset($arOneControl);

		return $arResult;
	}

	public static function GetControls($strControlID = false)
	{
		$arVatList = array();
		$arFilter = array();
		$rsVats = CCatalogVat::GetListEx(array(), $arFilter, false, false, array('ID', 'NAME'));
		while ($arVat = $rsVats->Fetch())
		{
			$arVatList[$arVat['ID']] = $arVat['NAME'];
		}
		unset($arVat, $rsVats);

		$arControlList = array(
			'CondIBElement' => array(
				'ID' => 'CondIBElement',
				'PARENT' => true,
				'FIELD' => 'ID',
				'FIELD_TYPE' => 'int',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_ELEMENT_ID_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_ELEMENT_ID_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
				'JS_VALUE' => array(
					'type' => 'popup',
					'popup_url' =>  '/bitrix/admin/iblock_element_search.php',
					'popup_params' => array(
						'lang' => LANGUAGE_ID,
						'discount' => 'Y'
					),
					'param_id' => 'n',
					'show_value' => 'Y'
				),
				'PHP_VALUE' => array(
					'VALIDATE' => 'element'
				)
			),
			'CondIBIBlock' => array(
				'ID' => 'CondIBIBlock',
				'PARENT' => true,
				'FIELD' => 'IBLOCK_ID',
				'FIELD_TYPE' => 'int',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_IBLOCK_ID_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_IBLOCK_ID_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
				'JS_VALUE' => array(
					'type' => 'popup',
					'popup_url' =>  '/bitrix/admin/cat_iblock_search.php',
					'popup_params' => array(
						'lang' => LANGUAGE_ID,
						'discount' => 'Y'
					),
					'param_id' => 'n',
					'show_value' => 'Y'
				),
				'PHP_VALUE' => array(
					'VALIDATE' => 'iblock'
				)
			),
			'CondIBSection' => array(
				'ID' => 'CondIBSection',
				'PARENT' => false,
				'FIELD' => 'SECTION_ID',
				'FIELD_TYPE' => 'int',
				'MULTIPLE' => 'Y',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_SECTION_ID_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_SECTION_ID_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
				'JS_VALUE' => array(
					'type' => 'popup',
					'popup_url' =>  '/bitrix/admin/cat_section_search.php',
					'popup_params' => array(
						'lang' => LANGUAGE_ID,
						'discount' => 'Y'
					),
					'param_id' => 'n',
					'show_value' => 'Y'
				),
				'PHP_VALUE' => array(
					'VALIDATE' => 'section'
				)
			),
			'CondIBCode' => array(
				'ID' => 'CondIBCode',
				'PARENT' => true,
				'FIELD' => 'CODE',
				'FIELD_TYPE' => 'string',
				'FIELD_LENGTH' => 255,
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_CODE_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_CODE_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_CONT, BT_COND_LOGIC_NOT_CONT)),
				'JS_VALUE' => array(
					'type' => 'input'
				),
				'PHP_VALUE' => ''
			),
			'CondIBXmlID' => array(
				'ID' => 'CondIBXmlID',
				'PARENT' => true,
				'FIELD' => 'XML_ID',
				'FIELD_TYPE' => 'string',
				'FIELD_LENGTH' => 255,
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_XML_ID_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_XML_ID_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_CONT, BT_COND_LOGIC_NOT_CONT)),
				'JS_VALUE' => array(
					'type' => 'input'
				),
				'PHP_VALUE' => ''
			),
			'CondIBName' => array(
				'ID' => 'CondIBName',
				'PARENT' => true,
				'FIELD' => 'NAME',
				'FIELD_TYPE' => 'string',
				'FIELD_LENGTH' => 255,
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_NAME_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_NAME_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_CONT, BT_COND_LOGIC_NOT_CONT)),
				'JS_VALUE' => array(
					'type' => 'input'
				),
				'PHP_VALUE' => ''
			),
			'CondIBActive' => array(
				'ID' => 'CondIBActive',
				'PARENT' => true,
				'FIELD' => 'ACTIVE',
				'FIELD_TYPE' => 'char',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_ACTIVE_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_ACTIVE_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
				'JS_VALUE' => array(
					'type' => 'select',
					'values' => array(
						'Y' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_ACTIVE_VALUE_YES'),
						'N' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_ACTIVE_VALUE_NO')
					)
				),
				'PHP_VALUE' => array(
					'VALIDATE' => 'list'
				)
			),
			'CondIBDateActiveFrom' => array(
				'ID' => 'CondIBDateActiveFrom',
				'PARENT' => true,
				'FIELD' => 'DATE_ACTIVE_FROM',
				'FIELD_TYPE' => 'datetime',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_DATE_ACTIVE_FROM_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_DATE_ACTIVE_FROM_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_GR, BT_COND_LOGIC_LS, BT_COND_LOGIC_EGR, BT_COND_LOGIC_ELS)),
				'JS_VALUE' => array(
					'type' => 'datetime',
					'format' => 'datetime'
				),
				'PHP_VALUE' => ''
			),
			'CondIBDateActiveTo' => array(
				'ID' => 'CondIBDateActiveTo',
				'PARENT' => true,
				'FIELD' => 'DATE_ACTIVE_TO',
				'FIELD_TYPE' => 'datetime',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_DATE_ACTIVE_TO_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_DATE_ACTIVE_TO_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_GR, BT_COND_LOGIC_LS, BT_COND_LOGIC_EGR, BT_COND_LOGIC_ELS)),
				'JS_VALUE' => array(
					'type' => 'datetime',
					'format' => 'datetime'
				),
				'PHP_VALUE' => ''
			),
			'CondIBSort' => array(
				'ID' => 'CondIBSort',
				'PARENT' => true,
				'FIELD' => 'SORT',
				'FIELD_TYPE' => 'int',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_SORT_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_SORT_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_GR, BT_COND_LOGIC_LS, BT_COND_LOGIC_EGR, BT_COND_LOGIC_ELS)),
				'JS_VALUE' => array(
					'type' => 'input'
				),
				'PHP_VALUE' => ''
			),
			'CondIBPreviewText' => array(
				'ID' => 'CondIBPreviewText',
				'PARENT' => true,
				'FIELD' => 'PREVIEW_TEXT',
				'FIELD_TYPE' => 'text',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_PREVIEW_TEXT_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_PREVIEW_TEXT_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_CONT, BT_COND_LOGIC_NOT_CONT)),
				'JS_VALUE' => array(
					'type' => 'input'
				),
				'PHP_VALUE' => ''
			),
			'CondIBDetailText' => array(
				'ID' => 'CondIBDetailText',
				'PARENT' => true,
				'FIELD' => 'DETAIL_TEXT',
				'FIELD_TYPE' => 'text',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_DETAIL_TEXT_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_DETAIL_TEXT_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_CONT, BT_COND_LOGIC_NOT_CONT)),
				'JS_VALUE' => array(
					'type' => 'input'
				),
				'PHP_VALUE' => ''
			),
			'CondIBDateCreate' => array(
				'ID' => 'CondIBDateCreate',
				'PARENT' => true,
				'FIELD' => 'DATE_CREATE',
				'FIELD_TYPE' => 'datetime',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_DATE_CREATE_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_DATE_CREATE_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_GR, BT_COND_LOGIC_LS, BT_COND_LOGIC_EGR, BT_COND_LOGIC_ELS)),
				'JS_VALUE' => array(
					'type' => 'datetime',
					'format' => 'datetime'
				),
				'PHP_VALUE' => ''
			),
			'CondIBCreatedBy' => array(
				'ID' => 'CondIBCreatedBy',
				'PARENT' => true,
				'FIELD' => 'CREATED_BY',
				'FIELD_TYPE' => 'int',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_CREATED_BY_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_CREATED_BY_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
				'JS_VALUE' => array(
					'type' => 'input'
				),
				'PHP_VALUE' => array(
					'VALIDATE' => 'user'
				)
			),
			'CondIBTimestampX' => array(
				'ID' => 'CondIBTimestampX',
				'PARENT' => true,
				'FIELD' => 'TIMESTAMP_X',
				'FIELD_TYPE' => 'datetime',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_TIMESTAMP_X_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_TIMESTAMP_X_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_GR, BT_COND_LOGIC_LS, BT_COND_LOGIC_EGR, BT_COND_LOGIC_ELS)),
				'JS_VALUE' => array(
					'type' => 'datetime',
					'format' => 'datetime'
				),
				'PHP_VALUE' => ''
			),
			'CondIBModifiedBy' => array(
				'ID' => 'CondIBModifiedBy',
				'PARENT' => true,
				'FIELD' => 'MODIFIED_BY',
				'FIELD_TYPE' => 'int',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_MODIFIED_BY_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_MODIFIED_BY_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
				'JS_VALUE' => array(
					'type' => 'input'
				),
				'PHP_VALUE' => array(
					'VALIDATE' => 'user'
				)
			),
			'CondIBTags' => array(
				'ID' => 'CondIBTags',
				'PARENT' => true,
				'FIELD' => 'TAGS',
				'FIELD_TYPE' => 'string',
				'FIELD_LENGTH' => 255,
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_TAGS_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_IBLOCK_TAGS_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_CONT, BT_COND_LOGIC_NOT_CONT)),
				'JS_VALUE' => array(
					'type' => 'input'
				),
				'PHP_VALUE' => ''
			),
			'CondCatQuantity' => array(
				'ID' => 'CondCatQuantity',
				'PARENT' => false,
				'FIELD' => 'CATALOG_QUANTITY',
				'FIELD_TYPE' => 'double',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_CATALOG_QUANTITY_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_CATALOG_QUANTITY_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_GR, BT_COND_LOGIC_LS, BT_COND_LOGIC_EGR, BT_COND_LOGIC_ELS)),
				'JS_VALUE' => array(
					'type' => 'input'
				)
			),
			'CondCatWeight' => array(
				'ID' => 'CondCatWeight',
				'PARENT' => false,
				'FIELD' => 'CATALOG_WEIGHT',
				'FIELD_TYPE' => 'double',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_CATALOG_WEIGHT_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_CATALOG_WEIGHT_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_GR, BT_COND_LOGIC_LS, BT_COND_LOGIC_EGR, BT_COND_LOGIC_ELS)),
				'JS_VALUE' => array(
					'type' => 'input'
				),
				'PHP_VALUE' => ''
			),
			'CondCatVatID' => array(
				'ID' => 'CondCatVatID',
				'PARENT' => false,
				'FIELD' => 'CATALOG_VAT_ID',
				'FIELD_TYPE' => 'int',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_CATALOG_VAT_ID_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_CATALOG_VAT_ID_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
				'JS_VALUE' => array(
					'type' => 'select',
					'values' => $arVatList
				),
				'PHP_VALUE' => array(
					'VALIDATE' => 'list'
				)
			),
			'CondCatVatIncluded' => array(
				'ID' => 'CondCatVatIncluded',
				'PARENT' => false,
				'FIELD' => 'CATALOG_VAT_INCLUDED',
				'FIELD_TYPE' => 'char',
				'MULTIPLE' => 'N',
				'GROUP' => 'N',
				'LABEL' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_CATALOG_VAT_INCLUDED_LABEL'),
				'PREFIX' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_CATALOG_VAT_INCLUDED_PREFIX'),
				'LOGIC' => static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ)),
				'JS_VALUE' => array(
					'type' => 'select',
					'values' => array(
						'Y' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_CATALOG_VAT_INCLUDED_VALUE_YES'),
						'N' => Loc::getMessage('BT_MOD_CATALOG_COND_CMP_CATALOG_VAT_INCLUDED_VALUE_NO')
					)
				),
				'PHP_VALUE' => array(
					'VALIDATE' => 'list'
				)
			)
		);

		if ($strControlID === false)
		{
			return $arControlList;
		}
		elseif (isset($arControlList[$strControlID]))
		{
			return $arControlList[$strControlID];
		}
		else
		{
			return false;
		}
	}

	public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
	{
		$strResult = '';

		if (is_string($arControl))
		{
			$arControl = static::GetControls($arControl);
		}
		$boolError = !is_array($arControl);

		if (!$boolError)
		{
			$arValues = static::Check($arOneCondition, $arOneCondition, $arControl, false);
			$boolError = ($arValues === false);
		}

		if (!$boolError)
		{
			$boolError = !isset($arControl['MULTIPLE']);
		}

		if (!$boolError)
		{
			$arLogic = static::SearchLogic($arValues['logic'], $arControl['LOGIC']);
			if (!isset($arLogic['OP'][$arControl['MULTIPLE']]) || empty($arLogic['OP'][$arControl['MULTIPLE']]))
			{
				$boolError = true;
			}
			else
			{
				if ($arControl['PARENT'] && !isset($arLogic['PARENT']))
					$arControl['PARENT'] = false;
				$strParent = $arParams['FIELD'].'[\'PARENT_'.$arControl['FIELD'].'\']';
				$strField = $arParams['FIELD'].'[\''.$arControl['FIELD'].'\']';
				switch ($arControl['FIELD_TYPE'])
				{
					case 'int':
					case 'double':
						$strParentResult = str_replace(array('#FIELD#', '#VALUE#'), array($strParent, $arValues['value']), $arLogic['OP'][$arControl['MULTIPLE']]);
						$strResult = str_replace(array('#FIELD#', '#VALUE#'), array($strField, $arValues['value']), $arLogic['OP'][$arControl['MULTIPLE']]);
						break;
					case 'char':
					case 'string':
					case 'text':
						$strParentResult = str_replace(array('#FIELD#', '#VALUE#'), array($strParent, '"'.EscapePHPString($arValues['value']).'"'), $arLogic['OP'][$arControl['MULTIPLE']]);
						$strResult = str_replace(array('#FIELD#', '#VALUE#'), array($strField, '"'.EscapePHPString($arValues['value']).'"'), $arLogic['OP'][$arControl['MULTIPLE']]);
						break;
					case 'date':
					case 'datetime':
						$strParentResult = str_replace(array('#FIELD#', '#VALUE#'), array($strParent, $arValues['value']), $arLogic['OP'][$arControl['MULTIPLE']]);
						$strResult = str_replace(array('#FIELD#', '#VALUE#'), array($strField, $arValues['value']), $arLogic['OP'][$arControl['MULTIPLE']]);
						if (!(BT_COND_LOGIC_EQ == $arLogic['ID'] || BT_COND_LOGIC_NOT_EQ == $arLogic['ID']))
						{
							$strParentResult = 'null !== '.$strParent.' && \'\' !== '.$strParent.' && '.$strResult;
							$strResult = 'null !== '.$strField.' && \'\' !== '.$strField.' && '.$strResult;
						}
						break;
				}
				$strResult = 'isset('.$strField.') && ('.$strResult.')';
				if ($arControl['PARENT'])
				{
					$strResult = '(isset('.$strParent.') ? (('.$strResult.')'.$arLogic['PARENT'].$strParentResult.') : ('.$strResult.'))';
				}
			}
		}

		return (!$boolError ? $strResult : false);
	}

	public static function ApplyValues($arOneCondition, $arControl)
	{
		$arResult = array();

		$arLogicID = array(
			BT_COND_LOGIC_EQ,
			BT_COND_LOGIC_EGR,
			BT_COND_LOGIC_ELS,
		);

		if (is_string($arControl))
		{
			$arControl = static::GetControls($arControl);
		}
		$boolError = !is_array($arControl);

		if (!$boolError)
		{
			$arValues = static::Check($arOneCondition, $arOneCondition, $arControl, false);
			if (false === $arValues)
			{
				$boolError = true;
			}
		}

		if (!$boolError)
		{
			$arLogic = static::SearchLogic($arValues['logic'], $arControl['LOGIC']);
			if (in_array($arLogic['ID'], $arLogicID))
			{
				$arResult = array(
					'ID' => $arControl['ID'],
					'FIELD' => $arControl['FIELD'],
					'FIELD_TYPE' => $arControl['FIELD_TYPE'],
					'VALUES' => (is_array($arValues['value']) ? $arValues['value'] : array($arValues['value']))
				);
			}
		}

		return (!$boolError ? $arResult : false);
	}
}

class CCatalogCondCtrlIBlockProps extends CCatalogCondCtrlComplex
{
	public static function GetClassName()
	{
		return __CLASS__;
	}

	public static function GetControls($strControlID = false)
	{
		$arControlList = array();
		$arIBlockList = array();
		$rsIBlocks = CCatalog::GetList(array(), array(), false, false, array('IBLOCK_ID', 'PRODUCT_IBLOCK_ID'));
		while ($arIBlock = $rsIBlocks->Fetch())
		{
			$arIBlock['IBLOCK_ID'] = (int)$arIBlock['IBLOCK_ID'];
			$arIBlock['PRODUCT_IBLOCK_ID'] = (int)$arIBlock['PRODUCT_IBLOCK_ID'];
			if ($arIBlock['IBLOCK_ID'] > 0)
				$arIBlockList[$arIBlock['IBLOCK_ID']] = true;
			if ($arIBlock['PRODUCT_IBLOCK_ID'] > 0)
				$arIBlockList[$arIBlock['PRODUCT_IBLOCK_ID']] = true;
		}
		unset($arIBlock, $rsIBlocks);
		if (!empty($arIBlockList))
		{
			$arIBlockList = array_keys($arIBlockList);
			sort($arIBlockList);
			foreach ($arIBlockList as &$intIBlockID)
			{
				$strName = CIBlock::GetArrayByID($intIBlockID, 'NAME');
				if (false !== $strName)
				{
					$boolSep = true;
					$rsProps = CIBlockProperty::GetList(array('SORT' => 'ASC', 'NAME' => 'ASC'), array('IBLOCK_ID' => $intIBlockID));
					while ($arProp = $rsProps->Fetch())
					{
						if ('CML2_LINK' == $arProp['XML_ID'])
							continue;
						if ('F' == $arProp['PROPERTY_TYPE'])
							continue;
						if ('L' == $arProp['PROPERTY_TYPE'])
						{
							$arProp['VALUES'] = array();
							$rsPropEnums = CIBlockPropertyEnum::GetList(array('DEF' => 'DESC', 'SORT' => 'ASC'), array('PROPERTY_ID' => $arProp['ID']));
							while ($arPropEnum = $rsPropEnums->Fetch())
							{
								$arProp['VALUES'][] = $arPropEnum;
							}
							if (empty($arProp['VALUES']))
								continue;
						}

						$strFieldType = '';
						$arLogic = array();
						$arValue = array();
						$arPhpValue = '';

						$boolUserType = false;
						if (isset($arProp['USER_TYPE']) && !empty($arProp['USER_TYPE']))
						{
							switch ($arProp['USER_TYPE'])
							{
								case 'DateTime':
									$strFieldType = 'datetime';
									$arLogic = static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_GR, BT_COND_LOGIC_LS, BT_COND_LOGIC_EGR, BT_COND_LOGIC_ELS));
									$arValue = array(
										'type' => 'datetime',
										'format' => 'datetime'
									);
									$boolUserType = true;
									break;
								default:
									$boolUserType = false;
									break;
							}
						}

						if (!$boolUserType)
						{
							switch ($arProp['PROPERTY_TYPE'])
							{
								case 'N':
									$strFieldType = 'double';
									$arLogic = static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_GR, BT_COND_LOGIC_LS, BT_COND_LOGIC_EGR, BT_COND_LOGIC_ELS));
									$arValue = array('type' => 'input');
									break;
								case 'S':
									$strFieldType = 'text';
									$arLogic = static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ, BT_COND_LOGIC_CONT, BT_COND_LOGIC_NOT_CONT));
									$arValue = array('type' => 'input');
									break;
								case 'L':
									$strFieldType = 'int';
									$arLogic = static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ));
									$arValue = array(
										'type' => 'select',
										'values' => array()
									);
									foreach ($arProp['VALUES'] as &$arOnePropValue)
									{
										$arValue['values'][$arOnePropValue['ID']] = $arOnePropValue['VALUE'];
									}
									if (isset($arOnePropValue))
										unset($arOnePropValue);
									break;
									$arPhpValue = array('VALIDATE' => 'list');
								case 'E':
									$strFieldType = 'int';
									$arLogic = static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ));
									$arValue = array(
										'type' => 'popup',
										'popup_url' =>  '/bitrix/admin/iblock_element_search.php',
										'popup_params' => array(
											'lang' => LANGUAGE_ID,
											'IBLOCK_ID' => $arProp['LINK_IBLOCK_ID'],
											'discount' => 'Y'
										),
										'param_id' => 'n'
									);
									$arPhpValue = array('VALIDATE' => 'element');
									break;
								case 'G':
									$strFieldType = 'int';
									$arLogic = static::GetLogic(array(BT_COND_LOGIC_EQ, BT_COND_LOGIC_NOT_EQ));
									$arValue = array(
										'type' => 'popup',
										'popup_url' =>  '/bitrix/admin/cat_section_search.php',
										'popup_params' => array(
											'lang' => LANGUAGE_ID,
											'IBLOCK_ID' => $arProp['LINK_IBLOCK_ID'],
											'discount' => 'Y'
										),
										'param_id' => 'n'
									);
									$arPhpValue = array('VALIDATE' => 'section');
									break;
							}
						}
						$arControlList["CondIBProp:".$intIBlockID.':'.$arProp['ID']] = array(
							"ID" => "CondIBProp:".$intIBlockID.':'.$arProp['ID'],
							"IBLOCK_ID" => $intIBlockID,
							"FIELD" => "PROPERTY_".$arProp['ID']."_VALUE",
							"FIELD_TYPE" => $strFieldType,
							'MULTIPLE' => 'Y',
							'GROUP' => 'N',
							'SEP' => ($boolSep ? 'Y' : 'N'),
							'SEP_LABEL' => ($boolSep ? str_replace(array('#ID#', '#NAME#'), array($intIBlockID, $strName), Loc::getMessage('BT_MOD_CATALOG_COND_CMP_CATALOG_PROP_LABEL')) : ''),
							'LABEL' => $arProp['NAME'],
							'PREFIX' => str_replace(array('#NAME#', '#IBLOCK_ID#', '#IBLOCK_NAME#'), array($arProp['NAME'], $intIBlockID, $strName), Loc::getMessage('BT_MOD_CATALOG_COND_CMP_CATALOG_ONE_PROP_PREFIX')),
							'LOGIC' => $arLogic,
							'JS_VALUE' => $arValue,
							'PHP_VALUE' => $arPhpValue
						);

						$boolSep = false;
					}
				}
			}
			if (isset($intIBlockID))
				unset($intIBlockID);
			unset($arIBlockList);
		}

		if ($strControlID === false)
		{
			return $arControlList;
		}
		elseif (isset($arControlList[$strControlID]))
		{
			return $arControlList[$strControlID];
		}
		else
		{
			return false;
		}
	}

	public static function GetControlShow($arParams)
	{
		$arControls = static::GetControls();
		$arResult = array();
		$intCount = -1;
		foreach ($arControls as &$arOneControl)
		{
			if (isset($arOneControl['SEP']) && 'Y' == $arOneControl['SEP'])
			{
				$intCount++;
				$arResult[$intCount] = array(
					'controlgroup' => true,
					'group' =>  false,
					'label' => $arOneControl['SEP_LABEL'],
					'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
					'children' => array()
				);
			}
			$arLogic = static::GetLogicAtom($arOneControl['LOGIC']);
			$arValue = static::GetValueAtom($arOneControl['JS_VALUE']);

			$arResult[$intCount]['children'][] = array(
				'controlId' => $arOneControl['ID'],
				'group' => false,
				'label' => $arOneControl['LABEL'],
				'showIn' => static::GetShowIn($arParams['SHOW_IN_GROUPS']),
				'control' => array(
					array(
						'id' => 'prefix',
						'type' => 'prefix',
						'text' => $arOneControl['PREFIX']
					),
					$arLogic,
					$arValue
				)
			);
		}
		if (isset($arOneControl))
			unset($arOneControl);

		return $arResult;
	}

	public static function Generate($arOneCondition, $arParams, $arControl, $arSubs = false)
	{
		$strResult = '';

		if (is_string($arControl))
		{
			$arControl = static::GetControls($arControl);
		}
		$boolError = !is_array($arControl);

		if (!$boolError)
		{
			$strResult = parent::Generate($arOneCondition, $arParams, $arControl, $arSubs);
			if (false === $strResult || '' == $strResult)
			{
				$boolError = true;
			}
			else
			{
				$strField = 'isset('.$arParams['FIELD'].'[\''.$arControl['FIELD'].'\'])';
				$strResult = $strField.' && '.$strResult;
			}
		}

		return (!$boolError ? $strResult : false);
	}

	public static function ApplyValues($arOneCondition, $arControl)
	{
		$arResult = array();
		$arValues = false;

		$arLogicID = array(
			BT_COND_LOGIC_EQ,
			BT_COND_LOGIC_EGR,
			BT_COND_LOGIC_ELS,
		);

		if (is_string($arControl))
		{
			$arControl = static::GetControls($arControl);
		}
		$boolError = !is_array($arControl);

		if (!$boolError)
		{
			$arValues = static::Check($arOneCondition, $arOneCondition, $arControl, false);
			if ($arValues === false)
			{
				$boolError = true;
			}
		}

		if (!$boolError)
		{
			$arLogic = static::SearchLogic($arValues['logic'], $arControl['LOGIC']);
			if (in_array($arLogic['ID'], $arLogicID))
			{
				$arResult = array(
					'ID' => $arControl['ID'],
					'FIELD' => $arControl['FIELD'],
					'FIELD_TYPE' => $arControl['FIELD_TYPE'],
					'VALUES' => (is_array($arValues['value']) ? $arValues['value'] : array($arValues['value']))
				);
			}
		}
		return (!$boolError ? $arResult : false);
	}
}

class CGlobalCondTree
{
	protected $intMode = BT_COND_MODE_DEFAULT;			// work mode
	protected $arEvents = array();						// events ID
	protected $arInitParams = array();					// start params
	protected $boolError = false;						// error flag
	protected $arMsg = array();							// messages (errors)

	protected $strFormName = '';						// form name
	protected $strFormID = '';							// form id
	protected $strContID = '';							// container id
	protected $strJSName = '';							// js object var name
	protected $boolCreateForm = false;					// need create form
	protected $boolCreateCont = false;					// need create container
	protected $strPrefix = 'rule';						// prefix for input
	protected $strSepID = '__';							// separator for id

	protected $arSystemMess = array();					// system messages

	protected $arAtomList = null;						// atom list cache
	protected $arAtomJSPath = null;						// atom js files
	protected $arControlList = null;					// control list cache
	protected $arShowControlList = null;				// control show method list
	protected $arShowInGroups = null;					// showin group list
	protected $arInitControlList = null;				// control init list

	protected $arDefaultControl = array(
		'Parse',
		'GetConditionShow',
		'Generate',
		'ApplyValues'
	);													// required control fields

	protected $usedModules = array();					// modules for real conditions
	protected $usedExtFiles = array();					// files from AddEventHandler

	protected $arConditions = null;						// conditions array

	public function __construct()
	{
		CJSCore::Init(array("core_condtree"));
	}

	public function __destruct()
	{

	}

	public function OnConditionAtomBuildList()
	{
		if (!$this->boolError)
		{
			if (!isset($this->arAtomList))
			{
				$this->arAtomList = array();
				$this->arAtomJSPath = array();
				foreach (GetModuleEvents($this->arEvents['ATOMS']['MODULE_ID'], $this->arEvents['ATOMS']['EVENT_ID'], true) as $arEvent)
				{
					$arRes = ExecuteModuleEventEx($arEvent);
					if (!isset($arRes['ID']))
						continue;;
					$this->arAtomList[$arRes["ID"]] = $arRes;
					if (isset($arRes['JS_SRC']))
					{
						if (!in_array($arRes['JS_SRC'], $this->arAtomJSPath))
							$this->arAtomJSPath[] = $arRes['JS_SRC'];
					}
				}
			}
		}
	}

	public function OnConditionControlBuildList()
	{
		if (!$this->boolError)
		{
			if (!isset($this->arControlList))
			{
				$this->arControlList = array();
				$this->arShowInGroups = array();
				$this->arShowControlList = array();
				$this->arInitControlList = array();
				foreach (GetModuleEvents($this->arEvents['CONTROLS']['MODULE_ID'], $this->arEvents['CONTROLS']['EVENT_ID'], true) as $arEvent)
				{
					$arRes = ExecuteModuleEventEx($arEvent);
					if (!is_array($arRes))
						continue;
					if (isset($arRes['ID']))
					{
						if (isset($arRes['EXIST_HANDLER']) && $arRes['EXIST_HANDLER'] === 'Y')
						{
							if (!isset($arRes['MODULE_ID']) && !isset($arRes['EXT_FILE']))
								continue;
						}
						else
						{
							$arRes['MODULE_ID'] = '';
							$arRes['EXT_FILE'] = '';
						}
						if (array_key_exists('EXIST_HANDLER', $arRes))
							unset($arRes['EXIST_HANDLER']);
						$arRes['GROUP'] = (isset($arRes['GROUP']) && 'Y' == $arRes['GROUP'] ? 'Y' : 'N');
						if (isset($this->arControlList[$arRes['ID']]))
						{
							$this->arMsg[] = array('id' => 'CONTROLS', 'text' => str_replace('#CONTROL#', $arRes['ID'], Loc::getMessage('BT_MOD_COND_ERR_CONTROL_DOUBLE')));
							$this->boolError = true;
						}
						else
						{
							if (!$this->CheckControl($arRes))
								continue;
							$this->arControlList[$arRes["ID"]] = $arRes;
							if ('Y' == $arRes['GROUP'])
								$this->arShowInGroups[] = $arRes["ID"];
							if (isset($arRes['GetControlShow']) && !empty($arRes['GetControlShow']))
							{
								if (!in_array($arRes['GetControlShow'], $this->arShowControlList))
									$this->arShowControlList[] = $arRes['GetControlShow'];
							}
							if (isset($arRes['InitParams']) && !empty($arRes['InitParams']))
							{
								if (!in_array($arRes['InitParams'], $this->arInitControlList))
									$this->arInitControlList[] = $arRes['InitParams'];
							}
						}
					}
					elseif (isset($arRes['COMPLEX']) && 'Y' == $arRes['COMPLEX'])
					{
						$complexModuleID = '';
						$complexExtFiles = '';
						if (isset($arRes['EXIST_HANDLER']) && $arRes['EXIST_HANDLER'] === 'Y')
						{
							if (isset($arRes['MODULE_ID']))
								$complexModuleID = $arRes['MODULE_ID'];
							if (isset($arRes['EXT_FILE']))
								$complexExtFiles = $arRes['EXT_FILE'];
						}
						if (isset($arRes['CONTROLS']) && !empty($arRes['CONTROLS']) && is_array($arRes['CONTROLS']))
						{
							if (array_key_exists('EXIST_HANDLER', $arRes))
								unset($arRes['EXIST_HANDLER']);
							$arInfo = $arRes;
							unset($arInfo['COMPLEX']);
							unset($arInfo['CONTROLS']);
							foreach ($arRes['CONTROLS'] as &$arOneControl)
							{
								if (isset($arOneControl['ID']))
								{
									if (isset($arOneControl['EXIST_HANDLER']) && $arOneControl['EXIST_HANDLER'] === 'Y')
									{
										if (!isset($arOneControl['MODULE_ID']) && !isset($arOneControl['EXT_FILE']))
											continue;
									}
									$arInfo['ID'] = $arOneControl['ID'];
									$arInfo['GROUP'] = 'N';
									$arInfo['MODULE_ID'] = isset($arOneControl['MODULE_ID']) ? $arOneControl['MODULE_ID'] : $complexModuleID;
									$arInfo['EXT_FILE'] = isset($arOneControl['EXT_FILE']) ? $arOneControl['EXT_FILE'] : $complexExtFiles;
									if (isset($this->arControlList[$arInfo['ID']]))
									{
										$this->arMsg[] = array('id' => 'CONTROLS', 'text' => str_replace('#CONTROL#', $arInfo['ID'], Loc::getMessage('BT_MOD_COND_ERR_CONTROL_DOUBLE')));
										$this->boolError = true;
									}
									else
									{
										if (!$this->CheckControl($arInfo))
											continue;
										$this->arControlList[$arInfo['ID']] = $arInfo;
									}
								}
							}
							if (isset($arOneControl))
								unset($arOneControl);
							if (isset($arRes['GetControlShow']) && !empty($arRes['GetControlShow']))
							{
								if (!in_array($arRes['GetControlShow'], $this->arShowControlList))
									$this->arShowControlList[] = $arRes['GetControlShow'];
							}
							if (isset($arRes['InitParams']) && !empty($arRes['InitParams']))
							{
								if (!in_array($arRes['InitParams'], $this->arInitControlList))
									$this->arInitControlList[] = $arRes['InitParams'];
							}
						}
					}
					else
					{
						foreach ($arRes as &$arOneRes)
						{
							if (is_array($arOneRes) && isset($arOneRes['ID']))
							{
								if (isset($arOneRes['EXIST_HANDLER']) && $arOneRes['EXIST_HANDLER'] === 'Y')
								{
									if (!isset($arOneRes['MODULE_ID']) && !isset($arOneRes['EXT_FILE']))
										continue;
								}
								else
								{
									$arOneRes['MODULE_ID'] = '';
									$arOneRes['EXT_FILE'] = '';
								}
								if (array_key_exists('EXIST_HANDLER', $arOneRes))
									unset($arOneRes['EXIST_HANDLER']);
								$arOneRes['GROUP'] = (isset($arOneRes['GROUP']) && 'Y' == $arOneRes['GROUP'] ? 'Y' : 'N');
								if (isset($this->arControlList[$arOneRes['ID']]))
								{
									$this->arMsg[] = array('id' => 'CONTROLS', 'text' => str_replace('#CONTROL#', $arOneRes['ID'], Loc::getMessage('BT_MOD_COND_ERR_CONTROL_DOUBLE')));
									$this->boolError = true;
								}
								else
								{
									if (!$this->CheckControl($arOneRes))
										continue;
									$this->arControlList[$arOneRes["ID"]] = $arOneRes;
									if ('Y' == $arOneRes['GROUP'])
										$this->arShowInGroups[] = $arOneRes["ID"];
									if (isset($arOneRes['GetControlShow']) && !empty($arOneRes['GetControlShow']))
									{
										if (!in_array($arOneRes['GetControlShow'], $this->arShowControlList))
											$this->arShowControlList[] = $arOneRes['GetControlShow'];
									}
									if (isset($arOneRes['InitParams']) && !empty($arOneRes['InitParams']))
									{
										if (!in_array($arOneRes['InitParams'], $this->arInitControlList))
											$this->arInitControlList[] = $arOneRes['InitParams'];
									}
								}
							}
						}
						if (isset($arOneRes))
							unset($arOneRes);
					}
				}
				if (empty($this->arControlList))
				{
					$this->arMsg[] = array('id' => 'CONTROLS', 'text' => Loc::getMessage('BT_MOD_COND_ERR_CONTROLS_EMPTY'));
					$this->boolError = true;
				}
			}
		}
	}

	protected function CheckControl($arControl)
	{
		$boolResult = true;
		foreach ($this->arDefaultControl as &$strKey)
		{
			if (!isset($arControl[$strKey]) || empty($arControl[$strKey]))
			{
				$boolResult = false;
				break;
			}
		}
		if (isset($strKey))
			unset($strKey);

		return $boolResult;
	}

	protected function GetModeList()
	{
		return array(
			BT_COND_MODE_DEFAULT,
			BT_COND_MODE_PARSE,
			BT_COND_MODE_GENERATE,
			BT_COND_MODE_SQL,
			BT_COND_MODE_SEARCH
		);
	}

	protected function GetEventList($intEventID)
	{
		$arEventList = array(
			BT_COND_BUILD_CATALOG => array(
				'ATOMS' => array(
					'MODULE_ID' => 'catalog',
					'EVENT_ID' => 'OnCondCatAtomBuildList'
				),
				'CONTROLS' => array(
					'MODULE_ID' => 'catalog',
					'EVENT_ID' => 'OnCondCatControlBuildList'
				)
			),
			BT_COND_BUILD_SALE => array(
				'ATOMS' => array(
					'MODULE_ID' => 'sale',
					'EVENT_ID' => 'OnCondSaleAtomBuildList'
				),
				'CONTROLS' => array(
					'MODULE_ID' => 'sale',
					'EVENT_ID' => 'OnCondSaleControlBuildList'
				)
			),
			BT_COND_BUILD_SALE_ACTIONS => array(
				'ATOMS' => array(
					'MODULE_ID' => 'sale',
					'EVENT_ID' => 'OnCondSaleActionsAtomBuildList'
				),
				'CONTROLS' => array(
					'MODULE_ID' => 'sale',
					'EVENT_ID' => 'OnCondSaleActionsControlBuildList'
				)
			)
		);

		return (isset($arEventList[$intEventID]) ? $arEventList[$intEventID] : false);
	}

	protected function CheckEvent($arEvent)
	{
		if (!is_array($arEvent))
			return false;
		if (!isset($arEvent['MODULE_ID']) || empty($arEvent['MODULE_ID']) || !is_string($arEvent['MODULE_ID']))
			return false;
		if (!isset($arEvent['EVENT_ID']) || empty($arEvent['EVENT_ID']) || !is_string($arEvent['EVENT_ID']))
			return false;
		return true;
	}

	public function Init($intMode, $mxEvent, $arParams = array())
	{
		global $APPLICATION;
		$this->arMsg = array();

		$intMode = (int)$intMode;
		if (!in_array($intMode, $this->GetModeList()))
			$intMode = BT_COND_MODE_DEFAULT;
		$this->intMode = $intMode;

		$arEvent = false;
		if (is_array($mxEvent))
		{
			if (isset($mxEvent['CONTROLS']) && $this->CheckEvent($mxEvent['CONTROLS']))
			{
				$arEvent['CONTROLS'] = $mxEvent['CONTROLS'];
			}
			else
			{
				$this->boolError = true;
				$this->arMsg[] = array('id' => 'EVENT','text' => Loc::getMessage('BT_MOD_COND_ERR_EVENT_BAD'));
			}
			if (isset($mxEvent['ATOMS']) && $this->CheckEvent($mxEvent['ATOMS']))
			{
				$arEvent['ATOMS'] = $mxEvent['ATOMS'];
			}
			else
			{
				$this->boolError = true;
				$this->arMsg[] = array('id' => 'EVENT','text' => Loc::getMessage('BT_MOD_COND_ERR_EVENT_BAD'));
			}
		}
		else
		{
			$mxEvent = (int)$mxEvent;
			if ($mxEvent >= 0)
			{
				$arEvent = $this->GetEventList($mxEvent);
			}
		}

		if ($arEvent === false)
		{
			$this->boolError = true;
			$this->arMsg[] = array('id' => 'EVENT','text' => Loc::getMessage('BT_MOD_COND_ERR_EVENT_BAD'));
		}
		else
		{
			$this->arEvents = $arEvent;
		}

		$this->arInitParams = $arParams;

		if (!is_array($arParams))
			$arParams = array();

		if (BT_COND_MODE_DEFAULT == $this->intMode)
		{
			if (!empty($arParams) && is_array($arParams))
			{
				if (isset($arParams['FORM_NAME']) && !empty($arParams['FORM_NAME']))
					$this->strFormName = $arParams['FORM_NAME'];
				if (isset($arParams['FORM_ID']) && !empty($arParams['FORM_ID']))
					$this->strFormID = $arParams['FORM_ID'];
				if (isset($arParams['CONT_ID']) && !empty($arParams['CONT_ID']))
					$this->strContID = $arParams['CONT_ID'];
				if (isset($arParams['JS_NAME']) && !empty($arParams['JS_NAME']))
					$this->strJSName = $arParams['JS_NAME'];

				$this->boolCreateForm = (isset($arParams['CREATE_FORM']) && 'Y' == $arParams['CREATE_FORM']);
				$this->boolCreateCont = (isset($arParams['CREATE_CONT']) && 'Y' == $arParams['CREATE_CONT']);
			}

			if (empty($this->strJSName))
			{
				if (empty($this->strContID))
				{
					$this->boolError = true;
					$this->arMsg[] = array('id' => 'JS_NAME','text' => Loc::getMessage('BT_MOD_COND_ERR_JS_NAME_BAD'));
				}
				else
				{
					$this->strJSName = md5($this->strContID);
				}
			}
		}
		if (BT_COND_MODE_DEFAULT == $this->intMode || BT_COND_MODE_PARSE == $this->intMode)
		{
			if (!empty($arParams) && is_array($arParams))
			{
				if (isset($arParams['PREFIX']) && !empty($arParams['PREFIX']))
					$this->strPrefix = $arParams['PREFIX'];
				if (isset($arParams['SEP_ID']) && !empty($arParams['SEP_ID']))
					$this->strSepID = $arParams['SEP_ID'];
			}
		}

		$this->OnConditionAtomBuildList();
		$this->OnConditionControlBuildList();

		if (!$this->boolError)
		{
			if (!empty($this->arInitControlList) && is_array($this->arInitControlList))
			{
				if (!empty($arParams) && is_array($arParams))
				{
					if (isset($arParams['INIT_CONTROLS']) && !empty($arParams['INIT_CONTROLS']) && is_array($arParams['INIT_CONTROLS']))
					{
						foreach ($this->arInitControlList as &$arOneControl)
						{
							call_user_func_array($arOneControl,
								array(
									$arParams['INIT_CONTROLS']
								)
							);
						}
						if (isset($arOneControl))
							unset($arOneControl);
					}
				}
			}
		}

		if (isset($arParams['SYSTEM_MESSAGES']) && !empty($arParams['SYSTEM_MESSAGES']) && is_array($arParams['SYSTEM_MESSAGES']))
		{
			$this->arSystemMess = $arParams['SYSTEM_MESSAGES'];
		}

		if ($this->boolError)
		{
			$obError = new CAdminException($this->arMsg);
			$APPLICATION->ThrowException($obError);
		}
		return !$this->boolError;
	}

	public function Show($arConditions)
	{
		$this->arMsg = array();

		if (!$this->boolError)
		{
			if (!empty($arConditions))
			{
				if (!is_array($arConditions))
				{
					if (!CheckSerializedData($arConditions))
					{
						$this->boolError = true;
						$this->arMsg[] = array('id' => 'CONDITIONS', 'text' => Loc::getMessage('BT_MOD_COND_ERR_SHOW_DATA_UNSERIALIZE'));
					}
					else
					{
						$arConditions = unserialize($arConditions);
						if (!is_array($arConditions))
						{
							$this->boolError = true;
							$this->arMsg[] = array('id' => 'CONDITIONS', 'text' => Loc::getMessage('BT_MOD_COND_ERR_SHOW_DATA_UNSERIALIZE'));
						}
					}
				}
			}
		}

		if (!$this->boolError)
		{
			$this->arConditions = (!empty($arConditions) ? $arConditions : $this->GetDefaultConditions());

			$strResult = '';

			$this->ShowScripts();

			if ($this->boolCreateForm)
			{

			}
			if ($this->boolCreateCont)
			{

			}

			$strResult .= '<script type="text/javascript">'."\n";
			$strResult .= 'var '.$this->strJSName.' = new BX.TreeConditions('."\n";
			$strResult .= $this->ShowParams().",\n";
			$strResult .= $this->ShowConditions().",\n";
			$strResult .= $this->ShowControls()."\n";

			$strResult .= ');'."\n";
			$strResult .= '</script>'."\n";

			if ($this->boolCreateCont)
			{

			}
			if ($this->boolCreateForm)
			{

			}

			echo $strResult;
		}
	}

	public function GetDefaultConditions()
	{
		return array(
			'CLASS_ID' => 'CondGroup',
			'DATA' => array('All' => 'AND', 'True' => 'True'),
			'CHILDREN' => array()
		);
	}

	public function Parse($arData = '', $arParams = false)
	{
		global $APPLICATION;
		$this->arMsg = array();

		$this->usedModules = array();
		$this->usedExtFiles = array();

		$arResult = array();
		if (!$this->boolError)
		{
			if (empty($arData) || !is_array($arData))
			{
				if (isset($_POST[$this->strPrefix]) && !empty($_POST[$this->strPrefix]) && is_array($_POST[$this->strPrefix]))
				{
					$arData = $_POST[$this->strPrefix];
				}
				else
				{
					$this->boolError = true;
					$this->arMsg[] = array('id' => 'CONDITIONS', 'text' => Loc::getMessage('BT_MOD_COND_ERR_PARSE_DATA_EMPTY'));
				}
			}
		}

		if (!$this->boolError)
		{
			foreach ($arData as $strKey => $value)
			{
				$arKeys = $this->__ConvertKey($strKey);
				if (empty($arKeys))
				{
					$this->boolError = true;
					$this->arMsg[] = array('id' => 'CONDITIONS', 'text' => Loc::getMessage('BT_MOD_COND_ERR_PARSE_DATA_BAD_KEY'));
					break;
				}

				if (!isset($value['controlId']) || empty($value['controlId']))
				{
					$this->boolError = true;
					$this->arMsg[] = array('id' => 'CONDITIONS', 'text' => Loc::getMessage('BT_MOD_COND_ERR_PARSE_DATA_EMPTY_CONTROLID'));
					break;
				}

				if (!isset($this->arControlList[$value['controlId']]))
				{
					$this->boolError = true;
					$this->arMsg[] = array('id' => 'CONDITIONS', 'text' => Loc::getMessage('BT_MOD_COND_ERR_PARSE_DATA_BAD_CONTROLID'));
					break;
				}

				$arOneCondition = call_user_func_array($this->arControlList[$value['controlId']]['Parse'],
					array(
						$value
					)
				);
				if (false === $arOneCondition)
				{
					$this->boolError = true;
					$this->arMsg[] = array('id' => 'CONDITIONS', 'text' => Loc::getMessage('BT_MOD_COND_ERR_PARSE_DATA_CONTROL_BAD_VALUE'));
					break;
				}

				$arItem = array(
					'CLASS_ID' => $value['controlId'],
					'DATA' => $arOneCondition
				);
				if ('Y' == $this->arControlList[$value['controlId']]['GROUP'])
				{
					$arItem['CHILDREN'] = array();
				}
				if (!$this->__SetCondition($arResult, $arKeys, 0, $arItem))
				{
					$this->boolError = true;
					$this->arMsg[] = array('id' => 'CONDITIONS', 'text' => Loc::getMessage('BT_MOD_COND_ERR_PARSE_DATA_DOUBLE_KEY'));
					break;
				}
			}
		}

		if ($this->boolError)
		{
			$obError = new CAdminException($this->arMsg);
			$APPLICATION->ThrowException($obError);
		}
		return (!$this->boolError ? $arResult : '');
	}

	public function ShowScripts()
	{
		if (!$this->boolError)
		{
			$this->ShowAtoms();
		}
	}

	public function ShowAtoms()
	{
		global $APPLICATION;

		if (!$this->boolError)
		{
			if (!isset($this->arAtomList))
			{
				$this->OnConditionAtomBuildList();
			}
			if (isset($this->arAtomJSPath) && !empty($this->arAtomJSPath))
			{
				foreach ($this->arAtomJSPath as &$strJSPath)
				{
					$APPLICATION->AddHeadScript($strJSPath);
				}
				if (isset($strJSPath))
					unset($strJSPath);
			}
		}
	}

	public function ShowParams()
	{
		if (!$this->boolError)
		{
			$arParams = array(
				'parentContainer' => $this->strContID,
				'form' => $this->strFormID,
				'formName' => $this->strFormName,
				'sepID' => $this->strSepID,
				'prefix' => $this->strPrefix,
			);

			if (!empty($this->arSystemMess))
				$arParams['messTree'] = $this->arSystemMess;

			return CUtil::PhpToJSObject($arParams);
		}
		else
		{
			return '';
		}
	}

	public function ShowControls()
	{
		if (!$this->boolError)
		{
			$arResult = array();
			if (isset($this->arShowControlList))
			{
				foreach ($this->arShowControlList as &$arOneControl)
				{
					$arShowControl = call_user_func_array($arOneControl,
						array(
							array(
								'SHOW_IN_GROUPS' => $this->arShowInGroups
							)
						)
					);
					if (!empty($arShowControl) && is_array($arShowControl))
					{
						if (isset($arShowControl['controlId']) || isset($arShowControl['controlgroup']))
						{
							$arResult[] = $arShowControl;
						}
						else
						{
							$arResult = array_merge($arResult, $arShowControl);
						}

					}
				}
				if (isset($arOneControl))
					unset($arOneControl);
			}

			return CUtil::PhpToJSObject($arResult);
		}
		else
		{
			return '';
		}
	}

	public function ShowLevel(&$arLevel, $boolFirst = false)
	{
		$boolFirst = (true === $boolFirst ? true : false);
		$arResult = array();
		if (empty($arLevel) || !is_array($arLevel))
			return $arResult;
		$intCount = 0;
		if ($boolFirst)
		{
			if (isset($arLevel['CLASS_ID']) && !empty($arLevel['CLASS_ID']))
			{
				if (isset($this->arControlList[$arLevel['CLASS_ID']]))
				{
					$arOneControl = $this->arControlList[$arLevel['CLASS_ID']];
					$arParams = array(
						'COND_NUM' => $intCount,
						'DATA' => $arLevel['DATA'],
						'ID' => $arOneControl['ID'],
					);
					$arOneResult = call_user_func_array($arOneControl["GetConditionShow"],
						array(
							$arParams,
						)
					);
					if ('Y' == $arOneControl['GROUP'])
					{
						$arOneResult['children'] = array();
						if (isset($arLevel['CHILDREN']))
							$arOneResult['children'] = $this->ShowLevel($arLevel['CHILDREN'], false);
					}
					$arResult[] = $arOneResult;
					$intCount++;
				}
			}
		}
		else
		{
			foreach ($arLevel as &$arOneCondition)
			{
				if (isset($arOneCondition['CLASS_ID']) && !empty($arOneCondition['CLASS_ID']))
				{
					if (isset($this->arControlList[$arOneCondition['CLASS_ID']]))
					{
						$arOneControl = $this->arControlList[$arOneCondition['CLASS_ID']];
						$arParams = array(
							'COND_NUM' => $intCount,
							'DATA' => $arOneCondition['DATA'],
							'ID' => $arOneControl['ID'],
						);
						$arOneResult = call_user_func_array($arOneControl["GetConditionShow"],
							array(
								$arParams,
							)
						);

						if ('Y' == $arOneControl['GROUP'] && isset($arOneCondition['CHILDREN']))
						{
							$arOneResult['children'] = $this->ShowLevel($arOneCondition['CHILDREN'], false);
						}
						$arResult[] = $arOneResult;
						$intCount++;
					}
				}
			}
			if (isset($arOneCondition))
				unset($arOneCondition);
		}
		return $arResult;
	}

	public function ShowConditions()
	{
		if (!$this->boolError)
		{
			if (empty($this->arConditions))
				$this->arConditions = $this->GetDefaultConditions();

			$arResult = $this->ShowLevel($this->arConditions, true);

			return CUtil::PhpToJSObject(current($arResult));
		}
		else
		{
			return '';
		}
	}

	public function Generate($arConditions, $arParams)
	{
		$this->usedModules = array();
		$this->usedExtFiles = array();

		$strResult = '';
		if (!$this->boolError)
		{
			if (is_array($arConditions) && !empty($arConditions))
			{
				$arResult = $this->GenerateLevel($arConditions, $arParams, true);
				if (false === $arResult || empty($arResult))
				{
					$strResult = '';
					$this->boolError = true;
				}
				else
				{
					$strResult = current($arResult);
				}
			}
			else
			{
				$this->boolError = true;
			}
		}
		return $strResult;
	}

	public function GenerateLevel(&$arLevel, $arParams, $boolFirst = false)
	{
		$arResult = array();
		$boolFirst = (true === $boolFirst);
		if (!is_array($arLevel) || empty($arLevel))
		{
			return $arResult;
		}
		if ($boolFirst)
		{
			if (isset($arLevel['CLASS_ID']) && !empty($arLevel['CLASS_ID']))
			{
				if (isset($this->arControlList[$arLevel['CLASS_ID']]))
				{
					$arOneControl = $this->arControlList[$arLevel['CLASS_ID']];
					if ('Y' == $arOneControl['GROUP'])
					{
						$arSubEval = $this->GenerateLevel($arLevel['CHILDREN'], $arParams);
						if (false === $arSubEval || !is_array($arSubEval))
							return false;
						$strEval = call_user_func_array($arOneControl['Generate'],
							array($arLevel['DATA'], $arParams, $arLevel['CLASS_ID'], $arSubEval)
						);
					}
					else
					{
						$strEval = call_user_func_array($arOneControl['Generate'],
							array($arLevel['DATA'], $arParams, $arLevel['CLASS_ID'])
						);
					}
					if (false === $strEval || !is_string($strEval) || 'false' === $strEval)
					{
						return false;
					}
					$arResult[] = '('.$strEval.')';
					if (isset($arOneControl['MODULE_ID']) && !empty($arOneControl['MODULE_ID']))
					{
						if (is_array($arOneControl['MODULE_ID']))
						{
							foreach ($arOneControl['MODULE_ID'] as &$oneModuleID)
							{
								if ($oneModuleID != $this->arEvents['CONTROLS']['MODULE_ID'])
									$this->usedModules[$oneModuleID] = true;
							}
							unset($oneModuleID);
						}
						else
						{
							if ($arOneControl['MODULE_ID'] != $this->arEvents['CONTROLS']['MODULE_ID'])
								$this->usedModules[$arOneControl['MODULE_ID']] = true;
						}
					}
					if (isset($arOneControl['EXT_FILE']) && !empty($arOneControl['EXT_FILE']))
					{
						if (is_array($arOneControl['EXT_FILE']))
						{
							foreach ($arOneControl['EXT_FILE'] as &$oneExtFile)
							{
								$this->usedExtFiles[$oneExtFile] = true;
							}
							unset($oneExtFile);
						}
						else
						{
							$this->usedExtFiles[$arOneControl['EXT_FILE']] = true;
						}
					}
				}
			}
		}
		else
		{
			foreach ($arLevel as &$arOneCondition)
			{
				if (isset($arOneCondition['CLASS_ID']) && !empty($arOneCondition['CLASS_ID']))
				{
					if (isset($this->arControlList[$arOneCondition['CLASS_ID']]))
					{
						$arOneControl = $this->arControlList[$arOneCondition['CLASS_ID']];
						if ('Y' == $arOneControl['GROUP'])
						{
							$arSubEval = $this->GenerateLevel($arOneCondition['CHILDREN'], $arParams);
							if (false === $arSubEval || !is_array($arSubEval))
								return false;
							$strEval = call_user_func_array($arOneControl['Generate'],
								array($arOneCondition['DATA'], $arParams, $arOneCondition['CLASS_ID'], $arSubEval)
							);
						}
						else
						{
							$strEval = call_user_func_array($arOneControl['Generate'],
								array($arOneCondition['DATA'], $arParams, $arOneCondition['CLASS_ID'])
							);
						}

						if (false === $strEval || !is_string($strEval) || 'false' === $strEval)
						{
							return false;
						}
						$arResult[] = '('.$strEval.')';
						if (isset($arOneControl['MODULE_ID']) && !empty($arOneControl['MODULE_ID']))
						{
							if (is_array($arOneControl['MODULE_ID']))
							{
								foreach ($arOneControl['MODULE_ID'] as &$oneModuleID)
								{
									if ($oneModuleID != $this->arEvents['CONTROLS']['MODULE_ID'])
										$this->usedModules[$oneModuleID] = true;
								}
								unset($oneModuleID);
							}
							else
							{
								if ($arOneControl['MODULE_ID'] != $this->arEvents['CONTROLS']['MODULE_ID'])
									$this->usedModules[$arOneControl['MODULE_ID']] = true;
							}
						}
						if (isset($arOneControl['EXT_FILE']) && !empty($arOneControl['EXT_FILE']))
						{
							if (is_array($arOneControl['EXT_FILE']))
							{
								foreach ($arOneControl['EXT_FILE'] as &$oneExtFile)
								{
									$this->usedExtFiles[$oneExtFile] = true;
								}
								unset($oneExtFile);
							}
							else
							{
								$this->usedExtFiles[$arOneControl['EXT_FILE']] = true;
							}
						}
					}
				}
			}
			if (isset($arOneCondition))
				unset($arOneCondition);
		}

		if (!empty($arResult))
		{
			foreach ($arResult as $key => $value)
			{
				if ('' == $value || '()' == $value)
					unset($arResult[$key]);
			}
		}
		if (!empty($arResult))
			$arResult = array_values($arResult);

		return $arResult;
	}

	public function GetConditionValues($arConditions)
	{
		$arResult = false;
		if (!$this->boolError)
		{
			if (!empty($arConditions) && is_array($arConditions))
			{
				$arValues = array();
				$this->GetConditionValuesLevel($arConditions, $arValues, true);
				$arResult = $arValues;
			}
		}
		return $arResult;
	}

	public function GetConditionValuesLevel(&$arLevel, &$arResult, $boolFirst = false)
	{
		$boolFirst = (true === $boolFirst);
		if (is_array($arLevel) && !empty($arLevel))
		{
			if ($boolFirst)
			{
				if (isset($arLevel['CLASS_ID']) && !empty($arLevel['CLASS_ID']))
				{
					if (isset($this->arControlList[$arLevel['CLASS_ID']]))
					{
						$arOneControl = $this->arControlList[$arLevel['CLASS_ID']];
						if ('Y' == $arOneControl['GROUP'])
						{
							if (call_user_func_array($arOneControl['ApplyValues'],
								array($arLevel['DATA'], $arLevel['CLASS_ID'])))
							{
								$this->GetConditionValuesLevel($arLevel['CHILDREN'], $arResult, false);
							}
						}
						else
						{
							$arCondInfo = call_user_func_array($arOneControl['ApplyValues'],
								array($arLevel['DATA'], $arLevel['CLASS_ID'])
							);
							if (!empty($arCondInfo) && is_array($arCondInfo))
							{
								if (!isset($arResult[$arLevel['CLASS_ID']]) || empty($arResult[$arLevel['CLASS_ID']]) || !is_array($arResult[$arLevel['CLASS_ID']]))
								{
									$arResult[$arLevel['CLASS_ID']] = $arCondInfo;
								}
								else
								{
									$arResult[$arLevel['CLASS_ID']]['VALUES'] = array_merge($arResult[$arLevel['CLASS_ID']]['VALUES'], $arCondInfo['VALUES']);
								}
							}
						}
					}
				}
			}
			else
			{
				foreach ($arLevel as &$arOneCondition)
				{
					if (isset($arOneCondition['CLASS_ID']) && !empty($arOneCondition['CLASS_ID']))
					{
						if (isset($this->arControlList[$arOneCondition['CLASS_ID']]))
						{
							$arOneControl = $this->arControlList[$arOneCondition['CLASS_ID']];
							if ('Y' == $arOneControl['GROUP'])
							{
								if (call_user_func_array($arOneControl['ApplyValues'],
									array($arOneCondition['DATA'], $arOneCondition['CLASS_ID'])))
								{
									$this->GetConditionValuesLevel($arOneCondition['CHILDREN'], $arResult, false);
								}
							}
							else
							{
								$arCondInfo = call_user_func_array($arOneControl['ApplyValues'],
									array($arOneCondition['DATA'], $arOneCondition['CLASS_ID'])
								);
								if (!empty($arCondInfo) && is_array($arCondInfo))
								{
									if (!isset($arResult[$arOneCondition['CLASS_ID']]) || empty($arResult[$arOneCondition['CLASS_ID']]) || !is_array($arResult[$arOneCondition['CLASS_ID']]))
									{
										$arResult[$arOneCondition['CLASS_ID']] = $arCondInfo;
									}
									else
									{
										$arResult[$arOneCondition['CLASS_ID']]['VALUES'] = array_merge($arResult[$arOneCondition['CLASS_ID']]['VALUES'], $arCondInfo['VALUES']);
									}
								}
							}
						}
					}
				}
				if (isset($arOneCondition))
					unset($arOneCondition);
			}
		}
	}

	protected function __ConvertKey($strKey)
	{
		if ('' !== $strKey)
		{
			$arKeys = explode($this->strSepID, $strKey);
			if (is_array($arKeys))
			{
				foreach ($arKeys as &$intOneKey)
				{
					$intOneKey = (int)$intOneKey;
				}
			}
			return $arKeys;
		}
		else
		{
			return false;
		}
	}

	protected function __SetCondition(&$arResult, $arKeys, $intIndex, $arOneCondition)
	{
		if (0 == $intIndex)
		{
			if (1 == sizeof($arKeys))
			{
				$arResult = $arOneCondition;
				return true;
			}
			else
			{
				return $this->__SetCondition($arResult, $arKeys, $intIndex + 1, $arOneCondition);
			}
		}
		else
		{
			if (!isset($arResult['CHILDREN']))
			{
				$arResult['CHILDREN'] = array();
			}
			if (!isset($arResult['CHILDREN'][$arKeys[$intIndex]]))
			{
				$arResult['CHILDREN'][$arKeys[$intIndex]] = array();
			}
			if (($intIndex + 1) < sizeof($arKeys))
			{
				return $this->__SetCondition($arResult['CHILDREN'][$arKeys[$intIndex]], $arKeys, $intIndex + 1, $arOneCondition);
			}
			else
			{
				if (!empty($arResult['CHILDREN'][$arKeys[$intIndex]]))
				{
					return false;
				}
				else
				{
					$arResult['CHILDREN'][$arKeys[$intIndex]] = $arOneCondition;
					return true;
				}
			}
		}
	}

	public function GetConditionHandlers()
	{
		if (empty($this->usedModules) && empty($this->usedExtFiles))
		{
			return array();
		}
		else
		{
			return array(
				'MODULES' => (!empty($this->usedModules) ? array_keys($this->usedModules) : array()),
				'EXT_FILES' => (!empty($this->usedExtFiles) ? array_keys($this->usedExtFiles) : array())
			);
		}
	}
}

class CCatalogCondTree extends CGlobalCondTree
{
	public function __construct()
	{
		parent::__construct();
	}

	public function __destruct()
	{
		parent::__destruct();
	}
}
?>