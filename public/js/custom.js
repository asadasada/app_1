//init
window.onload = function(){
             $('#hoge').fadeIn(2000);
           $('#hoge2').fadeIn(2000);
    let tmp = this.innerWidth;
    if(tmp < 600){
        if($("#hoge").length){
         $("#hoge").removeClass("test");
         $("#hoge2").removeClass("test2");
         $("#hoge").addClass("test_s");
         $("#hoge2").addClass("test2_s");
     }
 }
}
//event
window.addEventListener("resize",function(e){
    let tmp = this.innerWidth;
    if($("#hoge").length){
        if(tmp > 600){
           $("#hoge").addClass("test");
           $("#hoge2").addClass("test2");
           $("#hoge").removeClass("test_s");
           $("#hoge2").removeClass("test2_s");
       }
       if(tmp < 600){
        $("#hoge").removeClass("test");
        $("#hoge2").removeClass("test2");
        $("#hoge").addClass("test_s");
        $("#hoge2").addClass("test2_s");
    }
}
});

