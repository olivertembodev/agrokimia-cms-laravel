$('#tipe').on('change', function (e) {
    $('.hide').hide();
    $('#option-' + e.target.value).show();
    alert(e.target.value)
    if (e.target.value == 2) {
    	$('#is_precentage').val(0)
    } else {
    	$('#jumlah').val(0)
    }
});

// function tampilkan(){
// 	var type = document.getElementById("form1").tipe.value;
// 	if (type=="1") {
// 		document.getElementById("option-1").innerHTML="<label class='control-label'>Presentase</label><input type='number' name='is_precentage' id='is_precentage' class='form-control' value='0' placeholder=''>";
// 			} else if (type == "2") {
// 		document.getElementById("option-1").innerHTML="<div class='col-md-6 hide' id='option-2'><label class='control-label'>Jumlah</label><input type='number' name='jumlah' id='jumlah' class='form-control' value='0' placeholder=''></div><div class='form-group'><label class='control-label'>Nominal</label><input type='number' name='nominal' id='nominal' class='form-control' value='0' placeholder=''></div></div>";
// 	}
// }