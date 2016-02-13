window.onload = function (evt) {
    var post = [];
    var clums = [];
    for(i = 0; i < 100; i++) {
        var p = 'p';
        var id = p.concat(i);;
        post[i]=document.getElementById(id);
    }
    var colls = 5;
    
    for(i = 0; i < colls; i++) {
        clums[i] = 95;
    }
    Array.prototype.min = function() {
      return Math.min.apply(null, this);
    };
    for(j = 0; j <13; j++) {
        p = 'p';
        id = p.concat(j);
        var clumIndex = clums.indexOf(clums.min());
        var obj = document.getElementById(id);
        var collom = clumIndex;
        obj.style.position = "absolute";
        obj.style.top = clums[collom] + 'px';
        obj.style.width = '200px';
        obj.style.left = collom*225 +10+ 'px';
        window.alert(collom);
        post[j]['coll'] = clumIndex;
        clums[clumIndex] += post[j].offsetHeight + 10;
        
    }
}
