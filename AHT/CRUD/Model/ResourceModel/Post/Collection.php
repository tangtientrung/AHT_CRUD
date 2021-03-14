<?php
 
namespace AHT\CRUD\Model\ResourceModel\Post;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /*
    * @var $_idFieldName
    */
    protected $_idFieldName = 'id';
 
    protected function _construct()
    {
        $this->_init('AHT\CRUD\Model\Post', 'AHT\CRUD\Model\ResourceModel\Post');
    }
}