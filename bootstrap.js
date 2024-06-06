var script = document.createElement('script');
var script2 = document.createElement('script');
script.type = 'text/javascript';
script2.type = 'text/javascript';

script.src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"; 
script2.src = 'https://cdn.jsdelivr.net/npm/@floating-ui/dom@1.6.5/+esm';

document.body.appendChild(script2);  
document.body.appendChild(script);