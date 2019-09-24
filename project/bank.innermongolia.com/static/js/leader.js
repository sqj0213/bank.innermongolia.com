/**
 * 
 */

function buildCheckbox( v1, v2, v3 )
{
	var htmlStr='';
	alert( v3 );
	for ( i=0; i< v1.length; i++ )
	{
		if ( v3.indexOf( v1[i] ) != -1 )
		{
			if ( i%8 == 0 && i != 0 )
		 		htmlStr = htmlStr+ '<input type="checkbox" name="departmentIDList[]" checked disabled value='+v1[i]+'>'+v2[i]+'&nbsp;&nbsp;<br>';
			else
		 		htmlStr = htmlStr+ '<input type="checkbox" name="departmentIDList[]" checked disabled value='+v1[i]+'>'+v2[i]+'&nbsp;&nbsp;';
		}
		else
			{
				if ( i%8 == 0 && i != 0 )
			 		htmlStr = htmlStr+ '<input type="checkbox" name="departmentIDList[]" value='+v1[i]+'>'+v2[i]+'&nbsp;&nbsp;<br>';
				else
			 		htmlStr = htmlStr+ '<input type="checkbox" name="departmentIDList[]" value='+v1[i]+'>'+v2[i]+'&nbsp;&nbsp;';
			}
	}

	document.getElementById("departmentIDListID").innerHTML=htmlStr;

}
function changeDepartment(frm)
{

	var bankID = parseInt(frm.bankID.value);
	var index= bankIDList.indexOf( bankID );
	buildCheckbox( departmentIDList[index], departmentNameList[index], filterDepartmentIDList[index] );
}
