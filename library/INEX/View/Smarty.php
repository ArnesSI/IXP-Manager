<?php

class INEX_View_Smarty extends Zend_View_Abstract
{
    /**
     * Smarty object
     * @var Smarty
     */
    protected $_smarty;
    
    
    /**
     * Should we use a custom skin?
     * @var string
     */
    protected $_skin = false;

    /**
     * Constructor
     *
     * @param string $tmplPath
     * @param array $extraParams
     * @return void
     */
    public function __construct( $tmplPath = null, $extraParams = array() )
    {
        $this->_smarty = new Smarty();

        if( null !== $tmplPath )
            $this->setScriptPath( $tmplPath );

        foreach( $extraParams as $key => $value )
            $this->_smarty->$key = $value;
    }

    /**
     * Return the template engine object
     *
     * @return Smarty
     */
    public function getEngine()
    {
        return $this->_smarty;
    }


    /**
     * This is needed for {@link clearVars()} to work properly. It automatically
     * runs (PHP 5) after the "clone" operator did it's job. More descriptions
     * at {@link clearVars()} .
     *
     * @param void
     * @return void
     */
    public function __clone()
    {
		$_tpl_vars = $this->_smarty->_tpl_vars;
		$template_dir = $this->_smarty->template_dir;
		$compile_dir = $this->_smarty->compile_dir;
		$config_dir = $this->_smarty->config_dir;
		$plugins_dir = $this->_smarty->plugins_dir;

		$this->__construct();

		$this->_smarty->_tpl_vars = $_tpl_vars;
		$this->_smarty->template_dir = $template_dir;
		$this->_smarty->compile_dir = $compile_dir;
		$this->_smarty->config_dir = $config_dir;
		$this->_smarty->plugins_dir = $plugins_dir;
    }


    /**
     * Set the path to the templates
     *
     * @param string $path The directory to set as the path.
     * @return void
     */
    public function setScriptPath($path)
    {
        if (is_readable($path)) {
            $this->_smarty->template_dir = $path;
            return;
        }

        throw new Exception('Invalid path provided');
    }

    /**
     * Retrieve the current template directory
     *
     * @return string
     */
    public function getScriptPaths()
    {
        return array($this->_smarty->template_dir);
    }

    /**
     * Alias for setScriptPath
     *
     * @param string $path
     * @param string $prefix Unused
     * @return void
     */
    public function setBasePath($path, $prefix = 'Zend_View')
    {
        return $this->setScriptPath($path);
    }

    /**
     * Alias for setScriptPath
     *
     * @param string $path
     * @param string $prefix Unused
     * @return void
     */
    public function addBasePath($path, $prefix = 'Zend_View')
    {
        return $this->setScriptPath($path);
    }

    /**
     * Assign a variable to the template
     *
     * @param string $key The variable name.
     * @param mixed $val The variable value.
     * @return void
     */
    public function __set($key, $val)
    {
        $this->_smarty->assign_by_ref($key, $val);
    }

    /**
     * Retrieve an assigned variable
     *
     * @param string $key The variable name.
     * @return mixed The variable value.
     */
    public function __get($key)
    {
        return $this->_smarty->get_template_vars($key);
    }

    /**
     * Allows testing with empty() and isset() to work
     *
     * @param string $key
     * @return boolean
     */
    public function __isset($key)
    {
        return (null !== $this->_smarty->get_template_vars($key));
    }

    /**
     * Allows unset() on object properties to work
     *
     * @param string $key
     * @return void
     */
    public function __unset($key)
    {
        $this->_smarty->clear_assign($key);
    }

    /**
     * Assign variables to the template
     *
     * Allows setting a specific key to the specified value, OR passing
     * an array of key => value pairs to set en masse.
     *
     * @see __set()
     * @param string|array $spec The assignment strategy to use (key or
     * array of key => value pairs)
     * @param mixed $value (Optional) If assigning a named variable,
     * use this as the value.
     * @return void
     */
    public function assign($spec, $value = null)
    {
        if (is_array($spec)) {
            $this->_smarty->assign($spec);
            return;
        }

        $this->_smarty->assign($spec, $value);
    }


