<div class="modal fade" id="view_autorizacion" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form method="POST" action="http://localhost:8000/movimientos/addsalida" accept-charset="UTF-8" class="form-horizontal">

				<div class="modal-header" style="background: #4682B4; color: #FFFFFF;">
					<button type="button" class="close" date-dismiss='modal' aria-hidden='true'>&times;</button>
					<h4 class="modal-title">Despachar autorización</h4> 
				</div>

				@if($errors->has())
		            <div class="alert alert-warning" role="alert">
		               @foreach ($errors->all() as $error)
		                  <div>
		                  	{{ $error }}
		                  </div>
		              @endforeach
		            </div>
       			 @endif 
       			 </br> 


				<div class="modal-body">
					<div class="form-group">
						<label for="tipo_salida" class="control-label col-sm-2">Tipo de retiro:</label>
						<div class="col-sm-4">
							<input class="tipo_retiro form-control" style="width: 100%" required="required" id="tipo_retiro" readonly="true" name="tipo_retiro" type="text">	
						</div>
						<label for="articulo" class="control-label col-sm-6">{{Auth::user()->name}}</label>

					</div>
					<div class="form-group">
						<label for="" class="control-label col-sm-2">Destino:</label>
							
						<div class="col-sm-4">
							<input readonly="true" class=" form-control" id="destinos" style="width: 100%" name="desc_subarea" type="text">
								
						</div>
						<label for="" class="control-label col-sm-2">Asignado a:</label>
						<div class="col-sm-4">
							<select id="subdestinos" class=" form-control" style="width: 100%" disabled="disabled" name="subdestino">
							</select>
						</div>
						
					</div>

					<fieldset>
                     <legend>Detalles</legend>
                        <div class="form-group">
							<label class="control-label col-sm-2">Artículo:</label>
							<div class="col-sm-4">
								<select id="articulos" class=" form-control" style="width: 100%">
								</select>
							</div>
							<label class="control-label col-sm-2">Retirado por:</label>
							<div class="col-sm-4">
								<select id="empleados" class=" form-control" style="width: 100%">
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">Cantidad:</label>							<div class="col-sm-4">
							<input id="cantidad" class="form-control" placeholder="Stock actual" min="1" name="" type="number">
							</div>
							<div class="col-sm-4">
							<button id="agregar" class="btn btn-success" type="button">Agregar</button>
							</div>
						</div>
                        
               	 	</fieldset>

	               	<div class="box">
			            <div class="box-body">
			                <table id="tabla-salidastock" class="table table-striped table-bordered"  cellspacing="0" width="100%">
			                    <thead>
			                        <tr>
			                            <th>Articulo</th>
			                            <th>Cantidad</th>
			                            <th>Retirado por</th>
			                            <th>Acciones</th>
			                        </tr>
			                    </thead>
			                </table>
	           			</div>
	      			</div>
				</div>

				<div class="modal-footer">
					{{ csrf_field() }}
					<input class="btn btn btn-primary" type="submit" value="Despachar">
				</div>
			</form>
		</div>
	</div>
</div>