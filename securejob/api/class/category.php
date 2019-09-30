<?php
class Category
{
	public function CatList($LangId,$UserId=0)
	{
			$catlist=array();
			$sqlcat="SELECT c.id as category_id, ct.title_value as title
			FROM category c
			JOIN category_translation ct ON ct.category_id = c.id
			WHERE 1 and  ct.lang_id =$LangId and c.parent_category_id='0' and c.status='Active' and c.user_id in(0,$UserId) order by title asc";			
			$result=mysql_query($sqlcat);
			
			while($row=mysql_fetch_array($result))
				{
					if($row['title']!='')
					{
						$catlist[]=array("CategoryId"=>$row['category_id'],"CategoryName"=>$row['title']);
					}
				}	
				return $catlist;		
	}
}

?>