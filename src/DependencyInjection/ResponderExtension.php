<?php

/**
 * This file is part of the bugloos/responder-bundle project.
 * (c) Bugloos <https://bugloos.com/>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bugloos\ResponderBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Mojtaba Gheytasi <mjgheytasi@gmail.com>
 */
class ResponderExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('default_max_items_per_page', $config['default_max_items_per_page']);
        $container->setParameter('default_items_per_page', $config['default_items_per_page']);
        $container->setParameter('page_key_in_request', $config['page_key_in_request']);
        $container->setParameter('items_per_page_key_in_request', $config['items_per_page_key_in_request']);

        $container->setAlias(
            'paginator_response',
            $config['paginator_response']
        )->setPublic(true);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yaml');
    }

    public function getAlias(): string
    {
        return 'bugloos_responder';
    }
}
