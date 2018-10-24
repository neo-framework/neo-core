<?php

/**
 * This file is part of Neo Framework.
 *
 * (c) 2016-2018 YouniS Bensalah <younis.bensalah@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace neo\core\controller;

/**
 * Abstract Factory that creates {@link Controller} objects.
 *
 * By implementing and registering this Factory you can inform Neo how your Controllers shall be created at runtime.
 */
abstract class ControllerFactory
{

    private $closed = false;

    public function __invoke(string $type) : ?Controller
    {
        return $this->create($type);
    }

    /**
     * Create a {@link Controller} instance.
     *
     * @param string $type Fully qualified class name of the {@link Controller}.
     * @return Controller The freshly created {@link Controller} instance or null.
     */
    abstract public function create(string $type) : ?Controller;

    /**
     * Close this factory.
     * A closed factory is supposed to throw an InvalidArgumentException if it cannot create the requested instance.
     */
    public function close()
    {
        $this->closed = true;
        return $this;
    }

    /**
     * Open this factory.
     * An open factory is supposed to return null if it cannot create the requested instance.
     * This is orthogonal to throwing an InvalidArgumentException.
     */
    public function open()
    {
        $this->closed = false;
        return $this;
    }

    public function isClosed() : bool
    {
        return $this->closed;
    }

    /**
     * This should be called/returned whenever you decide that this concrete Factory is unable to create
     * the requested class instance.
     * That way you make sure that your Factory will behave correctly when it is open (i.e., return null)
     * or closed (i.e., throw InvalidArgumentException).
     */
    protected function fallthrough(string $type)
    {
        // when closed
        if ($this->closed) {
            throw new \InvalidArgumentException(\sprintf('Cannot create instance of type "%s".', $type));
        }

        // when open
        return null;
    }

}
