<script>
$(document).ready(function(){
	$("#numClasses").change(function(){
		$("#classesForEachAdmin").empty();
		for(var i = 0; i < $("#numClasses").val(); i++){
			$("#classesForEachAdmin").append($("#classTemplate").html());
		}
	});
});
</script>



		<div class="input-group" style="margin-bottom:10px">
			<span class="input-group-addon">First Name</span>
			<input class="form-control" type="text" />
		</div>
		<div class="input-group" style="margin-bottom:10px">
			<span class="input-group-addon">Last Name</span>
			<input class="form-control" type="text" />
		</div>
		<div class="input-group" style="margin-bottom:10px">
			<span class="input-group-addon">Email Address</span>
			<input class="form-control" type="text" />
		</div>

		<div class="input-group" style="margin-bottom:10px">
			<span class="input-group-addon">Number of Classes</span>
			<input type="number" min="1" max="10" value="1" id="numClasses" class="form-control" />
		</div>
		<span id="classesForEachAdmin" >
			<div class="input-group" style="margin-bottom:10px">
				<span class="input-group-addon">Class</span>
				<input class="form-control" type="text" />
			</div>
		</span>

		<div id="classTemplate" style="display:none">
			<div class="input-group" style="margin-bottom:10px">
				<span class="input-group-addon">Class</span>
				<input class="form-control" type="text" />
			</div>
		</div>

		<button class="btn btn-success" style="display:inline-block">Create Administrator</button>
		&nbsp;&nbsp;
		<button class="btn btn-danger" style="display:inline-block">Reset Form</button>