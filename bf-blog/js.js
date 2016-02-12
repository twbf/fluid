window.onload = function (evt) {
    var post = [];
    var clums = [];
    for(i = 0; i < 100; i++) {
        var p = 'p';
        var id = p.concat(i);
        //post[i] = new Array(2);
        post[i]=document.getElementById(id);
    }
    
    var colls = 5;
    for(i = 0; i < colls-1; i++) {
        post[i]['coll'] = i;
        clums[i]=post[i].offsetHeight;
        window.alert(clums[i]);
    }
    var counter = 0;
    for(j = colls; j < 100; j++) {
        post[j]['coll'] = counter;
        clums[counter] += post[i].offsetHeight;
        window.alert(clums[counter]);
        counter++;
        if(counter>4){
            counter=0;
        }
    }
    
    var i = 0;
    while(i < 100){
        p = 'p';
        id = p.concat(i);
        
        document.getElementById(id).style.position = "absolute";
        
        i++;
        if(!document.getElementById(id)){
            i = 130;
        }
        //window.alert(clums[3]);
    }
   // document.getElementById("p2").style.position = "absolute";
}
