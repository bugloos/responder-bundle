<?php

/**
 * This file is part of the bugloos/responder-bundle project.
 * (c) Bugloos <https://bugloos.com/>
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Bugloos\ResponderBundle;

use Bugloos\ResponderBundle\DependencyInjection\ResponderExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Mojtaba Gheytasi <mjgheytasi@gmail.com>
 */
class ResponderBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new ResponderExtension();
        }

        return $this->extension;
    }
}
