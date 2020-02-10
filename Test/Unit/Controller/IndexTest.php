<?php
declare(strict_types=1);
namespace Sana\CustomerAccount\Test\Unit\Controller\Index;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManagerHelper;
use PHPUnit\Framework\TestCase;
use Sana\CustomerAccount\Controller\Index\Index;

/**
 * Class IndexTest
 * @package Sana\CustomerAccount\Test\Unit\Controller\Index
 */
class IndexTest extends TestCase
{
    /**
     * @var Context $context
     */
    protected $context;

    /**
     * @var ObjectManagerHelper $objectManagerHelper
     */
    protected $objectManagerHelper;

    /**
     * @var Index $indexController
     */
    protected $indexController;

    /**
     * @var ResultFactory $resultFactory
     */
    protected $resultFactory;

    /**
     * @var Page $resultPage
     */
    protected $resultPage;

    /**
     *  Setup unit test
     */
    protected function setUp()
    {
        $this->resultPage = $this->createPartialMock(
            Page::class,
            ['setActiveMenu', 'getConfig', 'getTitle', 'prepend', 'addBreadcrumb']
        );
        $this->resultPage->expects($this->any())->method('getConfig')->willReturnSelf();
        $this->resultPage->expects($this->any())->method('getTitle')->willReturnSelf();
        $this->resultFactory = $this->createPartialMock(ResultFactory::class, ['create']);
        $this->resultFactory->expects($this->any())->method('create')->willReturn($this->resultPage);
        $this->context = $this->createPartialMock(Context::class, ['getResultFactory']);
        $this->context->expects($this->any())->method('getResultFactory')->willReturn($this->resultFactory);

        $this->indexController = new Index(
            $this->context
        );
    }

    /**
     *  Test Execute Method
     */
    public function testExecute(): void
    {
        $result = $this->indexController->execute();
        $this->assertNotNull($result);
    }
}
