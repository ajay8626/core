<?php 
class Message
{
		public function getlist($array,$LangId=1)
		{
			
			
			$im=implode("','",$array);
			$sql="SELECT tblgeneralmessage.title_key,tblgeneralmessagetranslation.title_value,tblgeneralmessagetranslation.created_date from tblgeneralmessagetranslation
			inner join tblgeneralmessage on tblgeneralmessage.id=tblgeneralmessagetranslation.general_message_id where tblgeneralmessagetranslation.lang_id=$LangId and tblgeneralmessage.title_key in ('$im')";			
			$result = mysql_query($sql);			
			$array='';
			$i = 0;
			while($row=mysql_fetch_array($result))
			{
					$array[$i]['msgKey'] = $row['title_key'];
					$array[$i]['msgValue'] = $row['title_value'];
					$i++;
			}
			
			return $array;
		}
		
}
?>