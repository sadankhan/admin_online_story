function checkValidation()
{
	 
	 
	if(document.getElementById('category_id').value=="")
	{
		alert("Please Select Category.!");
		 
		document.getElementById('category_id').focus();		 
		return false;
	}
	if(document.getElementById('story_title').value=="")
	{
		alert("Please add story title.!");
		 
		document.getElementById('story_title').focus();		 
		return false;
	}
	if(document.getElementById('story_image').value=="")
	{
		alert("please select story image");
		
		document.getElementById('story_image').focus();
		return false;
	}
	if(document.getElementById('story_description').value=="")
	{
		alert("Please add story description");
		
		document.getElementById('story_description').focus();
		return false;
	}
	return true;
} 
function editValidation()
{
	 
	if(document.getElementById('category_id').value=="")
	{
		alert("Please select Category !");
		 
		document.getElementById('category_id').focus();		 
		return false;
	}
	if(document.getElementById('story_title').value=="")
	{
		alert("Please select story title");
		
		document.getElementById('story_title').focus();
		return false;
	}
	if(document.getElementById('story_description').value=="")
	{
	  alert("please add story description")
;
		document.getElementById('story_description').focus();
		return false;
		}
		 
	return true;
}