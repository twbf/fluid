window.onload = function(evt) {
    
    function getHeight(){
        var post = document.getElementById('post');
        
    }
    var postWhole = [document.getElementById('post')];
    var post = new Array();
    for(i=0; i<postWhole.length; i++) {
        post[i] = postWhole.pop();
    }
    window.alert(post[1].offsetHeight);
}
