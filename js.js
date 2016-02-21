window.onload = function (evt) {
    
    document.styleSheets[1].disabled = true;
    
    //positioning posts    
    
    var post = [], i, id;
    for(i = 0; i < 100; i++) {
        id = 'p' + i;
        if(document.getElementById(id)===null){
            break;
        }
        post[i]=document.getElementById(id);
        var string = document.getElementById(id).getElementsByTagName("p")[0].innerHTML;
        document.getElementById(id).getElementsByTagName("p")[0].innerHTML = string.substring(0, 100) + ' ...';
        document.getElementById(id).getElementsByTagName("p")[1].innerHTML = string;
    }
    Array.prototype.min = function() {
      return Math.min.apply(null, this);
    };
    function style(){
        var clums = [], 
            colls = Math.floor(window.innerWidth/210);
        for(i = 0; i < colls; i++) {
            clums[i] = 100;
        }
        var k, obj,
            wW = window.innerWidth - 10;
        for(i = 0; i <post.length; i++) {
            id = 'p' + i;
            k = clums.indexOf(clums.min());
            obj = document.getElementById(id).style;
            obj.position = "absolute";
            obj.top = clums[k] + 'px';
            obj.width = (wW-30*colls)/colls + 'px';
            obj.left = (wW/colls)*k + 20 + 'px';
            clums[k] += post[i].offsetHeight + 20;
        }
    }
    $(window).resize(function(){
        style();
    });
    style();
};
