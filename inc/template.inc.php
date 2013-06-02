<?php

class Template{
    private $templateFile = "";
    private $variables    = array();
    protected $baseTemplatePath;

    /**
     * @param string $templateFile (optional)
     * @param array $variables (optional)
     */
    public function __construct( $templateFile = '', $variables = array() ){
        if( $templateFile ) $this->setTemplateFile( $templateFile );
        if( $variables ) $this->setVariables( $variables );

        $this->setBaseTemplatePath( 'inc/tpl/');
    }

    /**
     * @param $path
     * @return $this
     */
    public function setBaseTemplatePath( $path ){
        $this->baseTemplatePath = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseTemplatePath(){
        return $this->baseTemplatePath;
    }

    /**
     * @param $tpl
     * @return $this
     */
    public function setTemplateFile($tpl){
        $this->templateFile = "$tpl.php";

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateFile(){
        return $this->templateFile;
    }

    /**
     * @param array $vars
     * @return $this
     */
    public function setVariables(array $vars){
        if(is_array($vars)){
            $this->variables = $vars;
        }

        return $this;
    }//endSetVariables

    /**
     * @return array
     */
    public function getVariables(){
        return $this->variables;
    }

    /**
     *
     */
    public function render(){
        $content = $this->getTemplateContent();
        if($content !== false){
            foreach ($this->variables as $key => $value) {
                $content = preg_replace("/{{".$key."}}/", $value, $content);
            }
        } else {
            exit("Houston, we borked the template.");
        }
        echo $content;
    }//endRender

    /**
     * @param $variable
     * @param $templateFile
     * @param bool $isOutsideOfBaseTemplatePath (optional)
     * @return $this
     */
    public function setVariableFromTemplate( $variable, $templateFile, $isOutsideOfBaseTemplatePath = FALSE ){
        if( preg_match( '#.*\.php$#i', $templateFile ) !== 0 ) $isOutsideOfBaseTemplatePath = TRUE;

        try{
            ob_start();
            include $isOutsideOfBaseTemplatePath ? $templateFile : $this->baseTemplatePath.$templateFile.'.php';
            $this->variables[$variable] = ob_get_clean();
        } catch (Exception $ex){

            exit($ex);
        }

        return $this;
    }

    /**
     * @param array $templates
     * @return $this
     */
    public function setVariablesFromTemplates( array $templates ){
        foreach( $templates as $variable => $templateFile ){
            $this->setVariableFromTemplate( $variable, $templateFile );
        }

        return $this;
    }

    /**
     * @return bool|string
     */
    private function getTemplateContent(){
        if(isset($this->templateFile)){
            try{
                ob_start();
                include $this->baseTemplatePath.$this->templateFile;
                $template = ob_get_clean();
                return $template;
            } catch (Exception $ex){
                exit($ex);
            }
        } else {
            return false;
        }
    }//end getTemplateContent

    /**
     * @param string $templateFile
     * @param array $variables
     * @return Template
     */
    public static function factory( $templateFile = '', $variables = array() ){
        return new self( $templateFile, $variables );
    }

}//endTemplate