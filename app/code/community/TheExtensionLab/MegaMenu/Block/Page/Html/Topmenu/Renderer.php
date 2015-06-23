<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) TheExtensionLab (http://www.theextensionlab.com)
 * @license     Open Software License (OSL 3.0)
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */
class TheExtensionLab_MegaMenu_Block_Page_Html_Topmenu_Renderer
    extends Mage_Page_Block_Html_Topmenu_Renderer
{

    protected function _getMenuItemClasses(Varien_Data_Tree_Node $item)
    {
        $classes = array();

        $classes[] = 'level' . $item->getLevel();
        $classes[] = $item->getPositionClass();

        if ($item->getIsActive()) {
            $classes[] = 'active';
        }

        if ($item->getClass()) {
            $classes[] = $item->getClass();
        }

        if ($this->getHasDropdownContent($item)) {
            $classes[] = 'parent';
        }

        return $classes;
    }

    protected function getHasDropdownContent(Varien_Data_Tree_Node $item)
    {
        $hasContent = false;
        $columns = $item->getColumns();

        foreach($columns as $column){
            if(!empty($column['content'])):
                if($column['col_width'] != 0) {
                    $hasContent = true;
                }
            endif;
        }
        return $hasContent;
    }

    protected function getCategoryLiClass($category){
        $hasChildren = ($category->hasChildren()) ? ' has-children' : '';

        $class = 'level'.$category->getLevel();
        $class .= $hasChildren;

        return $class;
    }

    protected function setCategoryData($category,$parentLevel)
    {
        $childLevel = is_null($parentLevel) ? 0 : $parentLevel + 1;

        $category->setLevel($childLevel);
        $category->setHasDropDownContent($this->getHasDropdownContent($category));
    }

    protected function getMenuDropDownTypeClass($category)
    {
        $dropdownTypeId = $category->getMenuDropdownType();

        switch ($dropdownTypeId) {
            case 1:
                $dropdownClass = 'megamenu absolute-center';
                break;
            case 2:
                $dropdownClass = 'megamenu absolute-left';
                break;
            case 3:
                $dropdownClass = 'megamenu absolute-right';
                break;
            case 4:
                $dropdownClass = 'megamenu relative-center';
                break;
            case 5:
                $dropdownClass = 'megamenu hang-right';
                break;
            case 6:
                $dropdownClass = 'megamenu hang-left';
                break;
            case 7:
                $dropdownClass = '';
                break;
            default:
                $dropdownClass = 'megamenu absolute-center';
                break;
        }

        $dropdownClass .= ' level'.$category->getLevel();
        $dropdownClass .= ' xlab_grid_container';

        return $dropdownClass;
    }
}