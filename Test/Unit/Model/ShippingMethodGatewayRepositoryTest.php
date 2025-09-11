<?php
/**
 * Copyright © Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\Kss\Test\Unit\Model;

use Klarna\Base\Test\Unit\Mock\MockFactory;
use Klarna\Kss\Model\ResourceModel\ShippingMethodGateway as ShippingResource;
use Klarna\Kss\Model\ShippingMethodGatewayRepository;
use Klarna\Kss\Model\ShippingMethodGateway;
use Klarna\Kss\Model\ShippingMethodGatewayFactory;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Klarna\Kss\Model\ShippingMethodGatewayRepository
 */
class ShippingMethodGatewayRepositoryTest extends TestCase
{
    /**
     * @var ShippingMethodGatewayRepository
     */
    private $model;
    /**
     * @var ShippingMethodGateway
     */
    private $shippingMethodGateway;
    /**
     * @var ShippingMethodGatewayFactory|PHPUnit_Framework_MockObject_MockObject
     */
    private $shippingFactory;

    /**
     * @covers ::loadShipping
     */
    public function testLoadShipping(): void
    {
        $this->shippingFactory
            ->method('create')
            ->willReturn($this->shippingMethodGateway);

        $this->expectException(\Magento\Framework\Exception\NoSuchEntityException::class);
        $this->expectExceptionMessage("No such entity with klarna_session_id = ");
        $this->model->loadShipping('3823342b-7f23-6580-975f-b448f942085c', 'klarna_session_id');
    }

    protected function setUp(): void
    {
        $mockFactory                 = new MockFactory($this);
        $this->shippingMethodGateway = $mockFactory->create(ShippingMethodGateway::class);
        $shippingResource            = $mockFactory->create(ShippingResource::class);
        $this->shippingFactory       = $mockFactory->create(ShippingMethodGatewayFactory::class, ['create']);
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->model = $objectManager->getObject(
            ShippingMethodGatewayRepository::class,
            [
                'shippingResource' => $shippingResource,
                'shippingFactory'  => $this->shippingFactory
            ]
        );
    }
}
