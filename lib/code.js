var options=[
    'duck and cover',
    'use the force',
    'plunger time'
];

function help(){
    //alert("working");   
    var ron = Math.floor(Math.random() * options.length);   
    document.getElementById('doThis').innerHTML = '';
    document.getElementById('doThis').innerHTML = options[ron];
