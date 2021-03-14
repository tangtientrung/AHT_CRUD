<?php
 
namespace AHT\CRUD\Controller\Post;
 
use Magento\Framework\App\Action;
use AHT\CRUD\Model\PostFactory;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;

class Save extends \Magento\Framework\App\Action\Action
{
    /*
    * @var $resultRedirect
    * @var $formFactory
    */
    protected $postFactory;
    protected $cacheTypeList;
    protected $cacheFrontendPool;

    /*
    * @param Action\Context $context
    * @param FormFactory $formFactory
    */
    public function __construct(
        Action\Context $context,
        PostFactory $postFactory,
        TypeListInterface $cacheTypeList,
        Pool $cacheFrontendPool
    )
    {
        $this->postFactory = $postFactory;
        parent::__construct($context);
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
    }
 
    public function execute()
    {
        //create new post
        $post = $this->postFactory->create();
        
        try{
            if(!isset($_POST['id']))
            {
                $post->setName($_POST['name']);
                $post->setUrl($_POST['url']);
                $post->setImage($_POST['image']);
                $post->setContent($_POST['content']);
                $post->setStatus($_POST['status']);
                $post->setCreatedAt(date('Y-m-d H:i:s'));
                $post->setUpdatedAt(date('Y-m-d H:i:s'));
                $post->save();
                $this->messageManager->addSuccess(__('Add thành công'));
            }
            else
            {
                $id=$_POST['id'];
                $post->load($id);
                $post->setName($_POST['name']);
                $post->setUrl($_POST['url']);
                $post->setImage($_POST['image']);
                $post->setContent($_POST['content']);
                $post->setStatus($_POST['status']);
                $post->setUpdatedAt(date('Y-m-d H:i:s'));
                $post->save();
                $this->messageManager->addSuccess(__('Edit thành công'));
            }
            $this->cleanCache();
            return $this->_redirect('post/post/index');
        }catch (\Exception $e){
            $this->messageManager->addError(__('Error '.$e));
        }
        
    }
    public function cleanCache()
    {
        $types = array('config','layout','block_html','collections','reflection','db_ddl','eav','config_integration','config_integration_api','full_page','translate','config_webservice');
    
        foreach ($types as $type) {
            $this->cacheTypeList->cleanType($type);
        }
        foreach ($this->cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
    }
}