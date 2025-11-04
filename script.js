$(document).ready(function(){
  $("#regForm").submit(function(){
    if($("#name").val()=="" || $("#email").val()=="" || $("#course").val()==""){
      alert("Please fill all fields");
      return false;
    }
  });
});
