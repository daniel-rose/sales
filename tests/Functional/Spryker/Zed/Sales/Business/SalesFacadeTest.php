<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\Spryker\Zed\Sales\Business;

use Codeception\TestCase\Test;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use Spryker\Zed\Sales\Business\SalesFacade;

class SalesFacadeTest extends Test
{

    /**
     * return void
     */
    public function testGetOrderByIdSalesOrderShouldReturnOrderTransferWithOrderDataAndTotals()
    {
        $testOrderCreator = $this->createTestOrderCreator();
        $salesOrderEntity = $testOrderCreator->create();

        $salesFacade = $this->createSalesFacade();

        $orderTransfer = $salesFacade->getOrderByIdSalesOrder($salesOrderEntity->getIdSalesOrder());

        $this->assertInstanceOf(OrderTransfer::class, $orderTransfer);
        $this->assertInstanceOf(TotalsTransfer::class, $orderTransfer->getTotals());
        $this->assertCount(2, $orderTransfer->getItems());
        $this->assertInstanceOf(AddressTransfer::class, $orderTransfer->getBillingAddress());
        $this->assertInstanceOf(AddressTransfer::class, $orderTransfer->getShippingAddress());
        $this->assertCount(1, $orderTransfer->getExpenses());
    }

    /**
     * @return \Spryker\Zed\Sales\Business\SalesFacade
     */
    protected function createSalesFacade()
    {
        return new SalesFacade();
    }

    /**
     * @return \Functional\Spryker\Zed\Sales\Business\TestOrderCreator
     */
    protected function createTestOrderCreator()
    {
        return new TestOrderCreator();
    }

}
