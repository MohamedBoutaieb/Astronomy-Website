fetch("https://api.nasa.gov/planetary/apod?api_key=LNbZwodDvkKDpWCwWMPF1urwOnPDbO6b0N5eXoA6").then(response => response.json())
.then(data => {
   document.querySelector('iframe').src=  data['url'];
   document.querySelector('#explanation').textContent=data['explanation'];
   document.querySelector('#date').textContent='date :' +data['date'];

})

