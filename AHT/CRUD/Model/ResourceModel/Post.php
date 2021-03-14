<?php
 
namespace AHT\CRUD\Model\ResourceModel;
 
class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('post', 'id');
    }
}