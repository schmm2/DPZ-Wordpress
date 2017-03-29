var html = document.documentElement;

// background blend mode
if(!window.getComputedStyle(document.body).backgroundBlendMode) html.className = 'no-bblend ' + html.className;
