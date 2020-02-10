<?php

declare(strict_types=1);
namespace Sana\CustomerAccount\Controller\Index;

use Exception;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\CustomerFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

class Save extends Action
{
    /**
     * @var Customer
     */
    private $customerModel;
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    /**
     * Save constructor.

     * @param Context $context
     * @param Http $request
     * @param Customer $customerModel
     * @param Session $customerSession
     * @param CustomerFactory $customerFactory
     */
    public function __construct(
        Context $context,
        Http $request,
        Customer $customerModel,
        Session $customerSession,
        CustomerFactory $customerFactory
    ) {
        $this->_request = $request;
        $this->customerModel = $customerModel;
        $this->customerSession = $customerSession;
        $this->customerFactory = $customerFactory;
        parent::__construct($context);
    }
    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        if ($post = $this->getRequest()->getPost()->toArray()) {
            try {
                $customer_status = $this->getRequest()->getPostValue('customer_status');
                $customerNew = $this->customerModel->load($this->customerSession->getCustomer()->getId());
                $customerData = $customerNew->getDataModel();
                $customerData->setCustomAttribute(
                    'customer_status',
                    $customer_status
                );
                $customerNew->updateData($customerData);
                $customerResource = $this->customerFactory->create();
                $customerResource->saveAttribute($customerNew, 'customer_status');

                $this->messageManager->addSuccessMessage('Your Status Saved');
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setRefererOrBaseUrl();
                return $resultRedirect;
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setRefererOrBaseUrl();
                return $resultRedirect;
            }
        } else {
            $this->messageManager->addErrorMessage('No Value Found...');
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setRefererOrBaseUrl();
            return $resultRedirect;
        }
    }
}
