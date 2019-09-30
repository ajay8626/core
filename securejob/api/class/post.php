<?php 
class Post
{
	
	public function PostDetails($md5,$UserId,$LangId,$TimeZone="+00:00")
	{
		global $tz;
		$SITE_URL_SHARE=SITE_URL_SHARE;
		
		$row=array();		
		$sql="SELECT post.id as PostId,post.comment as Comment,post.permission as Permission,post.created as Created,post.user_id as PostedUserId,user.name as PostedUserName,user.gender as Gender,user_profile_picture.image as PostedUserProfilePicture,user_profile_picture.image_url as PostedUserProfilePictureUrl,IFNULL( post_like_total.total_like, 0 ) AS TotalLike,IFNULL( post_comment_total.total_comment, 0 ) AS TotalComment,IFNULL(GROUP_CONCAT(DISTINCT(hashtag.hashtag) SEPARATOR  ' '),'')  AS Hashtag,GROUP_CONCAT( DISTINCT(post_photo.id),CONCAT('*INNER*',post_photo.image_url), CONCAT('*INNER*',post_photo.is_default) SEPARATOR '*JOINIMAGE*') as PostImage,(SELECT count(post_id) from post_like where post_id=post.id and user_id=$UserId) AS IsLike,(SELECT count(id) from post_comment where post_id=post.id and user_id=$UserId) AS IsComment,(SELECT count(id) FROM post_favourite where post_id=post.id and user_id=$UserId) AS IsFavCloset,GROUP_CONCAT(DISTINCT(category.id) SEPARATOR  ',') as  PostCategory,CONCAT('$SITE_URL_SHARE',post.key) as CopyLink FROM post 		
		LEFT JOIN post_like_total AS post_like_total ON post_like_total.post_id = post.id
		LEFT JOIN post_comment_total AS post_comment_total ON post_comment_total.post_id = post.id
		LEFT JOIN post_hashtag ON post_hashtag.post_id=post.id AND post_hashtag.is_fromtag='1'
		LEFT JOIN hashtag ON hashtag.id=post_hashtag.hashtag_id	
		LEFT JOIN post_photo ON post_photo.post_id=post.id
		LEFT JOIN user on user.id=post.user_id
		LEFT JOIN user_profile_picture ON user_profile_picture.user_id=post.user_id and user_profile_picture.is_profile_picture='Yes' 
		LEFT JOIN post_category ON post_category.post_id=post.id
		LEFT JOIN category ON category.id=post_category.category_id AND category.user_id=0
		WHERE 1 
		AND post.key='$md5'
		AND post.status='Active' 
		
		GROUP BY post.id
		";
		
		$qry=mysql_query($sql);
		if(mysql_num_rows($qry)>0)
		{
			
					$row=mysql_fetch_assoc($qry);			


					$row['Created']=$tz->ConvertDate($row['Created'],$TimeZone);

					if(get_tag($row['PostId'],$LangId))
					{
						$row['Comment']=$row['Comment']." ".format_tag(get_tag($row['PostId'],$LangId));
					}
					if($row['Hashtag'])
					{
						$row['Comment']=$row['Comment']." ".format_tag($row['Hashtag']);
					}
					
					$row['PostImage'] =explode_img($row['PostImage']);


					$callist=array();
					if($row['PostCategory'])
					{
						$callist=explode(",",$row['PostCategory']);
					}

					$row['PostCategory']=$callist;

					if($row['IsLike']!=0){ $row['IsLike']=1; }		
					if($row['IsComment']!=0){ $row['IsComment']=1; }		
					if($row['IsFavCloset']!=0){	$row['IsFavCloset']=1;	}	


					//$image=$row['PostedUserProfilePicture'];
					//if($image!=''){ $src=POST_IMG_URL.$image;  } 
					$image=$row['PostedUserProfilePictureUrl'];
					if($image!=''){ $src=$image;  } 
					elseif($row['Gender']==1){ $src=ADMIN_URL."img/user-Male-thumb.png"; }
					else{ $src=ADMIN_URL."img/user-Female-thumb.png"; }	
					$row['PostedUserProfilePicture']=$src;

					unset($row['Hashtag']);
					unset($row['Gender']);		
		}
		return $row;
	
} 








