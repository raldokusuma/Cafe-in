function ajaque(){
$.ajax({url: "saji-re.php", success: function(result){
        
        // $("#div1").html(result);
        data = JSON.parse(result);
        //console.log(result);
        if(data.length)
        {
           $("#theb").html(""); 
        }
        else
        {
            $("#theb").html("<tr><td colspan='6' style='text-align:center;border-bottom:#F0F0F0 1px solid;color: black;'>Tidak ada data</td></tr>");
        }
        
        for (var i = data.length - 1; i >= 0; i--) {
          var dom='<tr>\
                    <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black">'+data[i].order_id+'</td>\
                    <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black">'+data[i].person_id+'</td>\
                    <td style="text-align:left;border-bottom:#F0F0F0 1px solid; color: black"><strong>'+data[i].Nama+'</strong></td>\
                    <td style="text-align:right;border-bottom:#F0F0F0 1px solid; color: black">'+data[i].order_date+'</td>\
                    <td style="text-align:left;border-bottom:#F0F0F0 1px solid; color: black"><strong>'+data[i].quantity+'</strong></td>\
                    <td style="text-align:center;border-bottom:#F0F0F0 1px solid;"><a id="btnEmpty" href="saji.php?order_id='+data[i].order_id+'&product_id='+data[i].product_id+'" class="btnRemoveAction">Sajikan</a></td>\
                </tr>';
                 $("#theb").append(dom);
        }
}});

}

// ajaque();
var myVar = setInterval(ajaque, 3000);