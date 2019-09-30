<?php 
class Contest
{

	public function NextWeek($LangId=1,$TimeZone,$start,$per_page,$UserId=0)
	{
		
		
		$today=date('Y-m-d H:i:s');
		$year=date('Y');		
		$today=$this->ConvertDate($today,"+08:00");		
		
		$w=date('o-W', strtotime($today));
		$array = explode('-',$w);
		$year = $array[0];
		$week = $array[1];
		
		list($start_date, $end_date) = getWeekDates($year,$week);		
		$start_final=date('Y-m-d', strtotime($end_date. ' + 1 days'));		
		//$weeak=date('W', strtotime($start_final));		
		//$year=date('Y',strtotime($start_final));
		
		$w=date('o-W', strtotime($start_final));
		$array = explode('-',$w);
		$year = $array[0];
		$week = $array[1];
		
		list($start_date, $end_final) = getWeekDates($year,$week);		
		$end_final=$end_final." 23:59:59";				
					
			$date=date('Y-m-d H:i:s');		
					
					$msg='';
					$data=array();
					$CONTEST_IMG_URL=CONTEST_IMG_URL;
					
					$sql="SELECT fashion_contest.id as Id FROM fashion_contest
						LEFT JOIN fashion_contest_translation ON fashion_contest_translation.fashion_contest_id = fashion_contest.id
						where fashion_contest.is_deleted = '0' and fashion_contest.status='Active' and fashion_contest_translation.lang_id='$LangId'
						
						and fashion_contest.start_date >= '$start_final' and fashion_contest.end_date <= '$end_final'
						
						Group by fashion_contest.id			
						";
					$count=mysql_num_rows(mysql_query($sql));		
					
					$sql="SELECT fashion_contest.id as Id,CONCAT('$CONTEST_IMG_URL',fashion_contest.photo) as Photo, fashion_contest_translation.title as Title, fashion_contest_translation.desc as  Description,count( fashion_contest_user.user_id ) AS IsParticipated 
					FROM fashion_contest
						LEFT JOIN fashion_contest_translation ON fashion_contest_translation.fashion_contest_id = fashion_contest.id
						LEFT JOIN fashion_contest_user ON fashion_contest_user.fashion_contest_id=fashion_contest.id and fashion_contest_user.user_id='$UserId'
						where fashion_contest.is_deleted = '0' and fashion_contest.status='Active' and fashion_contest_translation.lang_id='$LangId' 
						and fashion_contest.start_date >= '$start_final' and fashion_contest.end_date <= '$end_final'
						
						
						Group by fashion_contest.id
						LIMIT $start,$per_page
						";
								
					
					$qry=mysql_query($sql);
					if(mysql_num_rows($qry)>0)
					{
						while($row=mysql_fetch_assoc($qry))
						{
							$row['contestImage'] = getContestImage($row['Id']);
							$data[]=$row;
						}
					
					}
					else
					{
						$msg=get_msg("no_next_week_contest",$LangId);
						
					}
					
					
					
					$my_array=array("ContestList"=>$data,"Message"=>$msg,"TotalRecords"=>$count);		
								
					return $my_array;
					
	}
	
	
	
	
	