				public function PostDetails_new($postid,$UserId,$LangId,$TimeZone="+00:00")
	{
		global $tz;
		$SITE_URL_SHARE=SITE_URL_SHARE;
		
		$row=array();		
		$sql="SELECT post.id as PostId,post.comment as Comment,post.permission as Permission,post.created as Created,post.user_id as PostedUserId,user.name as PostedUserName,user.gender as Gender,user_profile_picture.image as PostedUserProfilePicture,user_profile_picture.image_url as PostedUserProfilePictureUrl,IFNULL( post_like_total.total_like, 0 ) AS TotalLike,IFNULL( post_comment_total.total_comment, 0 ) AS TotalComment,IFNULL(GROUP_CONCAT(DISTINCT(hashtag.hashtag) SEPARATOR  ', '),'')  AS Hashtag,GROUP_CONCAT( DISTINCT(post_photo.id),CONCAT('*INNER*',post_photo.image_url), CONCAT('*INNER*',post_photo.is_default) SEPARATOR '*JOINIMAGE*') as PostImage,(SELECT count(post_id) from post_like where post_id=post.id and user_id=$UserId) AS IsLike,(SELECT count(id) from post_comment where post_id=post.id and user_id=$UserId) AS IsComment,(SELECT count(id) FROM post_favourite where post_id=post.id and user_id=$UserId) AS IsFavCloset,GROUP_CONCAT(DISTINCT(category.id) SEPARATOR  ',') as  PostCategory,CONCAT('$SITE_URL_SHARE',post.key) as CopyLink FROM post 		
		LEFT JOIN post_like_total AS post_like_total ON post_like_total.post_id = post.id
		LEFT JOIN post_comment_total AS post_comment_total ON post_comment_total.post_id = post.id
		LEFT JOIN post_hashtag ON post_hashtag.post_id=post.id AND post_hashtag.is_fromtag='1'
		LEFT JOIN hashtag ON hashtag.id=post_hashtag.hashtag_id	
		LEFT JOIN post_photo ON post_photo.post_id=post.id
		LEFT JOIN user on user.id=post.user_id
		LEFT JOIN user_profile_picture ON user_profile_picture.user_id=post.user_id and user_profile_picture.is_profile_picture='Yes' 
		LEFT JOIN post_category ON post_category.post_id=post.id
		LEFT JOIN category ON category.id=post_category.category_id AND category.user_id=0
		WHERE 1 
		AND post.id='$postid'
		
		
		GROUP BY post.id
		";
		
		$qry=mysql_query($sql);
		if(mysql_num_rows($qry)>0)
		{
			
					$row=mysql_fetch_assoc($qry);			


					$row['Created']=$tz->ConvertDate($row['Created'],$TimeZone);
					
					$Tag='';
					
					if(get_tag($row['PostId'],$LangId))
					{
						$Tag=get_tag($row['PostId'],$LangId);
					} 
					if($row['Hashtag'])
					{  
						if(!$Tag)
						{
							$Tag .=$row['Hashtag'];
						}
						else
						{		
								if($row['Hashtag'])
								{
									$Tag .=", ".$row['Hashtag']; 
								}
						}
					} 
					
					$Tag = format_tag($Tag);
					
					$row['Tag']=$Tag;
					
					$row['PostImage'] =explode_img($row['PostImage']);


					$callist=array();
					if($row['PostCategory'])
					{
						$callist=explode(",",$row['PostCategory']);
					}

					$row['PostCategory']=$callist;

					if($row['IsLike']!=0){ $row['IsLike']=1; }		
					if($row['IsComment']!=0){ $row['IsComment']=1; }		
					if($row['IsFavCloset']!=0){	$row['IsFavCloset']=1;	}	


					//$image=$row['PostedUserProfilePicture'];
					//if($image!=''){ $src=POST_IMG_URL.$image;  } 
					$image=$row['PostedUserProfilePictureUrl'];
					if($image!=''){ $src=$image;  } 
					elseif($row['Gender']==1){ $src=ADMIN_URL."img/user-Male-thumb.png"; }
					else{ $src=ADMIN_URL."img/user-Female-thumb.png"; }	
					$row['PostedUserProfilePicture']=$src;

					//unset($row['Hashtag']);
					unset($row['Gender']);		
		}
		return $row;
	
} 

}
?>