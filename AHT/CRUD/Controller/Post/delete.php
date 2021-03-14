<?php
 
namespace AHT\CRUD\Controller\Post;
 
use Magento\Framework\App\Action;
use AHT\CRUD\Model\PostFactory;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;
 
class Delete extends \Magento\Framework\App\Action\Action
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
        try{
            //get post data
            $id = $this->getRequest()->getParam('id');
            
            $post = $this->postFactory->create();
            $post->load($id);
            //delete data
            $post->delete();

            //return success message
            $this->messageManager->addSuccess(__('Xóa thành công'));
            $this->cleanCache();
            return $this->_redirect('post/post/index');
            
        }catch (\Exception $e){
            $$this->messageManager->addError(__('Xóa thất bại.'));
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