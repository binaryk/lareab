<div class="row">
	<div class="col-md-6">
		{{$controls[0]->out()}}
	</div>
	<div class="col-md-6">
		{{$controls[1]->out()}} 
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		{{$controls[2]->out()}}
	</div>
	<div class="col-md-6">
		{{$controls[3]->out()}} 
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		{{$controls[4]->out()}}
	</div>
	<div class="col-md-6">
		{{$controls[5]->out()}}
	</div>
</div>
<div class="row"> 
	<div class="col-md-6">
		{{$controls[7]->out()}}
	</div>
	<div class="col-md-5">
		{{$controls[6]->out()}}
	</div>
	<div class="col-md-1">
		<label style="visibility:hidden">Vezi</label>
		<button class="btn btn-info pull-right" title="Vezi modalitatile de publicare" id="view-modalitati-publicare-by-tip-anunt"><i class="fa fa-info-circle"></i></button>
	</div>
</div> 
<div class="row"> 
	<div class="col-md-6">
		{{$controls[8]->out()}}
	</div>
</div> 
<div class="row">
	<div class="col-xs-12"><label>Tip achizitie</label></div>
	<?php
	for($i = 9; $i < $controls->count(); $i++)
	{
	?>
		<div class="col-md-3">
			{{ $controls[$i]->out() }}
		</div>
	<?php
	}
	?>
</div>