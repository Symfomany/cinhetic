<?php

namespace Cinhetic\PublicBundle\Webservice\Plateform;

/**
 * Class AbstractPlateform
 * @package Cinhetic\PublicBundle\Webservice
 */
abstract class AbstractPlateform implements \SeekableIterator, \ArrayAccess, \Countable{

    /**
     * Params array
     * @var
     */
    protected $params;

    /**
     * Feeds array
     * @var
     */
    protected $feeds;

    /**
     * Position of feeds cursor
     * @var
     */
    protected $position;




    /**
     * @param mixed $feeds
     */
    public function setFeeds($feeds)
    {
        $this->feeds = $feeds;
    }

    /**
     * @return mixed
     */
    public function getFeeds()
    {
        return $this->feeds;
    }


    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->feeds[$this->position];
    }

    /**
     * Move forward to next element
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Return the key of the current element
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return isset($this->feeds[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Whether a offset exists
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->feeds[$offset]);
    }

    /**
     * Offset to retrieve
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->feeds[$offset];
    }

    /**
     * Offset to set
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->feeds[$offset] = $value;
    }

    /**
     * Offset to unset
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->feeds[$offset]);
    }

    /**
     * Count elements of an object
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        count($this->feeds);
    }

    /**
     * Seeks to a position
     * @param int $position <p>
     * The position to seek to.
     * </p>
     * @return void
     */
    public function seek($position)
    {
        $oPosition = $this->position;
        $this->position = $position;

        if (!$this->valid())
        {
            trigger_error('No position specified or is not valid position.', E_USER_WARNING);
            $this->position = $oPosition;
        }
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

}
