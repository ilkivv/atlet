<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php $left = 1;?>
<div class="articles-list clearfix">

<?foreach($arResult["ITEMS"] as $arItem):?>

	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <article class="article <?php echo ($left)?'left':'right';$left=1-$left;?> <? if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])){echo "with-img";}?>"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="img"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="" /></a>
		<?endif?>
        <div class="article-body">
            <h3><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></h3>
            <span class="date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
            <div class="excerpt">
                <?echo $arItem["PREVIEW_TEXT"];?>
            </div>
        </div>
    </article>

<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>