    /**
     * Clears all variables assigned to Zend_View either via {@link assign()} or property
     * overloading ({@link __get()}/{@link __set()}).
     *
     *
     * Both Zend_View_Helper_Action::cloneView() and Zend_View_Helper_Partial::cloneView()
     * executes a "$view->clearVars();" line after a "$view = clone $this->view;" . Because
     * of how the "clone" operator works internally (object references are also copied, so a
     * clone of this object will point to the same Smarty object instance as this,
     * the "$view->clearVars();" unsets all the Smarty template variables. To solve
     * this, there is the {@link __clone()} method in this class which is called by the
     * "clone" operator just after it did it's cloning job.
     *
     * If for any reason this doesn't work, neither after amending {@link __clone()}, an
     * other "solution" is in the method, but commented out.
     * That will also work, but it is relatively slow and, not nice at all. That takes a look
     * on it's backtrace, and if finds a function name
     * "cloneView" then does NOT execute Smarty's clear_all_assign().
     *
     * Or just make this an empty function if neither the above works.
     *
     * @param void
     * @return void
     */
    public function clearVars()
    {
        //if (in_array('cloneView', XXX_Utils::filterFieldFromResult(OSS_Debug::compact_debug_backtrace(), 'function', false, false)) == false) $this->_smarty->clear_all_assign();

        // barryo 20100413
        //
        // I don't think we need to do this... it's a PITA as in the form view helpers, we lose
        //    all assigned variables.
        //
        // $this->_smarty->clear_all_assign();
    }


    /**
     * Clears all variables assigned to Zend_View either via {@link assign()} or property
     * overloading ({@link __get()}/{@link __set()}).
     *
     * @param void
     * @return void
     */
    public function clear_all_assign()
    {
        $this->_smarty->clear_all_assign();
    }


    /**
     * Processes a template and returns the output.
     *
     * @param string $name The template to process.
     * @return string The output.
     */
    public function render($name)
    {
        return $this->_smarty->fetch( $this->resolveTemplate( $name ) );
    }

    /**
     * Processes a template and sends the output.
     *
     * @param string $name The template to process.
     * @return void
     */
    public function display( $name )
    {
        return $this->_smarty->display( $this->resolveTemplate( $name ) );
    }

    /**
     * Checks to see if the named template exists
     *
     * @param string $name The template to look for
     * @return boolean
     */
    public function templateExists( $name )
    {
        return $this->_smarty->template_exists( $this->resolveTemplate( $name ) );
    }
    
    /**
     * Checks to see if the named template exists in the current skin
     *
     * @param string $name The template to look for
     * @return boolean
     */
    public function skinTemplateExists( $name )
    {
        if( $this->_skin && is_readable( $this->_smarty->template_dir . '/skins/' . $this->_skin . '/' . $name ) )
            return true;
            
        return $this->templateExists( $name );
    }
    
    
    /**
     * This function "resolves" a given template name into an appropriate 
     * template file depending on whether we're using skins or not.
     * 
     * If we're using skins and if a template exists in the skin, then 
     * it'll be used. Otherwise we'll use the default templates.
     * 
     * 
     * @param string $name The name of the template to use
     * @return string The resolved template name
     */
    protected function resolveTemplate( $name )
    {
        // if we're using a skin see if a skin file exists.
        // if so, use it, otherwise use the default skin files
        if( $this->_skin && is_readable( $this->_smarty->template_dir . '/skins/' . $this->_skin . '/' . $name ) )
            return 'skins/' . $this->_skin . '/' . $name;
            
        return $name;
    }

    protected function _run()
    {
        include func_get_arg(0);
    }

    /**
     * 
     * Set the skin to use
     * @param string $s The name of the skin
     * @throws Exception
     */
    public function setSkin( $s )
    {
        // does the skin exist?
        if( is_readable( $this->_smarty->template_dir . "/skins/$s" ) )
        {
            $this->_skin = $s;
            return true;
        }
            
        throw new Exception( "Specified skin directory does not exist or is not readable ("
            . $this->_smarty->template_dir . "/skins/$s" . ")" 
        );
    }
    
    /**
     * 
     * Return the name of the skin in use or false if default.
     * @return string The name of the skin in use or false if default.
     */
    public function getSkin()
    {
        return $this->_skin;
    }
}

?>