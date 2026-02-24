let xml;
let token;
if(window.XMLHttpRequest){
    xml     = new XMLHttpRequest();
    token   = document.querySelector('meta[name=csrf-token]').content;
}else{
    xml     = new ActiveXObject("MICROSOFT.XMLHTTP");
    token   = document.querySelector('meta[name=csrf-token]').content;
}