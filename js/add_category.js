function checkValidation()
{
	 
	if(document.getElementById('category_name').value=="")
	{
		alert("Please Add Category Name.!");
		 
		document.getElementById('category_name').focus();		 
		return false;
	}
	if(document.getElementById('category_image').value=="")
	{
		alert("Please Select Category image.!");
		 
		document.getElementById('category_image').focus();		 
		return false;
	}
	return true;
} 
function editValidation()
{
	 
	if(document.getElementById('category_name').value=="")
	{
		alert("Please Add Category Name.!");
		 
		document.getElementById('category_name').focus();		 
		return false;
	}
		 
	return true;
}