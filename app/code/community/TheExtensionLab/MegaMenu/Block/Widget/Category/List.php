<?php

/**
 * @category    TheExtensionLab
 * @package     TheExtensionLab_MegaMenu
 * @copyright   Copyright (c) 2015 TheExtensionLab (http://www.theextensionlab.com)
 * @license     http://www.theextensionlab.com/license/license.txt - Commercial License
 * @author      James Anelay @ TheExtensionLab <james@theextensionlab.com>
 */

class TheExtensionLab_MegaMenu_Block_Widget_Category_List
    extends TheExtensionLab_MegaMenu_Block_Widget_Template
    implements Mage_Widget_Block_Interface
{
    protected function getCategoryTree()
    {
        $json = $this->getCategoryJson();
        $categoryData = json_decode($json);

        return $categoryData->categories;
    }

    protected function getLoadedMenuNodes()
    {
        $currentMenu = Mage::registry('current_menu');
        $childNodes = $currentMenu->getAllChildNodes();

        return $childNodes;
    }

    protected function getCategoryLiClass($categoryNode,$category){
        $hasDropDownContent = ($this->getHasDropdownContent($categoryNode)) ? ' parent' : '';
        $hasChildren = property_exists($category,'children');

        $class = $hasDropDownContent;
        if($hasChildren) {
            $class .= ' ' . 'has-children';
        }

        return $class;
    }

    protected function _getCategoryNodeById($childNodes, $categoryId)
    {
        $categoryNodeId = 'category-node-'.$categoryId;

        if(!isset($childNodes[$categoryNodeId])):
            return false;
        endif;

        return $childNodes[$categoryNodeId];
    }

    protected function _getCustomCategoryMenuName($categoryNode, $categoryJson)
    {
        if(isset($categoryJson->custom_name)){
            return $categoryJson->custom_name;
        }

        return $categoryNode->getName();
    }

    protected function _getCategoryRenderer($template = null)
    {
        $renderer = $this->getLayout()->createBlock('theextensionlab_megamenu/widget_category_renderer');

        if($template === null) {
            $renderer->setTemplate('theextensionlab/megamenu/categories/list/renderer.phtml');
        }

       return $renderer;
    }

    protected function getHasDropdownContent(Varien_Data_Tree_Node $item)
    {
        $hasContent = false;

        if(!$item->hasColumns()):
            return false;
        endif;

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
}