	public function CurrentWeek($LangId,$TimeZone,$start,$per_page,$UserId)
	{
		//no_currnt_week_contest
		
		
		$today=date('Y-m-d H:i:s');
		//$year=date('Y');		
		$today=$this->ConvertDate($today,"+08:00");		
		
		//$weeak=date('W', strtotime($today));
		
		$w=date('o-W', strtotime($today));
		$array = explode('-',$w);
		$year = $array[0];
		$week = $array[1];
		
		
		
		list($start_final, $end_final) = getWeekDates($year,$week);		
		
		
		
		$end_final=$end_final." 23:59:59";				
					
			$date=date('Y-m-d H:i:s');		
					
					$msg='';
					$data=array();
					$CONTEST_IMG_URL=CONTEST_IMG_URL;
					
					$sql="SELECT fashion_contest.id as Id FROM fashion_contest
						LEFT JOIN fashion_contest_translation ON fashion_contest_translation.fashion_contest_id = fashion_contest.id
						where fashion_contest.is_deleted = '0' and fashion_contest.status='Active' and fashion_contest_translation.lang_id='$LangId'
						and fashion_contest.start_date >= '$start_final' and fashion_contest.end_date <= '$end_final'
						Group by fashion_contest.id			
						";
					$count=mysql_num_rows(mysql_query($sql));		
					
					$sql="SELECT fashion_contest.id as Id,CONCAT('$CONTEST_IMG_URL',fashion_contest.photo) as Photo, fashion_contest_translation.title as Title, fashion_contest_translation.desc as  Description
					FROM fashion_contest
						LEFT JOIN fashion_contest_translation ON fashion_contest_translation.fashion_contest_id = fashion_contest.id
						where fashion_contest.is_deleted = '0' and fashion_contest.status='Active' and fashion_contest_translation.lang_id='$LangId' 
						and fashion_contest.start_date >= '$start_final' and fashion_contest.end_date <= '$end_final'
						
						
						Group by fashion_contest.id
						LIMIT $start,$per_page
						";
								
					
					$qry=mysql_query($sql);
					if(mysql_num_rows($qry)>0)
					{
						while($row=mysql_fetch_assoc($qry))
						{
							$row['contestImage'] = getContestImage($row['Id']);
							$data[]=$row;
						}
					
					}
					else
					{
						$msg=get_msg("no_currnt_week_contest",$LangId);
						
					}
					
					
					
					$my_array=array("ContestList"=>$data,"Message"=>$msg,"TotalRecords"=>$count);		
								
					return $my_array;
		
		
		
		
		
	}
	public function PriviousWeek($LangId,$TimeZone,$start,$per_page,$UserId,$Search)
	{
		$filter='';		
		if($Search!='')
		{
			$filter .=" AND  (fashion_contest_translation.title LIKE '%$Search%' OR fashion_contest_translation.desc LIKE '%$Search%') "; 
		}
		
		
		
		
		
		//no_previos_week_contest
		 
		$today=date('Y-m-d H:i:s');
		//$year=date('Y');		
		$today=$this->ConvertDate($today,"+08:00");		
		
		//$weeak=date('W', strtotime($today));
		
		$w=date('o-W', strtotime($today));
		$array = explode('-',$w);
		$year = $array[0];
		$week = $array[1];
		
		
		
		list($start_date, $end_date) = getWeekDates($year,$week);	
			
		$end_final=date('Y-m-d', strtotime($start_date. ' - 1 days'));		
		//$weeak=date('W', strtotime($end_final));
		//$year=date('Y',strtotime($end_final));
		
		$w=date('o-W', strtotime($end_final));
		$array = explode('-',$w);
		$year = $array[0];
		$week = $array[1];
		
		
		
		
		list($start_final, $end_final) = getWeekDates($year,$week);		
		$end_final=$end_final." 23:59:59";
		
		$date=date('Y-m-d H:i:s');		
					
					$msg='';
					$data=array();
					$CONTEST_IMG_URL=CONTEST_IMG_URL;
					
					//fashion_contest.start_date >= '$start_final' and  Remove
					
					$sql="SELECT fashion_contest.id as Id FROM fashion_contest
						LEFT JOIN fashion_contest_translation ON fashion_contest_translation.fashion_contest_id = fashion_contest.id
						WHERE 1 $filter and fashion_contest.is_deleted = '0' and fashion_contest.status='Active' and fashion_contest_translation.lang_id='$LangId'
						and  fashion_contest.end_date <= '$end_final'
						Group by fashion_contest.id			
						";
					$count=mysql_num_rows(mysql_query($sql));		
					
					
					//fashion_contest.start_date >= '$start_final' and  remove 
					$sql="SELECT fashion_contest.id as Id,CONCAT('$CONTEST_IMG_URL',fashion_contest.photo) as Photo, fashion_contest_translation.title as Title, fashion_contest_translation.desc as  Description
					FROM fashion_contest
						LEFT JOIN fashion_contest_translation ON fashion_contest_translation.fashion_contest_id = fashion_contest.id
						WHERE 1 $filter and
						fashion_contest.is_deleted = '0' and fashion_contest.status='Active' and fashion_contest_translation.lang_id='$LangId' 
						and  fashion_contest.end_date <= '$end_final'
						
						
						Group by fashion_contest.id
						LIMIT $start,$per_page
						";
								
					
					$qry=mysql_query($sql);
					if(mysql_num_rows($qry)>0)
					{
						while($row=mysql_fetch_assoc($qry))
						{
							$row['contestImage'] = getContestImage($row['Id']);
							$data[]=$row;
						}
					
					}
					else
					{
						$msg=get_msg("no_previos_week_contest",$LangId);
						
					}				
					
					
					$my_array=array("ContestList"=>$data,"Message"=>$msg,"TotalRecords"=>$count);		
					return $my_array;
		
		
	}
	
