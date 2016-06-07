<?php
/**
 * stack
 * @author Johannes
 *
 */
class Stack { 
	/**
	 * stores the elements of the stack
	 * @var unknown_type
	 */
    protected $elements; 

    /**
     * construct
     */
    function __construct() { 
        $this->elements = array();
    } 
    
    /**
     * To String
     * @return string
     */
    function toString() {
    	foreach($this->elements as $e) $str .= $e->toString()."\n";
    	return $str;
    }
    
    /**
     * reverses the stack elements
     */
    function reverse() {
    	$this->elements = array_reverse($this->elements);
    }
    
    /**
     * function returns a value
     * width the given key
     */
    function get($key) {
    	return $this->elements[$key];
    }
    
    /**
     * returns the key of an element
     * @param unknown $obj
     * @return mixed
     */
    function indexOf($obj) {
    	return array_search($obj, $this->elements);
    }
    
    /**
     * removes an stack element
     * @param unknown $key
     */
    function remove($key) {
    	unset($this->elements[$key]);
    }
    
    /**
     * performs an ua sort
     * 
     * @param callable $cmpfn
     * @return boolean
     */
    function uasort($cmpfn) {
    	return uasort($this->elements, $cmpfn);
    }
    
    /**
     * push 
     * @param unknown_type $obj
     * @return number new number of elements
     */
    function push($obj) { 
        return array_push($this->elements, $obj);
    } 
    
    /**
     * pops
     * @return mixed
     */
    function pop($obj = null) { 
    	return array_pop($this->elements);
    }     
    
    /**
     * returns whether the stack is empty
     * @return boolean
     */
    function isEmpty() { 
    	return (count($this->elements) <= 0);
    } 
    
    /**
     * peeks the top element
     * @return NULL
     */
    function peek() { 
        return !$this->isEmpty()?
        	$this->elements[intval(count($this->elements)-1)]:null; 
    } 
    
    /**
     * returns the size of the stack
     * @return number
     */
    function size() { 
        return count($this->elements); 
    }   
}  
?>