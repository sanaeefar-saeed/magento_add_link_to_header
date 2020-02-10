<?php

declare(strict_types=1);
namespace Sana\CustomerAccount\Plugin\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\CustomerData\Customer;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class CustomerData
 * @package Sana\CustomerAccount\Customer
 */
class CustomerData
{
    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * CustomerData constructor.
     * @param CurrentCustomer $currentCustomer
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        CurrentCustomer $currentCustomer,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param Customer $subject
     * @param $result
     * @return mixed
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function afterGetSectionData(Customer $subject, $result)
    {
        if (!$this->currentCustomer->getCustomerId()) {
            return $result;
        }

        $customerId = $this->currentCustomer->getCustomerId();
        $customer = $this->customerRepository->getById($customerId);
        if ($customer->getCustomAttribute('customer_status') !== null) {
            $result['customerStatus'] = $customer->getCustomAttribute('customer_status')->getValue();
        }

        return $result;
    }
}
