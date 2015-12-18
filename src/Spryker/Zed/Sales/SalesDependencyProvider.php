<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Sales;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Sales\Dependency\Facade\SalesToCountryBridge;
use Spryker\Zed\Sales\Dependency\Facade\SalesToOmsBridge;

class SalesDependencyProvider extends AbstractBundleDependencyProvider
{

    const FACADE_COUNTRY = 'FACADE_COUNTRY';
    const FACADE_OMS = 'FACADE_OMS';
    const FACADE_REFUND = 'FACADE_REFUND';
    const FACADE_LOCALE = 'LOCALE_FACADE';
    const FACADE_SEQUENCE_NUMBER = 'FACADE_SEQUENCE_NUMBER';

    const PLUGINS_PAYMENT_LOGS = 'PLUGINS_PAYMENT_LOGS';

    /**
     * @param Container $container
     *
     * @return Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container[self::FACADE_SEQUENCE_NUMBER] = function (Container $container) {
            return $container->getLocator()->sequenceNumber()->facade();
        };

        $container[self::FACADE_COUNTRY] = function (Container $container) {
            return new SalesToCountryBridge($container->getLocator()->country()->facade());
        };

        $container[self::FACADE_OMS] = function (Container $container) {
            return new SalesToOmsBridge($container->getLocator()->oms()->facade());
        };

        $container[self::FACADE_REFUND] = function (Container $container) {
            return $container->getLocator()->refund()->facade();
        };

        $container[self::PLUGINS_PAYMENT_LOGS] = function (Container $container) {
            return $this->getPaymentLogPlugins($container);
        };

        return $container;
    }

    /**
     * @param Container $container
     *
     * @return Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container[self::FACADE_OMS] = function (Container $container) {
            return new SalesToOmsBridge($container->getLocator()->oms()->facade());
        };

        $container[self::FACADE_LOCALE] = function (Container $container) {
            return $container->getLocator()->locale()->facade();
        };

        return $container;
    }

    /**
     * @param Container $container
     *
     * @return array
     */
    protected function getPaymentLogPlugins(Container $container)
    {
        return [];
    }

}