<?php

namespace AHT\CRUD\Block;

class Edit extends \Magento\Framework\View\Element\Template
{
	protected $_postFactory;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\AHT\CRUD\Model\PostFactory $postFactory
	)
	{
		$this->_postFactory = $postFactory;
		parent::__construct($context);
	}

	public function getEditPost(){
		$post = $this->_postFactory->create();
        $id = $this->getRequest()->getParam('id');
        $post->load($id);
		return $post->getData();
	}

}