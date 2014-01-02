<?php
	#*************************************************************************************************************
	#PLEASE DON'T REMOVE THE NAME OF Author                                                                      * 
 	#@Eng.Ibraheem Z. Abu-Kaff																					 *
	#This Work Is dedicated To My Parents & To The most beautiful girl in the entire world					 	 *
	#*************************************************************************************************************
	class IZX{
		private $XMLFileName;
		private $dom=null;
		
		
		/* Begin File Operations */
		public function IZX($XMLFileName){
			$this->dom=new DOMDocument("1.0","UTF-8");
			$this->setXMLFileName($XMLFileName);
			//echo "Established!";
		}
		//-------------------------------------------
		public function setXMLFileName($XMLFileName){
			$this->XMLFileName=$XMLFileName;	
		}
		//-------------------------------------------
		public function getXMLFileName(){
			return $this->XMLFileName;	
		}
		//-------------------------------------------
		public function createXMLFile(){
			if(! $this->getXMLFileName()){
				echo "PLEASE ENTER THE XML FILE NAME AS A PARAMETER In The Constructor!";	
			}else{
				
				$this->dom->save($this->getXMLFileName());
				return $this->dom;
			}
			return false;
		}
		//-----------------------------------------------
		public function deleteXMLFile(){
			if(! $this->getXMLFileName()){
				echo "PLEASE ENTER THE XML FILE NAME AS A PARAMETER!";	
			}else{
				unlink($this->getXMLFileName());
				return true;
			}
			return false;
		}
		//-----------------------------------------------
		public function openXMLFile(){
			if($this->dom->load($this->getXMLFileName()) ){
				//echo 'done';   
				return true;
				
			}else{
				echo "You Are Trying To Open UN-Defined XML File!";
				return false;
			}
			
		}
		//------------------------------------------------
		public function saveXMLFile(){
			if($this->dom->save($this->getXMLFileName())){
				return true;
			}else{ 
				return false;
			}
		}
		//------------------------------------------------
		/* End of File Operations */
		//**************************************************************************************************************
		
		/* Begin Elements Operations */
		
		public function insertRootElement($rootElement){
				$handle=fopen($this->getXMLFileName(),'a+');
				fwrite($handle,"<".$rootElement.">"."\n"."</".$rootElement.">");
				fclose($handle);
				return true;
			
			
		}
		//-----------------------------------------------
		//@param $name :the name of the element tag
		//@param $index:the nndex of this element cuz may be there ara more than one element has the same name!
		public function getElementTag($name,$index){
			return $this->dom->documentElement->getElementsByTagName($name)->item($index);	
		}
		//-----------------------------------------------
		public function getElementTagInnerValue($name,$index){
			return $this->dom->documentElement->getElementsByTagName($name)->item($index)->nodeValue;	
		}
		//-----------------------------------------------
		
		public function removeElementTag($name,$index){
			if($this->dom->documentElement->removeChild($this->dom->documentElement->getElementsByTagName($name)->item($index))){
				$this->saveXMLFile();
				return true;
			}else{
				return false;
			}
		}
		//-----------------------------------------------
		public function removeElementTagInnerValue($name,$index){
			$this->dom->documentElement->getElementsByTagName($name)->item($index)->nodeValue="";
			$this->saveXMLFile();
			return true;
		}
		//-----------------------------------------------
		public function updateElementTagInnerValue($name,$index,$newValue){
			$this->dom->documentElement->getElementsByTagName($name)->item($index)->nodeValue=$newValue;
			$this->saveXMLFile();
			return true;
		}
		//-----------------------------------------------
		public function createElement($tagName,$tagValue){
			return $this->dom->createElement($tagName,$tagValue);	
		}
		//--------------------------------------------------
		//@param $afterMe u can get it by using the method getElementTag($name,$index)
		public function insertElement($insertedTag,$afterMe=null){
			if($afterMe==null){
				$this->dom->documentElement->appendChild($insertedTag);
				$this->saveXMLFile();
				return true;
			}elseif($afterMe->appendChild($insertedTag)){
					$this->saveXMLFile();
					return true;
			}else{
				return false;
			}
			
		}
		//----------------------------------------------
		//@param $newEle should be coming from the method createElement
		//@param $oldEle should be coming from the getElementTag()
		public function replaceElementTag($newEle,$oldEle){
			if($this->dom->documentElement->replaceChild($newEle,$oldEle)){
				$this->saveXMLFile();
				return true;
			}else
			return false;
			
		}
		//-----------------------------------------------
		public function appendData($eleTag,$index,$appendedData){
			$txt=$this->dom->createTextNode("");
			$txt->appendData(" ".$appendedData);
			$this->getElementTag($eleTag,$index)->appendChild($txt);
			$this->saveXMLFile();
		}
		//-----------------------------------------------
			
		/* End of Elements Operations */
		//**************************************************************************************************************
		/* Begin of Attrinbute Operations */
		
		public function getAttr($ele,$index,$attr){
			return $this->getElementTag($ele,$index)->getAttribute($attr);	
		}
		//-----------------------------------------------
		public function createAttr($ele,$index,$attrName,$attrValue){
			if($this->getElementTag($ele,$index)->setAttribute($attrName,$attrValue)){
				$this->saveXMLFile();
				return true;
			}else{
				return false;	
			}
			
		}
		//------------------------------------------------
		public function updateAttr($ele,$index,$attr,$newValue){
			if($this->getElementTag($ele,$index)->setAttribute($attr,$newValue)){
				$this->saveXMLFile();
				return true;
			}else{
				return false;
			}
		}
		//------------------------------------------------
		public function removeAttr($ele,$index,$attr){
			if($this->getElementTag($ele,$index)->removeAttribute($attr)){
				$this->saveXMLFile();
				return true;
			}else{
				return false;	
			}
		}
		//------------------------------------------------
		public function formatMeAfterAllOperations(){
			$FormatedDom=new DOMDocument("1.0","UTF-8");
			$FormatedDom->load($this->getXMLFileName());
			$FormatedDom->loadXML($FormatedDom->saveXML(),LIBXML_NOBLANKS);
			$FormatedDom->formatOutput=true;
			$FormatedDom->save($this->getXMLFileName());
			return true;
			
		}
			
		/* End Of Attributes Operations */
		
	}
	//end of class...
	//********************************************************************************************************
	//checking Before Deploying!!
	
	/* This Code Is Done
		$x=new IZX();
		$x->createXMLFile('newXMLFILE.xml');
	*/
	
	/* Should be read:if u have pre-defined XML File u can only use the constructor & openXMLFile() with all methods 
		except the File Operations 
	*/
	
	// This Code is done
	//$x=new IZX("ibraheem.xml");
		/*CREATE XML WITH INSERT OPERATIONS*/
		//$x->createXMLFile();
		//$x->deleteXMLFile();
		/*$x->insertRootElement("root");
		$x->openXMLFile();
		$x->insertElement($x->createElement("PHP","MY VALUE!"));
		$x->insertElement($x->createElement("InnerPHP2","MY VALUE!21!"),$x->getElementTag('PHP',0));
		$x->insertElement($x->createElement("PHP3","MY VALUE!"));
		$x->createAttr('PHP3',0,"MYATTR","MY ATTR VALUE");
		$x->createAttr('InnerPHP2',0,"MYATTR","MY ATTR VALUE");
		$x->createAttr('PHP',0,"MYATTR","MY ATTR VALUE");
		$x->appendData('PHP',0,"APPENDED DATA!");
		$x->removeElementTag('PHP',0);
		$x->formatMeAfterAllOperations();*/
		/* END OF XML CREATION WITH ITS OPERATIONS */
						
		//echo $x->getElementTagInnerValue('first',0);
		//$x->removeElementTag('first',0);
		//$x->removeElementTagInnerValue('first',0)
		//$x->updateElementTagInnerValue('first',0,'Myvalue');
		//$x->updateElementTagInnerValue('first',0,'Myvalue2');
		//$x->insertElement($x->createElement("PHP","MY VALUE!"),$x->getElementTag('first',0));
		//$x->replaceElementTag($x->createElement("My","VALUE"),$x->getElementTag('first',0));
		//echo $x->getAttr('first',0,"at");
		//$x->createAttr('first',2,'newAttribute','attributeValue');
		//$x->updateAttr('first',2,'newAttribute','updatedOne');
		//$x->removeAttr('first',2,'newAttribute');
		//$x->appendData('first',2,"APPENDED DATA");
		

		
?>