	public function MyEntries($LangId,$TimeZone,$start,$per_page,$UserId)
	{
			
		//$today=$this->ConvertDate($today,"+08:00");		
		
		
					
					$msg='';
					$data=array();
					$CONTEST_IMG_URL=CONTEST_IMG_URL;
					
					$sql="SELECT fashion_contest_user.id as Id FROM fashion_contest_user
						
						LEFT JOIN fashion_contest ON fashion_contest.id=fashion_contest_user.fashion_contest_id
						LEFT JOIN fashion_contest_translation ON fashion_contest_translation.fashion_contest_id = fashion_contest.id
						where fashion_contest.is_deleted = '0' and fashion_contest.status='Active' and fashion_contest_translation.lang_id='$LangId' and fashion_contest_user.user_id=$UserId
						
						Group by fashion_contest_user.id			
						";
					$count=mysql_num_rows(mysql_query($sql));		
					
					$sql="SELECT fashion_contest.id as Id,fashion_contest_translation.title as Title, fashion_contest_translation.desc as  Description,fashion_contest_user.total_vote as TotalVote,GROUP_CONCAT( DISTINCT(post_photo.id),CONCAT('*INNER*',post_photo.image_url), CONCAT('*INNER*',post_photo.is_default) SEPARATOR '*JOINIMAGE*') as PostImage
					FROM fashion_contest_user
					
						LEFT JOIN fashion_contest ON fashion_contest.id=fashion_contest_user.fashion_contest_id
						LEFT JOIN fashion_contest_translation ON fashion_contest_translation.fashion_contest_id = fashion_contest.id
						LEFT JOIN post_photo ON post_photo.post_id=fashion_contest_user.post_id
						where fashion_contest.is_deleted = '0' and fashion_contest.status='Active' and fashion_contest_translation.lang_id='$LangId' 				and fashion_contest_user.user_id=$UserId
						
						Group by fashion_contest_user.id 
						order by fashion_contest_user.id desc
						LIMIT $start,$per_page
						";
								
					
					$qry=mysql_query($sql);
					if(mysql_num_rows($qry)>0)
					{
						while($row=mysql_fetch_assoc($qry))
						{
							$PostImageArray =explode_img($row['PostImage']);
							
							$row=array_merge($row,array("PostImage"=>$PostImageArray));
							
							$data[]=$row;
						}
					
					}
					else
					{
						$msg=get_msg("no_entry_found",$LangId);
						
					}
					
					
					
					$my_array=array("ContestList"=>$data,"Message"=>$msg,"TotalRecords"=>$count);		
								
					return $my_array;
		
	}
	
	
	
