$('.message a').click(function(){
    $('form').animate({height:"toggle", opacity: "toggle"},"slow");
});
var pass = document.querySelector("#pswrd");
var confirme = document.querySelector("#confirmPass");
function invalid(event){
    if(  event.target.value.length <8  && pass.className!="form-control is-invalid") {
        pass.className="form-control is-invalid";
        document.querySelector("#warning").textContent="password must contain at least 8 characters";
    
     
  }
  
  else if (  event.target.value.length >=8  && pass.className=="form-control is-invalid") {
        pass.className="form-control";
        document.querySelector("invalid-feedback").textContent="" ; }
}
function match (event){
  if (pass.value!= event.target.value && event.target.className!="form-control is-invalid")
  {
    event.target.className="form-control is-invalid";
    document.querySelector("#conf").textContent="passwords do not match";
  }
  else if (pass.value== event.target.value && event.target.className!="form-control is-valid")
  {
    event.target.className="form-control is-valid";
  }


}
pass.addEventListener("input",invalid);
confirme.addEventListener("input",match);
var lastScrollTop=0;
var nav = document.querySelector("header");
window.addEventListener("scroll",function(){
  var scrollTop=window.pageYOffset || document.documentElement.scrollTop;
  if (scrollTop> lastScrollTop){
    nav.style.top="-300px";
  }
  else{ nav.style.top="0px";}
  lastScrollTop=scrollTop;
})
