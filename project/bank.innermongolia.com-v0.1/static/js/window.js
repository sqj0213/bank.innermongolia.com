/**
 * 
 */

function show11(optFlag,menuID){
	if ( optFlag == 'addSubFlag')
	{

		$.XYTipsWindow({
			___title:"增加",
			___content:"iframe:/appMenu.php?opt=addSubFlag\&menuID="+menuID,
			___width:"460",
			___height:"150",
			___showbg:true,
			___drag:"___boxTitle"
	
		});
	}
	if ( optFlag == 'updFlag')
	{
		$.XYTipsWindow({
			___title:"修改",
			___content:"iframe:/appMenu.php?opt=updFlag\&menuID="+menuID,
			___width:"460",
			___height:"150",
			___showbg:true,
			___drag:"___boxTitle"
	
		});
	}
	if ( optFlag == 'delFlag')
	{
		$.XYTipsWindow({
			___title:"删除",
			___content:"iframe:/appMenu.php?opt=delFlag\&menuID="+menuID,
			___width:"460",
			___height:"150",
			___showbg:true,
			___drag:"___boxTitle"
	
		});
	}	
}