	public function Entry($ContestId,$LangId,$TimeZone,$start,$per_page,$UserId)
	{
			$msg='';
			$data=array();	
	
			$sql="
			SELECT fashion_contest_user.id  FROM fashion_contest_user
			LEFT JOIN post ON post.id=fashion_contest_user.post_id
			LEFT JOIN user ON user.id=post.user_id

			WHERE user.status='Active' and post.status='Active'
			and fashion_contest_user.fashion_contest_id=$ContestId	

			group by fashion_contest_user.id		
			";

			$count=mysql_num_rows(mysql_query($sql));

			$POST_IMG_URL=POST_IMG_URL;

			$sql="
			SELECT fashion_contest_user.id as ParticipateId, fashion_contest_user.user_id as PostedUserId, user.name as PostedUserName,user.gender as Gender,fashion_contest_user.post_id as PostId, CONVERT_TZ(post.created,'+00:00','$TimeZone') as Created,count(fashion_contest_user_vote.user_id) as IsVote,group_concat(post_photo.id,CONCAT('$@_@$',post_photo.image_url), CONCAT('$@_@$',post_photo.is_default)  SEPARATOR ' @|@ ' ) as PostImage,fashion_contest_user.total_vote as TotalVote,user_profile_picture.image as PostedUserProfilePicture,user_profile_picture.image_url as PostedUserProfilePictureUrl FROM fashion_contest_user
			LEFT JOIN post ON post.id=fashion_contest_user.post_id
			LEFT JOIN user ON user.id=post.user_id
			LEFT JOIN post_photo ON post_photo.post_id=post.id
			LEFT JOIN fashion_contest_user_vote ON fashion_contest_user_vote.fashion_contest_user_id=fashion_contest_user.id and fashion_contest_user_vote.user_id=$UserId
			LEFT JOIN user_profile_picture ON user_profile_picture.user_id=post.user_id and user_profile_picture.is_profile_picture='Yes' 
			WHERE user.status='Active' and post.status='Active'
			and fashion_contest_user.fashion_contest_id=$ContestId	
			group by fashion_contest_user.id		
			";
			
			
			$qry=mysql_query($sql);
					if(mysql_num_rows($qry)>0)
					{
						while($row=mysql_fetch_assoc($qry))
						{
							$PostImageArray=array();
							
							if($row['PostImage'])
							{									
								$image = explode("@|@",$row['PostImage']);
								foreach($image as $img)
								{ 
									
									$img = explode("$@_@$",$img);									
									$PostImageArray[]=array("ImageId"=>$img[0],"Image"=>$img[1],"IsDefault"=>$img[2]);
									
								}
							}
							
							//PostId
							
							$tag=get_tag($row['PostId']);
							if($tag)
							{
								$t=tag_hashtag($row['PostId']);
									if($t)
									{										
										$tag .=", ".$t;
									}
							}
							else
							{
									$tag .=tag_hashtag($row['PostId']);
							} 
							$tag = format_tag($tag);
							
								//$image=$row['PostedUserProfilePicture'];
								
								//if($image!=''){ $src=POST_IMG_URL.$image;  } 
								
								$image=$row['PostedUserProfilePictureUrl'];
								
								if($image!=''){ $src=$image;  } 
								elseif($row['Gender']==1){ $src=ADMIN_URL."img/user-Male-thumb.png"; }
								else{ $src=ADMIN_URL."img/user-Female-thumb.png"; }
							
							
							$row=array_merge($row,array("PostImage"=>$PostImageArray,"PostedUserProfilePicture"=>$src,"Tag"=>$tag));
							
							
							
							$data[]=$row;
						}
					
					}
					else
					{
						$msg=get_msg("no_entry_found",$LangId);
						
					}
			
				$my_array=array("ParticipateList"=>$data,"Message"=>$msg,"TotalRecords"=>$count);							
				return $my_array;
			
	}
	
	
	
	
	
	
	
	
	function ConvertDate($Date,$Timezone)
	{
		
		$strsign=substr($Timezone,0,1);
		$h=$strsign.substr($Timezone,1,2)." hours "; 
		$m=$strsign.substr($Timezone,4,2)." minutes";
		$final=$h.$m;
		
			$temp= strtotime("$Date $final");
			$convert = date('Y-m-d H:i:s',$temp); 
			
		return $convert;
	}
	
	
public function Winnwer($ContestId,$total_winners,$start,$per_page,$TimeZone,$LangId=1,$UserId)
{
	$prize=get_msg("prize",$LangId);
	$string='';
		for($i=1;$i<=$total_winners;$i++)
		{
					if($i==$total_winners) 
					{
						$string .=$i; 	
					}
					else
					{
						$string .=$i.","; 	
						
					}
		}
	
		$sql="SELECT general_message.title_key,general_message_translation.title_value FROM general_message 
		INNER JOIN general_message_translation ON general_message_translation.general_message_id=general_message.id
		WHERE 1 and general_message.title_key in ($string) and general_message_translation.lang_id=$LangId		
		";
	$messagelist=array();	
	$qry=mysql_query($sql);
	while($row=mysql_fetch_array($qry))
	{
			$messagelist[$row['title_key']]=$row['title_value'];
	}
	
	
	
	$msg='';
	$data=array();	
	$qry=mysql_query("SELECT 	
	fashion_contest_user.id FROM fashion_contest_user 
	LEFT JOIN user on user.id=fashion_contest_user.user_id
	LEFT JOIN post ON post.id=fashion_contest_user.post_id	
	WHERE fashion_contest_user.fashion_contest_id='$ContestId' 
	AND user.status='Active'
	AND post.status='Active'
	group by fashion_contest_user.id
	order by fashion_contest_user.total_vote desc
	limit 0,$total_winners 
	");
	
	
	 $total_records=mysql_num_rows($qry);
	$POST_IMG_URL=POST_IMG_URL;
	$SITE_URL_SHARE=SITE_URL_SHARE;
	 $sql="SELECT user.id as PostedUserId, user.name as PostedUserName,post.id as PostId,user_profile_picture.image AS PostedUserProfilePicture, user_profile_picture.image_url AS PostedUserProfilePictureUrl, user.gender as Gender,CONVERT_TZ(post.created,'+00:00','$TimeZone') as Created,group_concat(post_photo.id,CONCAT('$@_@$',post_photo.image_url), CONCAT('$@_@$',post_photo.is_default)  SEPARATOR ' @|@ ' ) as PostImage, fashion_contest_user.total_vote as TotalVote,CONCAT('$SITE_URL_SHARE',post.key) as CopyLink,(SELECT count(post_id) from post_like where post_id=post.id and user_id=$UserId) AS IsLike,(SELECT count(id) from post_comment where post_id=post.id and user_id=$UserId) AS IsComment,(SELECT count(id) FROM post_favourite where (post_id=post.id or post_id in (select p.id from post as p where p.reference_id=post.id )) and user_id=$UserId) AS IsFavCloset,IFNULL(post.comment,'') as Comment,IFNULL( post_like_total.total_like, 0 ) AS TotalLike,IFNULL( post_comment_total.total_comment, 0 ) AS TotalComment,GROUP_CONCAT(DISTINCT(category.id) SEPARATOR  ',') as  PostCategory

	FROM fashion_contest_user 
	LEFT JOIN post ON post.id=fashion_contest_user.post_id	
	LEFT JOIN user on user.id=post.user_id
	LEFT JOIN post_photo ON post_photo.post_id=post.id
	LEFT JOIN user_profile_picture ON user_profile_picture.user_id=post.user_id and user_profile_picture.is_profile_picture='Yes' 
	LEFT JOIN post_like_total AS post_like_total ON post_like_total.post_id = post.id		
	LEFT JOIN post_comment_total AS post_comment_total ON post_comment_total.post_id = post.id	
	LEFT JOIN post_category ON post_category.post_id=post.id
	LEFT JOIN category ON category.id=post_category.category_id AND category.user_id=0
	
	WHERE fashion_contest_user.fashion_contest_id='$ContestId' 
	
	
	AND user.status='Active'
	AND post.status='Active'
	group by fashion_contest_user.id
	order by fashion_contest_user.total_vote desc
	limit 0,$total_winners";

		$qry=mysql_query($sql);
					if(mysql_num_rows($qry)>0)
					{
						$i=1;
						while($row=mysql_fetch_assoc($qry))
						{
							
							
							
							
							$tag=get_tag($row['PostId']);
							if($tag)
							{
								$t=tag_hashtag($row['PostId']);
									if($t)
									{
										$tag .=", ".$t;
										
									}
							}
							else
							{
									$tag .=tag_hashtag($row['PostId']);
							} 
							
							$tag = format_tag($tag);
							
							
							
							$PostImageArray=array();
							
							if($row['PostImage'])
							{									
								$image = explode("@|@",$row['PostImage']);
								foreach($image as $img)
								{
									
									$img = explode("$@_@$",$img);									
									$PostImageArray[]=array("ImageId"=>$img[0],"Image"=>$img[1],"IsDefault"=>$img[2]);
									
								}
							}
							
								if($messagelist[$i])
								{
										$PrIzeV=$messagelist[$i];
								}
								else 
								{
									$PrIzeV=$this->ordinal_suffix($i)." $prize";
								}
							
							
							$row=array_merge($row,array("PostImage"=>$PostImageArray,"Prize"=>$PrIzeV,"Tag"=>$tag));
							
							
							//$image=$row['PostedUserProfilePicture']; 
							//if($image!=''){ $src=POST_IMG_URL.$image;  } 
							$image=$row['PostedUserProfilePictureUrl']; 
							if($image!=''){ $src=$image;  } 
							elseif($row['Gender']==1){ $src=ADMIN_URL."img/user-Male-thumb.png"; }
							else{ $src=ADMIN_URL."img/user-Female-thumb.png"; }
									
							$row=array_merge($row,array("PostedUserProfilePicture"=>$src));
							
							if($row['IsComment'])
							{
								$row['IsComment']=1;
							}
							
						//	$callist=array();
							if($row['PostCategory'])
							{
								$row['PostCategory']=explode(",",$row['PostCategory']);
							}
							else 
							{
								$row['PostCategory']=array();
							}
							
						//	"CopyLink"=>$postrow['key']
							
							
							$data[]=$row;
							$i++;
						}
					
					}
					else
					{
						$msg=get_msg("no_winner_found",$LangId);
						
						
					}
			
				$my_array=array("WinnerList"=>$data,"Message"=>$msg,"TotalRecords"=>$total_records);							
				return $my_array;
	
}  
	
	function ordinal_suffix($num){
    $num = $num % 100; // protect against large numbers
    if($num < 11 || $num > 13){
         switch($num % 10){
            case 1: return $num.'st';
            case 2: return $num.'nd';
            case 3: return $num.'rd';
        }
    }
    return $num.'th';
} 
	
}
?>