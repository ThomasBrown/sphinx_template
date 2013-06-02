<?php

	class Template{
		private $templateFile = "";
		private $variables    = array();

		public function setTemplateFile($tpl){
			$this->templateFile = "inc/tpl/$tpl.php";
		}

		public function setVariables($vars){
			if(is_array($vars)){
				$this->variables = $vars;
			}
		}//endSetVariables

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

		public function getContentFileContent($key, $file){
			try{
				$contentFromFile = file_get_contents($file);
				$this->variables[$key] = $contentFromFile;
			} catch (Exception $ex){
				exit($ex);
			}
		}

		private function getTemplateContent(){
			if(isset($this->templateFile)){
				try{
					$template = file_get_contents($this->templateFile);
					return $template;
				} catch (Exception $ex){
					exit($ex);
				}
			} else {
				return false;
			}
		}//end getTemplateContent



	}//endTemplate

?>