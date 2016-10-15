<?php 
function formatTelephoneNumber($tel){
	if(isset($tel) AND !empty($tel)){
	$nb = strlen($tel);
	if($nb == 9){
	 return ("224" . $tel) ;
	}else if($nb > 9 and $nb <= 14 ) {
	  if(preg_match("#^00224[0-9]{9}#",$tel)){
	  str_replace("00","",$tel);
	  str_replace("+","",$tel);
	  return $tel;
	}else return "";
  }else return "";
 }else return "";
}//fct

?>
