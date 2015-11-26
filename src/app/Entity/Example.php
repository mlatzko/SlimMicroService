<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Entity;

/**
 * Entity handling to be extended by Doctrine generated class.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
class Example
{
    /**
     * Set created & modified to now.
     */
    public function markAsCreated()
    {
        $this->setCreated(new \DateTime());
    }

    /**
     * Set modified to now.
     */
    public function markAsUpdated()
    {
        $this->setModified(new \DateTime());
    }
}
