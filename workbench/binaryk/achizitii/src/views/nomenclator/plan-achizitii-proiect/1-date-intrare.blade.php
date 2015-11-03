<div class="col-xs-12">
	<div class="panel panel-info">
		<div class="panel-heading">Date intrare</div>
		<div class="panel-body">
			<div class="row">
				<!-- Tipul contractului -->
				<div class="col-xs-12 col-md-6">
					{{ $controls[0]->out() }}
				</div>
				<!-- Valoare estimata EUR -->
				<div class="col-xs-12 col-md-6">
					{{ $controls[1]->out() }}
				</div>
			</div>
			<div class="row">
				<!-- Data cursului valutar -->
				<div class="col-xs-12 col-md-4">
					{{ $controls[2]->out() }}
				</div>
				<!-- Cursul valutar (RON/EUR) -->
				<div class="col-xs-12 col-md-3">
					{{ $controls[3]->out() }}
				</div>
				<div class="col-xs-12 col-md-1 text-center">
					<button title="Preia cursul RON/EUR de la BNR" class="btn btn-info" id="btn-get-curs-valutar"><i class="fa fa-euro"></i></button>
				</div>
				<!-- Valoare estimata LEI -->
				<div class="col-xs-12 col-md-4">
					{{ $controls[4]->out() }}
				</div>
			</div>
		</div>
	</div>
</div>