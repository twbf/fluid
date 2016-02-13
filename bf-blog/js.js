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
    for(i = 0; i < colls; i++) {
        post[i]['coll'] = i;
        clums[i]=post[i].offsetHeight;
        p = 'p';
        id = p.concat(i);
        
        var obj = document.getElementById(id);
        var collom = post[i]['coll'];
        obj.style.position = "absolute";
        obj.style.width = '190px';
        obj.style.left = collom*225 + 'px';
        window.alert(collom);
    }
    Array.prototype.min = function() {
      return Math.min.apply(null, this);
    };
    for(j = colls; j <13; j++) {
        p = 'p';
        id = p.concat(j);
        var clumIndex = clums.indexOf(clums.min());
        var obj = document.getElementById(id);
        var collom = clumIndex;
        obj.style.position = "absolute";
        obj.style.top = clums[collom] + 'px';
        obj.style.width = '190px';
        obj.style.left = collom*225 + 'px';
        window.alert(collom);
        post[j]['coll'] = clumIndex;
        clums[clumIndex] += post[j].offsetHeight;
        
    }
    
    var i = 0;
    while(i < 12){
        
        
        i++;
        if(!document.getElementById(id)){
            i = 130;
        }
        //window.alert(clums[3]);
    }
   // document.getElementById("p2").style.position = "absolute";
}
