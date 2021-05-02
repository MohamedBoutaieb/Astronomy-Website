var el =document.querySelector('iframe');
var pic= document.querySelector('.media');
if (el){
   document.querySelector('.api').removeChild(el);
}
if (pic){
   document.querySelector('.api').removeChild(pic);
}
fetch("https://api.nasa.gov/planetary/apod?api_key=LNbZwodDvkKDpWCwWMPF1urwOnPDbO6b0N5eXoA6").then(response => response.json())
    .then(data => { str=data['url'];
       arr =['png','jpg','bmp','gif','svg']

       if (arr.includes(str.substring(str.length-3))){
          var picture= document.createElement("img");
          picture.width= "420";
          picture.height= "350";
          picture.src=str;
          document.querySelector('.api').appendChild(picture);
       }
       else {
          var frame= document.createElement("iframe");
          frame.width= "1024px";
          frame.height= "768px";
          frame.src=str;
          document.querySelector('.api').appendChild(frame);
       }



       document.querySelector('#explanation').textContent=data['explanation'];
       document.querySelector('#date').textContent='date :' +data['date'];

    })