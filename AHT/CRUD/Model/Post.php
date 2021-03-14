<?php
 
namespace AHT\CRUD\Model;
 
class Post extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('AHT\CRUD\Model\ResourceModel\Post');
    }
}