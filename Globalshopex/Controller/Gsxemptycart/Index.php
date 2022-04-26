<?php

namespace Gsx\Globalshopex\Controller\Gsxemptycart;

use Magento\Framework\Webapi\Exception;
use Magento\Quote\Model\QuoteFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    /** @var  \Magento\Framework\View\Result\Page */
    protected $resultPageFactory;
    /**
     * @var QuoteFactory
     */
    protected $quoteFactory;
    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $product;

    /**
     * Construct for Gsx empty cart index controller
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param Quote $quoteFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        QuoteFactory $quoteFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->quoteFactory = $quoteFactory;
        parent::__construct($context);
    }

    /**
     * Shows Gsx empty cart section.
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
  
        try {
            $quoteId = $this->getRequest()->getParam('quoteid');
            /*$cart = new \Magento\Checkout\Model\Cart;
            */
            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info(print_r($quoteId,true));
            if (is_numeric($quoteId)) {
                //$quote = $this->_objectManager->create('Magento\Quote\Model\QuoteFactory')->loadByIdWithoutStore(5);
                /*$quote = $this->getModel('\Magento\Quote\Model\Quote');
                $quote->load(5);*/
                $quote = $this->quoteFactory->create();
                $quote = $quote->loadByIdWithoutStore($quoteId);

                $quote->setIsActive(false)->save();

            }
            $resultPage = $this->resultPageFactory->create();
            return $resultPage;
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e->getName() ? $e->getName() : 'Error occured');
        }
    }
}
