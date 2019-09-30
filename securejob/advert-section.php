<div class="col-xs-12 col-md-2 stj_brc">
				<ul>
				 <?php 
				 
				 
						 $advert=mysql_query("select advert_id,title,description,image,link from tbladvert where status=1 and start_date <= '".date('Y-m-d')."' and end_date >= '".date('Y-m-d')."' order by advert_id desc LIMIT 3");
						 $rowscn=mysql_num_rows($advert);
						 if($rowscn > 0)
						 {
							 while($advertdata=mysql_fetch_array($advert))
							 {
								 $link='';
								 if($advertdata['link']!='')
								 {
									 $link=$advertdata['link'];
								 }
						 ?>
						 <li><a href="<?php echo $link; ?>"><img src="<?php echo ADVERT_IMG_URL.$advertdata['image']; ?>" alt=""/></a></li>
						 <?php 
							 }
						 }
						 else
						 {
						 ?>	 
				 
					
					<?php } ?>
				</ul>
			</div>